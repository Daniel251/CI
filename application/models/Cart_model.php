<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('cookie');
	}

	public function add($id, $size)
	{
		$query = $this->db->where('id', $id)->get('products');
		if($query->num_rows() == 0) {
			return 0;
		} else {
            $query = $this->db->where('id', $id)->get('products')->row();

            if($size==false) {
                $data=array(
                    'id'      => $id,
                    'qty'     => 1,
                    'price'   => $query->price,
                    'name'    => $query->name,
                );
            } else {
                $data=array(
                    'id'      => $id,
                    'qty'     => 1,
                    'price'   => $query->price,
                    'name'    => $query->name,
                    'options' => array('size' => $size)
                );
            } 
            if($this->cart->insert($data)) {
                return 1;
            } else {
                return "dasds";
            }

		}
	}

	public function remove($rowid)
	{
		$product = $this->cart->contents();
		$product = $product[$rowid];
		$qty = $product['qty'];
		if($qty == 1) {
		    if($this->cart->remove($rowid))  {
	            return 1;
	        } else {
		        return 0;
	        }	
		} else {
			if(array_key_exists('options',$product)) {
				$data=array(
                    'id'      => $product['id'],
                    'qty'     => -1,
                    'price'   => $product['price'],
                    'name'    => $product['name'],
                    'options' => array('size' => $product['options']['size'])
                );
			} else {
				$data=array(
                    'id'      => $product['id'],
                    'qty'     => -1,
                    'price'   => $product['price'],
                    'name'    => $product['name']
                );
			} if($this->cart->insert($data)) {
                return 1;
            } else {
                return 0;
            }
		}
	}

	public function order($email, $name, $surname, $city, $street, $post_code, $package_type, $package_price, $total,$payment_description)
	{
		$data = array(
			'user_id' => $this->session->userdata('id') == NULL ? 0 : $this->session->userdata('id'),
			'email' => $email,
			'name' => $name,
			'surname' => $surname,
			'city' => $city,
			'street' => $street,
			'post_code' => $post_code,
			'package_type' => $package_type,
			'package_price' => $package_price,
			'total' => $total,
			'payment_description'=> $payment_description
			);
		$this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$products = $this->cart->contents();
		foreach($products as $product) {
			(array_key_exists('options',$product)) ? $size=$product['options']['size'] : $size=null ;
			$data = array(
				'order_id' => $order_id,
				'product_id' => $product['id'],
				'quantity' => $product['qty'],
				'size' => $size
				);
		$this->db->insert('orderproducts', $data);
		}
		$message = 'Twoje zamówienie zostało złożone! ';
		$this->load->library('email');
		$this->email->from('d.skiepko@gmail.com', 'Nocny Kochanek');
		$this->email->to($email);
		$this->email->subject('Oczywiście to nie jest prawdziwy sklep zespołu i towar nie zostanie wysłany!');
		$this->email->message($message);
		$this->email->send();
		$this->session->set_flashdata('ok', 'Zamówienie zostało przyjęte!');
	}

	public function randomString($size)
	{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charsLength = strlen($chars) -1;
    $string = "";
    for($i=0; $i<$size; $i++) {
        $randNum = mt_rand(0, $charsLength);
        $string .= $chars[$randNum];
    }
    return $string;
	}

	public function paymentHash($random_str, $package_price)
	{
		$total_price = ($this->cart->total())+$package_price;
		return SHA1("ko3me9cr|" . $random_str . "|" . $total_price . "|PLN|S");
	}

	public function finish_payment($payment_description, $status, $id_sale)
	{
		$data = array(
			'payment_id' => $id_sale,
			'payment_status' => $status
			);
		$this->db->where('payment_description', "$payment_description");
		$this->db->update('orders', $data);
	}
}

/* End of file Cart_model.php */
/* Location: ./application/models/Cart_model.php */