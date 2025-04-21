<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model(['Main_model']);
    }

    function encode_img_base64($img_path = false, $img_type = 'jpg'){
        if( $img_path ){
            //convert image into Binary data
            $img_data = fopen ( $img_path, 'rb' );
            $img_size = filesize ( $img_path );
            $binary_image = fread ( $img_data, $img_size );
            fclose ( $img_data );
    
            //Build the src string to place inside your img tag
            $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", base64_encode($binary_image));
    
            return $img_src;
        }
    
        return false;
    }

    public function laporan_perizinan()
    {
        $data['title'] = 'Laporan Perizinan';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id_pend     = $this->input->post('pendidikan');
        $id_jurus     = $this->input->post('jurusan');
        $id_kls     = $this->input->post('kelas');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $pendidikan = $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();
        
        $params = [];
        $params['tgl_awal'] = $tgl_awal;
        $params['tgl_akhir'] = $tgl_akhir;
        $params['id_pend'] = $id_pend;
        $params['id_jurus'] = $id_jurus;
        $params['id_kls'] = $id_kls;
        $data['laporan'] = $this->Main_model->get_perizinan($params);
        
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['pendidikan'] = $pendidikan['nama'];
        
        if (!empty($id_jurus)) {
            $jurus = $this->db->get_where('data_jurusan', ['id' => $id_jurus])->row_array();
            $nama_jurus = '_' . $jurus['nama'];
            $data['jurus'] = $jurus['nama'];
        }else{
            $data['jurus'] = '';
            $nama_jurus = '';
        }
        
        if (!empty($id_kls)) {
            $kelas = $this->db->get_where('data_kelas', ['id' => $id_kls])->row_array();
            $nama_kelas = '_' . $kelas['nama'];
            $data['kelas'] = $kelas['nama'];
        }else{
            $data['kelas'] = '';
            $nama_kelas = '';
        }

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-perizinan ' . $pendidikan['nama'] . $nama_kelas . $nama_jurus .' .pdf';

        $this->pdf->load_view('laporan/laporan_perizinan', $data);
    }


    public function laporan_pelanggaran()
    {
        $data['title'] = 'Laporan Pelanggaran';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id_pend     = $this->input->post('pendidikan');
        $id_jurus     = $this->input->post('jurusan');
        $id_kls     = $this->input->post('kelas');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $pendidikan = $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();

        $params = [];
        $params['tgl_awal'] = $tgl_awal;
        $params['tgl_akhir'] = $tgl_akhir;
        $params['id_pend'] = $id_pend;
        $params['id_jurus'] = $id_jurus;
        $params['id_kls'] = $id_kls;
        $data['laporan'] = $this->Main_model->get_pelanggaran($params);

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['pendidikan'] = $pendidikan['nama'];
       
        if (!empty($id_jurus)) {
            $jurus = $this->db->get_where('data_jurusan', ['id' => $id_jurus])->row_array();
            $nama_jurus = '_' . $jurus['nama'];
            $data['jurus'] = $jurus['nama'];
        }else{
            $data['jurus'] = '';
            $nama_jurus = '';
        }
        
        if (!empty($id_kls)) {
            $kelas = $this->db->get_where('data_kelas', ['id' => $id_kls])->row_array();
            $nama_kelas = '_' . $kelas['nama'];
            $data['kelas'] = $kelas['nama'];
        }else{
            $data['kelas'] = '';
            $nama_kelas = '';
        }

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-pelanggaran ' . $pendidikan['nama'] . $nama_kelas . $nama_jurus .' .pdf';

        $this->pdf->load_view('laporan/laporan_pelanggaran', $data);
    }


    public function laporan_pelanggaran_siswa()
    {
        $data['title'] = 'Laporan Pelanggaran';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id_san     = $this->input->post('siswa');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $siswa = $this->db->get_where('siswa', ['id' => $id_san])->row_array();

        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $tgl_akhir);
        $this->db->where('id_siswa', $id_san);
        $data['laporan'] = $this->db->get('pelanggaran')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['siswa'] = $siswa['nama'];


        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-pelanggaran ' . $siswa['nama'] . ' .pdf';

        $this->pdf->load_view('laporan/laporan_pelanggaran', $data);
    }


    public function laporan_absen()
    {
        $data['title'] = 'Laporan Absen';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id     = $this->input->post('id');

        $this->db->where('role_absen', $id);
        $data['laporan'] = $this->db->get('absen')->result_array();

        $params['id_absen'] = $id;
        $data['daftar_absen'] = $this->Main_model->get_daftar_absen($params);

        $kelas_major = $data['daftar_absen']->class_name . ($data['daftar_absen']->majors_name ? '_' . $data['daftar_absen']->majors_name : '');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'Laporan-absen_' . $data['daftar_absen']->pend_name . '_' . $kelas_major . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen', $data);
    }

    public function laporan_absen_pegawai()
    {
        $data['title'] = 'Laporan Absen Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id     = $this->input->post('id');

        $this->db->where('role_absen', $id);
        $data['laporan'] = $this->db->get('absen_pegawai')->result_array();

        $this->db->where('id', $id);
        $data['daftar_absen'] = $this->db->get('data_absen_pegawai')->row_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'Laporan-absen-pegawai_' . mediumdate_indo(date($data['daftar_absen']['tgl'])) . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen_pegawai', $data);
    }


    public function laporan_konseling()
    {
        $data['title'] = 'Laporan Absen';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id     = $this->input->post('id');

        $this->db->where('role_konseling', $id);
        $this->db->order_by('id', 'asc');
        $data['laporan'] = $this->db->get('balas_konseling')->result_array();

        $this->db->where('id', $id);
        $data['konseling'] = $this->db->get('konseling')->row_array();
        $id_san = $data['konseling']['id_siswa'];

        $data['siswa'] = $this->db->get('siswa', ['id' => $id_san])->row_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-konseling_' . $data['konseling']['topik'] . '_' . $data['siswa']['nama'] . '.pdf';

        $this->pdf->load_view('laporan/laporan_konseling', $data);
    }

    public function cetak_formulir()
    {
        $data['title'] = 'Cetak Formulir';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id     = $this->input->get('id');
        $id = $this->secure->decrypt($id);

        $data['ppdb'] = $this->db->get_where('ppdb', ['id' => $id])->row_array();
        $data['period'] = $this->db->get_where('period', ['id' => $data['ppdb']['thn_msk']])->row_array();

        // $data['header'] = $this->encode_img_base64('assets/img/formulir/header.jpg');
        // $data['footer'] = $this->encode_img_base64('assets/img/formulir/footer.jpg');


        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'cetak_formulir_' . $data['ppdb']['nama'] . '.pdf';
        $this->pdf->load_view('laporan/cetakformulir', $data);
    }

    public function laporan_slip()
    {
        $data['title'] = 'Laporan Slip Gaji';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $id     = $this->input->post('id');
        $gajian = $this->db->get_where('penggajian', ['id' => $id])->row_array();
        $users = $this->db->get_where('karyawan', ['id' => $gajian['id_peng']])->row_array();

        $data['gaji'] = $gajian;
        $data['cicilan'] = $this->db->get_where('data_cicilan', ['id_peng' => $gajian['id_peng']])->result_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan_slip_gaji_' . $users['nama'] . '.pdf';

        $this->pdf->load_view('laporan/laporan_slip', $data);
    }

    public function laporan_absen_pegawai_bulanan()
    {
        $data['title'] = 'Laporan Absen Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $this->db->where('role_id !=', 1);
        $data['karyawan'] = $this->db->get('karyawan')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-absen_tanggal' . mediumdate_indo(date($tgl_awal)) . ' - ' . mediumdate_indo(date($tgl_akhir)) . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen_pegawai_bulanan', $data);
    }

    public function laporan_data_absensi_pegawai()
    {
        $data['title'] = 'Laporan Data Absensi Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = sess_user_admin();

        $divisi  = $this->input->post('divisi');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        if (!empty($divisi)) {
            $this->db->where('id_divisi', $divisi);
        }
        $this->db->where('role_id !=', 1);
        $data['karyawan'] = $this->db->get('karyawan')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;


        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan_data_absen_tanggal' . mediumdate_indo(date($tgl_awal)) . ' - ' . mediumdate_indo(date($tgl_akhir)) . '.pdf';

        $this->pdf->load_view('laporan/laporan_data_absensi_pegawai', $data);
    }
    
    public function cetak_invoice()
    {
        $data['title'] = 'Invoice PPDB';
        $data['web'] =  $this->db->get('website')->row_array();
        $id     = $this->input->get('id');
        $id = $this->secure->decrypt($id);
        $data['user'] = $this->db->get_where('ppdb', ['id' => $id])->row_array();

        $data['pay'] = $this->db->get_where('data_pembayaran', ['jenis' => 'PPDB'])->result_array();
        
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'invoice_ppdb_' . $data['user']['nama'] . '.pdf';

        $this->pdf->load_view('laporan/invoicePPDB', $data);
    }

}
