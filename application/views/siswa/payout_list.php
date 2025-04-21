
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

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
            <hr />
        </div>
        <div class="col-md-12">
			<?= $this->session->flashdata('message') ?>

				<?php if ($f) { ?>
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-success"> Informasi Siswa

								<div class="float-right">
								<?php if ($f['n'] and $f['r'] != NULL) { ?>
									<a href="<?= site_url('siswa/printBill' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-primary btn-xs pull-right"><i class="fa fa-print"></i> Cetak Semua Tagihan</a>
								<?php } ?>
								</div>
							</h6>
						</div>
						<div class="card-body row">
							<div class="col-md-9">
								<table class="table table-striped">
									<tbody>
										<tr>
											<td width="200">Tahun Pelajaran</td>
											<td width="4">:</td>
											<?php foreach ($period as $row) : ?>
												<?= (isset($f['n']) and $f['n'] == $row['id']) ?
													'<td><strong>' . $row['period_start'] . '/' . $row['period_end'] . '<strong></td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>NIS</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['nis'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>Nama Siswa</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['nama'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>Kelas</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['class_name'] . ' ' . $row['majors_name'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-3">
								<?php foreach ($siswa as $row) : ?>
									<?php if (isset($f['n']) and $f['r'] == $row['nis']) { ?>
										<?php if (!empty($row['img_siswa'])) { ?>
											<img src="<?= base_url('assets/img/profile/' . $row['img_siswa']) ?>" class="img-thumbnail img-responsive text-right" width="200" height="200">
										<?php } else { ?>
											<img src="<?= base_url('assets/img/profile/default.jpg') ?>" class="img-thumbnail img-responsive" width="200" height="200">
									<?php }
									} ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-success"> Transaksi Terakhir</h6>
								</div>
								<div class="card-body">
									<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
										<tr class="success">
											<th>Pembayaran</th>
											<th>Tagihan</th>
											<th>Tanggal</th>
										</tr>
										<?php
										foreach ($log as $key) :
										?>
											<tr>
												<td><?= ($key['bulan_bulan_id'] != NULL) ? $key['posmonth_name'] . ' - T.P ' . $key['period_start_month'] . '/' . $key['period_end_month'] . ' (' . $key['month_name'] . ')' : $key['posbebas_name'] . ' - T.A ' . $key['period_start_bebas'] . '/' . $key['period_end_bebas'] ?></td>
												<td><?= ($key['bulan_bulan_id'] != NULL) ? 'Rp. ' . number_format($key['bulan_bill'], 0, ',', '.') : 'Rp. ' . number_format($key['bebas_pay_bill'], 0, ',', '.') ?></td>
												<td><?= pretty_date($key['log_trx_input_date'], 'd F Y', false)  ?></td>
											</tr>
										<?php endforeach ?>

									</table>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-success">Cetak Bukti Pembayaran</h6>
								</div>
								<div class="card-body">
									<form action="<?= site_url('siswa/cetakBukti') ?>" method="GET" class="view-pdf">
										<input type="hidden" name="n" value="<?= $f['n'] ?>">
										<input type="hidden" name="r" value="<?= $f['r'] ?>">
										<div class="form-group">
											<label>Tanggal Transaksi</label>
											<div class="input-group date " data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input class="form-control" required="" type="date" name="d" value="<?= date('Y-m-d') ?>">
											</div>
										</div>
										<button class="btn btn-success btn-block" formtarget="_blank" type="submit"><i class="fa fa-print"></i> Cetak Bukti Pembayaran</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					
						<!-- List Tagihan Bulanan -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-success">Jenis Pembayaran</h6>
							</div>
							<div class="card-body" id="accordion">
								<div class="row nav-tabs-custom">
									<div class="col-md-6">
										<div id="headingOne">
											<button id="button_tab" type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#tab_1" aria-expanded="false" aria-controls="tab_1"><b>Bulanan</b> &nbsp;<i class="fa fa-shopping-cart"></i></button>
										</div>
									</div>
									<div class="col-md-6">
										<div id="headingTwo">
											<button type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#tab_2" aria-expanded="false" aria-controls="tab_2"><b>Bebas</b>&nbsp; <i class="fa fa-shopping-cart"></i></button>
										</div>
									</div>
								</div>
								<hr class="mb-5" />
								<div class="collapse show" id="tab_1" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="box-body table-responsive">
										<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
											<thead>
												<tr class="success">
													<th class="text-center">No.</th>
													<th>Jenis Pembayaran</th>
													<th>Tahun Pelajaran</th>
													<th class="text-center">Bayar</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1;
													foreach ($student as $row) :
													if ($f['n'] and $f['r'] == $row['nis']) { ?>
														<tr>
															<td width="5%" class="text-center"><?= $i ?></td>
															<td><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td class="danger"><?= $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td width="10%" class="text-center danger">
																<a href="<?= site_url('siswa/payout_bayar/' . $row['payment_payment_id'] . '/' . $row['student_student_id']) ?>" class="badge badge-success" data-toggle="tooltip" title="Lakukan Pembayaran"><i class="fa fa-dollar"></i>&nbsp;<b>Bayar Bulanan</b></a>
															</td>
														</tr>
												<?php } $i++; endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="collapse" id="tab_2" aria-labelledby="headingTwo" data-parent="#accordion">
								
									<div class="box-body">
										<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
											<thead>
												<tr class="success">
													<th class="text-center">No.</th>
													<th>Jenis Pembayaran</th>
													<th>Total Tagihan</th>
													<th>Dibayar</th>
													<th class="text-center">Status</th>
													<th class="text-center">Bayar</th>
													<th class="text-center">Detail Tagihan</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1;
													foreach ($bebas as $row) :
													if ($f['n'] and $f['r'] == $row['nis']) {
														$sisa = $row['bebas_bill'] - $row['bebas_total_pay']; ?>
														<tr class="<?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'success' : 'danger' ?>">
															<td style="background-color: #fff !important;" class="text-center" width="5%"><?= $i ?></td>
															<td style="background-color: #fff !important;"><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td><?= 'Rp. ' . number_format($sisa, 0, ',', '.') ?></td>
															<td><?= 'Rp. ' . number_format($row['bebas_total_pay'], 0, ',', '.') ?></td>
															<td class="text-center">
																<a data-toggle="modal" href="#RincianPayBebas<?= $row['bebas_id'] ?>" class="view-cicilan badge <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'badge-success' : 'badge-danger' ?>"><?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?></a>
															</td>
															<td class="text-center">
															<?php if($row['bebas_bill'] !== $row['bebas_total_pay']) : ?>
																<a data-toggle="modal" class="badge badge-success <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'disabled' : '' ?>" title="Bayar" href="#addCicilan<?= $row['bebas_id'] ?>"><span class="fa fa-dollar-alt"></span> <b>Bayar Tagihan</b></a>
															<?php else : ?>
																<span class="badge badge-success">Lunas</span>
															<?php endif ?>
															</td>
															<td class="text-center">
																<a data-toggle="modal" href="#RincianPayBebas<?= $row['bebas_id'] ?>" class="view-cicilan badge badge-primary">Lihat Pembayaran</a>
																<a data-toggle="modal" class="badge badge-info <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'disabled' : '' ?>" title="Bayar" href="#addRincian<?= $row['bebas_id'] ?>"><span class="fa fa-dollar"></span> <b>Rincian</b></a>
															</td>
														</tr>

														<div class="modal fade" id="RincianPayBebas<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Lihat Pembayaran / Angsuran</h4>
																	</div>
																	<div class="modal-body">
																		
																		<div id="AjaxPayBebas"></div>

																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>

														<div class="modal fade" id="addRincian<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-md">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title"><?= $row['nis'] ?> - Detail Tagihan</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" name="bebas_id" value="<?= $row['bebas_id'] ?>">
																		<input type="hidden" name="nis" value="<?= $row['nis'] ?>">
																		<input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
																		<input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
																		<div class="row">
																			<div class="col-md-12">
																				<label>Keterangan *</label>
																				<textarea rows="5" class="form-control" readonly><?= $row['bebas_desc'] ?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>

														<div class="modal fade" id="addCicilan<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-md">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Tambah Pembayaran / Angsuran</h4>
																	</div>
																	
																	<div class="modal-body">
																		<input type="hidden" name="bebas_id" value="<?= $row['bebas_id'] ?>">
																		<input type="hidden" name="nis" value="<?= $row['nis'] ?>">
																		<input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
																		<input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
																		<div class="form-group">
																			<label>Nama Pembayaran</label>
																			<input class="form-control" readonly="" type="text" value="<?= $row['pos_name'] . ' - T.A ' . $row['period_start'] . '/' . $row['period_end'] ?>">
																		</div>
																		<div class="form-group">
																			<label>Tanggal</label>
																			<input class="form-control" readonly="" type="text" value="<?= pretty_date(date('Y-m-d'), 'd F Y', false) ?>">
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label>Jumlah Bayar *</label>
																				<input type="number" required="" name="bebas_pay_bill" id="bebas_pay_bill" class="form-control numeric" placeholder="Jumlah Bayar">
																			</div>
																			<div class="col-md-6">
																				<label>Keterangan *</label>
																				<input type="text" required="" name="bebas_pay_desc" class="form-control" placeholder="Keterangan" id="keterangan">
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-success tombol-edit" data-toggle="modal" data-target="#payModal" data-id="<?= $row['bebas_id'] ?>">Simpan</button>
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																	
																</div>
														<?php
													}
													$i++;
												endforeach;
														?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
					<?php } ?>
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
				<form action="<?= base_url('siswa/payment_bebas') ?>" method="post" id="payy">
						<input type="hidden" name="bebas_id" id="id_bebas" value="">
						<input type="hidden" name="jumlah" id="jumlah" value="">
						<input type="hidden" name="ket" id="ket" value="">
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

	function startCalculate() {
		interval = setInterval("Calculate()", 10);
	}

	function Calculate() {
		var numberHarga = $('#harga').val(); // a string
		numberHarga = numberHarga.replace(/\D/g, '');
		numberHarga = parseInt(numberHarga, 10);
		var numberBayar = $('#bayar').val(); // a string
		numberBayar = numberBayar.replace(/\D/g, '');
		numberBayar = parseInt(numberBayar, 10);
		var total = numberBayar - numberHarga;
		$('#kembalian').val(total);
	}

	function stopCalc() {
		clearInterval(interval);
	}
</script>
<script>
	$('button').on('click', function(){
    $('button').removeClass('active_button');
    $(this).addClass('active_button');
	});

	$(document).ready(function() {
		$('#button_tab').addClass('active_button');

		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});

		$("#bebas_pay_bill").on("keydown keyup", function() {
			var val = $('#bebas_pay_bill').val();
			$("#jumlah").val(val);
			$("#jum").text('Rp.' + number_format(val) + ',-');
		});

		$("#keterangan").on("keydown keyup", function() {
			var val = $('#keterangan').val();
			$("#ket").val(val);
		});

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
        $('#id_bebas').val(id);
    });

</script>

<script type="text/javascript">
$(document).ready(function() {
	<?php foreach ($student as $row) : ?>
		$('.view-bulan').click(function(){
			$.ajax({
				type: 'POST',
				url: '<?= site_url('siswa/payout_bulan/' . $row['payment_payment_id'] . '/' . $row['student_student_id']); ?>',
				data: {
					majors: this.value
				},
				cache: false,
				success: function(response) {
					$('#AjaxPayBulan').html(response);
				}
			});
		});
	<?php endforeach ?>
	
	<?php foreach ($bebas as $row) : ?>
		$('.view-cicilan').click(function(){
			$.ajax({
				type: 'POST',
				url: '<?= site_url('siswa/payout_bebas/' . $row['payment_payment_id'] . '/' . $row['student_student_id'] . '/' . $row['bebas_id']); ?>',
				data: {
					majors: this.value
				},
				cache: false,
				success: function(response) {
					$('#AjaxPayBebas').html(response);
				}
			});
		});
	<?php endforeach ?>
});
</script>