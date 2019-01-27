<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Concerts extends CI_Controller {

	public function index()
	{
		$this->load->model('Concerts_model');
		$data['title'] = 'Koncerty - Nocny Kochanek';
		$data['concerts_past'] = $this->Concerts_model->get_past_concerts('DESC');
		$data['concerts_incoming'] = $this->Concerts_model->get_incoming_concerts('ASC');
		$this->load->view('header', $data);
		$this->load->view('concerts', $data);
		$this->load->view('footer');
	}
}

/* End of file Concerts.php */
/* Location: ./application/controllers/Concerts.php */