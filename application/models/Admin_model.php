<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function get_news($id = 0)
    {
        if ($id == 0) {
            return $this->db->order_by('date', 'DESC')->get('news')->result();
        } else {
            return $this->db->where('id', $id)->get('news')->row();
        }
    }

    public function add_news(string $post, string $title, string $date, string $img_name)
    {
        $data = [
            'post' => $post,
            'title' => $title,
            'date' => $date,
            'img_name' => $img_name
        ];
        $this->db->insert('news', $data);
        $this->session->set_flashdata('ok', 'Dodano newsa');
    }

    public function edit_news(int $id, string $post, string $title, string $date, string $img_name)
    {
        if ($img_name != '0') {
            $query = $this->db->select('img_name')->where('id', $id)->get('news')->row();
            $name = $query->img_name;
            unlink(FCPATH . 'images/posts/' . $name);
            unlink(FCPATH . 'images/posts/thumbs/' . $name);
            $this->db->set('img_name', $img_name);
        }
        $this->db->set('post', $post);
        $this->db->set('title', $title);
        $this->db->set('date', $date);
        $this->db->where('id', $id)->update('news');
        $this->session->set_flashdata('ok', 'Edytowano newsa');
    }

    public function remove_news(int $id)
    {
        $query = $this->db->select('img_name')->where('id', $id)->get('news')->row();
        $name = $query->img_name;
        unlink(FCPATH . 'images/posts/' . $name);
        unlink(FCPATH . 'images/posts/thumbs/' . $name);
        $this->db->where('id', $id)->delete('news');
        $this->session->set_flashdata('ok', 'Usunięto newsa');
    }

    public function get_concert(int $id = 0)
    {
        if ($id == 0) {
            return $this->db->order_by('date', 'ASC')->get('concerts')->result();
        } else {
            return $this->db->where('id', $id)->get('concerts')->row();
        }
    }

    public function add_concert(string $date, string $club, string $city)
    {
        $data = [
            'date' => $date,
            'club' => $club,
            'city' => $city
        ];
        $this->db->insert('concerts', $data);
        $this->session->set_flashdata('ok', 'Dodano koncert');
    }

    public function edit_concert(int $id, string $date, string $club, string $city)
    {
        $this->db->set('date', $date);
        $this->db->set('club', $club);
        $this->db->set('city', $city);
        $this->db->where('id', $id)->update('concerts');
        $this->session->set_flashdata('ok', 'Edytowano koncert');
    }

    public function remove_concert(int $id)
    {
        $this->db->where('id', $id)->delete('concerts');
        $this->session->set_flashdata('ok', 'Usunięto koncert');
    }

    public function get_videos(int $id = 0)
    {
        if ($id == 0) {
            return $this->db->get('videos')->result();
        } else {
            return $this->db->where('id', $id)->get('videos')->row();
        }
    }

    public function add_video(string $description, string $link, string $img_name, string $big_player): bool
    {
        $data = [
            'description' => $description,
            'link' => $link,
            'img_name' => $img_name,
            'big_player' => $big_player
        ];

        if ($big_player != 1) {
            $this->db->insert('videos', $data);
            return TRUE;
        } else {
            $this->db->where('big_player', 1)->set('big_player', 0)->update('videos');
            $this->db->insert('videos', $data);
            return TRUE;
        }
    }

    public function edit_video(int $id, string $description, string $link, string $img_name, string $big_player)
    {
        if ($big_player == 1) {
            $this->db->where('big_player', 1)->set('big_player', 0)->update('videos');
            $this->db->set('big_player', 1);
        }

        if ($img_name != '0') {
            $query = $this->db->select('img_name')->where('id', $id)->get('videos')->row();
            $old_img_name = $query->img_name;
            unlink(FCPATH . 'images/videos/' . $old_img_name);
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
        unlink(FCPATH . 'images/videos/' . $img_name);
        $this->db->where('id', $id)->delete('videos');
        $this->session->set_flashdata('ok', 'Usunięto film');
    }

    public function get_products(int $id = 0)
    {
        if ($id == 0) {
            return $this->db->get('products')->result();
        } else {
            return $this->db->where('id', $id)->get('products')->row();
        }
    }

    public function get_product_categories()
    {
        return $this->db->get('categories')->result();
    }

    public function get_product_sizes(int $id = 0)
    {
        $query = $this->db->where('product_id', $id)->get('product_sizes');
        if ($query->num_rows() == 0) {
            return $this->db->select('xs, s, m, l, xl, xxl, xxxl')->get('product_sizes')->row_array();
        } else {
            return $this->db->select('xs, s, m, l, xl, xxl, xxxl')->where('product_id', $id)->get('product_sizes')->row_array();
        }
    }

    public function add_product(string $name, string $category, string $nr, string $price, string $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl)
    {
        $data = array(
            'name' => $name,
            'category_id' => $category,
            'nr' => $nr,
            'price' => $price,
            'description' => $description,
        );
        $this->db->insert('products', $data);
        if ($category == 2) {
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

    public function edit_product($id, string $name, $old_category, $category, string $old_nr, string $nr, $price, string $description, $xs, $s, $m, $l, $xl, $xxl, $xxxl)
    {
        if ($old_nr != $nr && file_exists(FCPATH . 'images/products/' . $old_nr . '-0.jpg')) {
            rename(FCPATH . 'images/products/' . $old_nr . '-0.jpg', FCPATH . 'images/products/' . $nr . '-0.jpg');
            rename(FCPATH . 'images/products/thumbs/' . $old_nr . '-0.jpg', FCPATH . 'images/products/thumbs/' . $nr . '-0.jpg');

            if (file_exists(FCPATH . 'images/products/' . $old_nr . '-1.jpg')) {
                rename(FCPATH . 'images/products/' . $old_nr . '-1.jpg', FCPATH . 'images/products/' . $nr . '-1.jpg');
                rename(FCPATH . 'images/products/thumbs/' . $old_nr . '-1.jpg', FCPATH . 'images/products/thumbs/' . $nr . '-1.jpg');
            }
        }
        if ($category == 2 && $old_category == $category) {
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
        if ($category == 2 && $old_category != $category) {
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
        if ($category != 2 && $old_category == 2) {
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

    public function remove_product(int $id)
    {
        $query = $this->db->select('nr, category_id')->where('id', $id)->get('products')->row();
        $name = $query->nr;
        $category_id = $query->category_id;
        unlink(FCPATH . 'images/products/' . $name . "-0.jpg");
        unlink(FCPATH . 'images/products/thumbs/' . $name . "-0.jpg");
        if (file_exists(FCPATH . 'images/products/' . $name . "-1.jpg")) {
            unlink(FCPATH . 'images/products/' . $name . "-1.jpg");
            unlink(FCPATH . 'images/products/thumbs/' . $name . "-1.jpg");
        }
        if ($category_id == 2) {
            $this->db->where('product_id', $id)->delete('product_sizes');
        }
        $this->db->where('id', $id)->delete('products');
        $this->session->set_flashdata('ok', 'Usunięto produkt');
    }

    public function get_package(int $order_id)
    {
        $query = $this->db->query("
            SELECT p.price, p.name
            FROM orderpackage op
            INNER JOIN package_send_types p ON op.package_id = p.id
            WHERE op.order_id = $order_id
        ");

        return $query->first_row();
    }

    public function get_orders(int $id = 0)
    {
        if ($id == '0') {
            $query = $this->db->query("
		        SELECT o.id, o.date, o.email
		        FROM orders o
                INNER JOIN orderpackage op ON o.id = op.order_id
                WHERE op.parcel_number IS NULL
		    ");

            return $query->result();
        } elseif ($id == 'done') {
            $query = $this->db->query("
		        SELECT o.id, o.date, o.email
		        FROM orders o
                INNER JOIN orderpackage op ON o.id = op.order_id
                WHERE op.parcel_number IS NOT NULL
		    ");

            return $query->result();
        }
        $query = $this->db->query("
		        SELECT o.*, op.package_send_date, op.parcel_number
		        FROM orders o
                INNER JOIN orderpackage op ON o.id = op.order_id
                WHERE o.id = $id
		    ");

        return $query->first_row();

    }

    public function get_orderproducts(int $id)
    {
        $this->db->select('products.name, orderproducts.size, orderproducts.quantity, products.price');
        $this->db->where('orderproducts.product_id', 'products.id', FALSE);
        $this->db->where('orderproducts.order_id', $id, FALSE);
        $this->db->where('orders.id', $id, FALSE);
        $this->db->from('orders, orderproducts, products');
        return $this->db->get()->result();
    }

    public function update_order(int $id, string $date, string $package_number)
    {
        $this->db->set('package_send_date', $date);
        $this->db->set('parcel_number', $package_number);
        $this->db->where('order_id', $id);
        $this->db->update('orderpackage');
    }

    public function save_package(array $packageData): int
    {
        try {
            $this->db->insert('package_send_types', $packageData);
            return $this->db->insert_id();
        } catch (Exception $e) {
            error_log($e);
            return 0;
        }
    }

    public function edit_package(int $packageId, array $packageData): bool
    {
        return $this->db->where('id', $packageId)->update('package_send_types', $packageData);
    }
}