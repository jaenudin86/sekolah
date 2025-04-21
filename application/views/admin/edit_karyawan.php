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
                <form action="<?= base_url('update/password_karyawan') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="hidden" name="id" value="<?= $karyawan['id'] ?>">
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
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-user-plus fa-fw"></i> Edit Data Karyawan</h1>
            <hr />
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="pt-2 fa fa-list-alt fa-fw"></i> Form Pendaftaran

                        <div class="float-right">
                            <a href="<?= base_url('admin/karyawan') ?>" class="btn btn-block btn-success btn-sm"><i class="fa fa-angle-double-left"></i> Data Karyawan</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('admin/update_karyawan?id=') ?><?= $karyawan['id'] ?>" method="post">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="id_fp">Id Fingerprint</label>
                                    <input class="form-control" type="text" id="id_fp" name="id_fp" placeholder="ID Fingerprint" value="<?= $karyawan['id_fingerprint'] ?>" require>
                                    <?= form_error('id_fp', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="reff">Kode Referral</label>
                                    <input class="form-control" type="text" id="reff" name="reff" placeholder="Kode Referral" value="<?= $karyawan['kode_reff'] ?>" require>
                                    <?= form_error('reff', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="number" class="form-control" id="nip" name="nip" placeholder="Nomor Identitas Pegawai" value="<?= $karyawan['nip'] ?>">
                                    <?= form_error('nip', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $karyawan['nama'] ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $karyawan['email'] ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Password</label> :
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahPass">Ubah Password</a>
                                </div>

                                <div class="form-group">
                                    <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                                    <select class="form-control" id="jk" name="jk">
                                        <option value="">- Jenis Kelamin -</option>
                                        <option <?php if ($karyawan['jk'] == "L") {
                                                    echo "selected='selected'";
                                                } ?> value="L">Laki-Laki</option>
                                        <option <?php if ($karyawan['jk'] == "P") {
                                                    echo "selected='selected'";
                                                } ?> value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="ttl" name="ttl" value="<?= $karyawan['ttl'] ?>">
                                </div>

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $karyawan['alamat'] ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= $karyawan['telp'] ?>">
                                    <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                            </div>

                            <div class="col-md-6">

                            <div class="form-group">
                                    <label for="level" class="col-form-label">Level</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="">- Pilih Level -</option>
                                        <option <?php if ($karyawan['role_id'] == '2') {
                                                    echo "selected='selected'";
                                                } ?> value="2">Kesiswaan</option>

                                        <?php if ($user['role_id'] == '1') : ?>
                                        <option <?php if ($karyawan['role_id'] == '5') {
                                                    echo "selected='selected'";
                                                } ?>value="5">Bendahara</option>
                                        <?php endif ?>


                                        <option <?php if ($karyawan['role_id'] == '3') {
                                                    echo "selected='selected'";
                                                } ?>value="3">Guru</option>
                                        <option <?php if ($karyawan['role_id'] == '4') {
                                                    echo "selected='selected'";
                                                } ?>value="4">Karyawan Umum</option>
                                        <option <?php if ($karyawan['role_id'] == '6') {
                                                    echo "selected='selected'";
                                                } ?>value="6">Marketing</option>
                                    </select>
                                    <?= form_error('level', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="divisi">Divisi</label>  <a href="<?= base_url('admin/data_divisi') ?>" class="badge badge-success">Tambah</a>
                                    <select class="form-control" id="divisi" name="divisi" required>
                                        <option value="">- Pilih Divisi -</option>
                                        <?php foreach ($divisi as $a) : ?>
                                            <option <?php if ($karyawan['id_divisi'] == $a['id']) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('divisi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="">Intensif</label>
                                    <input type="number" class="form-control" id="intensif" name="intensif" value="<?= $karyawan['intensif'] ?>" placeholder="Intensif">
                                </div>
                                <div class="form-group">
                                    <label for="">Total Jam</label>
                                    <input type="number" class="form-control" id="jam_mengajar" name="jam_mengajar" value="<?= $karyawan['jam_mengajar'] ?>" placeholder="Jumlah Jam mengajar">
                                </div>

                                <div class="form-group">
                                    <label for="">Nominal Jam Mengajar</label>
                                    <input type="number" class="form-control" id="nominal_jam" name="nominal_jam" value="<?= $karyawan['nominal_jam'] ?>" placeholder="Nominal Jam mengajar">
                                </div>

                                <div class="form-group">
                                    <label>BPJS</label>
                                    <input type="number" class="form-control" id="bpjs" name="bpjs" placeholder="Nominal BPJS" value="<?= $karyawan['bpjs'] ?>">
                                    <?= form_error('bpjs', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Koperasi</label>
                                    <input type="number" class="form-control" id="koperasi" name="koperasi" placeholder="Nominal Koperasi" value="<?= $karyawan['koperasi'] ?>">
                                    <?= form_error('koperasi', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Simpanan</label>
                                    <input type="number" class="form-control" id="simpanan" name="simpanan" placeholder="Nominal Simpanan" value="<?= $karyawan['simpanan'] ?>">
                                    <?= form_error('simpanan', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Tabungan</label>
                                    <input type="number" class="form-control" id="tabungan" name="tabungan" placeholder="Nominal Tabungan" value="<?= $karyawan['tabungan'] ?>">
                                    <?= form_error('tabungan', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="col-form-label">Status :</label>
                                    <select class="form-control" id="status" name="status">
                                        <?php if ($karyawan['status'] == '1') : ?>
                                            <option value="1">
                                                Aktif (Terpilih)
                                            </option>
                                            <option value="0">Tidak Aktif</option>
                                        <?php elseif ($karyawan['status'] == '0') : ?>
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
                                <button type="submit" class="btn-block btn btn-success">Simpan Pendaftaran</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- /.container-fluid -->
</div>