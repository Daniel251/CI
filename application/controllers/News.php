<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller
{
    private $rows_per_page = 4;

    public function index(int $offset = 0)
    {
        $this->load->library('pagination');
        $this->load->model('Site_model');

        if ($offset != 0) {
            $offset = $offset * 4 - 4;
        }
        $records = $this->Site_model->get_news($this->rows_per_page, $offset);
        foreach ($records as $row) {
            $row->post = $this->Site_model->format_post($row->post);
        }
        $config['base_url'] = base_url() . 'news';
        $config['total_rows'] = $this->Site_model->count_news();
        $config['per_page'] = $this->rows_per_page;
        $config['use_page_numbers'] = TRUE;
        $config['next_link'] = 'STARSZE WPISY';
        $config['prev_link'] = 'NOWSZE WPISY';
        $this->pagination->initialize($config);

        $data['page_links'] = $this->pagination->create_links();
        $data['records'] = $records;
        $data['title'] = 'Newsy - Nocny Kochanek';
        $data['meta'] = "<link rel='stylesheet' href='" . base_url() . "css/lightbox.css'>";
        $data['script'] = "<script src='" . base_url() . "js/lightbox-plus-jquery.min.js'></script>";

        $this->load->view('header', $data);
        $this->load->view('news', $data);
        $this->load->view('footer', $data);
    }
}