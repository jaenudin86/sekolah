<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Bebas_model', 'Log_trx_model'));
    }

    public function index()
    {
        $json = $this->input->raw_input_stream;

        $this->db->where('id', 1);  
        $query  =  $this->db->get('payment')->row_array();

        // Isi dengan private key anda
        $privateKey = $query['private_key'];
        $signa = $this->input->server('HTTP_X_CALLBACK_SIGNATURE');
        $event = $this->input->server('HTTP_X_CALLBACK_EVENT');
        
        $callbackSignature = isset($signa) ? $signa: '';
     
        // Generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $privateKey);
        
        if ($callbackSignature !== $signature) {
            exit('Invalid signature');
        }

        if ('payment_status' !== $event) {
            echo 'Invalid callback event, no action was taken';
        }
        
        $data = json_decode($json);
        $uniqueRef = $data->merchant_ref;
        $status = strtoupper((string) $data->status);

        /*
        |--------------------------------------------------------------------------
        | Proses callback untuk closed payment
        |--------------------------------------------------------------------------
        */
        if (1 === (int) $data->is_closed_payment) {
          
            if ($status == 'PAID'){
                $stat = '1';
                $bs = '1';
            } elseif ($status == 'EXPIRED'){
                $stat = '0';
                $bs = '0';
            } elseif ($status == 'FAILED'){
                $stat = '0';
                $bs = '0';
            } elseif ($status == 'UNPAID'){
                $stat = '2';
                $bs = '0';
            }

            if(strpos($uniqueRef, 'IVB') !== false){
                $data = [
                    'inv' => $stat,
                    'date_inv' => date('Y-m-d')
                ];
                $this->db->where('kode_inv', $uniqueRef);
                $this->db->update('bebas_pay', $data);
                
                if ($status == 'PAID'){

                    $this->db->select ( '*' )
                    ->from('bebas_pay')
                    ->join('bebas', 'bebas_pay.bebas_bebas_id = bebas.bebas_id')
                    ->join('siswa', 'bebas.student_student_id = siswa.id');
                    $this->db->where('bebas_pay.kode_inv', $uniqueRef);
                    $bebas = $this->db->get()->row_array();

                    $this->Bebas_model->add(array('increase_budget' => $bebas['bebas_pay_bill'], 'bebas_id' =>  $bebas['bebas_id'], 'bebas_last_update' => date('Y-m-d H:i:s')));
                    
                    $log = array(
                        'bulan_bulan_id' => NULL,
                        'bebas_pay_bebas_pay_id' => $bebas['bebas_pay_id'],
                        'student_student_id' => $bebas['student_student_id'],
                        'log_trx_input_date' =>  date('Y-m-d H:i:s'),
                        'log_trx_last_update' => date('Y-m-d H:i:s'),
                    );
                    $this->Log_trx_model->add($log);

                    $find = array("https://","http://");
                    $replace = "www.";
                    $arr = site_url();
                    $site = str_replace($find,$replace,$arr);
            
                    $no = $bebas['no_hp'];
                    $pesan = 'Pembayaran bebas anda telah berhasil.
        
Info website : 
' . $site . '

Terimakasih.';
                    if($no){
                        wa_api($no, $pesan);
                    }
                }
            }elseif(strpos($uniqueRef, 'INV') !== false){
                $data = [
                    'bulan_status' => $bs,
                    'bulan_date_pay' => date('Y-m-d'),
                    'inv' => $stat,
                    'date_inv' => date('Y-m-d')
                ];
                $this->db->where('kode_inv', $uniqueRef);
                $this->db->update('bulan', $data);
                
                if ($status == 'PAID'){

                    $this->db->select ( '*' )
                    ->from('bulan')
                    ->join('siswa', 'bulan.student_student_id = siswa.id');
                    $this->db->where('bulan.kode_inv', $uniqueRef);
                    $bulan = $this->db->get()->row_array();

                    $log = array(
                        'bulan_bulan_id' => $bulan['bulan_id'],
                        'bebas_pay_bebas_pay_id' => NULL,
                        'student_student_id' => $bulan['student_student_id'],
                        'log_trx_input_date' =>  date('Y-m-d H:i:s'),
                        'log_trx_last_update' => date('Y-m-d H:i:s'),
                    );
                    $this->Log_trx_model->add($log);


                    $find = array("https://","http://");
                    $replace = "www.";
                    $arr = site_url();
                    $site = str_replace($find,$replace,$arr);
            
                    $no = $bulan['no_hp'];
                    $pesan = 'Pembayaran bulanan anda telah berhasil.
        
Info website : 
' . $site . '

Terimakasih.';
                    if($no){
                        wa_api($no, $pesan);
                    }
                }

            } else {
                $data = [
                    'inv' => $stat,
                    'date_inv' => date('Y-m-d')
                ];
                $this->db->where('kode_inv', $uniqueRef);
                $this->db->update('ppdb', $data);
                
                if ($status == 'PAID'){
                    
                    $ppdb =  $this->db->get_where('ppdb', ['kode_inv' => $uniqueRef])->row_array();

                    $find = array("https://","http://");
                    $replace = "www.";
                    $arr = site_url();
                    $site = str_replace($find,$replace,$arr);
            
                    $no = $ppdb['no_hp'];
                    $pesan = 'Pembayaran PPDB anda telah berhasil.
        
Info website : 
' . $site . '

Terimakasih.';
                    if($no){
                        wa_api($no, $pesan);
                    }
                    
                    $staff =  $this->db->get_where('karyawan', ['kode_reff' => $ppdb['kode_reff']])->row_array();
                    $jumlah = $staff['jumlah_reff'] + 1;
                    $this->db->set('jumlah_reff', $jumlah);
                    $this->db->where('id', $staff['id']);
                    $this->db->update('karyawan');
                }
            }
            echo json_encode(['success' => true]);
            exit;
        }

    }

}