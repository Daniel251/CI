<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model
{
    // News
    public function get_news(int $limit, int $offset): array
    {
        return $this->db->select('title, post, img_name, date')->order_by('date', 'DESC')->get('news', $limit, $offset)->result();
    }

    public function count_news(): int
    {
        return $this->db->count_all_results('news');
    }

    //Zamiana linków na -link-
    public function format_post(string $post = ''): string
    {
        $reg_ex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        preg_match_all($reg_ex_url, $post, $matches);
        $used_patterns = [];
        foreach ($matches[0] as $pattern) {
            if (!array_key_exists($pattern, $used_patterns)) {
                $used_patterns[$pattern] = true;
                $post = str_replace($pattern, "<a href=" . $pattern . ">-link-</a> </p>", $post);
            }
        }
        $post = nl2br($post);
        return "$post";
    }

    public function get_past_concerts() : array
    {
        return $this->db->select('date, club, city')->where('DATE(NOW()) > DATE(date)')->order_by('date DESC')->get('concerts')->result();
    }

    public function get_incoming_concerts() : array
    {
        return $this->db->select('date, club, city')->where('DATE(NOW()) <= DATE(date)')->order_by('date ASC')->get('concerts')->result();
    }

    public function get_big_player(): array
    {
        return $this->db->select('link')->where('big_player', 1)->get('videos')->result();
    }

    public function get_videos(): array
    {
        return $this->db->select('id, img_name, description, link')->order_by('id', 'DESC')->where('big_player', 0)->get('videos')->result();
    }
}