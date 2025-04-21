<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('tambah/prestasi_non_akademik') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="siswa">Nama siswa</label>
                        <select style="width:100%!important;" class="form-control js-example-basic-single" name="id_siswa">
                        </select>
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


    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right pr-1">
                            <a href="" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </h4>
                    <?= $this->session->flashdata('message') ?>


                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama siswa</th>
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Jumlah Prestasi</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_prestasi as $d) : ?>
                                    <?php $tot = $this->db->get_where('pres_non_akademik', ['id_siswa' => $d['id']])->num_rows(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['pend_name'] ?></td>
                                        <td><?= $d['class_name'] ?> <?= ($d['majors_name']) ? ' - '.$d['majors_name'] : '' ?></td>
                                        <td><?= $tot ?></td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addNewDataPres<?= $d['id'] ?>"><i class="fa fa-plus"></i> Tambah Prestasi</a>
                                            <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#DataPrestasi<?= $d['id'] ?>"><i class="fa fa-eye"></i>  Lihat Prestasi</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteDataPres<?= $d['id'] ?>"><i class="fa fa-trash"></i>  Hapus</a>
                                        </td>
                                    </tr>

                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php foreach ($data_prestasi as $d) : ?>
    <?php $pres = $this->db->get_where('pres_non_akademik', ['id_siswa' => $d['id']])->result_array(); ?>
    <!--update Data-->
    <div class="modal fade" id="DataPrestasi<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Data Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    
                    <table>
                    <tr>
                            <td>Nama </td>
                            <td>: <b><?= $d['nama'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Pendidikan</td>
                            <td>: <?= $d['pend_name'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: <?= $d['class_name'] ?> <?= ($d['majors_name']) ? ' - '.$d['majors_name'] : '' ?></td>
                        </tr>
                    </table>
                
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Prestasi</th>
                                <th>Dokumen</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($pres as $dd) : ?>
                                <tr>
                                    <td><?= $dd['prestasi'] ?></td>
                                    <td><a href="<?= base_url('assets/prestasi/'.$dd['dokumen']) ?>" class="badge badge-primary" download>Donwload File Dokumen</a></td>
                                    <td><?= mediumdate_indo(date($dd['tgl'])); ?></td>
                                    <td>               
                                        <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $dd['id'] ?>">Edit</a>
                                        <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $dd['id'] ?>">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="addNewDataPres<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url('admin/prestasi_non_akademik') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" value="<?= $d['id'] ?>" name="id_sis">
                            <input type="text" class="form-control bg-secondary text-white" value="<?= $d['nama'] ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label for="prestasi">Prestasi</label>
                            <input class="form-control" type="text" id="prestasi" name="prestasi" placeholder="Prestasi">
                        </div>

                        <div class="form-group">
                            <input hidden type="file" name="dokumen" class="fileD<?= $d['id'] ?>" id="imgInpD<?= $d['id'] ?>">
                            <label for="prestasi">Dokumen Prestasi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" disabled placeholder="File Dokumen" id="fileD<?= $d['id'] ?>">
                                <div class="input-group-append">
                                    <button type="button" class="browseD<?= $d['id'] ?> btn btn-primary">Browse</button>
                                </div>
                            </div>
                            <?= form_error('dokumen', '<small class="text-danger pl-3">', ' </small>') ?>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal">
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

    
    <!--delete Data-->
    <div class="modal fade" id="deleteDataPres<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Hapus Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data <b><?= $d['nama'] ?></b></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('hapus/data_prestasi_non_akademik/admin?id=' . $d['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                </div>

            </div>
        </div>
    </div>

<?php endforeach ?>


<?php foreach ($prestasi as $d) : ?>
    <!--update Data-->
    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Update Data Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('update/prestasi_non_akademik') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                        <div class="form-group">
                            <input type="text" class="form-control bg-secondary text-white" value="<?= $d['nama_siswa'] ?>" disabled>
                        </div>
                                
                        <div class="form-group">
                            <label for="prestasi">Prestasi</label>
                            <input class="form-control" type="text" id="prestasi" name="prestasi" placeholder="Prestasi" value="<?= $d['prestasi'] ?>">
                        </div>

                        <div class="form-group">
                            <input hidden type="file" name="dokumen" class="file<?= $d['id'] ?>" id="imgInp<?= $d['id'] ?>">
                            <label for="prestasi">Dokumen Prestasi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" disabled placeholder="<?= $d['dokumen'] ?>" id="file<?= $d['id'] ?>">
                                <div class="input-group-append">
                                    <button type="button" class="browse<?= $d['id'] ?> btn btn-primary">Browse</button>
                                </div>
                            </div>
                            <?= form_error('dokumen', '<small class="text-danger pl-3">', ' </small>') ?>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= $d['tgl'] ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!--delete Data-->
    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Hapus Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data <b><?= $d['prestasi'] ?></b></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('hapus/prestasi_non_akademik/admin?id=' . $d['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                </div>

            </div>
        </div>
    </div>

<?php endforeach ?>

<!-- Script -->

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getsiswa') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Ketik Nama siswa',
            minimumInputLength: 3,
        });

    });
</script>

<?php foreach ($data_prestasi as $d) : ?>
<script type="text/javascript">
    $(document).on("click", ".browseD<?= $d['id'] ?>", function() {
        var file = $(this).parents().find(".fileD<?= $d['id'] ?>");
        file.trigger("click");
    });

    $('#imgInpD<?= $d['id'] ?>').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#fileD<?= $d['id'] ?>").val(fileName);

    });
</script>
<?php endforeach ?>

<?php foreach ($prestasi as $d) : ?>
<script type="text/javascript">
    $(document).on("click", ".browse<?= $d['id'] ?>", function() {
        var file = $(this).parents().find(".file<?= $d['id'] ?>");
        file.trigger("click");
    });

    $('#imgInp<?= $d['id'] ?>').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file<?= $d['id'] ?>").val(fileName);

    });
</script>
<?php endforeach ?>

<script type="text/javascript">
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });

    $('#imgInp').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

    });
</script>