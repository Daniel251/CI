<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->helper('cookie');
    }

    public function add(int $id,  $size): bool
    {
        $query = $this->db->where('id', $id)->get('products');
        if ($query->num_rows() == 0) {
            error_log("Nie znaleziono produktu id: $id");

            return false;
        }

        $query = $this->db->where('id', $id)->get('products')->row();

        if ($size == false) {
            $data = [
                'id' => $id,
                'qty' => 1,
                'price' => $query->price,
                'name' => $query->name,
            ];
        } else {
            $data = [
                'id' => $id,
                'qty' => 1,
                'price' => $query->price,
                'name' => $query->name,
                'options' => ['size' => $size]
            ];
        }

        return $this->cart->insert($data);
    }

    public function remove(string $row_id)
    {
        $product = $this->cart->contents();
        $product = $product[$row_id];
        $qty = $product['qty'];
        if ($qty == 1) {
            if ($this->cart->remove($row_id)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            if (array_key_exists('options', $product)) {
                $data = [
                    'id' => $product['id'],
                    'qty' => -1,
                    'price' => $product['price'],
                    'name' => $product['name'],
                    'options' => ['size' => $product['options']['size']]
                ];
            } else {
                $data = [
                    'id' => $product['id'],
                    'qty' => -1,
                    'price' => $product['price'],
                    'name' => $product['name']
                ];
            }
            if ($this->cart->insert($data)) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function order($email, $name, $surname, $city, $street, $post_code, $packageId, $totalWithoutPackage, $payment_description)
    {
        try {
            $package = $this->db->where('id', $packageId)->get('package_send_types')->first_row();
            $total = $totalWithoutPackage + (float)$package->price;
            $data = [
                'user_id' => $this->session->userdata('id') == NULL ? 0 : $this->session->userdata('id'),
                'email' => $email,
                'name' => $name,
                'surname' => $surname,
                'city' => $city,
                'street' => $street,
                'post_code' => $post_code,
                'total' => $total,
                'payment_description' => $payment_description
            ];
            $this->db->insert('orders', $data);
            $order_id = $this->db->insert_id();

            $products = $this->cart->contents();
            foreach ($products as $product) {
                $size = (array_key_exists('options', $product)) ? $product['options']['size'] : null;
                $data = [
                    'order_id' => $order_id,
                    'product_id' => $product['id'],
                    'quantity' => $product['qty'],
                    'size' => $size
                ];
                $this->db->insert('orderproducts', $data);
            }

            $data = [
                'order_id' => $order_id,
                'package_id' => $packageId
            ];
            $this->db->insert('orderpackage', $data);

            $message = 'Twoje zamówienie zostało złożone! ';
            $this->load->library('email');
            $this->email->from('d.skiepko@gmail.com', 'Nocny Kochanek');
            $this->email->to($email);
            $this->email->subject('Oczywiście to nie jest prawdziwy sklep zespołu i towar nie zostanie wysłany!');
            $this->email->message($message);
            $this->email->send();

            return $total;
        } catch (Exception $e) {
            error_log($e);

            return 0;
        }
    }

    public function random_string($size)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $charsLength = strlen($chars) - 1;
        $string = "";
        for ($i = 0; $i < $size; $i++) {
            $randNum = mt_rand(0, $charsLength);
            $string .= $chars[$randNum];
        }
        return $string;
    }

    public function payment_hash($random_str, $total)
    {
        return SHA1("ko3me9cr|" . $random_str . "|" . $total . "|PLN|S");
    }

    public function finish_payment($id_sale, $status, $amount, $description, $hash)
    {
        $orderId = $this->db->where('hash', $hash)->get('orders')->first_row()->id;
        $this->db->update();

        $data = [
            'payment_id' => $id_sale,
            'payment_status' => $status
        ];
        $this->db->where('payment_description', "$payment_description");
        $this->db->update('orders', $data);
    }
}