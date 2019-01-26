<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->view('admin/header');
	}

	public function index()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$this->load->view('admin/home');
			$this->load->view('admin/footer');
		}
	}

	public function news()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['news'] = $this->Admin_model->get_news();
			$this->load->view('admin/show_news', $data);
			$this->load->view('admin/footer');
		}
	}

	public function add_admin(){
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ($this->input->post()) {
				$this->form_validation->set_rules('phrase', 'Szukana fraza', 'trim|required|min_length[5]|max_length[40]');
		        if ($this->form_validation->run() == TRUE) {
		            $phrase = $this->input->post('phrase');
		            $data['users'] = $this->User_model->find_email($phrase);
		            if (!empty($data['users'])){
		                $data['title']="Wyniki wyszukiwania";
		            }  else {
		                $data['title']="Nie ma takiego emaila";
		            }
		            $this->load->view('cmd/add_admin', $data);
		        }
				$this->load->view('admin/footer');
			} else {
				$this->load->view('admin/add_admin');
				$this->load->view('admin/footer');	
			}
		}
	}

	public function add_news()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$this->load->view('admin/add_news');
				$this->load->view('admin/footer');	
			} else {
				$title = $this->input->post('title');
				$post = $this->input->post('post');
				if ($this->input->post('checkbox') == 1){
					$date = date('Y-m-d H:i:s');
				} else {
					$date = $this->input->post('date') ." " . $this->input->post('time');	
				}

				$config['upload_path'] = FCPATH .'images/posts';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('img')) {
					$data = array(
						'error' => $this->upload->display_errors(),
						'title' => $title,
						'post' => $post,
						'date' => $this->input->post('date'),
						'time' => $this->input->post('time')
						);
					$this->session->set_flashdata($data);
					redirect('cms/admin/add_news');
				} else {
					$data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['new_image'] = FCPATH .'images/posts/thumbs';
					$config['source_image'] = $data['full_path'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 340;
					$config['height'] = 440;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize(); 

					$img_name = $this->upload->data('file_name'); 
					$this->Admin_model->add_news($post, $title, $date, $img_name);
					redirect('cms/admin/news');	
				}
			}
		}
	}

	public function edit_news($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$data['news'] = $this->Admin_model->get_news($id);
				$this->load->view('admin/edit_news', $data);
				$this->load->view('admin/footer');
			} else {
				$title = $this->input->post('title');
				$post = $this->input->post('post');
				$date = $this->input->post('date');

				$config['upload_path'] = FCPATH .'images/posts';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('img')) {
					$this->Admin_model->edit_news($id, $post, $title, $date, $img_name = 0);
					redirect('cms/admin/news');	
				} else {
					$data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['new_image'] = FCPATH .'images/posts/thumbs';
					$config['source_image'] = $data['full_path'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 340;
					$config['height'] = 440;
					$this->load->library('image_lib', $config);

					$this->image_lib->resize(); 
					$img_name = $this->upload->data('file_name'); 
					$this->Admin_model->edit_news($id, $post, $title, $date, $img_name);
					redirect('cms/admin/news');
				}
			}
		}
	}

	public function remove_news($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$this->Admin_model->remove_news($id);
			redirect('cms/admin/news');	
		}
	}

	public function videos()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['videos'] = $this->Admin_model->get_videos();

			$this->load->view('admin/show_videos', $data);
			$this->load->view('admin/footer');
		}
	}

	public function add_video()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$this->load->view('admin/add_video');
				$this->load->view('admin/footer');	
			} else {
				$description = $this->input->post('description');
				$link = $this->input->post('link');
				$big_player = $this->input->post('big_player');

				$config['upload_path'] = FCPATH .'images/videos';
				$config['allowed_types'] = 'jpg|jpeg|png';


				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('img')) {
					$data = array(
						'error' => $this->upload->display_errors(),
						'description' => $this->input->post('description'),
						'link' => $this->input->post('link')
						);
					$this->session->set_flashdata($data);
					redirect('cms/admin/add_video');
				} else {
					$big_player = $this->input->post('big_player');
					if ($big_player != 1) {
						$big_player = 0;
					}

					$data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $data['full_path'];
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 280;
					$config['height'] = 157;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize(); 

					$img_name = $this->upload->data('file_name'); 
					$this->Admin_model->add_video($description, $link, $img_name, $big_player);
					redirect('cms/admin/videos');	
				}
			}
		}
	}

	public function edit_video($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$data['videos'] = $this->Admin_model->get_videos($id);
				$this->load->view('admin/edit_video', $data);
				$this->load->view('admin/footer');
			} else {
			$description = $this->input->post('description');
			$link = $this->input->post('link');
			$big_player = $this->input->post('big_player');
			if ($big_player != 1) {
				$big_player = 0;
			}

				$config['upload_path'] = FCPATH .'images/videos';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('img')) {
					$this->Admin_model->edit_video($id, $description, $link, $img_name = 0, $big_player);
					redirect('cms/admin/videos');	
				} else {
		
					$data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $data['full_path'];
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 280;
					$config['height'] = 157;
					$this->load->library('image_lib', $config);

					$this->image_lib->resize(); 

					$img_name = $this->upload->data('file_name'); 
					$this->Admin_model->edit_video($id, $description, $link, $img_name, $big_player);
					redirect('cms/admin/videos');
				}
			}
		}
	}

	public function remove_video($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$this->Admin_model->remove_video($id);
			redirect('cms/admin/videos');
		}
	}

	public function concerts()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['concerts'] = $this->Admin_model->get_concert();

			$this->load->view('admin/show_concerts', $data);
			$this->load->view('admin/footer');
		}
	}

	public function add_concert()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$this->load->view('admin/add_concert');
				$this->load->view('admin/footer');	
			} else {
				$this->form_validation->set_rules('date', 'Data', 'trim|required');
				$this->form_validation->set_rules('club', 'Klub', 'trim|required');
				$this->form_validation->set_rules('city', 'Miasto', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$date = $this->input->post('date');
					$club = $this->input->post('club');
					$city = $this->input->post('city');
					$this->Admin_model->add_concert($date, $club, $city);
					redirect('cms/admin/concerts');
				} else {
					$data['errors'] = validation_errors();
					$this->session->set_flashdata($data);
					redirect('cms/admin/add_concert');
				}
			}
		}
	}

	public function edit_concert($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post())
			{
				$data['concerts'] = $this->Admin_model->get_concert($id);
				$this->load->view('admin/edit_concert', $data);
				$this->load->view('admin/footer');
			} else {
				$this->form_validation->set_rules('date', 'Data', 'trim|required');
				$this->form_validation->set_rules('club', 'Klub', 'trim|required');
				$this->form_validation->set_rules('city', 'Miasto', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$date = $this->input->post('date');
					$club = $this->input->post('club');
					$city = $this->input->post('city');
					$this->Admin_model->edit_concert($id, $date, $club, $city);
					redirect('cms/admin/concerts');
				} else {
					$data['errors'] = validation_errors();
					$this->session->set_flashdata($data);
					redirect('cms/admin/edit_concert/'.$id);
				}
			}
		}
	}

	public function remove_concert($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$this->Admin_model->remove_concert($id);
			redirect('cms/admin/concerts');
		}
	}

	public function products()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['products'] = $this->Admin_model->get_products();
			$this->load->view('admin/show_products', $data);
			$this->load->view('admin/footer');
		}
	}

	public function add_product()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				$data['product_sizes'] = $this->Admin_model->get_product_sizes();
				$data['categories'] = $this->Admin_model->get_product_categories();
				$this->load->view('admin/add_product', $data);
				$this->load->view('admin/footer');
			} else {
				$name = $this->input->post('name');
				$price = $this->input->post('price');
				$description = $this->input->post('description');
				$nr = $this->input->post('nr');
				$config['upload_path'] = FCPATH .'images/products/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['file_name'] = $nr . '-0';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('img1')) {
					$data = array(
						'error' => $this->upload->display_errors(),
						'name' => $name,
						'nr' => $nr,
						'price' => $price,
						'description' => $description
						);
					$this->session->set_flashdata($data);
					redirect('cms/admin/add_product');
				} else {
					$img_name = $this->upload->data('file_name'); 
					$extension = pathinfo(FCPATH .'images/products/' . $img_name, PATHINFO_EXTENSION);
		            switch($extension) {
					case 'jpg':
					case 'jpeg':
					case 'JPG':
					case 'JPEG':
						$image = imagecreatefromjpeg(FCPATH .'images/products/' . $img_name);
					break;
					case 'gif':
					case 'GIF':
					 	$image = imagecreatefromgif (FCPATH .'images/products/' . $img_name);
					   	break;
					case 'png':
					case 'PNG':
						$image = imagecreatefrompng(FCPATH .'images/products/' . $img_name);
						break;
					}
					imagejpeg($image, FCPATH .'images/products/' . $nr . '-0.jpg');
					if ($extension != 'jpg') {
						unlink(FCPATH .'images/products/' . $img_name);
					}
					$config['image_library'] = 'gd2';
					$config['new_image'] = FCPATH .'images/products/thumbs/'. $nr . '-0.jpg';
					$config['source_image'] = FCPATH .'images/products/' . $nr . '-0.jpg';
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 150;
					$config['height'] = 150;
					$config['overwrite'] = TRUE;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize(); 

					$category = $this->input->post('category');
					$xs = $this->input->post('xs') != 1 ? 0 : 1;
					$s = $this->input->post('s') != 1 ? 0 : 1;
					$m = $this->input->post('m') != 1 ? 0 : 1;
					$l = $this->input->post('l') != 1 ? 0 : 1;
					$xl = $this->input->post('xl') != 1 ? 0 : 1;
					$xxl = $this->input->post('xxl') != 1 ? 0 : 1;
					$xxl = $this->input->post('xxl') != 1 ? 0 : 1;
					$xxxl = $this->input->post('xxxl') != 1 ? 0 : 1;
					$this->Admin_model->add_product($name, $category, $nr, $price, $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl);
					if ($this->upload->do_upload('img2')) {
						$img_name2 = $this->upload->data('file_name'); 
						$extension = pathinfo(FCPATH .'images/products/' . $img_name2, PATHINFO_EXTENSION);
			            switch($extension) {
						case 'jpg':
						case 'jpeg':
						case 'JPG':
						case 'JPEG':
							$image = imagecreatefromjpeg(FCPATH .'images/products/' . $img_name2);
							break;					
						case 'gif':
						case 'GIF':
						 	$image = imagecreatefromgif (FCPATH .'images/products/' . $img_name2);
						   	break;
						case 'png':
						case 'PNG':
							$image = imagecreatefrompng(FCPATH .'images/products/' . $img_name2);
							break;
						}
						imagejpeg($image, FCPATH .'images/products/' . $nr . '-1.jpg');
						if ($extension != 'jpg') {
							unlink(FCPATH .'images/products/' . $img_name2);
						} else {
							unlink(FCPATH .'images/products/' . $nr . '-01.jpg');
						}
						$config2['image_library'] = 'gd2';
						$config2['new_image'] = FCPATH .'images/products/thumbs/'. $nr . '-1.jpg';
						$config2['source_image'] = FCPATH .'images/products/' . $nr . '-1.jpg';
						$config2['create_thumb'] = FALSE;
						$config2['maintain_ratio'] = TRUE;
						$config2['width'] = 150;
						$config2['height'] = 150;
						$this->image_lib->clear();
       					$this->image_lib->initialize($config2);

						$this->image_lib->resize(); 
					}
					redirect('cms/admin/products');
				}
			}
		}
	}

	public function edit_product($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		}
		else
		{
			if ( ! $this->input->post()) {
				$data['product_sizes'] = $this->Admin_model->get_product_sizes($id);
				$data['categories'] = $this->Admin_model->get_product_categories();
				$data['products'] = $this->Admin_model->get_products($id);
				$this->load->view('admin/edit_product', $data);
				$this->load->view('admin/footer');
			} else {
				$name = $this->input->post('name');
				$category = $this->input->post('category');
				$nr = $this->input->post('nr');
				$price = $this->input->post('price');
				$description = $this->input->post('description');
				$old_nr = $this->input->post('old_nr');
				$old_category = $this->input->post('old_category');
				$xs = $this->input->post('xs') != 1 ? 0 : 1;
				$s = $this->input->post('s') != 1 ? 0 : 1;
				$m = $this->input->post('m') != 1 ? 0 : 1;
				$l = $this->input->post('l') != 1 ? 0 : 1;
				$xl = $this->input->post('xl') != 1 ? 0 : 1;
				$xxl = $this->input->post('xxl') != 1 ? 0 : 1;
				$xxl = $this->input->post('xxl') != 1 ? 0 : 1;
				$xxxl = $this->input->post('xxxl') != 1 ? 0 : 1;

				$config['upload_path'] = FCPATH .'images/products';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = $nr . '-1';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('img1')) {
					$img_name = $this->upload->data('file_name'); 
					$extension = pathinfo(FCPATH .'images/products/' . $img_name, PATHINFO_EXTENSION);
		            switch($extension) {
						case 'jpg':
						case 'jpeg':
						case 'JPG':
						case 'JPEG':
							$image = imagecreatefromjpeg(FCPATH .'images/products/' . $img_name);
						break;
						case 'gif':
						case 'GIF':
						 	$image = imagecreatefromgif (FCPATH .'images/products/' . $img_name);
						   	break;
						case 'png':
						case 'PNG':
							$image = imagecreatefrompng(FCPATH .'images/products/' . $img_name);
							break;
					}
					imagejpeg($image, FCPATH .'images/products/' . $nr . '-0.jpg');
					if ($extension != 'jpg') {
						unlink(FCPATH .'images/products/' . $img_name);
					}
					if ($nr != $old_nr) {
						unlink(FCPATH .'images/products/' . $old_nr . '-0.jpg');
						unlink(FCPATH .'images/products/thumbs/' . $old_nr . '-0.jpg');
					}
					$config['image_library'] = 'gd2';
					$config['new_image'] = FCPATH .'images/products/thumbs/'. $nr . '-0.jpg';
					$config['source_image'] = FCPATH .'images/products/' . $nr . '-0.jpg';
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 150;
					$config['height'] = 150;
					$config['overwrite'] = FALSE;
					$this->load->library('image_lib', $config);

					$this->image_lib->resize(); 
				}

				if ($this->upload->do_upload('img2')) {
					$img_name2 = $this->upload->data('file_name'); 
					$extension = pathinfo(FCPATH .'images/products/' . $img_name2, PATHINFO_EXTENSION);
		            switch($extension) {
					case 'jpg':
					case 'jpeg':
					case 'JPG':
					case 'JPEG':
						$image = imagecreatefromjpeg(FCPATH .'images/products/' . $img_name2);
						break;					
					case 'gif':
					case 'GIF':
					 	$image = imagecreatefromgif (FCPATH .'images/products/' . $img_name2);
					   	break;
					case 'png':
					case 'PNG':
						$image = imagecreatefrompng(FCPATH .'images/products/' . $img_name2);
						break;
					}
					imagejpeg($image, FCPATH .'images/products/' . $nr . '-1.jpg');
					if ($extension != 'jpg') {
						unlink(FCPATH .'images/products/' . $img_name2);
					}
					else {
						unlink(FCPATH .'images/products/' . $nr . '-01.jpg');
					}
					if ($nr != $old_nr) {
						unlink(FCPATH .'images/products/' . $old_nr . '-1.jpg');
						unlink(FCPATH .'images/products/thumbs/' . $old_nr . '-1.jpg');
					}
					$this->load->library('image_lib');
					$config2['image_library'] = 'gd2';
					$config2['new_image'] = FCPATH .'images/products/thumbs/'. $nr . '-1.jpg';
					$config2['source_image'] = FCPATH .'images/products/' . $nr . '-1.jpg';
					$config2['create_thumb'] = FALSE;
					$config2['maintain_ratio'] = TRUE;
					$config2['width'] = 150;
					$config2['height'] = 150;
					$this->image_lib->clear();
   					$this->image_lib->initialize($config2);
					$this->image_lib->resize(); 
				}
				$this->Admin_model->edit_product($id, $name, $old_category, $category, $old_nr, $nr, $price, $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl);
				redirect('cms/admin/products');
			}
		}
	}
	public function remove_product($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$this->Admin_model->remove_product($id);
			redirect('cms/admin/products');
		}
	}

	public function orders()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['orders'] = $this->Admin_model->get_orders();
			$this->load->view('admin/show_orders', $data);
			$this->load->view('admin/footer');
		}
	}

	public function orders_done()
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['orders'] = $this->Admin_model->get_orders('done');
			$this->load->view('admin/show_orders_done', $data);
			$this->load->view('admin/footer');
		}
	}

	public function order_details($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			$data['order'] = $this->Admin_model->get_orders($id);
			$data['products'] = $this->Admin_model->get_orderproducts($id);
			$this->load->view('admin/show_order_details', $data);
			$this->load->view('admin/footer');
		}
	}
	public function send($id)
	{
		if ($this->session->userdata('is_admin') != 1) {
			redirect('cms/login');
		} else {
			if ( ! $this->input->post()) {
				redirect("cms/admin/order_details/".$id);
				
			} else {
				$this->form_validation->set_rules('date', 'Data', 'trim|required|max_length[11]');
				$this->form_validation->set_rules('nr', 'Nr paczki', 'trim|required|alpha_numeric|max_length[20]');
				if ($this->form_validation->run() == TRUE) {
					$date = $this->input->post('date');
					$nr = $this->input->post('nr');
					$this->Admin_model->update_order($id, $date, $nr);
					redirect("cms/admin/order_details/".$id);
				} else {
					$data['errors'] = validation_errors();
					$this->session->set_flashdata($data);
					redirect("cms/admin/order_details/".$id);
				}
			}
		}
	}
}
					
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */