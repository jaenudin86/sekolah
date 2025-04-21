<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo media_url('css/bootstrap.min.css') ?>">
</head>

<body>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-striped" id="mytable">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Jumlah Bayar</th>
							<th>Keterangan</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($bill)) {
							$i = 1;
							foreach ($bill as $row) :
						?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo pretty_date($row['bebas_pay_input_date'], 'd F Y', false); ?></td>
									<td align="right"><?php echo 'Rp. ' . number_format($row['bebas_pay_bill'], 0, ',', '.') ?></td>
									<td><?php echo $row['bebas_pay_desc']; ?></td>
									<td>
										<?php if($row['inv']  == '2') : ?>
                                        <a href="<?= $row['url_inv'] ?>" class="btn btn-xs btn-warning" <?= ($row['inv'] == 1) ?  'style="pointer-events: none"' : '' ?>> <b><?= ($row['inv'] == 1) ? 'Lunas' : 'Pending' ?></b></a>
                                        <?php elseif($row['inv']  == '1') : ?>
                                        <a href="<?= $row['url_inv'] ?>" class="btn btn-xs btn-success" <?= ($row['inv'] == 1) ?  'style="pointer-events: none"' : '' ?>> <b><?= ($row['inv'] == 1) ? 'Lunas' : 'Pending' ?></b></a>
                                        <?php else : ?>
                                        <a href="#" class="tombol-edit btn btn-xs btn-danger" style="pointer-events: none">Error</a>
                                        <?php endif ?>
									</td>
								</tr>

							<?php
								$i++;
							endforeach;
							?>
							<tr class="success">
								<td colspan="2"><b>Total Sudah Bayar</b></td>
								<td align="right"><b><?php echo 'Rp. ' . number_format($total_pay, 0, ',', '.') ?></b></td>
								<td colspan="3"><b>Tunggakan : <?php echo 'Rp. ' . number_format($total - $total_pay, 0, ',', '.') ?></b></td>
							</tr>
						<?php }  ?>

					</tbody>
				</table>
			</div>
		</div>
	</section>
</body>

</html>