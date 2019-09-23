<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
            echo 1;
        } else {
            echo 0;
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
            $data['packages'] = $this->Shop_model->get_active_package_types();
            $data['categories'] = $this->Shop_model->get_menu_categories();
            $data['title'] = 'Sklep - Nocny Kochanek';

            $data['total'] = $total = $this->cart->format_number($this->cart->total());
            $payment_description = $this->Cart_model->random_string(15);
            $payment_hash = $this->Cart_model->get_payment_hash($payment_description, $total);

            $this->session->set_userdata('payment_hash', $payment_hash);
            $this->session->set_userdata('payment_description', $payment_description);
            $this->session->set_userdata('total', $total);

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
            $package_id = (int)$this->input->post('package_id');

            if (!$this->form_validation->run() || !$package_id) {
                $data['validationErrors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect('shop/cart/order');
            }
            $total_amount_without_package = $this->session->total;
            $payment_description = $this->session->payment_description;
            $payment_hash = $this->Cart_model->get_payment_hash($payment_description, $total_amount_without_package);

            if ($payment_hash === $this->session->payment_hash) {
                $package = $this->Shop_model->get_package_by_id($package_id);
                $total = $total_amount_without_package + $package->price;
                $payment_hash = $this->Cart_model->get_payment_hash($this->session->payment_description, $total);
                $order_data = [
                    'user_id' => $this->session->userdata('id') == NULL ? 0 : $this->session->userdata('id'),
                    'email' => $this->input->post('email'),
                    'name' => $this->input->post('name'),
                    'surname' => $this->input->post('surname'),
                    'city' => $this->input->post('city'),
                    'street' => $this->input->post('street'),
                    'post_code' => $this->input->post('post_code'),
                    'total' => $total,
                    'payment_hash' => $payment_hash,
                    'payment_description' => $payment_description,
                ];
                if ($this->Cart_model->order($order_data, $package_id)) {
                    $data['total'] = $total;
                    $data['payment_description'] = $payment_description;
                    $data['payment_hash'] = $payment_hash;
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
            $payment_data = [
                'id' => $this->input->post('id_sale'),
                'payment_description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'status' => $this->input->post('status')
            ];
            $updated_orders = $this->Cart_model->finish_payment($payment_data);
            if ($updated_orders !== 1) {
                error_log('Orders update after finishing payments error. Updated orders: ' . $updated_orders . ' Payment data: ' . print_r($payment_data));
            }
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