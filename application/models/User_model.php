<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function register($email, $password, $name, $surname, $city, $street, $post_code, $is_admin = 0)
    {
        $query = $this->db->where('email', $email)->get('users');
        if ($query->num_rows() == 1) {
            return false;
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->load->helper('string');
            $code = random_string('alnum', 20);
            $data = array(
                'email' => $email,
                'PASSWORD' => $password_hash,
                'name' => $name,
                'surname' => $surname,
                'city' => $city,
                'street' => $street,
                'post_code' => $post_code,
                'activation_code' => $code,
                'is_admin' => $is_admin
            );
            $this->db->insert('users', $data);
            $link = base_url() . "shop/user/activation/{$code}";
            $message = "Aby aktywować konto w skelpie Nocnego Kochanka kliknij link: $link";
            $this->load->library('email');
            $this->email->from('your@example.com', 'Nocny Kochanek');
            $this->email->to($email);
            $this->email->subject('Aktywacja konta w sklepie Nocnego Kochanka');
            $this->email->message($message);
            $this->email->send();
            return 1;
        }
    }

    public function activate_account($code)
    {
        $query = $this->db->where('activation_code', $code)->get('users');
        if ($query->num_rows() == 1) {
            $this->db->set('activation_code', 1)->where('activation_code', $code)->update('users');
            return 1;
        } else {
            return 0;
        }
    }

    public function login($email, $password)
    {
        $query = $this->db->where('email', $email)->get('users');
        if ($query->num_rows() == 1) {
            $result = $query->row();
            $hash = $result->password;
            if ($result->activation_code == '1') {
                if (password_verify($password, $hash)) {
                    $data = array(
                        'logged_in' => 1,
                        'id' => $result->id,
                        'email' => $result->email,
                        'name' => $result->name,
                        'surname' => $result->surname,
                        'city' => $result->city,
                        'street' => $result->street,
                        'post_code' => $result->post_code,
                        'is_admin' => $result->is_admin
                    );
                    $this->session->set_userdata($data);
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
    }

    public function edit_profile($name, $surname, $city, $street, $post_code)
    {
        $this->db->set('name', $name);
        $this->db->set('surname', $surname);
        $this->db->set('city', $city);
        $this->db->set('street', $street);
        $this->db->set('post_code', $post_code);
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('users');
        $data = array(
            'name' => $name,
            'surname' => $surname,
            'city' => $city,
            'street' => $street,
            'post_code' => $post_code
        );
        $this->session->set_userdata($data);
        $this->session->set_flashdata('ok', 'Zmieniono dane');
    }

    public function edit_password($password, $code = 0)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($code == '0') {
            $email = $this->session->userdata('email');
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('users');
            return 1;
        } else {
            $query = $this->db->where('new_password_code', $code)->get('users');
            if ($query->num_rows() == 1) {
                $this->db->where('new_password_code', $code);
                $this->db->set('password', $password);
                $this->db->set('new_password_code', 0);
                $this->db->update('users');
                $this->session->set_flashdata('ok', 'Hasło zostało zmienione, możesz się teraz zalogować');
                redirect('shop/user');
            } else {
                $this->session->set_flashdata('errors', 'Błąd');
                redirect('shop/user/forget_password');
            }
        }
    }

    public function edit_email($new_email)
    {
        $query = $this->db->where('email', $new_email)->get('users');
        if ($query->num_rows() == 1) {
            return FALSE;
        } else {
            $this->load->helper('string');
            $code = random_string('alnum', 20);
            $email = $this->session->userdata('email');
            $array = array(
                'new_email' => $new_email,
                'new_email_code' => $code
            );
            $this->db->where('email', $email)->update('users', $array);
            $link = base_url() . "shop/user/activate_email/{$code}";
            $message = "Aby aktywować nowego emaila w skelpie Nocnego Kochanka kliknij link: {$link}";
            $this->load->library('email');
            $this->email->from('sklep@nocny.pl', 'Nocny Kochanek');
            $this->email->to($new_email);
            $this->email->subject('Zmiana emaila w sklepie Nocnego Kochanka');
            $this->email->message($message);
            $this->email->send();
            return 1;
        }
    }

    public function activate_admin($email)
    {
        $this->db->where('email', $email)->set('is_admin', 1)->update('users');
    }

    public function find_email($phrase)
    {
        return $this->db->like('email', $phrase)->order_by('email', 'ASC')->get('users')->result();
    }

    public function activate_email($code)
    {
        $query = $this->db->select('new_email')->where('new_email_code', $code)->get('users');
        if ($query->num_rows() == 1) {
            $result = $query->row();
            $new_email = $result->new_email;
            $array = array(
                'email' => $new_email,
                'new_email' => '0',
                'new_email_code' => '0'
            );
            $this->db->where('new_email_code', $code)->update('users', $array);
            $this->session->set_userdata('email', $new_email);
            return 1;
        } else {
            return FALSE;
        }
    }

    public function set_password_code($email)
    {
        $query = $this->db->select('id')->where('email', $email)->get('users');
        if ($query->num_rows() == 1) {
            $this->load->helper('string');
            $code = random_string('alnum', 20);
            $this->db->set('new_password_code', $code)->where('email', $email)->update('users');

            $link = base_url() . "shop/user/forget_password/{$code}";
            $message = "Aby aktywować nowego emaila w skelpie Nocnego Kochanka kliknij link: " . $link;
            $this->load->library('email');
            $this->email->from('email@email.com', 'Nocny Kochanek');
            $this->email->to($email);
            $this->email->subject('Zmiana hasła w sklepie Nocnego Kochanka');
            $this->email->message($message);
            $this->email->send();
            $this->session->set_flashdata('ok', 'Na podanego emaila wysłano link do formularza zmieniającego hasło');
        } else {
            $this->session->set_flashdata('errors', 'Nie ma takeigo emaila w bazie');
            redirect('shop/user/forget_password');
        }
    }
}