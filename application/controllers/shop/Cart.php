<?php use app\objects\responses\JsonResponse;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->model('Shop_model');
        $this->load->library('cart');
    }

    public function index()
    {
        $data['categories'] = $this->Shop_model->get_menu_categories();
        $data['title'] = 'Sklep - Nocny Kochanek';
        $this->load->view('shop/header', $data);
        $this->load->view('shop/cart', $data);
        $this->load->view('shop/footer');
    }

    public function add(int $id, $size = 0)
    {
        if ($this->Cart_model->add($id, $size)) {
            JsonResponse::sendSuccess();
        } else {
            JsonResponse::sendError();
        }
    }

    public function remove(string $row_id)
    {
        $result = $this->Cart_model->remove($row_id);
        echo $result;
    }

    public function order()
    {

        if ($this->cart->contents()) {
            $data['packages'] = $this->Shop_model->get_package_types();
            $data['categories'] = $this->Shop_model->get_menu_categories();
            $data['title'] = 'Sklep - Nocny Kochanek';

            $data['total'] = $total = $this->cart->format_number($this->cart->total());
            $random_str = $this->Cart_model->random_string(15);
            $data['description'] = $random_str;
            $data['hash'] = $this->Cart_model->payment_hash($random_str, $total);

            $this->session->set_userdata('hash', $data['hash']);
            $this->session->set_userdata('total', $total);
            $this->session->set_userdata('payment_description', $random_str);

            $this->load->view('shop/header', $data);
            $this->load->view('shop/order', $data);
            $this->load->view('shop/footer');

        } else {
            redirect('shop/cart');
        }
    }

    public function finalize()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Imię', 'trim|required|max_length[40]');
            $this->form_validation->set_rules('surname', 'Nazwisko', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('city', 'Miasto', 'trim|required|alpha_numeric_spaces|max_length[50]');
            $this->form_validation->set_rules('street', 'Ulica', 'trim|alpha_numeric_spaces|max_length[50]');
            $this->form_validation->set_rules('post_code', 'Kod pocztowy', 'trim|required|max_length[6]|regex_match[/[0-9]{2}\-[0-9]{3}/]');

            if (!$this->form_validation->run()) {
                $data['validationErrors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect('shop/cart/order');
            }
            $packageId = (int)$this->input->post('package_id');
            $hash = $this->input->post('hash');
            $session_hash = $this->session->hash;
            $payment_description = $this->input->post('payment_description');
            $session_payment_description = $this->session->payment_description;
            $session_total = $this->session->total;

            if (
                $packageId && $hash == $session_hash
                && $payment_description == $session_payment_description
                && $this->input->post('total') == $session_total
                && $session_total == $this->cart->format_number($this->cart->total())
            ) {
                $name = $this->input->post('name');
                $surname = $this->input->post('surname');
                $email = $this->input->post('email');
                $city = $this->input->post('city');
                $street = $this->input->post('street');
                $post_code = $this->input->post('post_code');

                if ($total = $this->Cart_model->order($email, $name, $surname, $city, $street, $post_code, $packageId, $session_total, $payment_description)) {
                    $data['total'] = $total;
                    $data['payment_description'] = $payment_description;
                    $data['hash'] = $hash;
                    $this->session->set_flashdata('ok', 'Zamówienie zostało przyjęte!');
                    return $this->load->view('shop/pay', $data);
                }
            }
        }

        $data['errors'] = "Coś poszło nie tak. Spróbuj jeszcze raz.";
        $this->session->set_flashdata($data);
        redirect('shop/cart/order');
    }

    public function finish_payment()
    {
        if ($this->input->post()) {
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