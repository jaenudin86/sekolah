<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">

        <!-- Modal -->
        <div class="modal fade" id="ubahPass" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewDataLabel">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('update/password_siswa') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Password Baru</label>
                                <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
                                <input type="text" class="form-control" id="password" name="password" placeholder="Password baru">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-redo"></i> Ubah Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-user-plus fa-fw"></i> Edit Data siswa</h1>
            <hr />
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="pt-2 fa fa-list-alt fa-fw"></i> Form edit data siswa

                        <div class="float-right">
                            <a href="<?= base_url('admin/daftar_siswa') ?>" class="btn btn-block btn-danger btn-sm"><i class="fa fa-angle-double-left"></i> Kembali</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    
                    <?= form_open_multipart('admin/update_siswa?id='.$siswa['id']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= $siswa['nik'] ?>">
                                    <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk siswa" value="<?= $siswa['nis'] ?>" required>
                                    <?= form_error('nis', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $siswa['nama'] ?>" required>
                                    <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $siswa['email'] ?>" required>
                                    <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Password</label> :
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahPass">Ubah Password</a>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nomor Hp</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Hp" value="<?= $siswa['no_hp'] ?>" require>
                                    <?= form_error('no_hp', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                                    <select class="form-control" id="jk" name="jk" required>
                                        <option value="">- Jenis Kelamin -</option>
                                        <option <?php if ($siswa['jk'] == "L") {
                                                    echo "selected='selected'";
                                                } ?> value="L">Laki-Laki</option>
                                        <option <?php if ($siswa['jk'] == "P") {
                                                    echo "selected='selected'";
                                                } ?> value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="ttl" name="ttl" value="<?= $siswa['ttl'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select class="form-control" id="prov" name="prov">
                                        <?php foreach ($prov as $v) : ?>
                                            <option <?php if ($siswa['prov'] == $v['nama']) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?= $v['id_prov'] ?>"><?= $v['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('prov', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <select class="form-control" id="kab" name="kab">
                                        <option value="<?= $siswa['kab']; ?>"><?= $siswa['kab']; ?></option>
                                        <?= form_error('kab', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $siswa['alamat'] ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Orang Tua" value="<?= $siswa['nama_ayah'] ?>">
                                    <?= form_error('nama_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Orang Tua" value="<?= $siswa['nama_ibu'] ?>">
                                    <?= form_error('nama_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nama Wali</label>
                                    <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="<?= $siswa['nama_wali'] ?>">
                                    <small class="text-info">* Kosongkan jika tidak ada.</small>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <select class="form-control" id="pek_ayah" name="pek_ayah" value="<?= $siswa['pek_ayah'] ?>">
                                        <option value="">- Pekerjaan Ayah -</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Wiraswasta") {
                                                    echo "selected='selected'";
                                                } ?> value="Wiraswasta">Wiraswasta</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Pedagang") {
                                                    echo "selected='selected'";
                                                } ?> value="Pedagang">Pedagang</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Buruh") {
                                                    echo "selected='selected'";
                                                } ?> value="Buruh">Buruh</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Pensiunan") {
                                                    echo "selected='selected'";
                                                } ?> value="Pensiunan">Pensiunan</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Guru") {
                                                    echo "selected='selected'";
                                                } ?> value="Guru">Guru</option>
                                        <option <?php if ($siswa['pek_ayah'] == "Honorer") {
                                                    echo "selected='selected'";
                                                } ?> value="Honorer">Honorer</option>
                                        <option <?php if ($siswa['pek_ayah'] == "PNS") {
                                                    echo "selected='selected'";
                                                } ?> value="PNS">PNS</option>
                                    </select>
                                    <?= form_error('pek_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <select class="form-control" id="pek_ibu" name="pek_ibu" value="<?= $siswa['pek_ibu'] ?>">
                                        <option value="">- Pekerjaan Ibu -</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Ibu Rumah Tangga") {
                                                    echo "selected='selected'";
                                                } ?> value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Wiraswasta") {
                                                    echo "selected='selected'";
                                                } ?> value="Wiraswasta">Wiraswasta</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Pedagang") {
                                                    echo "selected='selected'";
                                                } ?> value="Pedagang">Pedagang</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Buruh") {
                                                    echo "selected='selected'";
                                                } ?> value="Buruh">Buruh</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Pensiunan") {
                                                    echo "selected='selected'";
                                                } ?> value="Pensiunan">Pensiunan</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Guru") {
                                                    echo "selected='selected'";
                                                } ?> value="Guru">Guru</option>
                                        <option <?php if ($siswa['pek_ibu'] == "Honorer") {
                                                    echo "selected='selected'";
                                                } ?> value="Honorer">Honorer</option>
                                        <option <?php if ($siswa['pek_ibu'] == "PNS") {
                                                    echo "selected='selected'";
                                                } ?> value="PNS">PNS</option>
                                        <?= form_error('pek_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Wali</label>
                                    <select class="form-control" id="pek_wali" name="pek_wali">
                                        <option value="">- Pekerjaan Wali -</option>
                                        <option <?php if ($siswa['pek_wali'] == "Tidak ada wali") {
                                                    echo "selected='selected'";
                                                } ?> value="Tidak ada wali">Tidak ada wali</option>
                                        <option <?php if ($siswa['pek_wali'] == "Wiraswasta") {
                                                    echo "selected='selected'";
                                                } ?> value="Wiraswasta">Wiraswasta</option>
                                        <option <?php if ($siswa['pek_wali'] == "Pedagang") {
                                                    echo "selected='selected'";
                                                } ?> value="Pedagang">Pedagang</option>
                                        <option <?php if ($siswa['pek_wali'] == "Buruh") {
                                                    echo "selected='selected'";
                                                } ?> value="Buruh">Buruh</option>
                                        <option <?php if ($siswa['pek_wali'] == "Pensiunan") {
                                                    echo "selected='selected'";
                                                } ?> value="Pensiunan">Pensiunan</option>
                                        <option <?php if ($siswa['pek_wali'] == "Guru") {
                                                    echo "selected='selected'";
                                                } ?> value="Guru">Guru</option>
                                        <option <?php if ($siswa['pek_wali'] == "Honorer") {
                                                    echo "selected='selected'";
                                                } ?> value="Honorer">Honorer</option>
                                        <option <?php if ($siswa['pek_wali'] == "PNS") {
                                                    echo "selected='selected'";
                                                } ?> value="PNS">PNS</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Penghasilan Ortu / Wali</label>
                                    <select class="form-control" id="peng_ortu" name="peng_ortu">
                                        <option value="">- Penghasilan / Bulan -</option>
                                        <option <?php if ($siswa['peng_ortu'] == "< Rp.1.000.000") {
                                                    echo "selected='selected'";
                                                } ?> value="< Rp.1.000.000">
                                            << Rp.1.000.000</option>
                                        <option <?php if ($siswa['peng_ortu'] == "Rp.1.000.000 - Rp.2.000.000") {
                                                    echo "selected='selected'";
                                                } ?> value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
                                        <option <?php if ($siswa['peng_ortu'] == "Rp.2.000.000 - Rp.3.000.000") {
                                                    echo "selected='selected'";
                                                } ?> value="Rp.2.000.000 - Rp.3.000.000">Rp.2.000.000 - Rp.3.000.000</option>
                                        <option <?php if ($siswa['peng_ortu'] == "Rp.3.000.000 - Rp.4.000.000") {
                                                    echo "selected='selected'";
                                                } ?> value="Rp.3.000.000 - Rp.4.000.000">Rp.3.000.000 - Rp.4.000.000</option>
                                        <option <?php if ($siswa['peng_ortu'] == "Rp.4.000.000 - Rp.5.000.000") {
                                                    echo "selected='selected'";
                                                } ?> value="Rp.4.000.000 - Rp.5.000.000">Rp.4.000.000 - Rp.5.000.000</option>
                                        <option <?php if ($siswa['peng_ortu'] == "Rp.5.000.000 >") {
                                                    echo "selected='selected'";
                                                } ?> value="Rp.5.000.000 >">
                                            Rp.5.000.000 >></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Telepon Ortu / Wali</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= $siswa['no_telp'] ?>">
                                    <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Sekolah Asal</label>
                                    <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asalk" value="<?= $siswa['sekolah_asal'] ?>">
                                    <?= form_error('sekolah_asal', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" class="form-control" id="old_kelas" name="old_kelas" placeholder="Kelas" value="<?= $siswa['kelas'] ?>">
                                    <?= form_error('old_kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>


                                
                                <br />

                                <div class="form-group">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-sm-3">
                                                    <a id="imgLink" href="<?php echo base_url('assets/img/data/' . $siswa['img_siswa']); ?>" target="_blank">
                                                        <img src="<?php if (!empty($siswa['img_siswa'])) {
                                                                        echo base_url('assets/img/data/' . $siswa['img_siswa']);
                                                                    } ?>" width="100" height="85" id="preview" class="img-thumbnail mt-3">
                                                    </a>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input hidden type="file" name="img_siswa" class="file" accept="image/*" id="imgInp">
                                                    <div class="input-group my-3">
                                                        <input type="text" class="form-control" disabled placeholder="Foto siswa" id="file">
                                                        <div class="input-group-append">
                                                            <button type="button" class="browse btn btn-success">Browse</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <!-- Add the code for other images -->
                                                <div class="col-sm-3">
                                                    <a id="imgLink1" href="<?php echo base_url('assets/img/data/' . $siswa['img_kk']); ?>" target="_blank">
                                                        <img src="<?php if (!empty($siswa['img_kk'])) {
                                                                        echo base_url('assets/img/data/' . $siswa['img_kk']);
                                                                    } ?>" width="100" height="85" id="preview1" class="img-thumbnail mt-3">
                                                    </a>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input hidden type="file" name="img_kk" class="file1" accept="image/*" id="imgInp1">
                                                    <div class="input-group my-3">
                                                        <input type="text" class="form-control" disabled placeholder="Foto KK (Kartu keluarga)" id="file1">
                                                        <div class="input-group-append">
                                                            <button type="button" class="browse1 btn btn-success">Browse</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <!-- Add the code for other images -->
                                                <div class="col-sm-3">
                                                    <a id="imgLink2" href="<?php echo base_url('assets/img/data/' . $siswa['img_ijazah']); ?>" target="_blank">
                                                        <img src="<?php if (!empty($siswa['img_ijazah'])) {
                                                                        echo base_url('assets/img/data/' . $siswa['img_ijazah']);
                                                                    } ?>" width="100" height="85" id="preview2" class="img-thumbnail mt-3">
                                                    </a>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input hidden type="file" name="img_ijazah" class="file2" accept="image/*" id="imgInp2">
                                                    <div class="input-group my-3">
                                                        <input type="text" class="form-control" disabled placeholder="Foto Ijazah" id="file2">
                                                        <div class="input-group-append">
                                                            <button type="button" class="browse2 btn btn-success">Browse</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <!-- Add the code for other images -->
                                                <div class="col-sm-3">
                                                    <a id="imgLink3" href="<?php echo base_url('assets/img/data/' . $siswa['img_ktp']); ?>" target="_blank">
                                                        <img src="<?php if (!empty($siswa['img_ktp'])) {
                                                                        echo base_url('assets/img/data/' . $siswa['img_ktp']);
                                                                    } ?>" width="100" height="85" id="preview3" class="img-thumbnail mt-3">
                                                    </a>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input hidden type="file" name="img_ktp" class="file3" accept="image/*" id="imgInp3">
                                                    <div class="input-group my-3">
                                                        <input type="text" class="form-control" disabled placeholder="Foto Akte / KTP" id="file3">
                                                        <div class="input-group-append">
                                                            <button type="button" class="browse3 btn btn-success">Browse</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr class="sidebar-divider">

                                <div class="form-group">
                                    <label>Tahun Masuk</label>
                                    <select class="form-control" id="thn_msk" name="thn_msk">
                                        <option>- Pilih Periode -</option>
                                        <?php foreach ($thn_msk as $row) : ?>
                                            <option <?php if ($siswa['thn_msk'] == $row['id']) {
                                                                            echo "selected='selected'";
                                                    } ?> value="<?= $row['id'] ?>"><?= $row['period_start'] ?>/<?= $row['period_end'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('thn_msk', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                
                                <div class="form-group">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-university fa-fw"></i> Penempatan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pendidikan</label>
                                                        <select class="form-control" id="pendidikan" name="pendidikan" required>
                                                            <option>- Pilih Pendidikan -</option>
                                                            <?php foreach ($pendidikan as $row) : ?>

                                                                <option <?php if ($siswa['id_pend'] == $row['id']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>

                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6" id="major-kelas"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status" class="col-form-label">Status :</label>
                                    <select class="form-control" id="status" name="status">
                                        <?php if ($siswa['status'] == '1') : ?>
                                            <option value="1">
                                                Aktif (Terpilih)
                                            </option>
                                            <option value="0">Tidak Aktif</option>
                                        <?php elseif ($siswa['status'] == '0') : ?>
                                            <option value="0">
                                                Tidak Aktif (Terpilih)
                                            </option>
                                            <option value="1">Aktif</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="pt-3 form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn-block btn btn-success" onclick="return confirm('Lanjutkan Simpan Data Siswa?');">Simpan Data siswa</button>
                            </div>
                        </div>

                    <?php form_close() ?>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /.container-fluid -->

<script type="text/javascript">
    $(document).ready(function() {
        pendd = <?= $siswa['id_pend'] ?>;
        major = <?= $siswa['id_majors'] ?>;
        kelas = <?= $siswa['id_kelas'] ?>;
        $.ajax({
            url: '<?= site_url('get/get_majors_kelas_edit'); ?>',
            data: {
                pend: pendd, major: major, kelas: kelas
            },
            method: 'post',
            success: function(data) {
                $('#major-kelas').html(data);

                $('#jurusan').change(function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('get/get_kelas_majors'); ?>',
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


        $('#prov').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kota'); ?>',
                data: {
                    prov: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kab').html(response);
                }
            });
        });

        $('#pendidikan').change(function() {
            $.ajax({
                url: '<?= site_url('get/get_majors_kelas'); ?>',
                data: {
                    pend: this.value
                },
                method: 'post',
                success: function(data) {
                    $('#major-kelas').html(data);
                    
                    $('#jurusan').change(function() {
                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('get/get_kelas_majors'); ?>',
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

<script type="text/javascript">
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });

    $(document).on("click", ".browse1", function() {
        var file = $(this).parents().find(".file1");
        file.trigger("click");
    });

    $(document).on("click", ".browse2", function() {
        var file = $(this).parents().find(".file2");
        file.trigger("click");
    });

    $(document).on("click", ".browse3", function() {
        var file = $(this).parents().find(".file3");
        file.trigger("click");
    });

    $('#imgInp').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
        $('#imgLink').removeAttr('href');
    });

    $('#imgInp1').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file1").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview1").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
        $('#imgLink1').removeAttr('href');
    });

    $('#imgInp2').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file2").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview2").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
        $('#imgLink2').removeAttr('href');
    });

     $('#imgInp3').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file3").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview3").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
        $('#imgLink3').removeAttr('href');
    });
</script>