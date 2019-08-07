<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {

	public function get_news($limit, $offset)
	{
		return $this->db->select('title, post, img_name, date')->order_by('date', 'DESC')->get('news', $limit, $offset)->result();
	}

	public function count()
	{
		return $this->db->count_all_results('news');
	}

	public function format_post($post)
	{
        $reg_ex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        preg_match_all($reg_ex_url, $post, $matches);
        $used_patterns = array();
        foreach($matches[0] as $pattern){
            if(!array_key_exists($pattern, $used_patterns)){
                $used_patterns[$pattern] = true;
                $post = str_replace  ($pattern, "<a href=".$pattern.">-link-</a> </p>", $post); 
			}
        }
        $post = nl2br($post);
        return "$post";            
	}
}