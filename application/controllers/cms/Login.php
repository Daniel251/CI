<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('is_admin') != 1) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Hasło', 'trim|required');

                if (!$this->form_validation->run()) {
                    $data['errors'] = validation_errors();
                    $this->session->set_flashdata($data);
                    redirect('cms/login');
                } else {
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');

                    $this->User_model->login($email, $password);

                    if ($this->session->userdata('is_admin') == 1) {
                        redirect('cms/login');
                    } else {
                        $data['errors'] = 'Błędne dane!';
                        $data['login_email'] = $email;
                        $this->session->set_flashdata($data);
                        redirect('cms/login');
                    }
                }
            } else {
                $this->load->view('admin/login');
            }

        } else {
            redirect('cms/admin');
        }
    }
}