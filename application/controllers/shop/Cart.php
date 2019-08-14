<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cart_model');
		$this->load->model('Shop_model');
		$this->load->library('cart');
	}

	public function index()
	{
		$data['categories'] = $this->Shop_model->show_menu_categories();
		$data['title'] = 'Sklep - Nocny Kochanek';
		$this->load->view('shop/header', $data);
		$this->load->view('shop/cart', $data);
		$this->load->view('shop/footer');
	}
	public function add($id, $size=0)
	{
		$result = $this->Cart_model->add($id, $size);
		echo $result;
	}

	public function remove($rowid)
	{
		$result = $this->Cart_model->remove($rowid);
		echo $result;
	}
	public function order()
	{
		if (  $this->input->post() || $this->session->has_userdata('package')) {
			$data['categories'] = $this->Shop_model->show_menu_categories();
			$data['title'] = 'Sklep - Nocny Kochanek';
			if (!empty($this->input->post('package'))) {
				$package_type = $this->input->post('package');
				$this->session->set_userdata('package', $package_type);
			}
			else {
				$package_type = $this->session->userdata('package');
			}			
			if ($package_type == "poczta"){
				$package_price=10;
				$package = "Paczka priorytetowa";
			} else {
				$package = "Przesyłka kurierska";
				$package_price=15;	
			}

			$random_str = $this->Cart_model->randomString(15);
			$total = $this->cart->total()+$package_price;
			$data['description'] = $random_str;
			$data['hash'] = $this->Cart_model->paymentHash($random_str, $package_price);
			$data['package'] = $package;
			$data['package_type'] = $package_type;
			$data['price'] = $package_price;
			$data['total'] = $total;

			$this->session->set_userdata('hash', $data['hash']);
			$this->session->set_userdata('total', $total);
			$this->session->set_userdata('payment_description', $random_str);

			$this->load->view('shop/header', $data);
			$this->load->view('shop/order', $data);
			$this->load->view('shop/footer');

		}
		else
		{
			$this->session->set_flashdata('errors', 'Nie wybrano typu przesyłki!');
			redirect('shop/cart');
		}
	}

	public function finalize()
	{
		if (  $this->input->post()) {
			$this->form_validation->set_rules('name', 'Imię', 'trim|required|alpha|max_length[40]');
			$this->form_validation->set_rules('surname', 'Nazwisko', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('city', 'Miasto', 'trim|required|alpha_numeric_spaces|max_length[50]');
			$this->form_validation->set_rules('street', 'Ulica', 'trim|alpha_numeric_spaces|max_length[50]');
			$this->form_validation->set_rules('post_code', 'Kod pocztowy', 'trim|required|max_length[6]|regex_match[/[0-9]{2}\-[0-9]{3}/]');

			if (!$this->form_validation->run()) {
				$data['errors'] = validation_errors();
				$this->session->set_flashdata($data);
				redirect('shop/cart/order');
			}
			else {
				$hash = $this->input->post('hash');
				$session_hash =$this->session->hash;
				$payment_description = $this->input->post('payment_description');
				$session_payment_description = $this->session->payment_description;
				$total = $this->input->post('total');
				$session_total = $this->session->total;

				if ($hash==$session_hash && $payment_description==$session_payment_description && $total==$session_total) {
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $email = $this->input->post('email');
                    $city = $this->input->post('city');
					$street = $this->input->post('street');
					$post_code = $this->input->post('post_code');
					$package_type = $this->input->post('package_type');
					$package_price = $this->input->post('package_price');
					$this->Cart_model->order($email, $name, $surname, $city, $street, $post_code, $package_type, $package_price, $total, $payment_description);

					$data['total'] = $total;
					$data['payment_description'] = $payment_description;
					$data['hash'] = $hash;
					$this->load->view('shop/pay', $data);
				} else {
					$data['errors'] = "Coś poszło nie tak. Spróbuj jeszcze raz.";
					$this->session->set_flashdata($data);
					redirect('shop/cart/order');
				}
			}
		}
	}

	public function finish_payment()
	{
		if (  $this->input->post()){
			$payment_description = $this->input->post('description');
			$status = $this->input->post('status');
			$id_sale = $this->input->post('id_sale');
			$this->Cart_model->finish_payment($payment_description, $status, $id_sale);
			$this->cart->destroy();
			$data['ok'] = "Zamównienie przyjęte.";
			$this->session->set_flashdata($data);
			redirect('shop');
		} else {
			$data['error'] = "Coś poszło nie tak. Skontaktuj się z obsługą sklepu.";
			$this->session->set_flashdata($data);
			redirect('shop/cart/order');
		}
	}
}

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */

//array(6) { ["status"]=> string(9) "PERFORMED" ["amount"]=> string(3) "105" ["currency"]=> string(3) "PLN" ["description"]=> string(15) "bv7FgMIkfbQKQC4" ["hash"]=> string(40) "79fbe94dbfcdbf3514716ed7fee185ce2f8233ca" ["id_sale"]=> string(8) "12605170" } 