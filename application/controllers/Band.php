<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Band extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Zespół - Nocny Kochanek';
		$this->load->view('header', $data);
		$this->load->view('band');
		$this->load->view('footer');
	}
}
