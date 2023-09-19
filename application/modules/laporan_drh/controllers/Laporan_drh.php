<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
require_once APPPATH . "third_party/fpdf/fpdf.php";

class Laporan_drh extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('laporan_drh/laporan_drh_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/select2/js/select2.full.min.js']);
        $this->data['custom_js'] = ['laporan_drh/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'Daftar Riwayat Hidup';
    }

    public function index() {
        $this->data['content'] = 'laporan_drh/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_struktural'] = $this->list_model->list_eselon_struktural();
        $this->data['list_bulan'] = $this->list_model->list_bulan();
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $nip = (isset($_POST['nip']) && !empty($_POST['nip'])) ? trim($this->input->post('nip', TRUE)) : 0;

        $this->data['pegawai'] = $this->laporan_drh_model->get_data_pegawai($nip);
        $this->data['pegawai_pendidikan'] = $this->laporan_drh_model->get_data_pegawai_pendidikan($this->data['pegawai']['ID']);
        $this->data['pegawai_prajabatan'] = $this->laporan_drh_model->get_data_pegawai_prajabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penjenjangan'] = $this->laporan_drh_model->get_data_pegawai_penjenjangan($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_teknis'] = $this->laporan_drh_model->get_data_pegawai_diklat_teknis($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_fungsional'] = $this->laporan_drh_model->get_data_pegawai_diklat_fungsional($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_lain'] = $this->laporan_drh_model->get_data_pegawai_diklat_lain($this->data['pegawai']['ID']);
        $this->data['pegawai_kursus'] = $this->laporan_drh_model->get_data_pegawai_kursus($this->data['pegawai']['ID']);
        $this->data['pegawai_pangkat'] = $this->laporan_drh_model->get_data_pegawai_pangkat($this->data['pegawai']['ID']);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->data['pegawai_luar_negeri'] = $this->laporan_drh_model->get_data_pegawai_luar_negeri($this->data['pegawai']['ID']);
        $this->data['pegawai_pasangan'] = $this->laporan_drh_model->get_data_pegawai_pasangan($this->data['pegawai']['ID']);
        $this->data['pegawai_anak'] = $this->laporan_drh_model->get_data_pegawai_anak($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_kandung'] = $this->laporan_drh_model->get_data_pegawai_ortu_kandung($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_mertua'] = $this->laporan_drh_model->get_data_pegawai_ortu_mertua($this->data['pegawai']['ID']);
        $this->data['pegawai_saudara'] = $this->laporan_drh_model->get_data_pegawai_saudara($this->data['pegawai']['ID']);
        $this->data['pegawai_organisasi'] = $this->laporan_drh_model->get_data_pegawai_organisasi($this->data['pegawai']['ID']);
        $this->data['pegawai_perguruan'] = $this->laporan_drh_model->get_data_pegawai_perguruan($this->data['pegawai']['ID']);
        $this->data['pegawai_pns'] = $this->laporan_drh_model->get_data_pegawai_pns($this->data['pegawai']['ID']);
        $this->data['pegawai_keterangan'] = $this->laporan_drh_model->get_data_pegawai_keterangan($this->data['pegawai']['ID']);
        $this->data['list_bulan'] = $this->list_model->list_bulan();

        $this->load->view("laporan_drh/_hasil", $this->data);
    }

    public function export_excel() {
        $objPHPExcel = new PHPExcel();
        // Set properties
        //echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("BADAN PENCARIAN DAN PERTOLONGAN")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

		
        // Add some data, we will use printing features
        $styleArray = array(
            'font' => array(
                'bold' => false,
                'size' => 9
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'getStartColor' => array(
                    'argb' => '000000'
                )
            ),
        );
        //utk ukuran font yang digunakan
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

        // get data 	
        $data = $this->laporan_drh_model->get_data_pegawai($this->input->get('nip',true));
        $data_pendidikan = $this->laporan_drh_model->get_data_pegawai_pendidikan($data['ID']);
        $data_jabatan = $this->laporan_drh_model->get_data_pegawai_jabatan($data['ID']);
        $data_pangkat = $this->laporan_drh_model->get_data_pegawai_pangkat($data['ID']);
        $data_luar_negeri = $this->laporan_drh_model->get_data_pegawai_luar_negeri($data['ID']);
        $data_pasangan = $this->laporan_drh_model->get_data_pegawai_pasangan($data['ID']);
        $data_anak = $this->laporan_drh_model->get_data_pegawai_anak($data['ID']);
        $data_penghargaan = $this->laporan_drh_model->get_data_pegawai_penghargaan($data['ID']);
        $data_saudara = $this->laporan_drh_model->get_data_pegawai_saudara($data['ID']);
        $data_ortu = $this->laporan_drh_model->get_data_pegawai_ortu_kandung($data['ID']);
        $data_mertua = $this->laporan_drh_model->get_data_pegawai_ortu_mertua($data['ID']);
        $data_org_pns = $this->laporan_drh_model->get_data_pegawai_organisasi($data['ID']);
        $data_keterangan = $this->laporan_drh_model->get_data_pegawai_keterangan($data['ID']);
        $data_kursus = $this->laporan_drh_model->get_data_pegawai_kursus($data['ID']);
        $list_bulan = $this->list_model->list_bulan();
        $data_parajabatan = $this->laporan_drh_model->get_data_pegawai_prajabatan($data['ID']);
        $data_penjenjangan = $this->laporan_drh_model->get_data_pegawai_penjenjangan($data['ID']);
        $data_diklat_teknis = $this->laporan_drh_model->get_data_pegawai_diklat_teknis($data['ID']);
        $data_fungsional = $this->laporan_drh_model->get_data_pegawai_diklat_fungsional($data['ID']);
        $data_diklat_lain = $this->laporan_drh_model->get_data_pegawai_diklat_lain($data['ID']);
        //$data_master 				= $this->De_induk_pegawai_cetak_model->get_data($nip);
        //$jml_pdk=count($data_pendidikan)+$jml_pdk;
        //$jumlah= count($data)+1;
        /* -----------------------------------------------------------------I. keterangan perorangan------------------------------------------------------------------- */

        $path_file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('https://' . $_SERVER['HTTP_HOST'] . '/', '', base_url());
        $filename = $path_file . '_uploads/photo_pegawai/thumbs/' . $data['FOTO'];
        if (file_exists($filename)) {
            $foto = $data['FOTO'];
        } else {
            $foto = 'no_photo.jpg';
        }
        // ...... GAMBAR ............

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objDrawing->setName('Paid');
        $objDrawing->setDescription('Paid');
        $objDrawing->setPath('./_uploads/photo_pegawai/thumbs/' . $foto);
        $objDrawing->setCoordinates('I2');
        $objDrawing->setOffsetX(130);
        $objDrawing->setRotation(25);
        $objDrawing->setHeight(90);
        $objDrawing->setWidth(115);
        $objDrawing->getShadow()->setVisible(FALSE);
        $objDrawing->getShadow()->setDirection(45);
        //.................
		
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A11', '1')
                ->setCellValue('B11', 'Nama Lengkap')
                ->setCellValue('A12', '2')
                ->setCellValue('B12', 'Nip')
                ->setCellValue('A13', '3')
                ->setCellValue('B13', 'Pangkat Dan Golongan Ruang')
                ->setCellValue('A14', '4')
                ->setCellValue('B14', 'Tempat Lahir/Tgl.Lahir')
                ->setCellValue('A15', '5')
                ->setCellValue('B15', 'Jenis Kelamin')
                ->setCellValue('A16', '6')
                ->setCellValue('B16', 'Agama')
                ->setCellValue('A17', '7')
                ->setCellValue('B17', 'Status Perkawinan')
                ->setCellValue('A18', '8')
                ->setCellValue('B18', 'Alamat Rumah')
                ->setCellValue('C18', 'a.jalan')
                ->setCellValue('C19', 'b.kelurahan desa')
                ->setCellValue('C20', 'c.kecamatan')
                ->setCellValue('C21', 'd.kabupaten/kodya')
                ->setCellValue('C22', 'e.provinsi')
                ->setCellValue('A23', '9')
                ->setCellValue('B23', 'keterangan')
                ->setCellValue('C23', 'a.tinggi(cm)')
                ->setCellValue('C24', 'b.berat badan(kg)')
                ->setCellValue('C25', 'c.rambut')
                ->setCellValue('C26', 'd.bentuk muka')
                ->setCellValue('C27', 'e.warna kulit')
                ->setCellValue('C28', 'f.ciri-ciri khas')
                ->setCellValue('C29', 'g.cacat')
                ->setCellValue('C30', 'h.golongan darah')
                ->setCellValue('A31', '10')
                ->setCellValue('B31', 'Kegemaran (Hobby)');
        //utk membuat garis

        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:I8');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:G9');
        $objPHPExcel->getActiveSheet()->mergeCells('B31:D31');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('B12:D12');
        $objPHPExcel->getActiveSheet()->mergeCells('B13:D13');
        $objPHPExcel->getActiveSheet()->mergeCells('B14:D14');
        $objPHPExcel->getActiveSheet()->mergeCells('B15:D15');
        $objPHPExcel->getActiveSheet()->mergeCells('B16:D16');
        $objPHPExcel->getActiveSheet()->mergeCells('B17:D17');
        $objPHPExcel->getActiveSheet()->mergeCells('C18:D18');
        $objPHPExcel->getActiveSheet()->mergeCells('C19:D19');
        $objPHPExcel->getActiveSheet()->mergeCells('C20:D20');
        $objPHPExcel->getActiveSheet()->mergeCells('C21:D21');
        $objPHPExcel->getActiveSheet()->mergeCells('C22:D22');
        $objPHPExcel->getActiveSheet()->mergeCells('C23:D23');
        $objPHPExcel->getActiveSheet()->mergeCells('C24:D24');
        $objPHPExcel->getActiveSheet()->mergeCells('C25:D25');
        $objPHPExcel->getActiveSheet()->mergeCells('C26:D26');
        $objPHPExcel->getActiveSheet()->mergeCells('C27:D27');
        $objPHPExcel->getActiveSheet()->mergeCells('C28:D28');
        $objPHPExcel->getActiveSheet()->mergeCells('C29:D29');
        $objPHPExcel->getActiveSheet()->mergeCells('C30:D30');
        $objPHPExcel->getActiveSheet()->mergeCells('C31:D31');
        /* ------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->mergeCells('E11:I11');
        $objPHPExcel->getActiveSheet()->mergeCells('E12:I12');
        $objPHPExcel->getActiveSheet()->mergeCells('E13:I13');
        $objPHPExcel->getActiveSheet()->mergeCells('E14:I14');
        $objPHPExcel->getActiveSheet()->mergeCells('E15:I15');
        $objPHPExcel->getActiveSheet()->mergeCells('E16:I16');
        $objPHPExcel->getActiveSheet()->mergeCells('E17:I17');
        $objPHPExcel->getActiveSheet()->mergeCells('E18:I18');
        $objPHPExcel->getActiveSheet()->mergeCells('E19:I19');
        $objPHPExcel->getActiveSheet()->mergeCells('E20:I20');
        $objPHPExcel->getActiveSheet()->mergeCells('E21:I21');
        $objPHPExcel->getActiveSheet()->mergeCells('E22:I22');
        $objPHPExcel->getActiveSheet()->mergeCells('E23:I23');
        $objPHPExcel->getActiveSheet()->mergeCells('E24:I24');
        $objPHPExcel->getActiveSheet()->mergeCells('E25:I25');
        $objPHPExcel->getActiveSheet()->mergeCells('E26:I26');
        $objPHPExcel->getActiveSheet()->mergeCells('E27:I27');
        $objPHPExcel->getActiveSheet()->mergeCells('E28:I28');
        $objPHPExcel->getActiveSheet()->mergeCells('E29:I29');
        $objPHPExcel->getActiveSheet()->mergeCells('E30:I30');
        $objPHPExcel->getActiveSheet()->mergeCells('E31:I31');
		
        $objPHPExcel->getActiveSheet()->getStyle('I2:I8')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A11:I31')->applyFromArray($styleArray);
        if ($data['NIPNEW'] == '' or $data['NIPNEW'] == Null) {
            $nip = $data['NIP'];
        } else {
            $nip = $data['NIPNEW'];
        }

        //unset($styleArray);	
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A10', 'I')
                ->setCellValue('B10', 'KETERANGAN PERORANGAN');
        //$objPHPExcel->getActiveSheet()->getStyle('A10:B10')->applyFromArray($stylecss);
        
        $jk = '';
        if ($data['SEX'] != "") {
            if ($data['SEX'] == "L") {
                $jk = "Laki-laki";
            } elseif ($data['SEX'] == "L") {
                $jk = "Perempuan";
            }
        }

        $datanama = ((!empty($data['GELAR_DEPAN'])) ? $data['GELAR_DEPAN'] . " " : "") . ($data['NAMA']) . ((!empty($data['GELAR_BLKG'])) ? ", " . $data['GELAR_BLKG'] : '');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E11', '' . $datanama . '')
                ->setCellValue('E12', '\'' . $nip)
                ->setCellValue('E13', '' . ($data['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $data['PANGKAT'] . " / " . $data['GOLONGAN'] : $data['PANGKAT'])
                ->setCellValue('E14', '' . $data['TPTLAHIR'] . ' ' . '/' . ' ' . $data['TGLLAHIR2'])
                ->setCellValue('E15', '' . $jk)
                ->setCellValue('E16', '' . $data['AGAMA'])
                ->setCellValue('E17', '' . $data['PERNIKAHAN'])
                ->setCellValue('E18', '' . $data['ALAMAT'])
                ->setCellValue('E19', '' . $data['KELURAHAN'])
                ->setCellValue('E20', '' . $data['KECAMATAN'])
                ->setCellValue('E21', '' . $data['NAMAKABUPATEN'])
                ->setCellValue('E22', '' . $data['NAMA_PROPINSI'])
                ->setCellValue('E23', '\'' . $data['TINGGI_BADAN'])
                ->setCellValue('E24', '\'' . $data['BERAT_BADAN'])
                ->setCellValue('E25', '' . $data['RAMBUT'])
                ->setCellValue('E26', '' . $data['BENTUK_MUKA'])
                ->setCellValue('E27', '' . $data['WARNA_KULIT'])
                ->setCellValue('E28', '' . $data['CIRI_KHAS'])
                ->setCellValue('E31', '' . $data['HOBI']);

        $objPHPExcel->getActiveSheet()->getStyle('C37')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('G37')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E37')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('I43')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A50')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D50')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D52')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E50')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E52')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E64')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('C85')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E85')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A37:G37')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A50:I51')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A52:I52')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A64:I64')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A80:I80')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A85:I85')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('E33')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /* ---------------------------------------------------------------II .PENDIDIKAN------------------------------------------------------------------- */
        //  1.pendidikan dalam dan luar negeri

        $objPHPExcel->getActiveSheet()->mergeCells('G37:I37');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A35', 'II')
                ->setCellValue('A36', '1.')
                ->setCellValue('B36', 'Pendidikan Di Dalam Dan Luar Negeri')
                ->setCellValue('B35', 'PENDIDIKAN')
                ->setCellValue('A37', 'NO')
                ->setCellValue('B37', 'TINGKAT')
                ->setCellValue('C37', 'NAMA PENDIDIKAN')
                ->setCellValue('D37', 'JURUSAN')
                ->setCellValue('E37', 'STTB/TANDA LULUS/IJAZAH TAHUN')
                ->setCellValue('F37', 'TEMPAT')
                ->setCellValue('G37', 'NAMA KEPALA SEKOLAH/ DIREKTUR/DEKAN/PROMOTOR');


        $ip = 38;
        $no = 1;
        foreach ($data_pendidikan as $r) {

            $objPHPExcel->getActiveSheet()->getStyle('C' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('G' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['TINGKAT_PENDIDIKAN'])
                    ->setCellValue('C' . $ip, $r['NAMA_LBGPDK'])
                    ->setCellValue('D' . $ip, $r['NAMA_JURUSAN'])
                    ->setCellValue('E' . $ip, $r['THN_LULUS'])
                    ->setCellValue('F' . $ip, $r['NAMA_NEGARA'])
                    ->setCellValue('G' . $ip, $r['NAMA_DIREKTUR']);
            $no++;
            $ip++;
        }
        $ip_last = $ip - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A37:I' . $ip_last)->applyFromArray($styleArray);
        /* -----------------------------------------------------------------III. DIKLAT-------------------------------------------------------------------- */
        //  1. ------------  Seminar dalam/luar negeri  -----------------------
		
        $first_head = $ip_last + 2;
        $firts = $ip_last + 3;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $first_head, '2.')
                ->setCellValue('B' . $first_head, 'Kursus/Latihan di Dalam dan Luar Negeri')
                ->setCellValue('A' . $pntitle, 'NO')
                ->setCellValue('B' . $pntitle, 'NAMA/KURSUS/LATIHAN')
                ->setCellValue('C' . $pntitle, 'LAMANYA/TGL/BLN/THN/S/D/TGL/BLN/THN')
                ->setCellValue('E' . $pntitle, 'IJAZAH/TANDA LULUH/SURAT KETERANGAN TAHUN')
                ->setCellValue('G' . $pntitle, 'TEMPAT')
                ->setCellValue('H' . $pntitle, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $pntitle . ':D' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitle . ':F' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pntitle . ':I' . $pntitle);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $pntitle)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $pntitle)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $pntitle)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $pntitle)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
        $ip = $pntitle + 1;
        $no = 1;
        foreach ($data_parajabatan as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['NAMA_DIKLAT'])
                    ->setCellValue('C' . $ip, $r['JPL'])
                    ->setCellValue('E' . $ip, $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'])
                    ->setCellValue('G' . $ip, $r['PENYELENGGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        
        foreach ($data_penjenjangan as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['NAMA_JENJANG'])
                    ->setCellValue('C' . $ip, $r['JPL'])
                    ->setCellValue('E' . $ip, $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] . " " . $r['THN_DIKLAT'])
                    ->setCellValue('G' . $ip, $r['PENYELENGGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        
        foreach ($data_diklat_teknis as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['KETERANGAN'])
                    ->setCellValue('C' . $ip, $r['JPL'])
                    ->setCellValue('E' . $ip, $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'])
                    ->setCellValue('G' . $ip, $r['PENYELENGGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        foreach ($data_fungsional as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['JENIS_DIKLAT_FUNGSIONAL'] . " " . $r['PENJENJANGAN_FUNGSIONAL'] . " " . $r['NAMA_PENJENJANGAN'])
                    ->setCellValue('C' . $ip, $r['JPL'])
                    ->setCellValue('E' . $ip, $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'])
                    ->setCellValue('G' . $ip, $r['PENYELENGGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        foreach ($data_diklat_lain as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['NAMA_DIKLAT'])
                    ->setCellValue('C' . $ip, $r['JPL'])
                    ->setCellValue('E' . $ip, $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'])
                    ->setCellValue('G' . $ip, $r['PENYELENGGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        foreach ($data_kursus as $r) {
            foreach ($list_bulan as $b) {
                if ($r['BULAN'] == trim($b['kode'])) {
                    $bln = $b['nama'];
                } else {
                    
                }
            }
            $objPHPExcel->getActiveSheet()->getStyle('C' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $r['NAMA_KEGIATAN'])
                    ->setCellValue('C' . $ip, $bln . ' ' . $r['TAHUN'])
                    ->setCellValue('E' . $ip, $r['TAHUN'])
                    ->setCellValue('G' . $ip, $r['TEMPAT'] . '-' . $r['NAMA_NEGARA'])
                    ->setCellValue('H' . $ip, '-');
            $no++;
            $ip++;
        }
        $ip_last = $ip - 1;
        //$ip_bwah=$ip;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $ip_last)->applyFromArray($styleArray);

        /* -----------------------------------------------------------------IV. RIWAYAT PEKERJAAN-------------------------------------------------------------------- */
        //  1. ------------  Riwayat Kepangkatan Golongan Ruang Penggajian  -----------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'III')
                ->setCellValue('B' . $firts, 'RIWAYAT PEKERJAAN')
                ->setCellValue('A' . $pntitle, '1.')
                ->setCellValue('B' . $pntitle, 'Riwayat Kepangkatan Golongan / Ruang Penggajian')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'PANGKAT')
                ->setCellValue('C' . $pnhead, 'GOL.RUANG PENGGAJIAN')
                ->setCellValue('D' . $pnhead, 'BERLAKU TERHITUNG MULAI TANGGAL')
                ->setCellValue('E' . $pnhead, 'GAJI POKOK')
                ->setCellValue('F' . $pnhead, 'SURAT KEPUTUSAN')
                ->setCellValue('F' . $merge, 'PEJABAT')
                ->setCellValue('H' . $merge, 'NOMOR')
                ->setCellValue('G' . $merge, 'TANGGAL')
                ->setCellValue('I' . $pnhead, 'PERATURAN YANG DIJADIKAN DASAR');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $pnhead . ':A' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':B' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $pnhead . ':C' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $pnhead . ':D' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pnhead . ':E' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':H' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('I' . $pnhead . ':I' . $merge);

        $ip = $merge + 1;
        $no = 1;
        foreach ($data_pangkat as $row) {

            $objPHPExcel->getActiveSheet()->getStyle('C' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $row['JENIS_KENAIKAN_PANGKAT'])
                    ->setCellValue('C' . $ip, ($row['TRSTATUSKEPEGAWAIAN_ID'] == "1") ? $row['PANGKAT']." (".$row['GOLONGAN'].")" : $row['PANGKAT'])
                    ->setCellValue('D' . $ip, $row['TMT_GOL2'])
                    ->setCellValue('E' . $ip, $row['GAPOK'])
                    ->setCellValue('F' . $ip, $row['PEJABAT_SK'])
                    ->setCellValue('G' . $ip, $row['NO_SK'])
                    ->setCellValue('H' . $ip, $row['TGL_SK'])
                    ->setCellValue('I' . $ip, $row['DASAR_PANGKAT']);
            $no++;
            $ip++;
        }
        $ip_last = $ip - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);
        // ----------------------------------------------------------------------------------------------
        //  ---------------------  2.Pengalaman Jabatan /Pekerjaan  -------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, '2.')
                ->setCellValue('B' . $firts, 'Pengalaman Jabatan /Pekerjaan')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'JABATAN/PEKERJAAN')
                ->setCellValue('D' . $pnhead, 'MULAI DAN SAMPAI')
                ->setCellValue('E' . $pnhead, 'GOL.RUANG PENGGAJIAN')
                ->setCellValue('F' . $pnhead, 'GAJI POKOK')
                ->setCellValue('G' . $pnhead, 'SURAT KEPUTUSAN')
                ->setCellValue('G' . $merge, 'PEJABAT')
                ->setCellValue('H' . $merge, 'NOMOR')
                ->setCellValue('I' . $merge, 'TANGGAL');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $pnhead . ':A' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $pnhead . ':D' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pnhead . ':E' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':F' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $pnhead);

        $ip = $merge + 1;
        $no = 1;
        foreach ($data_jabatan as $rowj) {
            $mecah = explode(";;", $rowj['GOLPANGKAT']);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $rowj['N_JABATAN'])
                    ->setCellValue('D' . $ip, $rowj['TMT_JABATAN2'] . ' ' . 'sampai' . ' ' . $rowj['TGL_AKHIR2'])
                    ->setCellValue('E' . $ip, isset($mecah[0]) ? $mecah[0] : '')
                    ->setCellValue('F' . $ip, $rowj['GAPOK'])
                    ->setCellValue('G' . $ip, $rowj['PEJABAT_SK'])
                    ->setCellValue('H' . $ip, $rowj['NO_SK'])
                    ->setCellValue('I' . $ip, $rowj['TGL_SK2']);


            $no++;
            $ip++;
        }
        if (count($data_jabatan) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);
        /* -----------------------------------------------------------------V. TANDA JASA / PENGHARGAAN-------------------------------------------------------------------- */
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'IV')
                ->setCellValue('B' . $firts, 'TANDA JASA / PENGHARGAAN')
                ->setCellValue('A' . $pntitle, 'NO')
                ->setCellValue('B' . $pntitle, 'NAMA BINTANG/SATYA LENCANA PENGHARGAAN')
                ->setCellValue('E' . $pntitle, 'TAHUN PEROLEHAN')
                ->setCellValue('G' . $pntitle, 'NAMA NEGARA / INSTANSI YANG MEMBERI');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitle . ':D' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitle . ':F' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pntitle . ':I' . $pntitle);

        $ip = $pnhead;
        $no = 1;
        foreach ($data_penghargaan as $rowp) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('G' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $rowp['TANDA_JASA'])
                    ->setCellValue('E' . $ip, $rowp['THN_PRLHN'])
                    ->setCellValue('G' . $ip, $rowp['NAMA_NEGARA']);
            $no++;
            $ip++;
        }
        if (count($data_penghargaan) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        //$ip_last=$ip-1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $ip_last)->applyFromArray($styleArray);
        /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

        /* -----------------------------------------------------------------  VI. PENGALAMAN KE LUAR NEGERI ------------------------------------------------------------------------ */
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'V')
                ->setCellValue('B' . $firts, 'PENGALAMAN KE LUAR NEGERI')
                ->setCellValue('A' . $pntitle, 'NO')
                ->setCellValue('B' . $pntitle, 'NEGARA')
                ->setCellValue('D' . $pntitle, 'TUJUAN KUNJUNGAN')
                ->setCellValue('F' . $pntitle, 'LAMANYA')
                ->setCellValue('H' . $pntitle, 'YANG MEMBIAYAI');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitle . ':C' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $pntitle . ':E' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pntitle . ':G' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pntitle . ':I' . $pntitle);

        $ip = $pnhead;
        $no = 1;
        foreach ($data_luar_negeri as $rowl) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('D' . $ip . ':E' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $rowl['NAMA_NEGARA'])
                    ->setCellValue('D' . $ip, $rowl['TUJUAN'])
                    ->setCellValue('F' . $ip, $rowl['WKTU_HARI'] . '.hari' . ' ' . '/' . $rowl['WKTU_BLN'] . '.bulan' . ' ' . '/' . $rowl['WKTU_THN'] . ' .tahun')
                    ->setCellValue('H' . $ip, $rowl['JENIS_PEMBIAYAAN']);

            $no++;
            $ip++;
        }
        if (count($data_luar_negeri) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $ip_last)->applyFromArray($styleArray);
        /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

        /* -----------------------------------------------------------------  VII.  KETERANGAN KELUARGA ------------------------------------------------------------------------ */
        //-------------------------  1. Suami / istri -----------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'VI')
                ->setCellValue('B' . $firts, 'KETERANGAN KELUARGA')
                ->setCellValue('A' . $pntitle, '1.')
                ->setCellValue('B' . $pntitle, 'Istri/Suami')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA')
                ->setCellValue('D' . $pnhead, 'TEMPAT LAHIR')
                ->setCellValue('E' . $pnhead, 'TGL LAHIR')
                ->setCellValue('F' . $pnhead, 'TGL NIKAH')
                ->setCellValue('G' . $pnhead, 'PEKERJAAN')
                ->setCellValue('I' . $pnhead, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':H' . $pnhead);

        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_pasangan as $pasangan) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('G' . $ip . ':H' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $pasangan['NAMA'])
                    ->setCellValue('D' . $ip, $pasangan['TEMPAT_LHR'])
                    ->setCellValue('E' . $ip, $pasangan['TGL_LAHIR2'])
                    ->setCellValue('F' . $ip, $pasangan['TGL_NIKAH2'])
                    ->setCellValue('G' . $ip, $pasangan['PEKERJAAN'])
                    ->setCellValue('I' . $ip, $pasangan['JENIS_PASANGAN'] == '1' ? "Suami" : 'Isteri');
            $no++;
            $ip++;
        }
        if (count($data_pasangan) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //-------------------------  2. Anak ----------------------------------------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '2.')
                ->setCellValue('B' . $pntitle, 'Anak')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA')
                ->setCellValue('D' . $pnhead, 'JENIS KELAMIN')
                ->setCellValue('E' . $pnhead, 'TEMPAT LAHIR')
                ->setCellValue('F' . $pnhead, 'TGL LAHIR')
                ->setCellValue('G' . $pnhead, 'PEKERJAAN')
                ->setCellValue('I' . $pnhead, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':H' . $pnhead);

        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_anak as $ank) {
            $sex = '';
            if ($ank['SEX'] == 'L')
                $sex = 'Laki-laki';
            elseif ($ank['SEX'] == 'P')
                $sex = 'Perempuan';
            else
                $sex = '-';
                                            
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('G' . $ip . ':H' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $ank['NAMA'])
                    ->setCellValue('D' . $ip, $sex)
                    ->setCellValue('E' . $ip, $ank['TEMPAT_LHR'])
                    ->setCellValue('F' . $ip, $ank['TGL_LAHIR2'])
                    ->setCellValue('G' . $ip, $ank['PEKERJAAN'])
                    ->setCellValue('I' . $ip, $ank['KETERANGAN']);
            $no++;
            $ip++;
        }
        if (count($data_anak) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //-------------------------  3. Bapak Dan Ibu Kandung ----------------------------------------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '3.')
                ->setCellValue('B' . $pntitle, 'Bapak Dan Ibu Kandung')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA')
                ->setCellValue('D' . $pnhead, 'TANGGAL LAHIR/UMUR')
                ->setCellValue('F' . $pnhead, 'PEKERJAAN')
                ->setCellValue('H' . $pnhead, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $pnhead . ':E' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);
        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_ortu as $ortu) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('D' . $ip . ':E' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $ortu['NAMA'])
                    ->setCellValue('D' . $ip, $ortu['TGL_LAHIR2'])
                    ->setCellValue('F' . $ip, $ortu['PEKERJAAN'])
                    ->setCellValue('H' . $ip, $ortu['NAMAORTU']);
            $no++;
            $ip++;
        }
        if (count($data_ortu) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //-------------------------  4. Bapak Dan Ibu Mertua ----------------------------------------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '4.')
                ->setCellValue('B' . $pntitle, 'Bapak Dan Ibu Mertua')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA')
                ->setCellValue('D' . $pnhead, 'TANGGAL LAHIR/UMUR')
                ->setCellValue('F' . $pnhead, 'PEKERJAAN')
                ->setCellValue('H' . $pnhead, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $pnhead . ':E' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);
        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_mertua as $mert) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('D' . $ip . ':E' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $mert['NAMA'])
                    ->setCellValue('D' . $ip, $mert['TGL_LAHIR2'])
                    ->setCellValue('F' . $ip, $mert['PEKERJAAN'])
                    ->setCellValue('H' . $ip, $mert['NAMAORTU']);
            $no++;
            $ip++;
        }
        if (count($data_mertua) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //-------------------------  5. Saudara Kandung  ----------------------------------------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '5.')
                ->setCellValue('B' . $pntitle, 'saudara kandung')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA')
                ->setCellValue('D' . $pnhead, 'JENIS KELAMIN')
                ->setCellValue('E' . $pnhead, 'TGL LAHIR')
                ->setCellValue('F' . $pnhead, 'PEKERJAAN')
                ->setCellValue('H' . $pnhead, 'KETERANGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);
        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_saudara as $sdra) {
            $sex = '';
            if ($sdra['SEX'] == 'L')
                $sex = 'Laki-laki';
            elseif ($sdra['SEX'] == 'P')
                $sex = 'Perempuan';
            else
                $sex = '-';
            
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $sdra['NAMA'])
                    ->setCellValue('D' . $ip, $sex)
                    ->setCellValue('E' . $ip, $sdra['TGL_LAHIR2'])
                    ->setCellValue('F' . $ip, $sdra['PEKERJAAN'])
                    ->setCellValue('H' . $ip, $sdra['KETERANGAN']);
            $no++;
            $ip++;
        }
        if (count($data_saudara) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        /* -----------------------------------------------------------------  VIII. KETERANGAN ORGANISASI ------------------------------------------------------------------------ */

        //----------  1. Semasa Mengikuti Pendidikan Pada SLTA Ke Bawah.   -------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'VII.')
                ->setCellValue('B' . $firts, 'KETERANGAN ORGANISASI')
                ->setCellValue('A' . $pntitle, '1.')
                ->setCellValue('B' . $pntitle, 'Semasa Mengikuti Pendidikan Pada SLTA Ke Bawah.')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA ORGANISASI')
                ->setCellValue('D' . $pnhead, 'KEDUDUKAN DALAM ORGANISASI')
                ->setCellValue('E' . $pnhead, 'DALAM TAHUN s/d TAHUN')
                ->setCellValue('F' . $pnhead, 'TEMPAT')
                ->setCellValue('H' . $pnhead, 'NAMA PIMPINAN ORGANISASI');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);

        $ip = $pnhead + 1;
        $no = 1;
        $ip_last = $ip - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //----------  2.  Semasa Mengikuti Pendidikan Pada Perguruan Tinggi.   -------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '2.')
                ->setCellValue('B' . $pntitle, 'Semasa Mengikuti Pendidikan Pada Perguruan Tinggi.')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA ORGANISASI')
                ->setCellValue('D' . $pnhead, 'KEDUDUKAN DALAM ORGANISASI')
                ->setCellValue('E' . $pnhead, 'DALAM TAHUN s/d TAHUN')
                ->setCellValue('F' . $pnhead, 'TEMPAT')
                ->setCellValue('H' . $pnhead, 'NAMA PIMPINAN ORGANISASI');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);

        $ip = $pnhead + 1;
        $no = 1;
        $ip_last = $ip - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        //----------  3.  Sesudah Selesai Pendidikan Dan Atau Selama Menjadi Pegawai.   -------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pntitle, '3.')
                ->setCellValue('B' . $pntitle, 'Semasa Mengikuti Pendidikan Pada Perguruan Tinggi.')
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'NAMA ORGANISASI')
                ->setCellValue('D' . $pnhead, 'KEDUDUKAN DALAM ORGANISASI')
                ->setCellValue('E' . $pnhead, 'DALAM TAHUN s/d TAHUN')
                ->setCellValue('F' . $pnhead, 'TEMPAT')
                ->setCellValue('H' . $pnhead, 'NAMA PIMPINAN ORGANISASI');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':C' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $pnhead . ':G' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pnhead . ':I' . $pnhead);

        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_org_pns as $sklpns) {
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':C' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $sklpns['nama_org'])
                    ->setCellValue('D' . $ip, $sklpns['jabatan_org'])
                    ->setCellValue('E' . $ip, $sklpns['thn_terdaftar'] . ' ' . 's/d' . ' ' . $sklpns['thn_selesai'])
                    ->setCellValue('F' . $ip, $sklpns['tempat_org'])
                    ->setCellValue('H' . $ip, $sklpns['pimpinan_org']);
            $no++;
            $ip++;
        }
        if (count($data_org_pns) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);

        /* -----------------------------------------------------------------  IX. KETERANGAN LAIN-LAIN ------------------------------------------------------------------------ */

        $firts = $ip_last + 2;
        $pntitle = $ip_last + 3;
        $pnhead = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'IX')
                ->setCellValue('B' . $firts, 'KETERANGAN LAIN-LAIN')
                ->setCellValue('A' . $pntitle, 'NO')
                ->setCellValue('B' . $pntitle, 'NAMA KETERANGAN')
                ->setCellValue('E' . $pntitle, 'SURAT KETERANGAN')
                ->setCellValue('E' . $pnhead, 'PEJABAT')
                ->setCellValue('G' . $pnhead, 'NOMOR')
                ->setCellValue('I' . $pntitle, 'TANGGAL');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $pntitle . ':A' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitle . ':H' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pnhead . ':F' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':H' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitle . ':D' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('I' . $pntitle . ':I' . $pnhead);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $ip = $pnhead + 1;
        $no = 1;
        foreach ($data_keterangan as $ketr) {

            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('G' . $ip . ':H' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $merge . ':I' . $merge)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $ketr['KETERANGAN'])
                    ->setCellValue('E' . $ip, $ketr['PEJABAT_SK'])
                    ->setCellValue('G' . $ip, $ketr['NO_SK'])
                    ->setCellValue('I' . $ip, $ketr['TGL_SK2']);

            $no++;
            $ip++;
        }
        $bawah = $ip;
        if (count($data_keterangan) == 0) {
            $ip_last = $ip + 2;
        } else {
            $ip_last = $ip - 1;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('B' . $bawah . ':I' . $bawah);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $bawah)->applyFromArray($styleArray);
        
        
        
        /* -----------------------------------------------------------------  bawah ----------------------------------------------------------------------------------- */

        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $ip_last = $pntitle + 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'Demikian daftar riwayat hidup ini saya buat dengan sesungguhnya dan apabila dikemudian hari terdapat keterangan yang')
                ->setCellValue('A' . $pntitle, 'tidak benar saya bersedia dituntut dimuka pengadilan serta bersedia menerima segala tindakan yang di ambil oleh pemerintah.');
        
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $custom1 = $ip_last + 7;
        $custom2 = $ip_last + 8;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G' . $pntitle, date('d-m-Y'))
                ->setCellValue('G' . $pnhead, 'DIBUAT OLEH,')
                ->setCellValue('G' . $custom2, (!empty($this->session->userdata('nama')) ? $this->session->userdata('nama') : '')." ( ".(!empty($this->session->userdata('nip')) ? $this->session->userdata('nip') : '')." ) ");
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pntitle . ':I' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $custom1);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $custom2 . ':I' . $custom2);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->getStyle('G' . $pntitle . ':I' . $custom2)->applyFromArray($styleArray);
        
        $ip_last = $ip_last + 10;
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $custom = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'PERHATIAN')
                ->setCellValue('A' . $pntitle, '1. Harus di isi sendiri menggunakan huruf kapital/balok dan tinta hitam.')
                ->setCellValue('A' . $pnhead, '2. Jika ada yang salah harus di coret, yang dicoret tetap terbaca kemudian yang benar dituliskan diatas atau sibawahnya dan diparaf.')
                ->setCellValue('A' . $custom, '3. Kolom yang kosong diberi tanda (-) ');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */

        /* --------------------------------------------------------- .footer -------------------------------------------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDaftar Riwayat Hidup');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Printing');

        $ip_last = $ip_last + 10;
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $custom = $ip_last + 4;
        $merge = $ip_last + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'PERHATIAN')
                ->setCellValue('A' . $pntitle, '1. Harus di isi sendiri menggunakan huruf kapital/balok dan tinta hitam.')
                ->setCellValue('A' . $pnhead, '2. Jika ada yang salah harus di coret, yang dicoret tetap terbaca kemudian yang benar dituliskan diatas atau sibawahnya dan diparaf.')
                ->setCellValue('A' . $custom, '3. Kolom yang kosong diberi tanda (-) ');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */

        /* --------------------------------------------------------- .footer -------------------------------------------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDaftar Riwayat Hidup');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Printing');


        // Set active sheet index to the
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        // Save Excel 2007 file
        //echo date('H:i:s') . " Write to Excel2007 format\n";
        // Echo memory peak usage
        //echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_DRH.xls"');
        header('Cache-Control: max-age=0');
        // Echo done
        //echo date('H:i:s') . " Done writing file.\r\n";

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
        // Set active sheet index to the
    }

    public function export_pdf() {
        $nip = (isset($_GET['nip']) && !empty($_GET['nip'])) ? trim($this->input->get('nip', TRUE)) : 0;

        $this->data['pegawai'] = $this->laporan_drh_model->get_data_pegawai($nip);
        $this->data['pegawai_pendidikan'] = $this->laporan_drh_model->get_data_pegawai_pendidikan($this->data['pegawai']['ID']);
        $this->data['pegawai_prajabatan'] = $this->laporan_drh_model->get_data_pegawai_prajabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penjenjangan'] = $this->laporan_drh_model->get_data_pegawai_penjenjangan($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_teknis'] = $this->laporan_drh_model->get_data_pegawai_diklat_teknis($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_fungsional'] = $this->laporan_drh_model->get_data_pegawai_diklat_fungsional($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_lain'] = $this->laporan_drh_model->get_data_pegawai_diklat_lain($this->data['pegawai']['ID']);
        $this->data['pegawai_kursus'] = $this->laporan_drh_model->get_data_pegawai_kursus($this->data['pegawai']['ID']);
        $this->data['pegawai_pangkat'] = $this->laporan_drh_model->get_data_pegawai_pangkat($this->data['pegawai']['ID']);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->data['pegawai_luar_negeri'] = $this->laporan_drh_model->get_data_pegawai_luar_negeri($this->data['pegawai']['ID']);
        $this->data['pegawai_pasangan'] = $this->laporan_drh_model->get_data_pegawai_pasangan($this->data['pegawai']['ID']);
        $this->data['pegawai_anak'] = $this->laporan_drh_model->get_data_pegawai_anak($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_kandung'] = $this->laporan_drh_model->get_data_pegawai_ortu_kandung($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_mertua'] = $this->laporan_drh_model->get_data_pegawai_ortu_mertua($this->data['pegawai']['ID']);
        $this->data['pegawai_saudara'] = $this->laporan_drh_model->get_data_pegawai_saudara($this->data['pegawai']['ID']);
        $this->data['pegawai_organisasi'] = $this->laporan_drh_model->get_data_pegawai_organisasi($this->data['pegawai']['ID']);
        $this->data['pegawai_perguruan'] = $this->laporan_drh_model->get_data_pegawai_perguruan($this->data['pegawai']['ID']);
        $this->data['pegawai_pns'] = $this->laporan_drh_model->get_data_pegawai_pns($this->data['pegawai']['ID']);
        $this->data['pegawai_keterangan'] = $this->laporan_drh_model->get_data_pegawai_keterangan($this->data['pegawai']['ID']);
        $this->data['list_bulan'] = $this->list_model->list_bulan();
        
        $this->load->view("laporan_drh/pdf", $this->data);
    }

}
