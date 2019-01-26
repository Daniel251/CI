<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Concerts extends CI_Controller {

	public function index()
	{
		$this->load->model('Site_model');
		$data['title'] = 'Koncerty - Nocny Kochanek';
		$data['concerts_past'] = $this->Site_model->get_concerts('DESC');
		$data['concerts_incoming'] = $this->Site_model->get_concerts('ASC');
		$this->load->view('header', $data);
		$this->load->view('concerts', $data);
		$this->load->view('footer');
	}
}

/* End of file Concerts.php */
/* Location: ./application/controllers/Concerts.php */