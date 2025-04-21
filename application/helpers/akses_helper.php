<?php


function is_logged_in_admin()
{
    $ci = get_instance();
    
    $email = $ci->session->userdata('email');
    $role_id = $ci->session->userdata('role_id');

    $ci->db->where('email', $email);
    $ci->db->where('role_id', $role_id);
    $user = $ci->db->get('karyawan')->row();

    if ($user) {
        if ($email !== $user->email || $role_id !== $user->role_id) {
            $ci->session->unset_userdata('email');
            $ci->session->unset_userdata('role_id');
            delete_cookie('remember_me_admin');

            $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Silahkan login terlebih dahulu!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('auth/admin');
        }
    } else {
        $ci->session->unset_userdata('email');
        $ci->session->unset_userdata('role_id');
        delete_cookie('remember_me_admin');

        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Silahkan login terlebih dahulu!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button></div>');
        redirect('auth/admin');
    }
}

function is_logged_in()
{
    $ci = get_instance();
    
    $nis = $ci->session->userdata('nis');
    $role_id = $ci->session->userdata('role_id');

    $ci->db->where('nis', $nis);
    $ci->db->where('role_id', $role_id);
    $user = $ci->db->get('siswa')->row();

    if ($user) {
        if ($nis !== $user->nis || $role_id !== $user->role_id) {
            $ci->session->unset_userdata('nis');
            $ci->session->unset_userdata('role_id');
            delete_cookie('remember_me');

            $ci->session->set_flashdata('message', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Silahkan login terlebih dahulu!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
            redirect('auth');
        }
    } else {
        $ci->session->unset_userdata('nis');
        $ci->session->unset_userdata('role_id');
        delete_cookie('remember_me');

        $ci->session->set_flashdata('message', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Silahkan login terlebih dahulu!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>');
        redirect('auth');
    }
}


function sess_user_admin()
{
    $ci = get_instance();
    $array = $ci->db->get_where('karyawan', ['email' => $ci->session->userdata('email')]);
    return $array->row_array();
}

function sess_expired() 
{
    $ci = get_instance();
    $date = date('Y-m-d');
    $ci->db->where('expired <', $date);
    $izin = $ci->db->get('perizinan')->result_array();
    
    foreach($izin as $z){
        $sis = $ci->db->get_where('siswa', ['id' => $z['id_siswa']])->row_array();
        $data_izin = $ci->db->get_where('data_perizinan', ['id' => $z['id_izin']])->row_array();
        
        // Check if $sis and $data_izin are not null
        if ($sis !== null && $data_izin !== null) {
            $sum = $sis['point'] - $data_izin['point'];
            if($z['status'] == 'Proses'){
                $ci->db->set('point', max($sum, 0));
                $ci->db->where('id', $sis['id']);
                $ci->db->update('siswa');

                $ci->db->set('status', 'Expired');
                $ci->db->where('id_siswa', $sis['id']);
                $ci->db->update('perizinan');
            }
        }
    }
}
