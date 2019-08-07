<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Concerts_model extends CI_Model {

	public function get_past_concerts()
	{
		$query = $this->db->select('date, club, city')->where('DATE(NOW()) > DATE(date)')->order_by('date DESC')->get('concerts');
		return $query->result();
	}

	public function get_incoming_concerts()
	{
		$query = $this->db->select('date, club, city')->where('DATE(NOW()) <= DATE(date)')->order_by('date ASC')->get('concerts');
		return $query->result();
	}
}