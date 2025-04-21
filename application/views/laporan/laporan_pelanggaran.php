<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
</head>

<body>
    <br />
    <h3 align="center">Laporan Data Pelanggaran <?= $pendidikan ?>
        <?php if(!empty($kelas)) : ?>
        <h4>Kelas : <?= $kelas ?> <?= ($jurus)? ' - ' . $jurus : '' ?></h4>
        <?php endif ?>
    </h3>
    <h5> Tanggal : <?= mediumdate_indo(date($tgl_awal)) ?> - <?= mediumdate_indo(date($tgl_akhir)) ?></h5>
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama siswa</th>
                <?php if(empty($kelas)) : ?>
                <th>Kelas</th>
                <?php endif ?>
                <th>Pelanggaran</th>
                <th>Point (-)</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($laporan as $d) : ?>
                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <?= $d['nama_siswa'] ?>
                    </td>
                    <?php if(empty($kelas)) : ?>
                    <td>
                        <center><?= $d['class_name'] ?> <?= ($d['majors_name'])? ' - ' . $d['majors_name'] : '' ?></center>
                    </td>
                    <?php endif ?>
                    <td>
                        <center><?= $d['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $d['point'] ?></center>
                    </td>
                    <td>
                        <center><?= mediumdate_indo(date($d['tgl'])) ?></center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>