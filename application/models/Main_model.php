<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model
{
    // Fetch siswa
    function getsiswa($searchTerm = "")
    {
        $user = sess_user_admin();

        $data_kelas = $this->db->get_where('kelas_pengajar', ['id_peng' => $user['id']])->result_array();
        $id_kelas = array_column($data_kelas,"id_kelas");

        if ($user['role_id'] == '3') {
        $this->db->where_in('id_kelas', $id_kelas);
        }else{
            $this->db->select('*');
        }

        $this->db->where("nama like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get('siswa');
        $siswa = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($siswa as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['nis'] . ' | ' . $user['nama']);
        }
        return $data;
    }

    // Fetch siswa
    function getAllsiswa($searchTerm = "")
    {
        $this->db->where("nama like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get('siswa');
        $siswa = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($siswa as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['nis'] . ' | ' . $user['nama']);
        }
        return $data;
    }

    // Fetch Karyawan
    function getKaryawan($searchTerm = "")
    {

        // Fetch karyawan
        $this->db->select('*');
        $this->db->where("nama like '%" . $searchTerm . "%' ");

        $fetched_records = $this->db->get('karyawan');
        $siswa = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($siswa as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['nama']);
        }
        return $data;
    }

    // Fetch siswa
    function getsiswa_pendidikan($pendidikan, $searchTerm = "")
    {
        // Fetch siswa
        $this->db->select('*');
        $this->db->where("nama like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get_where('siswa', ['id_pend' => $pendidikan]);
        $siswa = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($siswa as $user) {
            $data[] = array("id" => $user['nama'], "text" => $user['nis'] . ' | ' . $user['nama']);
        }
        return $data;
    }

    // Fetch siswa
    function getsiswa_kelas($kelas, $searchTerm = "")
    {
        // Fetch siswa
        $this->db->select('*');
        $this->db->where("nama like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get_where('siswa', ['id_kelas' => $kelas]);
        $siswa = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($siswa as $user) {
            $data[] = array("id" => $user['nama'], "text" => $user['nis'] . ' | ' . $user['nama']);
        }
        return $data;
    }

    // Fetch Takzir
    function getTakzir($searchTerm = "")
    {

        // Fetch Takzir
        $this->db->select('*');
        $this->db->where("nama like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get('data_pelanggaran');
        $takzir = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($takzir as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['kode'] . ' | ' . $user['nama']);
        }
        return $data;
    }

    function get_pres_ak($params = array())
    {
        $this->db->order_by('pres_akademik.id', 'DESC');
        $this->db->select('siswa.nama as nama_siswa, 
                            siswa.id_pend, data_pendidikan.nama as pend_name,
                            siswa.id_majors, data_jurusan.nama as majors_name,
                            siswa.id_kelas, data_kelas.nama as class_name,
                            pres_akademik.id as id,
                            pres_akademik.prestasi as prestasi,
                            pres_akademik.dokumen as dokumen,
                            pres_akademik.tgl as tgl,
                            ');
        $this->db->join('siswa', 'siswa.id = pres_akademik.id_siswa', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
    
        if (isset($params['id_kelas'])) {
            $this->db->where_in('id_kelas', $params['id_kelas']);
        }
    
        $res = $this->db->get('pres_akademik');
        return $res->result_array();
    }
    

    function get_pres_non_ak($params = array())
    {
        $this->db->order_by('pres_non_akademik.id', 'DESC');
        $this->db->select('siswa.nama as nama_siswa, 
                            siswa.id_pend, data_pendidikan.nama as pend_name,
                            siswa.id_majors, data_jurusan.nama as majors_name,
                            siswa.id_kelas, data_kelas.nama as class_name,
                            pres_non_akademik.id as id,
                            pres_non_akademik.prestasi as prestasi,
                            pres_non_akademik.dokumen as dokumen,
                            pres_non_akademik.tgl as tgl,
                            ');
        $this->db->join('siswa', 'siswa.id = pres_non_akademik.id_siswa', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
    
        if (isset($params['id_kelas'])) {
            $this->db->where_in('id_kelas', $params['id_kelas']);
        }
    
        $res = $this->db->get('pres_non_akademik');
        return $res->result_array();
    }

    function get_konseling($params = array())
    {
        if (isset($params['id_kelas'])) {
            $this->db->where_in('konseling.id_kelas', $params['id_kelas']);
        }
        $this->db->select('konseling.id, topik, solusi, tgl_pengajuan, tgl_tutup, pembuka, penutup, konseling.status');
        $this->db->select('siswa.nama as nama_siswa, 
        siswa.id_pend, data_pendidikan.nama as pend_name,
        siswa.id_majors, data_jurusan.nama as majors_name,
        siswa.id_kelas, data_kelas.nama as class_name,
        ');
        $this->db->join('siswa', 'siswa.id = konseling.id_siswa', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
        $res = $this->db->get('konseling');
        return $res->result_array();
    }
    function get_perizinan($params = array())
    {
        if (isset($params['id_kelas'])) {
            $this->db->where_in('siswa.id_kelas', $params['id_kelas']);
        }
        if (isset($params['tgl_awal']) && isset($params['tgl_akhir'])) {
            // Pastikan tgl_awal dan tgl_akhir sudah di-set dan bukan string kosong
            if (!empty($params['tgl_awal']) && !empty($params['tgl_akhir'])) {
                $this->db->where('perizinan.tgl >=', $params['tgl_awal']);
                $this->db->where('perizinan.tgl <=', $params['tgl_akhir']);
            }
        }
        if (isset($params['id_pend'])) {
            $this->db->where('siswa.id_pend', $params['id_pend']);
        }
        if (isset($params['id_jurus'])) {
            if(!empty($params['id_jurus'])){
                $this->db->where('siswa.id_majors', $params['id_jurus']);
            }
        }
        if (isset($params['id_kls'])) {
            if(!empty($params['id_kls'])){
                $this->db->where('siswa.id_kelas', $params['id_kls']);
            }
        }
    
        $this->db->select('perizinan.id, keterangan, tgl, expired, perizinan.status');
        $this->db->select('siswa.nama as nama_siswa, 
            siswa.id_pend, data_pendidikan.nama as pend_name,
            siswa.id_majors, data_jurusan.nama as majors_name,
            siswa.id_kelas, data_kelas.nama as class_name,
            data_perizinan.nama as nama_izin,
        ');
        $this->db->from('perizinan');
        $this->db->join('siswa', 'siswa.id = perizinan.id_siswa', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
        $this->db->join('data_perizinan', 'data_perizinan.id = perizinan.id_izin', 'left');
    
        $res = $this->db->get();
        return $res->result_array();
    }
    
    function get_daftar_absen($params = array())
    {
        if (isset($params['id_absen'])) {
            $this->db->where('daftar_absen.id', $params['id_absen']);
        }
        if (isset($params['id_kelas'])) {
            $this->db->where_in('daftar_absen.id_kelas', $params['id_kelas']);
        }
        $this->db->select('daftar_absen.id, daftar_absen.tgl, daftar_absen.status');
        $this->db->select('data_pendidikan.nama as pend_name, data_jurusan.nama as majors_name, data_kelas.nama as class_name');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = daftar_absen.id_pend', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = daftar_absen.id_kelas', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = data_kelas.id_jurus', 'left');
        $res = $this->db->get('daftar_absen');
        if (isset($params['id_absen'])) {
            return $res->row();
        } else {
            return $res->result_array();
        }
    }
    
    function get_absen($params = array())
    {
        if (isset($params['id_kelas'])) {
            $this->db->where_in('absen.id_kelas', $params['id_kelas']);
        }
        if (isset($params['id_absen'])) {
            $this->db->where('role_absen', $params['id_absen']);
        }
        $this->db->select('absen.id, absen.tgl, absen.waktu, absen.status, absen.ket');
        $this->db->select('siswa.nama as nama_siswa');
        $this->db->join('siswa', 'siswa.id = absen.id_siswa', 'left');
        $res = $this->db->get('absen');
        return $res->result_array();
    }
    
    function get_pelanggaran($params = array())
    {
        if (isset($params['id_kelas'])) {
            $this->db->where_in('siswa.id_kelas', $params['id_kelas']);
        }
        if (isset($params['tgl_awal']) && isset($params['tgl_akhir'])) {
            // Pastikan tgl_awal dan tgl_akhir sudah di-set dan bukan string kosong
            if (!empty($params['tgl_awal']) && !empty($params['tgl_akhir'])) {
                $this->db->where('pelanggaran.tgl >=', $params['tgl_awal']);
                $this->db->where('pelanggaran.tgl <=', $params['tgl_akhir']);
            }
        }
        if (isset($params['id_pend'])) {
            $this->db->where('siswa.id_pend', $params['id_pend']);
        }
        if (isset($params['id_jurus'])) {
            if(!empty($params['id_jurus'])){
                $this->db->where('siswa.id_majors', $params['id_jurus']);
            }
        }
        if (isset($params['id_kls'])) {
            if(!empty($params['id_kls'])){
                $this->db->where('siswa.id_kelas', $params['id_kls']);
            }
        }
        if (isset($params['id'])) {
            $this->db->where('id', $params['id']);
        }
        $this->db->select('pelanggaran.id, pelanggaran.id_pelang, pelanggaran.tgl');
        $this->db->select('siswa.nama as nama_siswa, 
                            siswa.id_pend, data_pendidikan.nama as pend_name,
                            siswa.id_majors, data_jurusan.nama as majors_name,
                            siswa.id_kelas, data_kelas.nama as class_name,
                            data_pelanggaran.nama as nama,
                            data_pelanggaran.point as point,
                        ');
        $this->db->join('siswa', 'siswa.id = pelanggaran.id_siswa', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
        $this->db->join('data_pelanggaran', 'data_pelanggaran.id = pelanggaran.id_pelang', 'left');
        $res = $this->db->get('pelanggaran');
        if (isset($params['id'])) {
            return $res->row();
        } else {
            return $res->result_array();
        }
    }
    
}
