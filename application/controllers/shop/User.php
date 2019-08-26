<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Shop_model');
        $this->load->model('User_model');
        $data['categories'] = $this->Shop_model->get_menu_categories();
        $data['title'] = 'Sklep - Nocny Kochanek';
        $this->load->view('shop/header', $data);
    }

    public function index()
    {
        if ($this->session->userdata('logged_in') == 1) {
            $this->load->view('shop/account');
        } else {
            $this->load->view('shop/login');
        }
        $this->load->view('shop/footer');
    }

    public function registration()
    {
        if ($this->session->userdata('logged_in') != 1) {
            $this->load->view('shop/registration');
            $this->load->view('shop/footer');
        } else {
            redirect('shop/user');
        }
    }


    public function register()
    {
        if ($this->session->userdata('logged_in') != 1 && $this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Hasło', 'trim|required|min_length[8]|max_length[255]');
            $this->form_validation->set_rules('password2', 'Hasło 2', 'trim|required|min_length[8]|max_length[255]|matches[password]');
            $this->form_validation->set_rules('name', 'Imię', 'trim|required|alpha');
            $this->form_validation->set_rules('surname', 'Nazwisko', 'trim|required');
            $this->form_validation->set_rules('city', 'Miasto', 'trim|required|alpha_numeric_spaces');
            $this->form_validation->set_rules('street', 'Ulica', 'trim|alpha_numeric_spaces');
            $this->form_validation->set_rules('post_code', 'Kod pocztowy', 'trim|required|max_length[6]|regex_match[/[0-9]{2}\-[0-9]{3}/]');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $name = $this->input->post('name');
                $password = $this->input->post('password');
                $surname = $this->input->post('surname');
                $city = $this->input->post('city');
                $street = $this->input->post('street');
                $post_code = $this->input->post('post_code');
                $result = $this->User_model->register($email, $password, $name, $surname, $city, $street, $post_code);
                if ($result) {
                    $this->session->set_flashdata('ok', "Na adres mailowy {$email} został wysłany link aktywacyjny. Aktywuj konto aby móc się zalogować.");
                    redirect('shop/user');
                } else {
                    $this->session->set_flashdata('errors', 'Konto z takim adresem email już istnieje.');
                    redirect('shop/user/registration');
                }
            } else {
                $data['errors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect('shop/user/registration');
            }
        } else {
            redirect('shop/user');
        }
    }

    public function activation($code = 0)
    {
        if (strlen($code) == 20) {
            $result = $this->User_model->activate_account($code);
            if ($result) {
                $this->session->set_flashdata('ok', 'Konto zostało aktywowane. Możesz się teraz zalogować.');
            }
            redirect('shop/user');
        } else {
            redirect('shop');
        }
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Hasło', 'trim|required');

        if (!$this->form_validation->run()) {
            $data['errors'] = validation_errors();
            $this->session->set_flashdata($data);
            redirect('shop/user');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $result = $this->User_model->login($email, $password);

            if (!$result) {
                redirect('shop/user');
            } else {
                switch ($result) {
                    case 1:
                        $data['errors'] = 'Błędne dane!';
                        break;
                    case 2:
                        $data['errors'] = 'Konto nie zostało aktywowane!';
                        break;
                }
                $this->session->set_flashdata($data);
                redirect('shop/user');
            }
        }
    }

    public function logout()
    {
        $this->User_model->logout();
        redirect('shop');
    }

    public function edit_profile()
    {
        if ($this->session->userdata('logged_in') == 1) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'Imię', 'trim|required|alpha');
                $this->form_validation->set_rules('surname', 'Nazwisko', 'trim|required');
                $this->form_validation->set_rules('city', 'Miasto', 'trim|required|alpha_numeric_spaces');
                $this->form_validation->set_rules('street', 'Ulica', 'trim|alpha_numeric_spaces');
                $this->form_validation->set_rules('post_code', 'Kod pocztowy', 'trim|required|max_length[6]|regex_match[/[0-9]{2}\-[0-9]{3}/]');

                if ($this->form_validation->run()) {
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $city = $this->input->post('city');
                    $street = $this->input->post('street');
                    $post_code = $this->input->post('post_code');
                    $this->User_model->edit_profile($name, $surname, $city, $street, $post_code);
                    redirect('shop/user');
                } else {
                    $data['errors'] = validation_errors();
                    $this->session->set_flashdata($data);
                    redirect('shop/user/edit_profile');
                }
            } else {
                $this->load->view('shop/edit_profile');
                $this->load->view('shop/footer');
            }
        } else {
            redirect('shop/user');
        }
    }

    public function edit_password($code = 0)
    {
        if ($this->session->userdata('logged_in') == 1) {
            if ($this->input->post() && $code == 0) {
                $this->form_validation->set_rules('password', 'Hasło', 'trim|required|max_length[255]|min_length[8]');
                $this->form_validation->set_rules('password2', 'Hasło 2', 'trim|required|matches[password]');

                if ($this->form_validation->run()) {
                    $password = $this->input->post('password');
                    $result = $this->User_model->edit_password($password);
                    $this->session->set_flashdata('ok', 'Hasło zostało zmienione');
                    redirect('shop/user');
                } else {
                    $data['errors'] = validation_errors();
                    $this->session->set_flashdata($data);
                    redirect('shop/user/edit_password');
                }
            } elseif (!$this->input->post() && $code == 0) {
                $this->load->view('shop/edit_password');
                $this->load->view('shop/footer');
            }
        } elseif (strlen($code) == 20 && $this->input->post()) {
            $this->form_validation->set_rules('password', 'Hasło', 'trim|required|max_length[255]|min_length[8]');
            $this->form_validation->set_rules('password2', 'Hasło 2', 'trim|required|matches[password]');

            if ($this->form_validation->run()) {
                $password = $this->input->post('password');
                $this->User_model->edit_password($password, $code);
            } else {
                $data['errors'] = validation_errors();
                $this->session->set_flashdata($data);
                redirect('shop/user/forget_password/' . $code);
            }
        } else {
            redirect('shop/user');
        }
    }

    public function edit_email()
    {
        if ($this->session->userdata('logged_in') == 1) {
            if (!$this->input->post()) {
                $this->load->view('shop/edit_email');
                $this->load->view('shop/footer');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('email2', 'Email', 'trim|required|matches[email]');
                if (!$this->form_validation->run()) {
                    $data['errors'] = validation_errors();
                    $this->session->set_flashdata($data);
                    redirect('shop/user/edit_email');
                } else {
                    $email = $this->input->post('email');
                    $result = $this->User_model->edit_email($email);
                    if ($result) {
                        $this->session->set_flashdata('ok', 'Na nowego emaila został wysłany link, który go aktywuje.');
                        redirect('shop/user');
                    } else {
                        $this->session->set_flashdata('errors', 'Nowy email przypisany jest już do innego konta');
                        redirect('shop/user/edit_email');
                    }
                }
            }
        } else {
            redirect('shop/user');
        }
    }

    public function activate_email($code = 0)
    {
        if (strlen($code) == 20) {
            $result = $this->User_model->activate_email($code);
            if ($result) {
                $this->session->set_flashdata('ok', 'Email został zmieniony');
            }
            redirect('shop/user');
        } else {
            redirect('shop');
        }
    }

    public function forget_password($code = 0)
    {
        if ($this->session->userdata('logged_in') != 1) {
            if ($this->input->post() && $code == '0') {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                if (!$this->form_validation->run()) {
                    $this->session->set_flashdata('error', 'Błędny email');
                    redirect('shop/user/forget_password');
                } else {
                    $email = $this->input->post('email');
                    $this->User_model->set_password_code($email);
                    redirect('shop/user/forget_password');
                }
            } elseif ($code == '0') {
                $this->load->view('shop/forget_password');
                $this->load->view('shop/footer');
            }
            if (strlen($code) == 20) {
                $data['code'] = $code;
                $this->load->view('shop/edit_password', $data);
            }
        } else {
            redirect('shop/user');
        }
    }

    public function orders()
    {
        $data['orders'] = $this->Shop_model->get_user_orders($this->session->userdata('id'));
        $this->load->view('shop/user_orders', $data);
        $this->load->view('shop/footer');
    }

    public function order_details(int $order_id)
    {
        $data['order_details'] = $this->Shop_model->get_user_order_details($this->session->userdata('id'), $order_id);
        $this->load->view('shop/user_order_details', $data);
        $this->load->view('shop/footer');
    }
}