<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model
{
    public function get_menu_categories(): array
    {
        return $this->db->get('categories')->result();
    }

    public function show_products(int $id)
    {
        if ($id === 0) {
            return $this->db->order_by('id', 'DESC')->get('products')->result();
        } elseif ($id > 0 && $id < 4) {
            return $this->db->where('category_id', $id)->order_by('id', 'DESC')->get('products')->result();
        } else {
            redirect('shop');
        }
    }

    public function show_product_info(int $id)
    {
        $query = $this->db->where('id', $id)->get('products');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }

    public function get_product_images(int $id): array
    {
        $images = [];
        $nr = $this->db->select('nr')->where('id', $id)->get('products')->row()->nr;
        for ($i = 0; $i < 5; $i++) {

            $filename = $nr . "-" . $i . ".jpg";
            $filepath = FCPATH . "images/products/$filename";

            if (file_exists($filepath)) {
                $images[] = $filename;
            }
        }
        return $images;
    }

    public function get_product_sizes(int $id)
    {
        return $this->db->where('product_id', $id)->get('product_sizes')->row();
    }

    public function find_products(string $phrase): array
    {
        return $this->db->like('name', $phrase)->order_by('id', 'DESC')->get('products')->result();
    }

    public function get_package_types(): array
    {
        return $this->db->get('package_send_types')->result();
    }
    public function get_active_package_types(): array
    {
        return $this->db->where('is_active', 1)->get('package_send_types')->result();
    }

    public function get_package_by_id(int $package_id)
    {
        return $this->db->where('id', $package_id)->get('package_send_types')->first_row();
    }

    public function get_user_orders(int $user_id): array
    {
        return $this->db->where('user_id', $user_id)->order_by('date', 'DESC')->get('orders')->result();
    }

    public function get_user_order_details(int $user_id, int $order_id): array
    {
        return $this->db->query("
            SELECT p.name, p.nr, p.price, p.id AS product_id, 
                   op.quantity, op.size,
                   o.id, o.total, o.date
            FROM orders o
            INNER JOIN orderproducts op ON op.order_id = o.id
            INNER JOIN products p ON p.id = op.product_id
            WHERE o.user_id = $user_id
               AND o.id = $order_id
        ")->result();
    }

    public function get_payment_status(int $order_id)
    {
        $status_row = $this->db->query("SELECT p.status FROM orders o INNER JOIN payments p ON o.payment_id = p.id WHERE o.id = $order_id")->first_row();

        if (!$status_row) {
            return 'Błąd płatności';
        } elseif ($status_row->status == 'CLEARED') {
            return 'Płatność zaksięgowana';
        } elseif ($status_row->status == 'PENDING') {
            return 'Oczekiwanie na zakończenie płatności';
        }
    }
}