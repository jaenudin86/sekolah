<style type="text/css">
    img[src=""] {
        display: none;
    }

    .pointer {
        cursor: pointer;
    }

input[type="checkbox"][class^="cb"] {
  display: none;
}

label {
  border: 1px solid #fff;
  display: block;
  position: relative;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 35px;
  width: 80px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}
:checked + .bg {
    background-color: darkgray;
    color: white;
}
:checked + label img {
    transform: scale(0.9);
    z-index: -1;
}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="col-md-12 text-center">
        <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-list fa-fw"></i><?= $title ?></h1>
        <hr />
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Transaksi Bulanan

                        <div class="float-right">
                            <a href="<?= base_url('siswa/payout') ?>" class="btn btn-block btn-danger btn-sm"><i class="fa fa-random"></i> &nbsp;Kembali</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messageKet') ?>
                    <table class="table table-hover table-striped table-bordered" id="mytable">
                        <tbody>
                            <?php foreach ($bulan as $row) : ?>
                                <tr>
                                    <td class="text-left"><b><?= $row['month_name']; ?></b></td>
                                    <input type="hidden" name="bulan_id[]" value="<?= $row['bulan_id'] ?>">
                                    <td class="<?= ($row['bulan_status'] == 1) ? 'danger' : 'success' ?> text-center">
                                        <?php if($row['inv']  == '2') : ?>
                                        <a href="<?= $row['url_inv'] ?>" class="btn btn-xs btn-warning" <?= ($row['bulan_status'] == 1) ?  'style="pointer-events: none"' : '' ?>>
                                        <?php elseif($row['inv']  == '1') : ?>
                                        <a href="<?= $row['url_inv'] ?>" class="btn btn-xs btn-success" <?= ($row['bulan_status'] == 1) ?  'style="pointer-events: none"' : '' ?>>
                                        <?php elseif($row['inv']  == '0') : ?>
                                        <a href="#" data-toggle="modal" data-target="#payModal" data-id="<?= $row['bulan_id'] ?>" class="tombol-edit btn btn-xs btn-<?= ($row['bulan_status'] == 1) ?  'success' : 'danger' ?>" <?= ($row['bulan_status'] == 1) ?  'style="pointer-events: none"' : '' ?>>
                                        <?php else : ?>   
                                        <a href="#" data-toggle="modal" data-target="#payModal" data-id="<?= $row['bulan_id'] ?>" class="tombol-edit btn btn-xs btn-<?= ($row['bulan_status'] == 1) ?  'success' : 'danger' ?>" <?= ($row['bulan_status'] == 1) ?  'style="pointer-events: none"' : '' ?>>
                                        <?php endif ?>
                                        <b><?= ($row['bulan_status'] == 1) ? '(' . pretty_date($row['bulan_date_pay'], 'd/m/y', false) . ')' : number_format($row['bulan_bill'], 0, ',', '.') ?></b></a>
                                    </td>
                                    <td class="<?= ($row['bulan_status'] == 1) ? 'success' : 'danger' ?> text-center">
                                        <a style="color:white;" data-toggle="modal" data-target="#addDesc<?= $row['bulan_id'] ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit margin-r-5"></i> <b>Tambah Keterangan</b></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="addDesc<?= $row['bulan_id'] ?>" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tambah Keterangan</h4>
                                            </div>
                                            <?= form_open('payout/update_pay_desc?role=siswa', array('method' => 'post')); ?>
                                            <div class="modal-body">
                                                <input type="hidden" name="bulan_id" value="<?= $row['bulan_id'] ?>">
                                                <input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
                                                <input type="hidden" name="student_nis" value="<?= $row['nis'] ?>">
                                                <input type="hidden" name="period_period_id" value="<?= $row['period_period_id'] ?>">
                                                <input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Keterangan *</label>
                                                        <input type="text" required="" name="bulan_pay_desc" value="<?= $row['bulan_pay_desc'] ?>" class="form-control" placeholder="Keterangan">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save margin-r-5"></i> <b>SIMPAN DATA</b></button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i><b> TUTUP</b></button>
                                            </div>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Jenis Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $payment['pos_name'] . ' - T.P ' . $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Tahun Pelajaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Tipe Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= ($payment['payment_type'] == 'BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">NIS</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['nis'] ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['nama'] ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 control-label">Kelas</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" value="<?= $student['class_name'] ?>">
                        </div>
                    </div>
                    <br>
                    <?php if(!empty($student['id_majors'])) : ?>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 control-label">Program Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly="" value="<?= $student['majors_name'] ?>">
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    
</div>


    <!-- Payment Modal-->
    <div class="modal fade" id="payModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Pembayaran :</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('siswa/payment_bulan/'.$this->uri->segment(3).'/'.$this->uri->segment(4)) ?>" method="post" id="payy">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="jumlah" id="jumlah" value="">
                        <div id="jenis_pay"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success" onclick="$('#payy').submit()"><i class="bi bi-credit-card"></i> Bayar <b id="jum"></b></button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
	function number_format (number, decimals, decPoint, thousandsSep) { 
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
		var n = !isFinite(+number) ? 0 : +number
		var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
		var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
		var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
		var s = ''

		var toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec)
		return '' + (Math.round(n * k) / k)
			.toFixed(prec)
		}

		// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
		if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
		}
		if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
		}

		return s.join(dec)
	}

    $(document).ready(function() {
        $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_jenis_pay'); ?>',
                cache: false,
                success: function(response) {
                    $('#jenis_pay').html();
                    $('#jenis_pay').html(response);
                }
            });

            $(document).on('change', ".cb", function() {
                $(".cb").not(this).prop('checked', false); 
        });
            
    });

    $('.tombol-edit').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('get/data_bulan'); ?>',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.bulan_id);
                $('#jumlah').val(data.bulan_bill);
                $("#jum").text('Rp.' + number_format(data.bulan_bill) + ',-');
            }
        });
    });
</script>
