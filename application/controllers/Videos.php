<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends CI_Controller {

	public function index()
	{
		$this->load->model('Site_model');
		$data['videos'] = $this->Site_model->get_videos();
		$data['big_player'] = $this->Site_model->get_big_player();
		$data['meta'] = "<link rel='stylesheet' href='".base_url()."css/swipebox.min.css'>";
		$data['title'] = 'Filmy - Nocny Kochanek';
		
		$this->load->view('header', $data);
		$this->load->view('videos', $data);
		$this->load->view('footer', $data);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */