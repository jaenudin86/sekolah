<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <?= form_error(
                'kelas',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'tanggal',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="fas fa-list"></i> <?= $title ?>

                        <div class="float-right">
                            <a href="" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </h4>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status Absen</th>
                                    <th scope="col">Hadir</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($absen as $d) : ?>
                                    <?php $hadir = $this->db->get_where('absen', ['role_absen' => $d['id'], 'status' => 'Hadir'])->num_rows(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['pend_name'] ?></td>
                                        <td><?= $d['class_name'] ?> <?= ($d['majors_name']) ? ' - '.$d['majors_name'] : '' ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])) ?></td>
                                        <td><?php if ($d['status'] == 'Selesai') : ?>
                                                <span class="badge badge-success"><?= $d['status'] ?></span>
                                            <?php elseif ($d['status'] == 'Belum Selesai') : ?>
                                                <span class="badge badge-danger"><?= $d['status'] ?></span>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $hadir ?></td>
                                        <td><?php if ($d['status'] == 'Selesai') : ?>
                                                <a href="" class="badge badge-info" data-toggle="modal" data-target="#printData<?= $d['id'] ?>"><i class="fa fa-print"></i> Print</a>
                                                <a href="<?= base_url('admin/absen/') ?><?= $d['tgl'] ?>?id=<?= $d['id'] ?>" class="badge badge-success"><i class="fa fa-eye"></i> View</a>
                                            <?php endif ?>
                                            <?php if ($d['status'] == 'Belum Selesai') : ?>
                                                <a href="<?= base_url('admin/absen/') ?><?= $d['tgl'] ?>?id=<?= $d['id'] ?>" class="badge badge-primary">Absen</a>
                                                <a href="" class="badge badge-warning" data-toggle="modal" data-target="#tutupData<?= $d['id'] ?>">Tutup Absen</a>
                                            <?php endif ?>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="tutupData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Tutup Absen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menutup absensi <br/> kelas <b><?= $d['class_name'] ?> <?= ($d['majors_name']) ? ' - '.$d['majors_name'] : '' ?></b> tanggal <b><?= mediumdate_indo(date($d['tgl'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('update/tutup_absen_kelas/admin/daftar_absen?id=') ?><?= $d['id'] ?>" class="btn btn-warning">Tutup Absen</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Absen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus Absensi : <br /> <b><?= $d['pend_name'] .' : Kelas '. $d['class_name'] ?> <?= ($d['majors_name']) ? ' - '.$d['majors_name'] : '' ?></b> tanggal <b><?= mediumdate_indo(date($d['tgl'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_daftar_absen?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!--modal-->
<?php foreach ($absen as $ab) : ?>
    <!--print Data-->
    <div class="modal fade" id="printData<?= $ab['id'] ?>" role="dialog" aria-labelledby="printDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printDataLabel"><i class="fa fa-print"></i> Print Absen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form target="_blank" action="<?= base_url('laporan/laporan_absen') ?>" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <div class="card bg-secondary text-white shadow">
                                <div class="card-body">
                                        Absensi <?= $ab['pend_name'] ?> : kelas <?= $ab['class_name'] . ($ab['majors_name'] ? ' - ' . $ab['majors_name'] : '') ?>
                                    <br />
                                    <div class="text-white-50 small">Tanggal : <?= mediumdate_indo(date($ab['tgl'])) ?></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $ab['id'] ?>" name="id">
                        <div class="form-group">
                            <?php $hadir = $this->db->get_where('absen', ['role_absen' => $ab['id'], 'status' => 'Hadir'])->num_rows(); ?>
                            <?php $no_hadir = $this->db->get_where('absen', ['role_absen' => $ab['id'], 'status' => 'Tidak Hadir'])->num_rows(); ?>
                            <?php $izin = $this->db->get_where('absen', ['role_absen' => $ab['id'], 'status' => 'Izin'])->num_rows(); ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hadir</td>
                                        <td><?= $hadir ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tidak Hadir</td>
                                        <td><?= $no_hadir ?></td>
                                    </tr>
                                    <tr>
                                        <td>Izin</td>
                                        <td><?= $izin ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/daftar_absen') ?>" method="post">
                <div class="modal-body">


                    <div class="form-group">
                        <label for="pendidikan">Nama Pendidikan</label>
                        <select class="form-control" id="pendidikan" name="pendidikan">
                            <option value="">- Pilih Pendidikan -</option>
                            <?php foreach ($pendidikan as $a) : ?>
                                <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
              
                    <div id="major-kelas"></div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= set_value('tanggal') ?>">
                        <?= form_error('tanggal', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#pendidikan').change(function() {
            $.ajax({
                url: '<?= site_url('get/get_majors_kelas_peng'); ?>',
                data: {
                    pend: this.value
                },
                method: 'post',
                success: function(data) {
                    
                    $('#major-kelas').html(data);
                    
                    $('#jurusan').change(function() {
                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('get/get_kelas_majors_peng'); ?>',
                            data: {
                                majors: this.value
                            },
                            cache: false,
                            success: function(response) {
                                if (response.trim() === '') {
                                    $('#div-kelas').hide();
                                } else {
                                    $('#kelas').html(response);
                                    $('#div-kelas').show();
                                }
                            }
                        });
                    });

                }
            });
          
        });
    });
</script>