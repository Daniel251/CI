<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos_model extends CI_Model {

	public function get_big_player()
	{
		return $this->db->select('link')->where('big_player', 1)->get('videos')->result();
	}

	public function get_videos()
	{
		return $this->db->select('id, img_name, description, link')->order_by('id', 'DESC')->where('big_player', 0)->get('videos')->result();
	}

}