<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Ppdb extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_payment');
    }

    public function index()
    {
        $data['menu'] = 'ppdb';
        $nis = $this->session->userdata('nis');
        $user = $this->db->get_where('ppdb', ['nis' => $nis])->num_rows();
        if (!empty($user)) {
            redirect('ppdb/dashboard');
        }
        $data['menu'] = 'home';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $this->db->order_by('nama', 'asc');
        $data['prov'] = $this->db->get('provinsi')->result_array();
        $data['pendidikan'] = $this->db->get('data_pendidikan')->result_array();
        $this->db->where('period_status', 1);
        $thn_msk = $this->db->get_where('period', ['period_start' => date('Y')])->row();

        $this->form_validation->set_rules('nik', 'NIK', 'required|is_unique[ppdb.nik]', [
            'is_unique' => 'Nik ini sudah terdaftar!',
            'required' => 'Nik tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[ppdb.nis]', [
            'is_unique' => 'Nis ini sudah terdaftar!',
            'required' => 'Nis tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[ppdb.email]', [
            'is_unique' => 'Email ini sudah terdaftar!',
            'required' => 'Email tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password terlalu pendek!',
            'required' => 'Password tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('no_hp', 'Nomor Hp', 'required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('ttl', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('prov', 'Provinsi', 'required');
        $this->form_validation->set_rules('kab', 'Kota', 'required');
        $this->form_validation->set_rules('kec', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kel', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required');
        $this->form_validation->set_rules('nama_ibu', 'Nama ibu', 'required');
        $this->form_validation->set_rules('pek_ayah', 'Pekerjaan Ayah', 'required');
        $this->form_validation->set_rules('pek_ibu', 'Pekerjaan Ibu', 'required');
        $this->form_validation->set_rules('peng_ortu', 'Penghasilan Ortu', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('sekolah_asal', 'Sekolah Asal', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('thn_lls', 'Tahun Lulus', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('frontend/header', $data);
            $this->load->view('frontend/ppdb/ppdb', $data);
            $this->load->view('frontend/footer', $data);
        } else {
            $find = array("https://","http://");
            $replace = "www.";
            $arr = site_url();
            $site = str_replace($find,$replace,$arr);

            $tgl = date('Y-m-d');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $id_prov = $this->input->post('prov');
            $id_pend = $this->input->post('pendidikan');

            $provinsi =  $data['prov'] = $this->db->get_where('provinsi', ['id_prov' => $id_prov])->row_array();
            $pend = $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();
            
            $majrs = $this->input->post('jurusan');
            if (isset($majrs)) {
                if($pend['majors'] == 1){
                    $majors = $this->input->post('jurusan');
                }elseif($pend['majors'] == 0){
                    $majors = '';
                }
            }else{
                $majors = '';
            }
            

            //Buat ID DAFTAR
            $query = $this->db->order_by('id', 'DESC')->limit(1)->get('ppdb');
            if ($query->num_rows() !== 0) {
                $data1 = $query->row_array();
                $nodaftar = $data1['id'] + 1;
            } else {
                $nodaftar = 1;
            }
            $nodaftarmax = str_pad($nodaftar, 5, "0", STR_PAD_LEFT);
            $nodaftarjadi = 'SIS' . $nodaftarmax;

            //GAMBAR
            $config['upload_path'] = './assets/img/data/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('img_siswa')) {
                $img_siswa  = $this->upload->data('file_name');
            } else {
                $img_siswa  = '';
            }
            if ($this->upload->do_upload('img_kk')) {
                $img_kk  = $this->upload->data('file_name');
            } else {
                $img_kk  = '';
            }
            if ($this->upload->do_upload('img_ijazah')) {
                $img_ijazah  = $this->upload->data('file_name');
            } else {
                $img_ijazah  = '';
            }
            if ($this->upload->do_upload('img_ktp')) {
                $img_ktp  = $this->upload->data('file_name');
            } else {
                $img_ktp  = '';
            }
            $kab = $this->db->get_where('kabupaten', ['id_kab' => $this->input->post('kab')])->row_array();
            $kec = $this->db->get_where('kecamatan', ['id_kec' => $this->input->post('kec')])->row_array();
            $kel = $this->db->get_where('kelurahan', ['id_kel' => $this->input->post('kel')])->row_array();

            $data = [
                'no_daftar' => $nodaftarjadi,
                'nik' => $this->input->post('nik'),
                'nis' => $this->input->post('nis'),
                'nama' => $nama,
                'email' => $email,
                'no_hp' => $this->input->post('no_hp'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'jk' => $this->input->post('jk'),
                'ttl' => $this->input->post('ttl'),
                'prov' => $provinsi['nama'],
                'kab' => $kab['nama_kab'],
                'kec' => $kec['nama'],
                'kel' => $kel['nama'],
                'alamat' => $this->input->post('alamat'),
                'nama_ayah' => $this->input->post('nama_ayah'),
                'nama_ibu' => $this->input->post('nama_ibu'),
                'pek_ayah' => $this->input->post('pek_ayah'),
                'pek_ibu' => $this->input->post('pek_ibu'),
                'nama_wali' => $this->input->post('nama_wali'),
                'pek_wali' => $this->input->post('pek_wali'),
                'peng_ortu' => $this->input->post('peng_ortu'),
                'no_telp' => $this->input->post('no_telp'),
                'thn_msk'       => $thn_msk->id,
                'sekolah_asal'  => $this->input->post('sekolah_asal'),
                'kelas'         => $this->input->post('kelas'),
                'thn_lls'         => $this->input->post('thn_lls'),
                'id_pend'       => $id_pend,
                'id_majors'     => $majors,
                'img_siswa' => $img_siswa,
                'img_kk' => $img_kk,
                'img_ijazah' => $img_ijazah,
                'img_ktp' => $img_ktp,
                'date_created' => $tgl,
                'kode_reff' => $this->input->post('reff'),
                'status' => '0'
            ];

            $ppdb = $this->db->insert('ppdb', $data);
            $id = $this->db->insert_id();

        $no = $data['no_hp'];
        $pesan = 'Pendaftaran PPDB anda berhasil dengan data :

Nama : '.$data['nama'].'
Nomor Pendaftaran : '.$data['no_daftar'].'
NIS : '.$data['nis'].'
Email : '.$data['email'].'

Untuk pengumuman PPDB akan di infokan melalui website :
' . $site . '

Terimakasih.';
        wa_api($no, $pesan);

        $this->ppdbEmail($id);

            $sess = [
                'email' => $email,
                'nis' => $this->input->post('nis')
            ];
            $this->session->set_userdata($sess);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Data pendaftaran kamu berhasil dikirim!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('ppdb/dashboard');
        }
    }


    private function ppdbEmail($id)
    {
        $response = false;
        $mail = new PHPMailer(true);

        $data['web'] =  $this->db->get('website')->row_array();

        $data['ppdb'] =  $this->db->get_where('ppdb', ['id' => $id])->row_array();
        $email = $data['ppdb']['email'];

        $web = $data['web'];

        $esen =  $this->db->get('email_sender')->row_array();

        
        // SMTP configuration
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();
        $mail->Host     = $esen['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $esen['email']; // user email
        $mail->Password = $esen['password']; // password email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port     = $esen['port'];

        $mail->SMTPKeepAlive = true;

        $mail->setFrom($esen['email'], $web['nama']); // user email
        $mail->addReplyTo($esen['email'], ''); //user email
        $mail->IsHTML(true);

        // Add a recipient
        $mail->addAddress($email); //email tujuan pengiriman email

        // Email subject
        // $mail->Subject = $subjek; 

        // Set email format to HTML
        $mail->isHTML(true);

        $data['link_web'] = base_url();
        $data['email'] = $email;

        $body = $this->load->view('email/daftar_ppdb', $data, TRUE);

        $mail->Subject = 'Informasi Pendaftaran PPDB - ' . $web['nama'];
        $mail->Body = $body;
 
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return true;
        }
    }

    public function dashboard()
    {
        $nis = $this->session->userdata('nis');
        $user = $this->db->get_where('ppdb', ['nis' => $nis])->num_rows();
        if (empty($user)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
             Silahkan masuk terlebih dahulu!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         redirect('auth');
        }
        $data['menu'] = 'home';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $data['user'] = $this->db->get_where('ppdb', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['cek_major'] = $this->db->get_where('data_pendidikan', ['id' => $data['user']['id_pend']])->row();

        $data['pembayaran'] = $this->db->get_where('data_pembayaran', ['jenis' => 'PPDB'])->result_array();
        $this->db->order_by('nama', 'asc');
        $data['prov'] = $this->db->get('provinsi')->result_array();
        $data['pendidikan'] = $this->db->get('data_pendidikan')->result_array();
        $data['jurusan'] = $this->db->get('data_jurusan')->result_array();
        $this->db->where('period_status', 1);
        $thn_msk = $this->db->get_where('period', ['period_start' => date('Y')])->row();

        
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor Hp', 'required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('ttl', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('prov', 'Provinsi', 'required');
        $this->form_validation->set_rules('kab', 'Kota', 'required');
        $this->form_validation->set_rules('kec', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kel', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required');
        $this->form_validation->set_rules('nama_ibu', 'Nama ibu', 'required');
        $this->form_validation->set_rules('pek_ayah', 'Pekerjaan Ayah', 'required');
        $this->form_validation->set_rules('pek_ibu', 'Pekerjaan Ibu', 'required');
        $this->form_validation->set_rules('peng_ortu', 'Penghasilan Ortu', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('sekolah_asal', 'Sekolah Asal', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('thn_lls', 'Tahun Lulus', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('frontend/header', $data);
            $this->load->view('frontend/ppdb/dashboard', $data);
            $this->load->view('frontend/footer', $data);
        } else {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $id_prov = $this->input->post('prov');
            $id_pend = $this->input->post('pendidikan');

            $pend = $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();
            if($pend['majors'] == 1){
                $majors = $this->input->post('jurusan');
            }elseif($pend['majors'] == 0){
                $majors = '';
            }
            $provinsi =  $data['prov'] = $this->db->get_where('provinsi', ['id_prov' => $id_prov])->row_array();

            //GAMBAR
            $config['upload_path'] = './assets/img/data/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config);

            $this->db->where('id', $id);
            $g =  $this->db->get('ppdb')->row_array();

            if ($this->upload->do_upload('img_siswa')) {
                $img_siswa  = $this->upload->data('file_name');
                unlink("./assets/img/data/" . $g['img_siswa']);
            } else {
                $img_siswa  = $g['img_siswa'];
            }
            if ($this->upload->do_upload('img_kk')) {
                $img_kk  = $this->upload->data('file_name');
                unlink("./assets/img/data/" . $g['img_kk']);
            } else {
                $img_kk  = $g['img_kk'];
            }
            if ($this->upload->do_upload('img_ijazah')) {
                $img_ijazah  = $this->upload->data('file_name');
                unlink("./assets/img/data/" . $g['img_ijazah']);
            } else {
                $img_ijazah  = $g['img_ijazah'];
            }
            if ($this->upload->do_upload('img_ktp')) {
                $img_ktp  = $this->upload->data('file_name');
                unlink("./assets/img/data/" . $g['img_ktp']);
            } else {
                $img_ktp  = $g['img_ktp'];
            }

            $pass = $this->input->post('password');
            if(empty($pass)){
                $password = $data['user']['password'];
            }else{
                $password = password_hash($pass, PASSWORD_DEFAULT);
            }

            $kabup = $this->input->post('kab');
         
            if (is_numeric($kabup)) {
                $kab = $this->db->get_where('kabupaten', ['id_kab' => $kabup])->row();
                $kec = $this->db->get_where('kecamatan', ['id_kec' => $this->input->post('kec')])->row();
                $kel = $this->db->get_where('kelurahan', ['id_kel' => $this->input->post('kel')])->row();
                
                $kabb = $kab->nama_kab;
                $kecc = $kec->nama;
                $kell = $kel->nama;
            }else{
                $kabu = $this->db->get_where('kabupaten', ['nama_kab' => $kabup])->row();
                $keca = $this->db->get_where('kecamatan', ['nama' => $this->input->post('kec')])->row();
                $kelu = $this->db->get_where('kelurahan', ['nama' => $this->input->post('kel')])->row();

                $kabb = $kabu->nama_kab;
                $kecc = $keca->nama;
                $kell = $kelu->nama;
            }

            $data = [
                'nik' => $this->input->post('nik'),
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'password' => $password,
                'jk' => $this->input->post('jk'),
                'ttl' => $this->input->post('ttl'),
                'prov' => $provinsi['nama'],
                'kab' => $kabb,
                'kec' => $kecc,
                'kel' => $kell,
                'alamat' => $this->input->post('alamat'),
                'nama_ayah' => $this->input->post('nama_ayah'),
                'nama_ibu' => $this->input->post('nama_ibu'),
                'pek_ayah' => $this->input->post('pek_ayah'),
                'pek_ibu' => $this->input->post('pek_ibu'),
                'nama_wali' => $this->input->post('nama_wali'),
                'pek_wali' => $this->input->post('pek_wali'),
                'peng_ortu' => $this->input->post('peng_ortu'),
                'no_telp' => $this->input->post('no_telp'),
                'thn_msk'       => $thn_msk->id,
                'sekolah_asal'  => $this->input->post('sekolah_asal'),
                'kelas'         => $this->input->post('kelas'),
                'thn_lls'         => $this->input->post('thn_lls'),
                'id_pend'       => $id_pend,
                'id_majors'     => $majors,
                'img_siswa' => $img_siswa,
                'img_kk' => $img_kk,
                'img_ijazah' => $img_ijazah,
                'img_ktp' => $img_ktp
            ];

            $this->db->where('id', $id);
            $this->db->update('ppdb', $data);

            if($status == 2){
                $this->db->set('status', 0);
                $this->db->where('id', $id);
                $this->db->update('ppdb');
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data pendaftaran kamu berhasil di update.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('ppdb/dashboard');
        }
    }

    public function payment()
    {
        if (!$this->session->userdata('nis')) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
             Silahkan masuk terlebih dahulu!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
         </div>');
            redirect('auth');
        }

        $user = $this->db->get_where('ppdb', ['nis' => $this->session->userdata('nis')])->row_array();

        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        $this->form_validation->set_rules('pay[]', 'Metode', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Pilih jenis pembayaran.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('ppdb/dashboard');
        } else {

            $kode    = $user['no_daftar'];
            $metode    = $this->input->post('pay');
            $jumlah    = $this->input->post('jumlah');
            
            $chanel = $this->M_payment->req_payment($user['id'], $kode, $jumlah, $metode);
            // var_dump($chanel);die;
            $datainv = [
                'url_inv' => $chanel['checkout_url'],
                'inv' => 2
            ];
            $this->db->where('id', $user['id']);
            $this->db->update('ppdb', $datainv);

            redirect($chanel['checkout_url']);
        }
    }
    
    public function logout()
    {
        $this->session->unset_userdata('nis');
        $this->session->unset_userdata('email');

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
}
