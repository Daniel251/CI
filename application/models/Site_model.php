<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	// News
	public function get_news($limit, $offset)
	{
		return $this->db->select('title, post, img_name, date')->order_by('date', 'DESC')->get('news', $limit, $offset)->result();
	}

	public function count_news()
	{
		return $this->db->count_all_results('news');
	}

	//Zamiana linkw na -link-
	public function format_post($post)
	{
        $reg_ex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        preg_match_all($reg_ex_url, $post, $matches);
        $used_patterns = array();
        foreach($matches[0] as $pattern){
            if (!array_key_exists($pattern, $used_patterns)) {
                $used_patterns[$pattern] = true;
                $post = str_replace  ($pattern, "<a href=".$pattern.">-link-</a> </p>", $post); 
			}
        }
        $post = nl2br($post);
        return "$post";            
	}

	// Videos
	public function get_big_player()
	{
		return $this->db->select('link')->where('big_player', 1)->get('videos')->result();
	}

	public function get_videos()
	{
		return $this->db->select('id, img_name, description, link')->order_by('id', 'DESC')->where('big_player', 0)->get('videos')->result();
	}
}

/* End of file  */
/* Location: ./application/models/ */