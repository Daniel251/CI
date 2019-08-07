<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function get_news($id = 0)
	{
		if($id == 0) {
			return $this->db->order_by('date', 'DESC')->get('news')->result();
		} else {
			return $this->db->where('id', $id)->get('news')->row();
		}
	}

	public function add_news($post, $title, $date, $img_name)
	{
		$data = array(
			'post' => $post,
			'title' => $title,
			'date' => $date,
			'img_name' => $img_name
			);
		$this->db->insert('news', $data);
		$this->session->set_flashdata('ok', 'Dodano newsa');
	}

	public function edit_news($id, $post, $title, $date, $img_name)
	{
		if($img_name != '0') {
			$query = $this->db->select('img_name')->where('id', $id)->get('news')->row();
			$name = $query->img_name;
			unlink(FCPATH .'images/posts/' . $name);
			unlink(FCPATH .'images/posts/thumbs/' . $name);
			$this->db->set('img_name', $img_name);	
		}
		$this->db->set('post', $post);
		$this->db->set('title', $title);
		$this->db->set('date', $date);
		$this->db->where('id', $id)->update('news');
		$this->session->set_flashdata('ok', 'Edytowano newsa');
	}

	public function remove_news($id)
	{
		$query = $this->db->select('img_name')->where('id', $id)->get('news')->row();
		$name = $query->img_name;
		unlink(FCPATH .'images/posts/' . $name);
		unlink(FCPATH .'images/posts/thumbs/' . $name);
		$this->db->where('id', $id)->delete('news');
		$this->session->set_flashdata('ok', 'Usunięto newsa');
	}

	public function get_concert($id = 0)
	{
		if($id == 0) {
			return $this->db->order_by('date', 'ASC')->get('concerts')->result();
		} else {
			return $this->db->where('id', $id)->get('concerts')->row();
		}
	}

	public function add_concert($date, $club, $city)
	{
		$data = array(
			'date' => $date,
			'club' => $club,
			'city' => $city
			);
		$this->db->insert('concerts', $data);
		$this->session->set_flashdata('ok', 'Dodano koncert');
	}

	public function edit_concert($id, $date, $club, $city)
	{
		$this->db->set('date', $date);
		$this->db->set('club', $club);
		$this->db->set('city', $city);
		$this->db->where('id', $id)->update('concerts');
		$this->session->set_flashdata('ok', 'Edytowano koncert');
	}

	public function remove_concert($id)
	{
		$this->db->where('id', $id)->delete('concerts');
		$this->session->set_flashdata('ok', 'Usunięto koncert');
	}
	
	public function get_videos($id = 0)
	{
		if($id == 0) {
			return $this->db->get('videos')->result();
		} else {
			return $this->db->where('id', $id)->get('videos')->row();
		}
	}

	public function add_video($description, $link, $img_name, $big_player)
	{
		$data = array(
			'description' => $description,
			'link' => $link,
			'img_name' => $img_name,
			'big_player' => $big_player
			);

		if($big_player != 1) {
			$this->db->insert('videos', $data);
			return TRUE;
		} else {
			$this->db->where('big_player', 1)->set('big_player', 0)->update('videos');
			$this->db->insert('videos', $data);
			return TRUE;
		}
	}

	public function edit_video($id, $description, $link, $img_name, $big_player)
	{	
		if($big_player == 1) {
			$this->db->where('big_player', 1)->set('big_player', 0)->update('videos');
			$this->db->set('big_player', 1);
		}

		if($img_name != '0') {
			$query = $this->db->select('img_name')->where('id', $id)->get('videos')->row();
			$old_img_name = $query->img_name;
			unlink(FCPATH .'images/videos/' . $old_img_name);
			$this->db->set('img_name', $img_name);	
		}
		$this->db->set('description', $description);
		$this->db->set('link', $link);
		$this->db->where('id', $id)->update('videos');
		$this->session->set_flashdata('ok', 'Edytowano film');
	}

	public function remove_video($id)
	{
		$query = $this->db->select('img_name')->where('id', $id)->get('videos')->row();
		$img_name = $query->img_name;
		unlink(FCPATH .'images/videos/' . $img_name);
		$this->db->where('id', $id)->delete('videos');
		$this->session->set_flashdata('ok', 'Usunięto film');
	}

	public function get_products($id = 0)
	{
		if($id == 0) {
			return $this->db->get('products')->result();
		} else {
			return $this->db->where('id', $id)->get('products')->row();
		}
	}	

	public function get_product_categories()
	{
		return $this->db->get('categories')->result();
	}

	public function get_product_sizes($id =0)
	{
		$query = $this->db->where('product_id', $id)->get('product_sizes');
		if($query->num_rows() == 0) {
			return $this->db->select('xs, s, m, l, xl, xxl, xxxl')->get('product_sizes')->row_array();
		}
		else {
			return $this->db->select('xs, s, m, l, xl, xxl, xxxl')->where('product_id', $id)->get('product_sizes')->row_array();
		}
	}
	public function add_product($name, $category, $nr, $price, $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl)
	{
		$data = array(
			'name' => $name,
			'category_id' => $category,
			'nr' => $nr,
			'price' => $price,
			'description' => $description,
			);
		$this->db->insert('products', $data);
		if($category == 2) {
			$data = array(
				'product_id' => $this->db->insert_id(),
				'xs' => $xs,
				's' => $s,
				'm' => $m,
				'l' => $l,
				'xl' => $xl,
				'xxl' => $xxl,
				'xxxl' => $xxxl
				);
			$this->db->insert('product_sizes', $data);
		}
		$this->session->set_flashdata('ok', 'Pomyślnie dodano produkt');
	}

	public function edit_product($id, $name, $old_category, $category, $old_nr, $nr, $price, $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl)
	{
		if($old_nr != $nr && file_exists(FCPATH .'images/products/' . $old_nr . '-0.jpg')) {
			rename(FCPATH .'images/products/' . $old_nr . '-0.jpg', FCPATH .'images/products/' . $nr . '-0.jpg');
			rename(FCPATH .'images/products/thumbs/' . $old_nr . '-0.jpg', FCPATH .'images/products/thumbs/' . $nr . '-0.jpg');

			if(file_exists(FCPATH .'images/products/' . $old_nr . '-1.jpg')) {
				rename(FCPATH .'images/products/' . $old_nr . '-1.jpg', FCPATH .'images/products/' . $nr . '-1.jpg');
				rename(FCPATH .'images/products/thumbs/' . $old_nr . '-1.jpg', FCPATH .'images/products/thumbs/' . $nr . '-1.jpg');
			}
		}
		if($category == 2 && $old_category == $category) {
			$data = array(
				'xs' => $xs,
				's' => $s,
				'm' => $m,
				'l' => $l,
				'xl' => $xl,
				'xxl' => $xxl,
				'xxxl' => $xxxl
				);
			$this->db->set($data)->where('product_id', $id)->update('product_sizes');
			$this->session->set_flashdata('ok', 'Edytowano produkt');
		}
		if($category == 2 && $old_category != $category) {
			$data = array(
				'product_id' => $id,
				'xs' => $xs,
				's' => $s,
				'm' => $m,
				'l' => $l,
				'xl' => $xl,
				'xxl' => $xxl,
				'xxxl' => $xxxl
				);
			$this->db->insert('product_sizes', $data);
		}
		if($category != 2 && $old_category == 2) {
			$this->db->where('product_id', $id)->delete('product_sizes');
		}
		$data2 = array(
			'name' => $name,
			'category_id' => $category,
			'nr' => $nr,
			'price' => $price,
			'description' => $description,
			);
		$this->db->set($data2)->where('id', $id)->update('products');
	}

	public function remove_product($id)
	{
		$query = $this->db->select('nr, category_id')->where('id', $id)->get('products')->row();
		$name = $query->nr;
		$category_id = $query->category_id;
		unlink(FCPATH .'images/products/' . $name . "-0.jpg");
		unlink(FCPATH .'images/products/thumbs/' . $name . "-0.jpg");
		if(file_exists(FCPATH .'images/products/' . $name . "-1.jpg")) {
			unlink(FCPATH .'images/products/' . $name . "-1.jpg");
			unlink(FCPATH .'images/products/thumbs/' . $name . "-1.jpg");
		}
		if($category_id == 2) {
			$this->db->where('product_id', $id)->delete('product_sizes');
		}
		$this->db->where('id', $id)->delete('products');
		$this->session->set_flashdata('ok', 'Usunięto produkt');
	}
	
	public function get_orders($id = 0)
	{
		
		if($id == '0') {
			return $this->db->select('date, id, email')->where('parcel_nr', '0')->get('orders')->result();
		} elseif($id == 'done') {
			return $this->db->select('date, id, email')->where('parcel_nr != "0"')->get('orders')->result();
		} else {
			return $this->db->where('id', $id)->get('orders')->row();
		}
	}

	public function get_orderproducts($id)
	{
		$this->db->select('products.name, orderproducts.size, orderproducts.quantity, products.price');
		$this->db->where('orderproducts.product_id', 'products.id', FALSE);
		$this->db->where('orderproducts.order_id', $id, FALSE);
		$this->db->where('orders.id', $id, FALSE);
		$this->db->from('orders, orderproducts, products');
		return $this->db->get()->result();
	}
	
	public function update_order($id, $date, $nr)
	{
		$this->db->set('send_date', $date);
		$this->db->set('parcel_nr', $nr);
		$this->db->where('id', $id);
		$this->db->update('orders');
	}
}