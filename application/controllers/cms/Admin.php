<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\objects\responses\JsonResponse;

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_admin') != 1 && $this->router->method != 'login') {
            redirect('cms/login');
        }
        $this->load->model('Admin_model');
    }

    private function loadView(string $view, array $data = [])
    {
        $this->load->view('admin/header');
        $this->load->view($view, $data);
        $this->load->view('admin/footer');
    }

    public function index()
    {
        $this->loadView('admin/home');
    }

    public function news()
    {
        $data['news'] = $this->Admin_model->get_news();
        $this->loadView('admin/show_news', $data);
    }

    public function add_news()
    {
        if (!$this->input->post()) {
            $this->loadView('admin/add_news');
        } else {
            $title = $this->input->post('title');
            $post = $this->input->post('post');
            if ($this->input->post('checkbox') == 1) {
                $date = date('Y-m-d H:i:s');
            } else {
                $date = $this->input->post('date') . " " . $this->input->post('time');
            }

            $config['upload_path'] = FCPATH . 'images/posts';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('img')) {
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
                $config['new_image'] = FCPATH . 'images/posts/thumbs';
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

    public function edit_news(int $id)
    {

        if (!$this->input->post()) {
            $data['news'] = $this->Admin_model->get_news($id);
            $this->loadView('admin/edit_news', $data);
        } else {
            $title = $this->input->post('title');
            $post = $this->input->post('post');
            $date = $this->input->post('date');

            $config['upload_path'] = FCPATH . 'images/posts';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('img')) {
                $this->Admin_model->edit_news($id, $post, $title, $date, $img_name = 0);
                redirect('cms/admin/news');
            } else {
                $data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['new_image'] = FCPATH . 'images/posts/thumbs';
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

    public function remove_news(int $id)
    {
        $this->Admin_model->remove_news($id);
        redirect('cms/admin/news');
    }

    public function videos()
    {
        $data['videos'] = $this->Admin_model->get_videos();
        $this->loadView('admin/show_videos', $data);
    }

    public function add_video()
    {
        if (!$this->input->post()) {
            $this->loadView('admin/add_video');
        } else {
            $description = $this->input->post('description');
            $link = $this->input->post('link');
            $big_player = $this->input->post('big_player');

            $config['upload_path'] = FCPATH . 'images/videos';
            $config['allowed_types'] = 'jpg|jpeg|png';


            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('img')) {
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

    public function edit_video(int $id)
    {
        if (!$this->input->post()) {
            $data['videos'] = $this->Admin_model->get_videos($id);
            $this->loadView('admin/edit_video', $data);
        } else {
            $description = $this->input->post('description');
            $link = $this->input->post('link');
            $big_player = $this->input->post('big_player');
            if ($big_player != 1) {
                $big_player = 0;
            }

            $config['upload_path'] = FCPATH . 'images/videos';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('img')) {
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

    public function remove_video(int $id)
    {
        $this->Admin_model->remove_video($id);
        redirect('cms/admin/videos');
    }

    public function concerts()
    {
        $data['concerts'] = $this->Admin_model->get_concert();

        $this->loadView('admin/show_concerts', $data);

    }

    public function add_concert()
    {
        if (!$this->input->post()) {
            $this->loadView('admin/add_concert');
        } else {
            $this->form_validation->set_rules('date', 'Data', 'trim|required');
            $this->form_validation->set_rules('club', 'Klub', 'trim|required');
            $this->form_validation->set_rules('city', 'Miasto', 'trim|required');
            if ($this->form_validation->run()) {
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

    public function edit_concert(int $id)
    {
        if (!$this->input->post()) {
            $data['concerts'] = $this->Admin_model->get_concert($id);
            $this->loadView('admin/edit_concert', $data);
        } else {
            $this->form_validation->set_rules('date', 'Data', 'trim|required');
            $this->form_validation->set_rules('club', 'Klub', 'trim|required');
            $this->form_validation->set_rules('city', 'Miasto', 'trim|required');
            if ($this->form_validation->run()) {
                $date = $this->input->post('date');
                $club = $this->input->post('club');
                $city = $this->input->post('city');
                $this->Admin_model->edit_concert($id, $date, $club, $city);
                redirect('cms/admin/concerts');
            } else {
                $data['errors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect('cms/admin/edit_concert/' . $id);
            }
        }
    }


    public function remove_concert(int $id)
    {
        $this->Admin_model->remove_concert($id);
        redirect('cms/admin/concerts');
    }

    public function products()
    {
        $data['products'] = $this->Admin_model->get_products();
        $this->loadView('admin/show_products', $data);
    }

    public function add_product()
    {
        if (!$this->input->post()) {
            $data['product_sizes'] = $this->Admin_model->get_product_sizes();
            $data['categories'] = $this->Admin_model->get_product_categories();
            $this->loadView('admin/add_product', $data);

        } else {
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $description = $this->input->post('description');
            $nr = $this->input->post('nr');
            $config['upload_path'] = FCPATH . 'images/products/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $nr . '-0';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('img1')) {
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
                $extension = pathinfo(FCPATH . 'images/products/' . $img_name, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'JPG':
                    case 'JPEG':
                        $image = imagecreatefromjpeg(FCPATH . 'images/products/' . $img_name);
                        break;
                    case 'gif':
                    case 'GIF':
                        $image = imagecreatefromgif(FCPATH . 'images/products/' . $img_name);
                        break;
                    case 'png':
                    case 'PNG':
                        $image = imagecreatefrompng(FCPATH . 'images/products/' . $img_name);
                        break;
                }
                imagejpeg($image, FCPATH . 'images/products/' . $nr . '-0.jpg');
                if ($extension != 'jpg') {
                    unlink(FCPATH . 'images/products/' . $img_name);
                }
                $config['image_library'] = 'gd2';
                $config['new_image'] = FCPATH . 'images/products/thumbs/' . $nr . '-0.jpg';
                $config['source_image'] = FCPATH . 'images/products/' . $nr . '-0.jpg';
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
                    $extension = pathinfo(FCPATH . 'images/products/' . $img_name2, PATHINFO_EXTENSION);
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'JPG':
                        case 'JPEG':
                            $image = imagecreatefromjpeg(FCPATH . 'images/products/' . $img_name2);
                            break;
                        case 'gif':
                        case 'GIF':
                            $image = imagecreatefromgif(FCPATH . 'images/products/' . $img_name2);
                            break;
                        case 'png':
                        case 'PNG':
                            $image = imagecreatefrompng(FCPATH . 'images/products/' . $img_name2);
                            break;
                    }
                    imagejpeg($image, FCPATH . 'images/products/' . $nr . '-1.jpg');
                    if ($extension != 'jpg') {
                        unlink(FCPATH . 'images/products/' . $img_name2);
                    } else {
                        unlink(FCPATH . 'images/products/' . $nr . '-01.jpg');
                    }
                    $config2['image_library'] = 'gd2';
                    $config2['new_image'] = FCPATH . 'images/products/thumbs/' . $nr . '-1.jpg';
                    $config2['source_image'] = FCPATH . 'images/products/' . $nr . '-1.jpg';
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

    public function edit_product(int $id)
    {
        if (!$this->input->post()) {
            $data['product_sizes'] = $this->Admin_model->get_product_sizes($id);
            $data['categories'] = $this->Admin_model->get_product_categories();
            $data['products'] = $this->Admin_model->get_products($id);
            $this->loadView('admin/edit_product', $data);

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
            $xxxl = $this->input->post('xxxl') != 1 ? 0 : 1;

            $config['upload_path'] = FCPATH . 'images/products';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = $nr . '-1';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('img1')) {
                $img_name = $this->upload->data('file_name');
                $extension = pathinfo(FCPATH . 'images/products/' . $img_name, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'JPG':
                    case 'JPEG':
                        $image = imagecreatefromjpeg(FCPATH . 'images/products/' . $img_name);
                        break;
                    case 'gif':
                    case 'GIF':
                        $image = imagecreatefromgif(FCPATH . 'images/products/' . $img_name);
                        break;
                    case 'png':
                    case 'PNG':
                        $image = imagecreatefrompng(FCPATH . 'images/products/' . $img_name);
                        break;
                }
                imagejpeg($image, FCPATH . 'images/products/' . $nr . '-0.jpg');
                if ($extension != 'jpg') {
                    unlink(FCPATH . 'images/products/' . $img_name);
                }
                if ($nr != $old_nr) {
                    unlink(FCPATH . 'images/products/' . $old_nr . '-0.jpg');
                    unlink(FCPATH . 'images/products/thumbs/' . $old_nr . '-0.jpg');
                }
                $config['image_library'] = 'gd2';
                $config['new_image'] = FCPATH . 'images/products/thumbs/' . $nr . '-0.jpg';
                $config['source_image'] = FCPATH . 'images/products/' . $nr . '-0.jpg';
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
                $extension = pathinfo(FCPATH . 'images/products/' . $img_name2, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'JPG':
                    case 'JPEG':
                        $image = imagecreatefromjpeg(FCPATH . 'images/products/' . $img_name2);
                        break;
                    case 'gif':
                    case 'GIF':
                        $image = imagecreatefromgif(FCPATH . 'images/products/' . $img_name2);
                        break;
                    case 'png':
                    case 'PNG':
                        $image = imagecreatefrompng(FCPATH . 'images/products/' . $img_name2);
                        break;
                }
                imagejpeg($image, FCPATH . 'images/products/' . $nr . '-1.jpg');
                if ($extension != 'jpg') {
                    unlink(FCPATH . 'images/products/' . $img_name2);
                } else {
                    unlink(FCPATH . 'images/products/' . $nr . '-01.jpg');
                }
                if ($nr != $old_nr) {
                    unlink(FCPATH . 'images/products/' . $old_nr . '-1.jpg');
                    unlink(FCPATH . 'images/products/thumbs/' . $old_nr . '-1.jpg');
                }
                $this->load->library('image_lib');
                $config2['image_library'] = 'gd2';
                $config2['new_image'] = FCPATH . 'images/products/thumbs/' . $nr . '-1.jpg';
                $config2['source_image'] = FCPATH . 'images/products/' . $nr . '-1.jpg';
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

    public function remove_product(int $id)
    {
        $this->Admin_model->remove_product($id);
        redirect('cms/admin/products');
    }

    public function orders()
    {
        $data['orders'] = $this->Admin_model->get_orders();
        $this->loadView('admin/show_orders', $data);
    }

    public function orders_done()
    {
        $data['orders'] = $this->Admin_model->get_orders('done');
        $this->loadView('admin/show_orders_done', $data);
    }

    public function order_details(int $order_id)
    {
        $data['order'] = $this->Admin_model->get_orders($order_id);
        $data['package'] = $this->Admin_model->get_package($order_id);
        $data['products'] = $this->Admin_model->get_orderproducts($order_id);
        $this->loadView('admin/show_order_details', $data);
    }

    public function packages()
    {
        $this->load->model('Shop_model');
        $data['packageTypes'] = $this->Shop_model->get_package_types();
        $this->loadView('admin/show_packages', $data);
    }

    public function send(int $id)
    {
        if (!$this->input->post()) {
            redirect("cms/admin/order_details/" . $id);

        } else {
            $this->form_validation->set_rules('date', 'Data', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('nr', 'Nr paczki', 'trim|required|alpha_numeric|max_length[20]');
            if ($this->form_validation->run()) {
                $date = $this->input->post('date');
                $nr = $this->input->post('nr');
                $this->Admin_model->update_order($id, $date, $nr);
                redirect("cms/admin/order_details/" . $id);
            } else {
                $data['errors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect("cms/admin/order_details/" . $id);
            }
        }
    }

    public function save_package(int $packageId = 0)
    {
        $this->form_validation->set_rules('packageName', 'Nazwa paczki', 'trim|required|min_length[4]|max_length[40]');
        $this->form_validation->set_rules('packagePrice', 'Cena paczki', 'trim|required|numeric');
        if ($this->form_validation->run()) {
            $packageData = [
                'name' => $this->input->post('packageName'),
                'is_active' => (int)$this->input->post('packageIsActive'),
            ];
            if ($packageId) {
                if ($this->Admin_model->edit_package($packageId, $packageData)) {
                    JsonResponse::sendSuccess(JsonResponse::DATA_CHANGE_SUCCESS_MESSAGE);
                }
            } else {
                $packageData['price'] = $this->input->post('packagePrice');
                if ($savedPackageId = $this->Admin_model->save_package($packageData)) {
                    JsonResponse::sendSuccess(JsonResponse::DATA_CHANGE_SUCCESS_MESSAGE, ['packageId' => $savedPackageId]);
                }
            }
        }
        JsonResponse::sendError(JsonResponse::DATA_CHANGE_ERROR_MESSAGE);
    }
}