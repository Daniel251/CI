<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Shop_model');
        $data['categories'] = $this->Shop_model->get_menu_categories();
        $data['title'] = 'Sklep - Nocny Kochanek';
        $this->load->view('shop/header', $data);
    }

    public function index()
    {
        $data['products'] = $this->Shop_model->show_products(0);
        $data['category'] = "";
        $this->load->view('shop/home', $data);
        $this->load->view('shop/footer');
    }

    public function category(int $id = 0)
    {
        switch ($id) {
            case 1:
                $category = "Płyty";
                break;
            case 2:
                $category = "Koszulki";
                break;
            case 3:
                $category = "Pozostałe";
                break;
            default:
                $category = "";
                break;
        }
        $data['products'] = $this->Shop_model->show_products($id);
        $data['category'] = $category;
        $this->load->view('shop/home', $data);
        $this->load->view('shop/footer');
    }

    public function product(int $id = 0)
    {
        $result = $this->Shop_model->show_product_info($id);
        if ($result) {
            $data['images'] = $this->Shop_model->get_product_images($id);
            $data['product'] = $result;
            $data['sizes'] = $this->Shop_model->get_product_sizes($id);
            $this->load->view('shop/product', $data);
            $this->load->view('shop/footer');
        } else {
            redirect('shop');
        }
    }

    public function search()
    {
        $this->form_validation->set_rules('phrase', 'Szukana fraza', 'trim|required|min_length[3]|max_length[30]');
        if ($this->form_validation->run()) {
            $phrase = $this->input->post('phrase');
            $data['products'] = $this->Shop_model->find_products($phrase);
            if (!empty($data['products'])) {
                $data['category'] = "Wyniki wyszukiwania";
            } else {
                $data['category'] = "Brak produktów spełniających kryteria wyszukiwania";
            }
            $this->load->view('shop/home', $data);
        }
        $this->load->view('shop/footer');
    }
}