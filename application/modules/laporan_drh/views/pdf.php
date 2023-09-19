<?php

$jk = '';
if ($pegawai['SEX'] != "") {
    if ($pegawai['SEX'] == "L") {
        $jk = "Laki-laki";
    } elseif ($pegawai['SEX'] == "L") {
        $jk = "Perempuan";
    }
}

$pdf = new FPDF('P', 'mm', array(250, 215));
$pdf->setTopMargin(15);
$pdf->setLeftMargin(5);
$pdf->SetFont('times', 'B', '9');
$pdf->AddPage();
$pdf->Cell(80, 6, "", 0, 0, 'L');
$pdf->Cell(100, 6, 'DAFTAR RIWAYAT HIDUP', 0, 1, 'L');
$path_file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', base_url());
$filename = $path_file . '_uploads/photo_pegawai/thumbs/' . $pegawai['FOTO'];
if (!empty($pegawai['FOTO']) && file_exists($filename)) {
    $foto = $pegawai['FOTO'];
} else {
    $foto = 'no_photo.jpg';
}

if ($pegawai['nipnew'] == '' or $pegawai['nipnew'] == NULL) {
    $nip = $pegawai['nip'];
} else {
    $nip = $pegawai['nipnew'];
}

$pdf->Cell(100, 39, "", 0, 1, 'L');
$pdf->Image($path_file . '_uploads/photo_pegawai/thumbs/' . $foto, 180, 20, 30, 35);
$pdf->Cell(100, 6, "I. KETERANGAN PERORANGAN", 0, 1, 'L');
$pdf->SetFont('times', '', '9');
$pdf->Cell(15, 6, "1.", 1, 0, 'C');
$pdf->Cell(100, 6, "Nama Lengkap", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['nama'], 1, 1, 'L');
$pdf->Cell(15, 6, "2.", 1, 0, 'C');
$pdf->Cell(100, 6, "NIP", 1, 0, 'L');
;
$pdf->Cell(90, 6, $nip, 1, 1, 'L');
$pdf->Cell(15, 6, "3.", 1, 0, 'C');
$pdf->Cell(100, 6, "Pangkat Dan Golongan Ruang", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['nama'], 1, 1, 'L');
$pdf->Cell(15, 6, "4.", 1, 0, 'C');
$pdf->Cell(100, 6, "Tempat Lahir/Tgl Lahir", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['tptlahir'] . '  /  ' . $pegawai['tgllahir2'], 1, 1, 'L');
$pdf->Cell(15, 6, "5.", 1, 0, 'C');
$pdf->Cell(100, 6, "Jenis Kelamin", 1, 0, 'L');
;
$pdf->Cell(90, 6, $jk, 1, 1, 'L');
$pdf->Cell(15, 6, "6.", 1, 0, 'C');
$pdf->Cell(100, 6, "Agama", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['agama2'], 1, 1, 'L');
$pdf->Cell(15, 6, "7.", 1, 0, 'C');
$pdf->Cell(100, 6, "Status Perkawinan", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['stskawin2'], 1, 1, 'L');
$pdf->Cell(15, 30, "8.", 1, 0, 'C');
$pdf->Cell(50, 30, "Alamat", 1, 0, 'C');
$pdf->Cell(50, 6, "a. Jalan", 1, 0, 'L');
$pdf->MultiCell(90, 6, $pegawai['alamat'], 1);
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "b. Kelurahan / Desa", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['kelurahan'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "c. Kecamatan", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['kecamatan'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "d. Kabupaten / Kota", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['kabupaten2'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "e. Propinsi", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['propinsi2'], 1, 1, 'L');
$pdf->Cell(15, 42, "9.", 1, 0, 'C');
$pdf->Cell(50, 42, "Keterangan Badan", 1, 0, 'C');
$pdf->Cell(50, 6, "a. Tinggi(cm)", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['tinggi_badan'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "b. Berat Badan(Kg)", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['berat_badan'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "c. Rambut", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['rambut'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "d. Bentuk Muka", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['bentuk_muka'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "e. Warna Kulit", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['warna_kulit'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "f. Ciri-ciri Khas", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['ciri_khas'], 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(50, 6, "g. Cacat tubuh", 1, 0, 'L');
$pdf->Cell(90, 6, $pegawai['cacat_tubuh'], 1, 1, 'L');
$pdf->Cell(15, 6, "10.", 1, 0, 'C');
$pdf->Cell(100, 6, "Kegemaran / Hoby", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['hobi'], 1, 1, 'L');
$pdf->Cell(15, 6, "11.", 1, 0, 'C');
$pdf->Cell(100, 6, "Jabatan", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['n_jabatan'], 1, 1, 'L');
$pdf->Cell(15, 6, "12.", 1, 0, 'C');
$pdf->Cell(100, 6, "Masa Kerja", 1, 0, 'L');
;
$pdf->Cell(90, 6, $pegawai['thn_masakerja'], 1, 1, 'L');

//Riwayat Pendidikan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "II. PENDIDIKAN", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Pendidikan Dalam dan Luar Negeri", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(30, 10, "TINGKAT", 1, 0, 'L');
$pdf->Cell(45, 10, "NAMA PENDIDIKAN", 1, 0, 'L');
$pdf->Cell(20, 10, 'JURUSAN', 1, 0, 'L');
$pdf->Cell(25, 10, "IJAZAH TAHUN", 1, 0, 'C');
$pdf->Cell(25, 10, "TEMPAT", 1, 0, 'C');
$pdf->Cell(45, 10, "NAMA KEPALA SEKOLAH", 1, 1, 'L');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(30, 6, "2", 1, 0, 'L');
$pdf->Cell(45, 6, "3", 1, 0, 'C');
$pdf->Cell(20, 6, '4', 1, 0, 'C');
$pdf->Cell(25, 6, "5", 1, 0, 'C');
$pdf->Cell(25, 6, "6", 1, 0, 'C');
$pdf->Cell(45, 6, "7", 1, 1, 'L');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($pegawai_pendidikan as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(30, 6, $r['TINGKAT_PENDIDIKAN'], 1, 0, 'L');
    $pdf->Cell(45, 6, $r['NAMA_LBGPDK'], 1, 0, 'L');
    $pdf->Cell(20, 6, $r['NAMA_FAKULTAS'], 1, 0, 'L');
    $pdf->Cell(25, 6, $r['NO_STTB'] . '  ' . $r['THN_LULUS'], 1, 0, 'C');
    $pdf->Cell(25, 6, $r['NAMA_NEGARA'], 1, 0, 'C');
    $pdf->Cell(45, 6, $r['NAMA_DIREKTUR'], 1, 1, 'L');
    $i++;
}

//III. DIKLAT
//1. Seminar Dalam/Luar Negeri
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "III. DIKLAT", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Seminar di Dalam dan di Luar Negeri", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(60, 10, "NAMA KURSUS / LATIHAN", 1, 0, 'L');
$pdf->Cell(30, 10, "LAMANYA ", 1, 0, 'L');
$pdf->Cell(25, 10, 'IJAZAH TAHUN', 1, 0, 'L');
$pdf->Cell(35, 10, "TEMPAT", 1, 0, 'C');
$pdf->Cell(40, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(60, 6, "2", 1, 0, 'C');
$pdf->Cell(30, 6, "3 ", 1, 0, 'C');
$pdf->Cell(25, 6, '4', 1, 0, 'C');
$pdf->Cell(35, 6, "5", 1, 0, 'C');
$pdf->Cell(40, 6, "6", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($pegawai_kursus as $r) {
    foreach ($list_bulan as $b) {
        if ($r['BULAN'] == trim($b['kode'])) {
            $bln = $b['nama'];
        } else {
            
        }
    }
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(60, 6, $r['NAMA_KEGIATAN'], 1, 0, 'L');
    $pdf->Cell(30, 6, $bln . " " . $r['TAHUN'], 1, 0, 'L');
    $pdf->Cell(25, 6, $r['TAHUN'], 1, 0, 'L');
    $pdf->Cell(35, 6, $r['TEMPAT'] . " " . $r['NAMA_NEGARA'], 1, 0, 'C');
    $pdf->Cell(40, 6, '-', 1, 1, 'C');
    $i++;
}

//2. Pra Jabatan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "2. Pra Jabatan", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(150, 10, "NAMA DIKLAT", 1, 0, 'C');
$pdf->Cell(40, 10, "LAMA ", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(150, 6, "2", 1, 0, 'C');
$pdf->Cell(40, 6, "3 ", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($pegawai_prajabatan as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(150, 6, $r['NAMA_DIKLAT'], 1, 0, 'L');
    $pdf->Cell(40, 6, $r['JPL'], 1, 1, 'C');
    $i++;
}

//3. Penjenjangan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "3. Penjenjangan", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(120, 10, "NAMA DIKLAT", 1, 0, 'C');
$pdf->Cell(35, 10, "TAHUN DIKLAT", 1, 0, 'C');
$pdf->Cell(35, 10, "LAMA ", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(120, 6, "2", 1, 0, 'C');
$pdf->Cell(35, 6, "2", 1, 0, 'C');
$pdf->Cell(35, 6, "3 ", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($pegawai_penjenjangan as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(120, 6, $r['NAMA_JENJANG'], 1, 0, 'L');
    $pdf->Cell(35, 6, $r['THN_DIKLAT'], 1, 0, 'C');
    $pdf->Cell(35, 6, $r['JPL'], 1, 1, 'C');
    $i++;
}

//4. Teknis
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "4. Teknis", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(35, 10, "KELOMPOK", 1, 0, 'C');
$pdf->Cell(120, 10, "NAMA DIKLAT", 1, 0, 'C');
$pdf->Cell(35, 10, "LAMA ", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(35, 6, "2", 1, 0, 'C');
$pdf->Cell(120, 6, "2", 1, 0, 'C');
$pdf->Cell(35, 6, "3 ", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($pegawai_diklat_teknis as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(35, 6, $r['KETERANGAN'], 1, 0, 'C');
    $pdf->Cell(120, 6, $r['nama_diklat2'], 1, 0, 'L');
    $pdf->Cell(35, 6, $r['jpl'], 1, 1, 'C');
    $i++;
}

//5. Fungsional
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "5. Fungsional", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(35, 10, "JENIS DIKLAT", 1, 0, 'C');
$pdf->Cell(60, 10, "TINGKAT DIKLAT", 1, 0, 'C');
$pdf->Cell(60, 10, "JENJANG DIKLAT", 1, 0, 'C');
$pdf->Cell(35, 10, "LAMA ", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(35, 6, "2", 1, 0, 'C');
$pdf->Cell(60, 6, "2", 1, 0, 'C');
$pdf->Cell(60, 6, "3", 1, 0, 'C');
$pdf->Cell(35, 6, "4 ", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_fungsional as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(35, 6, $r['nm_diklat'], 1, 0, 'C');
    $pdf->Cell(60, 6, $r['jenis_jenjang'], 1, 0, 'L');
    $pdf->Cell(60, 6, $r['nm_jenjang'], 1, 0, 'L');
    $pdf->Cell(35, 6, $r['jpl'], 1, 1, 'C');
    $i++;
}

//6. Lain/Umum
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "6. Lain/Umum", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(150, 10, "NAMA DIKLAT", 1, 0, 'C');
$pdf->Cell(40, 10, "LAMA ", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(150, 6, "2", 1, 0, 'C');
$pdf->Cell(40, 6, "3 ", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_diklat_lain as $r) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(150, 6, $r['nama_diklat'], 1, 0, 'L');
    $pdf->Cell(40, 6, $r['jpl'], 1, 1, 'C');
    $i++;
}

//Riwayat Pekerjaan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "IV. RIWAYAT PEKERJAAN", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Riwayat kepangkatan golongan ruang penggajian", 0, 1, 'L');
$pdf->Cell(15, 12, "NO", 1, 0, 'C');
$pdf->Cell(25, 12, "PANGKAT", 1, 0, 'L');
$pdf->Cell(20, 12, "GOL. RUANG", 1, 0, 'L');
$pdf->Cell(30, 12, 'BERLAKU MULAI', 1, 0, 'L');
$pdf->Cell(20, 12, "GAJI POKOK", 1, 0, 'C');
$pdf->Cell(60, 6, "SURAT KEPUTUSAN", 1, 0, 'C');
$pdf->Cell(35, 6, "PERATURAN DASAR", 1, 1, 'L');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(25, 0, "", 0, 0, 'L');
$pdf->Cell(20, 0, "", 0, 0, 'L');
$pdf->Cell(30, 0, '', 0, 0, 'L');
$pdf->Cell(20, 0, "", 0, 0, 'C');
$pdf->Cell(20, 6, "PEJABAT", 1, 0, 'C');
$pdf->Cell(20, 6, "NOMOR", 1, 0, 'L');
$pdf->Cell(20, 6, "TANGGAL", 1, 0, 'C');
$pdf->Cell(35, 6, "", 1, 1, 'L');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(25, 6, "2", 1, 0, 'C');
$pdf->Cell(20, 6, "3", 1, 0, 'C');
$pdf->Cell(30, 6, '4', 1, 0, 'C');
$pdf->Cell(20, 6, "5", 1, 0, 'C');
$pdf->Cell(20, 6, "6", 1, 0, 'C');
$pdf->Cell(20, 6, "7", 1, 0, 'C');
$pdf->Cell(20, 6, "8", 1, 0, 'C');
$pdf->Cell(35, 6, "9", 1, 1, 'C');
$pdf->SetFont('times', '', '8');
$i = 1;
foreach ($data_pangkat as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(25, 6, $p['jenis'], 1, 0, 'L');
    $pdf->Cell(20, 6, $p['golongan'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['tmt_gol2'], 1, 0, 'L');
    $pdf->Cell(20, 6, $p['gapok'], 1, 0, 'C');
    $pdf->Cell(20, 6, $p['pejabat_sk'], 1, 0, 'C');
    $pdf->Cell(20, 6, $p['no_sk'], 1, 0, 'L');
    $pdf->Cell(20, 6, $p['tgl_sk2'], 1, 0, 'C');
    $pdf->Cell(35, 6, $p['dasar_pangkat'], 1, 1, 'L');
    $i++;
}
//PENGALAMAN JABATAN 
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "2. Pengalaman jabatan /Pekerjaan", 0, 1, 'L');
$pdf->Cell(13, 12, "NO", 1, 0, 'C');
$pdf->Cell(50, 12, "JABATAN / PEKERJAAN", 1, 0, 'L');
$pdf->Cell(35, 12, "MULAI DAN SELESAI", 1, 0, 'L');
$pdf->Cell(27, 12, 'GOL. RUANG', 1, 0, 'L');
$pdf->Cell(20, 12, "GAJI POKOK", 1, 0, 'C');
$pdf->Cell(60, 6, "SURAT KEPUTUSAN", 1, 1, 'C');
$pdf->Cell(13, 0, "", 0, 0, 'C');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(35, 0, "", 0, 0, 'L');
$pdf->Cell(27, 0, '', 0, 0, 'L');
$pdf->Cell(20, 0, "", 0, 0, 'C');
$pdf->Cell(20, 6, "PEJABAT", 1, 0, 'C');
$pdf->Cell(20, 6, "NOMOR", 1, 0, 'L');
$pdf->Cell(20, 6, "TANGGAL", 1, 1, 'C');

$pdf->Cell(13, 6, "1", 1, 0, 'C');
$pdf->Cell(50, 6, "2", 1, 0, 'C');
$pdf->Cell(35, 6, "3", 1, 0, 'C');
$pdf->Cell(27, 6, '4', 1, 0, 'C');
$pdf->Cell(20, 6, "5", 1, 0, 'C');
$pdf->Cell(20, 6, "6", 1, 0, 'C');
$pdf->Cell(20, 6, "7", 1, 0, 'C');
$pdf->Cell(20, 6, "8", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_jabatan as $g) {
    $pdf->Cell(13, 6, $i, 1, 0, 'C');
    $pdf->Cell(50, 6, $g['jabatan'], 1, 0, 'L');
    $pdf->Cell(35, 6, $g['tmt_jabatan2'] . ' sampai ' . $g['tgl_akhir2'], 1, 0, 'L');
    $pdf->Cell(27, 6, $g['eselon_tr'], 1, 0, 'L');
    $pdf->Cell(20, 6, $g['gapok'], 1, 0, 'C');
    $pdf->Cell(20, 6, $g['pejabat_sk'], 1, 0, 'C');
    $pdf->Cell(20, 6, $g['no_sk'], 1, 0, 'L');
    $pdf->Cell(20, 6, $g['tgl_sk2'], 1, 1, 'C');
    $i++;
}

//Tanda jasa / penghargaan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "V. TANDA JASA / PENGHARGAAN", 0, 1, 'L');
$pdf->Cell(15, 12, "NO", 1, 0, 'C');
$pdf->Cell(80, 12, "NAMA BINTANG / SATYA LENCANA PENGHARGAAN", 1, 0, 'C');
$pdf->Cell(40, 12, "TAHUN PEROLEHAN", 1, 0, 'C');
$pdf->Cell(70, 12, "NAMA NEGARA / INSTANSI YANG MEMBERI", 1, 1, 'C');

$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(80, 6, "2", 1, 0, 'C');
$pdf->Cell(40, 6, "3", 1, 0, 'C');
$pdf->Cell(70, 6, '4', 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_penghargaan as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(80, 6, $p['jenis_jasa'] . ' / ' . $p['nama_tdjasa'], 1, 0, 'L');
    $pdf->Cell(40, 6, $p['thn_prlhn'], 1, 0, 'L');
    $pdf->Cell(70, 6, $p['negara'] . ' / ' . $p['instansi'], 1, 1, 'L');
    $i++;
}

//PENGALAMAN KE LUAR NEGERI
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "VI. PENGALAMAN KE LUAR NEGERI", 0, 1, 'L');
$pdf->Cell(15, 12, "NO", 1, 0, 'C');
$pdf->Cell(40, 12, "NEGARA", 1, 0, 'C');
$pdf->Cell(70, 12, "TUJUAN KUNJUNGAN", 1, 0, 'C');
$pdf->Cell(40, 12, "LAMANYA", 1, 0, 'C');
$pdf->Cell(40, 12, "YANG MEMBIAYAI", 1, 1, 'C');

$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(40, 6, "2", 1, 0, 'C');
$pdf->Cell(70, 6, "3", 1, 0, 'C');
$pdf->Cell(40, 6, "4", 1, 0, 'C');
$pdf->Cell(40, 6, '5', 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_luar_negeri as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(40, 6, $p['nama_negara'], 1, 0, 'L');
    $pdf->Cell(70, 6, $p['tujuan'], 1, 0, 'L');
    $pdf->Cell(40, 6, $p['wkt_hari'] . ' hari ' . $p['wkt_bln'] . ' bln ' . $p['wkt_thn'] . ' Thn ', 1, 0, 'L');
    $pdf->Cell(40, 6, $p['jenis'], 1, 1, 'L');
    $i++;
}
// KELUARGA
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "VII. KETERANGAN KELUARGA", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Istri / Suami", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(35, 10, "NAMA", 1, 0, 'C');
$pdf->Cell(30, 10, "TEMPAT LAHIR", 1, 0, 'C');
$pdf->Cell(30, 10, 'TANGGAL LAHIR', 1, 0, 'C');
$pdf->Cell(30, 10, "TANGGAL NIKAH", 1, 0, 'C');
$pdf->Cell(30, 10, "PEKERJAAN", 1, 0, 'C');
$pdf->Cell(35, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(35, 6, "2", 1, 0, 'C');
$pdf->Cell(30, 6, "3", 1, 0, 'C');
$pdf->Cell(30, 6, '4', 1, 0, 'C');
$pdf->Cell(30, 6, "5", 1, 0, 'C');
$pdf->Cell(30, 6, "6", 1, 0, 'C');
$pdf->Cell(35, 6, "7", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_pasangan as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(35, 6, $p['nama'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['tempat_lhr'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['tgl_lahir2'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['tgl_nikah2'], 1, 0, 'C');
    $pdf->Cell(30, 6, $p['pekerjaan'], 1, 0, 'C');
    $pdf->Cell(20, 6, $p['jenis'] . $p['ket'], 1, 0, 'L');
    $i++;
}
//Anak
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "2. Anak", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(45, 10, "NAMA", 1, 0, 'C');
$pdf->Cell(25, 10, "JENIS KELAMIN", 1, 0, 'C');
$pdf->Cell(28, 10, "TEMPAT LAHIR", 1, 0, 'C');
$pdf->Cell(27, 10, 'TANGGAL LAHIR', 1, 0, 'C');
$pdf->Cell(30, 10, "PEKERJAAN", 1, 0, 'C');
$pdf->Cell(35, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(45, 6, "2", 1, 0, 'C');
$pdf->Cell(25, 6, "3", 1, 0, 'C');
$pdf->Cell(28, 6, "4", 1, 0, 'C');
$pdf->Cell(27, 6, '5', 1, 0, 'C');
$pdf->Cell(30, 6, "6", 1, 0, 'C');
$pdf->Cell(35, 6, "7", 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_anak as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(45, 6, $p['nama'], 1, 0, 'C');
    $pdf->Cell(25, 6, $p['jenis'], 1, 0, 'C');
    $pdf->Cell(28, 6, $p['tempat_lhr'], 1, 0, 'C');
    $pdf->Cell(27, 6, $p['tgl_lahir2'], 1, 0, 'C');
    $pdf->Cell(30, 6, $p['kerja'], 1, 0, 'C');
    $pdf->Cell(35, 6, $p['ket'], 1, 1, 'L');
    $i++;
}

//Bapak dan Ibu Kandung
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "3. Bapak dan Ibu Kandung", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(50, 10, "NAMA", 1, 0, 'C');
$pdf->Cell(60, 10, 'TANGGAL LAHIR / UMUR', 1, 0, 'C');
$pdf->Cell(45, 10, "PEKERJAAN", 1, 0, 'C');
$pdf->Cell(35, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(50, 6, "2", 1, 0, 'C');
$pdf->Cell(60, 6, "3", 1, 0, 'C');
$pdf->Cell(45, 6, "4", 1, 0, 'C');
$pdf->Cell(35, 6, '5', 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_ortu as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(50, 6, $p['nama'], 1, 0, 'L');
    $pdf->Cell(60, 6, $p['tgl_lahir2'], 1, 0, 'C');
    $pdf->Cell(45, 6, $p['kerja'], 1, 0, 'L');
    $pdf->Cell(35, 6, $p['status'] . ' ' . $p['ket'], 1, 1, 'L');
    $i++;
}

//Bapak dan Ibu Mertua
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "4. Bapak dan Ibu Mertua", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(50, 10, "NAMA", 1, 0, 'C');
$pdf->Cell(60, 10, 'TANGGAL LAHIR / UMUR', 1, 0, 'C');
$pdf->Cell(45, 10, "PEKERJAAN", 1, 0, 'C');
$pdf->Cell(35, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(50, 6, "2", 1, 0, 'C');
$pdf->Cell(60, 6, "3", 1, 0, 'C');
$pdf->Cell(45, 6, "4", 1, 0, 'C');
$pdf->Cell(35, 6, '5', 1, 1, 'C');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_mertua as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(50, 6, $p['nama'], 1, 0, 'L');
    $pdf->Cell(60, 6, $p['tgl_lahir2'], 1, 0, 'C');
    $pdf->Cell(45, 6, $p['kerja'], 1, 0, 'L');
    $pdf->Cell(35, 6, $p['status'] . ' ' . $p['ket'], 1, 1, 'L');
    $i++;
}

//Saudara Kandung
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "5. Saudara Kandung", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(55, 10, "NAMA", 1, 0, 'C');
$pdf->Cell(25, 10, "JENIS KELAMIN", 1, 0, 'C');
$pdf->Cell(45, 10, 'TANGGAL LAHIR / UMUR', 1, 0, 'C');
$pdf->Cell(30, 10, "PEKERJAAN", 1, 0, 'C');
$pdf->Cell(35, 10, "KETERANGAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(55, 6, "2", 1, 0, 'C');
$pdf->Cell(25, 6, "3", 1, 0, 'C');
$pdf->Cell(45, 6, "4", 1, 0, 'C');
$pdf->Cell(30, 6, '5', 1, 0, 'C');
$pdf->Cell(35, 6, "6", 1, 1, 'C');

$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_saudara as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(55, 6, $p['nama'], 1, 0, 'L');
    $pdf->Cell(25, 6, $p['jenis'], 1, 0, 'C');
    $pdf->Cell(45, 6, $p['tgl_lahir2'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['kerja'], 1, 0, 'C');
    $pdf->Cell(20, 6, $p['ket'], 1, 0, 'L');
    $i++;
}

//ORGANISASI
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "VIII. KETERANGAN ORGANISASI", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Semasa Mengikuti Pendidikan Pada SLTA ke Bawah", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(45, 10, "NAMA ORGANISASI", 1, 0, 'C');
$pdf->Cell(50, 10, "KEDUDUKAN DALAM ORGANISASI", 1, 0, 'C');
$pdf->Cell(30, 10, 'DALAM TH S/D TH', 1, 0, 'C');
$pdf->Cell(25, 10, "TEMPAT", 1, 0, 'C');
$pdf->Cell(40, 10, "NAMA PIMPINAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(45, 6, "2", 1, 0, 'C');
$pdf->Cell(50, 6, "3", 1, 0, 'C');
$pdf->Cell(30, 6, '4', 1, 0, 'C');
$pdf->Cell(25, 6, "5", 1, 0, 'C');
$pdf->Cell(40, 6, "6", 1, 1, 'C');

$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_org_sklh as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(45, 6, $p['nama_org'], 1, 0, 'L');
    $pdf->Cell(50, 6, $p['jabatan_org'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['thn_terdaftar'] . ' s/d ' . $p['thn_selesai'], 1, 0, 'L');
    $pdf->Cell(25, 6, $p['tempat_org'], 1, 0, 'C');
    $pdf->Cell(40, 6, $p['pimpinan_org'], 1, 1, 'C');
    $i++;
}

//Semasa Perguruan Tinggi
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "2. Semasa Mengikuti Pendidikan Pada Perguruan Tinggi", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(45, 10, "NAMA ORGANISASI", 1, 0, 'C');
$pdf->Cell(50, 10, "KEDUDUKAN DALAM ORGANISASI", 1, 0, 'C');
$pdf->Cell(30, 10, 'DALAM TH S/D TH', 1, 0, 'C');
$pdf->Cell(25, 10, "TEMPAT", 1, 0, 'C');
$pdf->Cell(40, 10, "NAMA PIMPINAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(45, 6, "2", 1, 0, 'C');
$pdf->Cell(50, 6, "3", 1, 0, 'C');
$pdf->Cell(30, 6, '4', 1, 0, 'C');
$pdf->Cell(25, 6, "5", 1, 0, 'C');
$pdf->Cell(40, 6, "6", 1, 1, 'C');
//$pdf->Cell(15, 6,"1",1,0,'C');$pdf->Cell(35, 6,"2",1,0,'L');$pdf->Cell(45, 6,"3",1,0,'C');$pdf->Cell(20, 6,'4',1,0,'C');$pdf->Cell(25, 6,"5",1,0,'C');$pdf->Cell(25, 6,"6",1,0,'C');$pdf->Cell(40, 6,"7",1,1,'L');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_org_perguruan as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(45, 6, $p['nama_org'], 1, 0, 'L');
    $pdf->Cell(50, 6, $p['jabatan_org'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['thn_terdaftar'], 1, 0, 'L');
    $pdf->Cell(25, 6, $p['tempat_org'], 1, 0, 'C');
    $pdf->Cell(40, 6, $p['pimpinan_org'], 1, 1, 'C');
    $i++;
}

//sudah selesai pendidikan
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "3. Sudah Selesai Pendidikan atau Semasa Menjadi Pegawai", 0, 1, 'L');
$pdf->Cell(15, 10, "NO", 1, 0, 'C');
$pdf->Cell(45, 10, "NAMA ORGANISASI", 1, 0, 'C');
$pdf->Cell(50, 10, "KEDUDUKAN DALAM ORGANISASI", 1, 0, 'C');
$pdf->Cell(30, 10, 'DALAM TH S/D TH', 1, 0, 'C');
$pdf->Cell(25, 10, "TEMPAT", 1, 0, 'C');
$pdf->Cell(40, 10, "NAMA PIMPINAN", 1, 1, 'C');
$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(45, 6, "2", 1, 0, 'C');
$pdf->Cell(50, 6, "3", 1, 0, 'C');
$pdf->Cell(30, 6, '4', 1, 0, 'C');
$pdf->Cell(25, 6, "5", 1, 0, 'C');
$pdf->Cell(40, 6, "6", 1, 1, 'C');
//$pdf->Cell(15, 6,"1",1,0,'C');$pdf->Cell(35, 6,"2",1,0,'L');$pdf->Cell(45, 6,"3",1,0,'C');$pdf->Cell(20, 6,'4',1,0,'C');$pdf->Cell(25, 6,"5",1,0,'C');$pdf->Cell(25, 6,"6",1,0,'C');$pdf->Cell(40, 6,"7",1,1,'L');
$pdf->SetFont('times', '', '9');
$i = 1;
foreach ($data_org_pns as $p) {
    $pdf->Cell(15, 6, $i, 1, 0, 'C');
    $pdf->Cell(45, 6, $p['nama_org'], 1, 0, 'L');
    $pdf->Cell(50, 6, $p['jabatan_org'], 1, 0, 'L');
    $pdf->Cell(30, 6, $p['thn_terdaftar'], 1, 0, 'L');
    $pdf->Cell(25, 6, $p['tempat_org'], 1, 0, 'C');
    $pdf->Cell(40, 6, $p['pimpinan_org'], 1, 1, 'C');
    $i++;
}

//Keterangan Lain-Lain
$pdf->SetFont('times', 'B', '8');
$pdf->Cell(100, 10, "IX. KETERANGAN LAIN-LAIN", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(100, 6, "1. Semasa Mengikuti Pendidikan pada SLTA Ke Bawah", 0, 1, 'L');
$pdf->Cell(15, 12, "NO", 1, 0, 'C');
$pdf->Cell(70, 12, "NAMA KETERANGAN", 1, 0, 'C');
$pdf->Cell(80, 6, "SURAT KETERANGAN", 1, 0, 'C');
$pdf->Cell(40, 6, "TANGGAL", 1, 1, 'C');
$pdf->Cell(15, 0, "", 0, 0, 'C');
$pdf->Cell(70, 0, "", 0, 0, 'C');
$pdf->Cell(40, 6, "PEJABAT", 1, 0, 'C');
$pdf->Cell(40, 6, "NOMOR", 1, 0, 'C');
$pdf->Cell(40, 6, "", 1, 1, 'C');

$pdf->Cell(15, 6, "1", 1, 0, 'C');
$pdf->Cell(70, 6, "2", 1, 0, 'C');
$pdf->Cell(40, 6, "3", 1, 0, 'C');
$pdf->Cell(40, 6, '4', 1, 0, 'C');
$pdf->Cell(40, 6, "5", 1, 1, 'C');
$pdf->SetFont('times', '', '9');

$pdf->Cell(15, 6, "1", 1, 0, 'L');
$pdf->Cell(70, 6, "KETERANGAN BERKELAKUAN BAIK", 1, 0, 'L');
$pdf->Cell(40, 6, "", 1, 0, 'C');
$pdf->Cell(40, 6, '', 1, 0, 'C');
$pdf->Cell(40, 6, "", 1, 1, 'C');
$pdf->Cell(15, 6, "2", 1, 0, 'C');
$pdf->Cell(70, 6, "KETERANGAN BERBADAN SEHAT", 1, 0, 'L');
$pdf->Cell(40, 6, "", 1, 0, 'C');
$pdf->Cell(40, 6, '', 1, 0, 'C');
$pdf->Cell(40, 6, "", 1, 1, 'C');
$pdf->Cell(15, 6, "3", 1, 0, 'C');
$pdf->Cell(190, 6, "KETERANGAN LAIN YANG DI ANGGAP PERLU :", 1, 1, 'L');
$pdf->Cell(15, 3, "", 0, 1, 'C');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "Demikian daftar riwayat hidup ini saya buat dengan sesungguhnya dan apabila dikemudian hari terdapat keterangan yang tidak benar ", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "saya bersedia dituntut dimuka pengadilan serta bersedia menerima segala tindakan yang di ambil oleh pemerintah. ", 0, 1, 'L');
$pdf->Cell(15, 3, "", 0, 1, 'C');
$pdf->Cell(120, 6, "", 0, 0, 'C');
$pdf->Cell(70, 6, "................ , .....................", 0, 1, 'L');
$pdf->Cell(120, 6, "", 0, 0, 'C');
$pdf->Cell(70, 6, "Yang Membuat,", 0, 1, 'L');
$pdf->Cell(15, 20, "", 0, 1, 'C');
$pdf->Cell(120, 6, "", 0, 0, 'C');
$pdf->Cell(70, 6, "..................................", 0, 1, 'L');
$pdf->Cell(15, 2, "", 0, 1, 'C');
$pdf->SetFont('times', 'B', '10');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "PERHATIAN :", 0, 1, 'L');

$pdf->SetFont('times', '', '9');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "1. Harus di isi sendiri menggunakan huruf kapital/balok dan tinta hitam.", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "2. Jika ada yang salah harus di coret, yang dicoret tetap terbaca kemudian yang benar dituliskan diatas atau sibawahnya dan diparaf.", 0, 1, 'L');
$pdf->Cell(5, 6, "", 0, 0, 'C');
$pdf->Cell(205, 6, "3. Kolom yang kosong diberi tanda (-) ", 0, 1, 'L');



//$pdf->Close();
$pdf->Output('drh_' . $nip . '.pdf', 'I');
?>
