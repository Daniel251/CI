<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    const PAYLANE_HASH_SALT = 'ko3me9cr';

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

    public function order(array $order_data, int $package_id): bool
    {
        try {
            $this->db->insert('orders', $order_data);
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
                'package_id' => $package_id,
            ];
            $this->db->insert('orderpackage', $data);

            $message = 'Twoje zamówienie zostało złożone! ';
            $this->load->library('email');
            $this->email->from('d.skiepko@gmail.com', 'Nocny Kochanek');
            $this->email->to($order_data['email']);
            $this->email->subject('Oczywiście to nie jest prawdziwy sklep zespołu i towar nie zostanie wysłany!');
            $this->email->message($message);
            $this->email->send();

            return true;
        } catch (Exception $e) {
            error_log($e);

            return false;
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

    public function get_payment_hash($payment_description, $total)
    {
        return SHA1(self::PAYLANE_HASH_SALT . '|' . $payment_description . "|" . $total . "|PLN|S");
    }

    public function finish_payment(array $payment_data): int
    {
        $this->db->insert('payments', $payment_data);

        $this->db->where('payment_description', $payment_data['payment_description']);
        $this->db->update('orders', ['payment_id' => $payment_data['id']]);

        if ($payment_data['id']) {
            return $this->db->affected_rows();
        }

        return 0;
    }
}