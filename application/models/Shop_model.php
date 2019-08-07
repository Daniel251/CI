<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model {

	public function show_menu_categories()
	{
		return $this->db->get('categories')->result();
	}

	public function show_products($id)
	{
		if($id == 0)
		{
			return $this->db->order_by('id', 'DESC')->get('products')->result();
		}
		elseif($id>0 && $id<4)
		{
			return $this->db->where('category_id', $id)->order_by('id', 'DESC')->get('products')->result();
		}
		else
		{
			redirect('shop');
		}
	}
	public function show_product_info($id)
	{
		$query = $this->db->where('id', $id)->get('products');
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $query->row();
		}
	}

	public function get_product_images($id){
		$images = array();
		$nr = $this->db->select('nr')->where('id', $id)->get('products')->row()->nr;
		for($i=0; $i<5; $i++){
			
			$filename = $nr."-".$i.".jpg";
			$filepath = FCPATH."images/products/$filename";
			
			if(file_exists($filepath)){
				$images[] = $filename;
			}
		}
		return $images;
	}

	public function get_product_sizes($id)
	{
		return $this->db->where('product_id', $id)->get('product_sizes')->row();
	}
	
    public function find_products($phrase)
    {
        return $this->db->like('name', $phrase)->order_by('id', 'DESC')->get('products')->result();
    }
}