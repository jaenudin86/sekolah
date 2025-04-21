<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Main_model', 'M_payment']);
    }

    public function getsiswa()
    {
        // Search term
        $searchTerm = $this->input->post('search');

        // Get siswa
        $response = $this->Main_model->getsiswa($searchTerm);

        echo json_encode($response);
    }

    public function getAllsiswa()
    {
        // Search term
        $searchTerm = $this->input->post('search');

        // Get siswa
        $response = $this->Main_model->getAllsiswa($searchTerm);


        echo json_encode($response);
    }


    public function getsiswa_pendidikan()
    {
        $sesi = sess_user_admin();
        $pendidikan = $sesi['pendidikan'];
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getsiswa_pendidikan($pendidikan, $searchTerm);

        echo json_encode($response);
    }

    public function get_majors_kelas()
    {
        $pend = $this->input->post('pend');
        if (isset($pend)) {
            $penddkn = $this->db->get_where('data_pendidikan', ['id' => $pend])->row();
            $majors    = $this->db->get_where('data_jurusan', ['id_pend' => $pend])->result_array();
            $kelas     = $this->db->get_where('data_kelas', ['id_pend' => $pend])->result_array();

            if (is_object($penddkn) && isset($penddkn->majors) && $penddkn->majors == 1) {
                if (isset($majors[0]) && is_array($majors)) {
                    $options = '<div class="col-md-12">
                     <div class="form-group">
                    <label>Kejuruan</label>
                    <select class="form-control" id="jurusan" name="jurusan">';
                    $options .= '<option value="">- Pilih Kejuruan -</option>';
                        foreach ($majors as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                            </div>';

                    $options .= '<div class="col-md-12" id="div-kelas">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control" id="kelas" name="kelas">
                                            <option value="">- Pilih Kejuruan Dahulu -</option>
                                        </select>
                                    </div>
                                </div>';

                    echo $options;
                }
            }else{
                if (isset($kelas[0]) && is_array($kelas)) {
                    $options = '<div class="col-md-12">
                                    <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">';
                    $options .= '<option selected value="">- Pilih Kelas -</option>';
                        foreach ($kelas as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                                </div>';
                    echo $options;
                }
            }
        }
    }


    public function get_majors_kelas_peng()
    {
        $user = sess_user_admin();
        $pend = $this->input->post('pend');

        if (isset($pend)) {
   
            $penddkn = $this->db->get_where('data_pendidikan', ['id' => $pend])->row();
            
            if($user['role_id'] === '3'){
                $data_kelas = $this->db->get_where('kelas_pengajar', ['id_peng' => $user['id']])->result_array();
                $id_kelas = array_column($data_kelas,"id_kelas");

                $majors =  $this->db->select('dj.id as jurus_id, dj.nama as nama_jurus, kp.*') 
                                ->from('data_jurusan dj')
                                ->join('kelas_pengajar kp', 'dj.id = kp.id_jurus')
                                ->where('dj.id_pend', $pend)
                                ->where('kp.id_peng', $user['id'])
                                ->get()
                                ->result_array();

                $kelas = $this->db->where('id_pend', $pend)->where_in('id', $id_kelas)->get('data_kelas')->result_array();
                
            }else{
                $majors =  $this->db
                                ->select('id as jurus_id, nama as nama_jurus')
                                ->get_where('data_jurusan', ['id_pend' => $pend])
                                ->result_array();
                $kelas = $this->db->where('id_pend', $pend)->get('data_kelas')->result_array();
            }
      
          

            if (is_object($penddkn) && isset($penddkn->majors) && $penddkn->majors == 1) {
                if (isset($majors[0]) && is_array($majors)) {
                    $options = '<div>
                     <div class="form-group">
                    <label>Kejuruan</label>
                    <select class="form-control" id="jurusan" name="jurusan">';
                    $options .= '<option value="">- Pilih Kejuruan -</option>';
                        foreach ($majors as $value) {
                            $options  .= '<option value="' . $value['jurus_id'] . '">' .
                            $value['nama_jurus'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                            </div>';

                    $options .= '<div id="div-kelas">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control" id="kelas" name="kelas">
                                            <option value="">- Pilih Kejuruan Dahulu -</option>
                                        </select>
                                    </div>
                                </div>';

                    echo $options;
                }
            }else{
                if (isset($kelas[0]) && is_array($kelas)) {
                    $options = '<div>
                                    <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">';
                    $options .= '<option selected value="">- Pilih Kelas -</option>';
                        foreach ($kelas as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                                </div>';
                    echo $options;
                }
            }
        }
    }

    public function get_majors_kelas_pemb()
    {
        $user = sess_user_admin();
        $pend = $this->input->post('pend');

        if (isset($pend)) {
   
            $penddkn = $this->db->get_where('data_pendidikan', ['id' => $pend])->row();
            
            if($user['role_id'] === '3'){
                $data_kelas = $this->db->get_where('kelas_pengajar', ['id_peng' => $user['id']])->result_array();
                $id_kelas = array_column($data_kelas,"id_kelas");

                $majors =  $this->db->select('dj.id as jurus_id, dj.nama as nama_jurus, kp.*') 
                                ->from('data_jurusan dj')
                                ->join('kelas_pengajar kp', 'dj.id = kp.id_jurus')
                                ->where('dj.id_pend', $pend)
                                ->where('kp.id_peng', $user['id'])
                                ->get()
                                ->result_array();

                $kelas = $this->db->where('id_pend', $pend)->where_in('id', $id_kelas)->get('data_kelas')->result_array();
                
            }else{
                $majors =  $this->db
                                ->select('id as jurus_id, nama as nama_jurus')
                                ->get_where('data_jurusan', ['id_pend' => $pend])
                                ->result_array();
                $kelas = $this->db->where('id_pend', $pend)->get('data_kelas')->result_array();
            }
      
          

            if (is_object($penddkn) && isset($penddkn->majors) && $penddkn->majors == 1) {
                if (isset($majors[0]) && is_array($majors)) {
                    $options = '<div class="form-group row">
                    <label for="" class="col-sm-4 control-label">Kejuruan</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="jurusan" name="jurusan">';
                    $options .= '<option value="">- Pilih Kejuruan -</option>';
                        foreach ($majors as $value) {
                            $options  .= '<option value="' . $value['jurus_id'] . '">' .
                            $value['nama_jurus'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                            </div>';

                    $options .= '<div id="div-kelas" class="form-group row">
                                    <label for="" class="col-sm-4 control-label">Kelas</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="kelas" name="class_id">
                                            <option value="">- Pilih Kejuruan Dahulu -</option>
                                        </select>
                                    </div>
                                </div>';

                    echo $options;
                }
            }else{
                if (isset($kelas[0]) && is_array($kelas)) {
                    $options = '<div class="form-group row">
                                <label for="" class="col-sm-4 control-label">Kelas</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="kelas" name="class_id">';
                    $options .= '<option selected value="">- Pilih Kelas -</option>';
                        foreach ($kelas as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>
                                </div>';
                    echo $options;
                }
            }
        }
    }

    public function get_majors_kelas_edit()
    {
        $pend = $this->input->post('pend');
        $major = $this->input->post('major');
        $kelas = $this->input->post('kelas');
        
        if (isset($pend)) {
            $penddkn = $this->db->get_where('data_pendidikan', ['id' => $pend])->row();
            $majors = $this->db->get_where('data_jurusan', ['id_pend' => $pend])->result_array();
            $kelass = $this->db->get_where('data_kelas', ['id_pend' => $pend])->result_array();
    
            if ($penddkn->majors == 1) {
                if($major !== '0'){
                    $kelasss = $this->db->get_where('data_kelas', ['id_jurus' => $major])->result_array();
                }
    
                $options = '<div class="col-md-12">
                                <div class="form-group">
                                    <label>Kejuruan</label>
                                    <select class="form-control" id="jurusan" name="jurusan">';
                $options .= '<option value="">- Pilih Kejuruan -</option>';
                foreach ($majors as $value) {
                    $selected = ($major == $value['id']) ? 'selected' : '';
                    $options .= '<option value="' . $value['id'] . '" ' . $selected . '>' .
                                $value['nama'] . '</option>';
                }
                $options .= '</select>
                            </div>
                        </div>';
    
                $options .= '<div class="col-md-12" id="div-kelas">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">';
                if($major !== '0'){
                    $options .= '<option value="">- Pilih Kelas -</option>';
                    foreach ($kelasss as $value) {
                        $selected = ($kelas == $value['id']) ? 'selected' : '';
                        $options .= '<option value="' . $value['id'] . '" ' . $selected . '>' .
                                    $value['nama'] . '</option>';
                    }
                }else{
                    $options .= '<option value="">- Pilih Kejuruan Dahulu -</option>';
                }

                $options .= '</select>
                            <div id="err-kelas" class="invalid-feedback">Kelas harus dipilih.</div>
                            </div>
                        </div>';
    
                echo $options;
            } else {
                $options = '<div class="col-md-12">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">';
                $options .= '<option value="">- Pilih Kelas -</option>';
                foreach ($kelass as $value) {
                    $selected = ($kelas == $value['id']) ? 'selected' : '';
                    $options .= '<option value="' . $value['id'] . '" ' . $selected . '>' .
                                $value['nama'] . '</option>';
                }
                $options .= '</select>
                            <div id="err-kelas" class="invalid-feedback">Kelas harus dipilih.</div>
                            </div>
                        </div>';
                
                echo $options;
            }
        }
    }
    

    public function get_majors_kelas_karyawan()
    {
        $id = $this->input->post('id');
        $pend = $this->input->post('pend');
        if (isset($pend)) {
            $penddkn = $this->db->get_where('data_pendidikan', ['id' => $pend])->row();
            $majors    = $this->db->get_where('data_jurusan', ['id_pend' => $pend])->result_array();
            $kelas     = $this->db->get_where('data_kelas', ['id_pend' => $pend])->result_array();

            if($penddkn->majors == 1){
                if (isset($majors[0]) && is_array($majors)) {
                    $options = ' <div class="form-group">
                    <label>Kejuruan</label>
                    <select class="form-control" id="jurusan'.$id.'" name="jurusan">';
                    $options .= '<option value="">- Pilih Kejuruan -</option>';
                        foreach ($majors as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>';

                    $options .= '<div class="form-group" id="div-kelas'.$id.'">
                                <label>Kelas</label>
                                <select class="form-control" id="kelas'.$id.'" name="kelas">
                                    <option value="">- Pilih Kejuruan Dahulu -</option>
                                </select>
                            </div>';

                    echo $options;
                }
            }else{
                if (isset($kelas[0]) && is_array($kelas)) {
                    $options = ' <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">';
                    $options .= '<option selected value="">- Pilih Kelas -</option>';
                        foreach ($kelas as $value) {
                            $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                        }
                    $options .= '</select>
                                </div>';
                    echo $options;
                }
            }
        }
    }

    public function getKaryawan()
    {
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getKaryawan($searchTerm);

        echo json_encode($response);
    }


    public function getsiswa_kelas()
    {
        $kelas = $this->uri->segment(3);
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getsiswa_kelas($kelas, $searchTerm);

        echo json_encode($response);
    }


    public function get_point()
    {
        $jenis = $this->input->post('jenis');
        if (isset($jenis)) {
            $this->db->where('id', $jenis);
            $query  =  $this->db->get('data_pelanggaran');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                foreach ($result as $value) {
                    $options  = $value['point'];
                }
                echo $options;
            }
        }
    }

    public function get_pelanggaran()
    {
        $jenis = $this->input->post('jenis');
        if (isset($jenis)) {
            $this->db->where('id', $jenis);
            $query  =  $this->db->get('data_pelanggaran');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                foreach ($result as $value) {
                    $options  = $value['nama'];
                }
                echo $options;
            }
        }
    }

    public function get_izin()
    {
        $absen = $this->input->post('absen');
        if (isset($absen)) {
            $query  =  $this->db->get('data_perizinan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Perizinan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_majors()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_jurusan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Jurusan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_id_majors()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id', $pendidikan);
            $query  =  $this->db->get('data_pendidikan');
            $result =  $query->row_array();
                $options = $result['majors'];
                echo $options;
        }
    }
    
    public function get_kelas_majors()
    {
        $majors = $this->input->post('majors');
        if (isset($majors)) {
            $this->db->where('id_jurus', $majors);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }
    
    public function get_kelas_majors_peng()
    {
        $user = sess_user_admin();
        $data_kelas = $this->db->get_where('kelas_pengajar', ['id_peng' => $user['id']])->result_array();
        $id_kelas = array_column($data_kelas,"id_kelas");

        $majors = $this->input->post('majors');
        if (isset($majors)) {
            $this->db->where('id_jurus', $majors);
            if($user['role_id'] === '3'){
            $this->db->where_in('id', $id_kelas);
            }
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kelas_all()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $pend =  $this->db->get_where('data_pendidikan', ['id' => $pendidikan])->row();
            if($pend->majors == '1'){
                $options = '<option selected value="">- Pilih Kejuruan Dahulu -</option>';
                echo $options;
            }else{
                $this->db->where('id_pend', $pendidikan);
                $result =  $this->db->get('data_kelas')->result_array();
                if (isset($result[0]) && is_array($result)) {
                    $options = '';
                    $options .= '<option selected value="">- Pilih Kelas -</option>';
                    foreach ($result as $value) {
                        $options  .= '<option value="' . $value['id'] . '">' .
                            $value['nama'] . '</option>';
                    }
                    echo $options;
                }
            }
        }
    }

    public function get_kelas_ajax()
    {
        $f = $this->input->get(NULL, TRUE);
        $data['f'] = $f;
        $params = array();
        // Nip
        if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
        $params['class_id'] = $f['pr'];
        }
        
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option'.(isset($f['pr']) and $f['pr'] == $value['id']) ? 'selected' : ''.' value="' . $value['id'] . '">' . $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota()
    {
        $seg = $this->uri->segment(3);
        $prov = $this->input->post('prov');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                if ($seg == 'daftar') {
                    $options .= '<option selected value="">- Pilih provinsi saja -</option>';
                } else {
                    $options .= '<option selected disabled>- Pilih Kota -</option>';
                }
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota_ppdb()
    {
        $prov = $this->input->post('prov');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                    $options .= '<option selected disabled>- Pilih Kota -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kec()
    {
        $kab = $this->input->post('kab');
        if (isset($kab)) {
            $this->db->order_by('nama', 'asc');
            $this->db->where('id_kab', $kab);
            $query  =  $this->db->get('kecamatan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                    $options .= '<option selected disabled>- Pilih Kecamatan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kec'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kel()
    {
        $kec = $this->input->post('kec');
        if (isset($kec)) {
            $this->db->order_by('nama', 'asc');
            $this->db->where('id_kec', $kec);
            $query  =  $this->db->get('kelurahan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                    $options .= '<option selected disabled>- Pilih Kelurahan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kel'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota_edit()
    {
        $prov = $this->input->post('prov1');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Kota -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_ket_point()
    {
        $id = $this->input->post('jenis');
        if (isset($id)) {
            $this->db->where('id', $id);
            $query  =  $this->db->get('data_perizinan')->row_array();
            $options['div'] = '<div class="alert alert-dark" role="alert">
                                Jika Expired point berkurang -'.$query['point'].'
                            </div>';
            $options['id'] = $id;
                echo json_encode($options);
        }
    }
    
    public function get_jenis_pay()
    {
        $chanel = $this->M_payment->get_chanel();

        if (isset($chanel[0]) && is_array($chanel)) {
            $options = '<div class="row mb-3">
                            <div class="col-md-12"><h5>Virtual Account Bank :</h5></div>';
            foreach ($chanel as $value) {
                if($value['active'] == true){
                    if($value['group'] == 'Virtual Account'){
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="'.$value['code'].'" value="'.$value['code'].'"/>
                                    <label for="'.$value['code'].'" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                               <img src="'.$value['icon_url'].'" alt="'.$value['icon_url'].'" width="80" height="35"/>
                                        </div>
                                            <p class="text-center">'.$value['code'].'</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            $options .= '<div class="row mb-3">
                        <div class="col-md-12"><h5>Convenience Store :</h5></div>';
            foreach ($chanel as $value) {
                if($value['active'] == true){
                    if($value['group'] == 'Convenience Store'){
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="'.$value['code'].'" value="'.$value['code'].'"/>
                                    <label for="'.$value['code'].'" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                            <img src="'.$value['icon_url'].'" alt="'.$value['icon_url'].'" width="80" height="35">
                                        </div>
                                        <p class="text-center">'.$value['code'].'</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            $options .= '<div class="row mb-3">
                        <div class="col-md-12"><h5>E-Wallet :</h5></div>';
            foreach ($chanel as $value) {
                if($value['active'] == true){
                    if($value['group'] == 'E-Wallet'){
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="'.$value['code'].'" value="'.$value['code'].'"/>
                                    <label for="'.$value['code'].'" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                            <img src="'.$value['icon_url'].'" alt="'.$value['icon_url'].'" width="80" height="35">
                                        </div>
                                        <p class="text-center">'.$value['name'].'</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            echo $options;
        }
    }

    
    public function data_bulan()
    {
        $id = $this->input->post('id', true);
        $this->db->select ( '*' )
        ->from('bulan');
        $this->db->where('bulan.bulan_id', $id);
       echo json_encode($this->db->get()->row_array());
    }
    
    public function data_bebas()
    {
        $id = $this->input->post('id', true);
        $this->db->select ( '*' )
        ->from('bebas');
        $this->db->where('bebas.bebas_id', $id);
       echo json_encode($this->db->get()->row_array());
    }

}