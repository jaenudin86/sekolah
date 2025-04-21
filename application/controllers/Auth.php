<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        sess_expired();
        $this->load->library('form_validation');
    }

    public function index()
    {
         // Cek apakah sudah login
         if ($this->session->userdata('nis')) {
            redirect('siswa');
            return;
        }
        
        // Check if remember me cookie exists
        $remember_cookie = $this->input->cookie('remember_me');
        if($remember_cookie) {
            // decrypt cookie value
            $user_id = $this->encryption->decrypt($remember_cookie);

            // Validate user ID
            if($user_id) {
                // Load user data from database based on user ID
                $user = $this->db->get_where("siswa", ["id" => $user_id])->row();
                if($user) {
                    // Set session data
                    $userdata = array(
                        'nis' => $user->nis,
                        'role_id' => $user->role_id
                    );
                    $this->session->set_userdata($userdata);

                    // Redirect to siswa
                    redirect('siswa');
                }
            }
        }

        $this->form_validation->set_rules('nis', 'Nomor', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login siswa';
            $data['web'] =  $this->db->get('website')->row_array();

            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        } else {
            $nis = $this->input->post('nis');
            $user = $this->db->get_where('siswa', ['nis' => $nis])->row_array();

            if ($user) {
                $this->_login();
            }else{
                $this->_login_ppdb();
            }
        }
    }
    
    public function admin()
    {
        // Cek apakah sudah login
        if ($this->session->userdata('email')) {
            redirect('admin');
            return;
        }
        
        // Proses login dengan cookie 'remember me' jika ada
        $remember_cookie = $this->input->cookie('remember_me_admin');
        if ($remember_cookie && !$this->session->userdata('email')) { // tambahkan pengecekan session untuk menghindari looping
            // decrypt cookie value
            $user_id = $this->encryption->decrypt($remember_cookie);
    
            // Validate user ID
            if ($user_id) {
                // Load user data from database based on user ID
                $user = $this->db->get_where("karyawan", ["id" => $user_id])->row();
                if ($user) {
                    // Set session data
                    $userdata = array(
                        'email' => $user->email,
                        'role_id' => $user->role_id
                    );
                    $this->session->set_userdata($userdata);
    
                    // Redirect to admin
                    redirect('admin');
                    return; // tambahkan return setelah redirect
                }
            }
        }
    
        // Form validation
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
    
        if ($this->form_validation->run() == false) {
            // Jika validasi form gagal, tampilkan halaman login
            $data['title'] = 'Login Admin';
            $data['web'] =  $this->db->get('website')->row_array();
    
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login_admin');
            $this->load->view('template/auth_footer');
        } else {
            // Jika validasi form berhasil, lakukan proses login
            $this->_login_admin();
        }
    }


    private function _login()
    {
        $nis = $this->input->post('nis');
        $password = $this->input->post('password');
        $remember = $this->input->post('remember');

        $user = $this->db->get_where('siswa', ['nis' => $nis])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['status'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'nis' => $user['nis'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                       
                    if($remember) {
                        $cookie = array(
                            'name'   => 'remember_me',
                            'value'  => $this->encryption->encrypt($user['id']),
                            'expire' => '604800',
                        );
                        set_cookie($cookie);
                    }

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Susccess!</strong> Anda berhasil login! :)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>'
                    );
                    redirect('siswa');

                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Password salah!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 </div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nomor Induk ini belum diaktifkan!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nomor induk tidak terdaftar!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
            );
            redirect('auth');
        }
    }

    
    private function _login_ppdb()
    {
        $nis = $this->input->post('nis');
        $password = $this->input->post('password');

        $user = $this->db->get_where('ppdb', ['nis' => $nis])->row_array();

        // jika usernya ada
        if ($user) {
            // cek password
            if (password_verify($password, $user['password'])) {
                $data = [
                    'nis' => $user['nis'],
                    'nik' => $user['nik']
                ];
                $this->session->set_userdata($data);

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Susccess!</strong> Anda berhasil login! :)
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>'
                );
                redirect('ppdb/dashboard');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Password salah!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    NIS tidak terdaftar!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
            );
            redirect('auth');
        }
    }


    private function _login_admin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = $this->input->post('remember');

        $user = $this->db->get_where('karyawan', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['status'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);

                    
                    if($remember) {
                        $cookie = array(
                            'name'   => 'remember_me_admin',
                            'value'  => $this->encryption->encrypt($user['id']),
                            'expire' => '604800',
                        );
                        set_cookie($cookie);
                    }


                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Susccess!</strong> Anda berhasil login! :)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>'
                    );
                    redirect('admin');
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Password salah!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 </div>'
                    );
                    redirect('auth/admin');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email ini belum diaktifkan!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
                );
                redirect('auth/admin');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email tidak terdaftar!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
            );
            redirect('auth/admin');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('nis');
        $this->session->unset_userdata('role_id');
        delete_cookie('remember_me');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Anda berhasil Keluar :)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>'
        );
        redirect('auth');
    }


    public function logout_admin()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        delete_cookie('remember_me_admin');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Anda berhasil Keluar :)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>'
        );
        redirect('auth/admin');
    }
}
