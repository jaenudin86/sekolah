<!-- Begin Page Content -->
<div class="container-fluid">

    <!--Tambah Data-->
    <div class="modal fade" id="tambahData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Data Ciri Khas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/ciri_khas') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Ciri Khas Sekolah</label>
                            <input type="text" class="form-control" id="isi" name="isi" placeholder="Ciri Khas">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Ciri Khas Sekolah</h1>
            <hr />
        </div>

        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-cogs fa-fw"></i> Ciri Khas Sekolah
                    <div class="float-right">
                        <a href="#" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                    </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%;">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Ciri Khas</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($data as $d) : ?>
                                <tr>
                                    <th scope="row"><?= $i++ ?></th>
                                    <td><?= $d['isi'] ?></td>
                                    <td><?= mediumdate_indo(date($d['tgl'])) ?></td>
                                    <td>
                                        <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                        <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-cogs fa-fw"></i> Gambar Ciri Khas</h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messageGambar') ?>
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                            <?= $this->session->flashdata('messageimg') ?>
                            <div class="logoset">
                                <div class="logo">
                                    <form action="<?= base_url('update/gambar_ciri_khas') ?>" method="post" enctype="multipart/form-data">
                                        <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                        <div class="title">Gambar</div>
                                        <img style="height:200px;width:auto" id="logo" src="<?= base_url("assets/img/" . $img['img_ciri_khas']) ?>" />
                                        <div class="form-group">
                                            <div style="text-align:left;" class="custom-file">
                                                <input type="file" class="custom-file-input" id="gambar" name="gambar" onchange="previewImg()" value="<?= base_url("assets/img/" . $img['img_ciri_khas']) ?>">
                                                <label class="custom-file-label" for="gambar">Pilih gambar</label>
                                            </div>

                                            <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Gambar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>

    </div>

    
    <!--Update Data-->
    <?php foreach ($data as $d) : ?>
    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Update Data Ciri Khas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('update/ciri_khas') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Ciri Khas Sekolah</label>
                            <input type="hidden" class="form-control" name="id" value="<?= $d['id'] ?>">
                            <input type="text" class="form-control" id="isi" name="isi" value="<?= $d['isi'] ?>" placeholder="Ciri Khas">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
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
                    <h5 class="modal-title" id="addNewDataLabel">Hapus Data Ciri Khas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data <b><?= $d['isi'] ?></b></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('hapus/ciri_khas?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                </div>

            </div>
        </div>
    </div>
    <?php endforeach ?>

</div>

</div>
<!-- End of Main Content -->
<script type="text/javascript">
    function previewImg() {

        const gambar = document.querySelector('#gambar');
        const gambarLabel = document.querySelector('.custom-file-label');

        gambarLabel.textContent = gambar.files[0].name;

        const fileGambar = new FileReader();
        fileGambar.readAsDataURL(gambar.file[0]);

        fileGambar.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>