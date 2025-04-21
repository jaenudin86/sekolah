<?php

function wa_api($no, $pesan)
{
    $ci = get_instance();
    $wa = $ci->db->get_where('wa_gateway', ['id' => '1'])->row_array();

    $dataSending = Array();
    $dataSending["api_key"] = $wa['api_key'];
    $dataSending["number_key"] = $wa['number_key'];
    $dataSending["phone_no"] = $no;
    $dataSending["message"] = $pesan;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $wa['url'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dataSending),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    // var_dump($response);die;
}