<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "vendor/autoload.php";

class Master_pegawai_cuti extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_cuti_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Cuti Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $this->load->view('master_pegawai/cuti/index', $this->data);
    }
    
    function jmlharicuti() {
        $helpertglbekerja = $this->rangeTglBekerja($_POST['tglawal'], $_POST['tglakhir'], $_POST['jeniscuti']);
        
        $tglawal = explode("/", $_POST['tglawal']);
        $tglakhir = explode("/", $_POST['tglakhir']);
        $tglawalcreate = $tglawal[2] . "-" . $tglawal[1] . "-" . $tglawal[0];
        $tglakhircreate =$tglakhir[2] . "-" . $tglakhir[1] . "-" . $tglakhir[0];
        $cektgllarangancuti = $this->master_pegawai_cuti_model->cekHariLaranganCuti($tglawalcreate,$tglakhircreate);
        
        echo json_encode(array('jmlhari' => $helpertglbekerja,'larangancuti'=>$cektgllarangancuti>0?true:false));
    }

    // format tanggal => 2004-10-27
    function rangeTglBekerja($tglawal, $tglakhir, $jeniscuti) {
        $tglawal = explode("/", $tglawal);
        $tglakhir = explode("/", $tglakhir);
        $tglawalcreate = date_create($tglawal[2] . "-" . $tglawal[1] . "-" . $tglawal[0]);
        $tglakhircreate = date_create($tglakhir[2] . "-" . $tglakhir[1] . "-" . $tglakhir[0]);
        $kurang = date_diff($tglawalcreate, $tglakhircreate, TRUE);
        $kurang = $kurang->format('%a');
        $kurang = $kurang + 1;

        // cari weekend
        $jmlkurangweekend = 0;
        for ($i = 0; $i < $kurang; $i++) {
            $tglweekend = date('w', mktime(0, 0, 0, $tglawal[1], $tglawal[0] + $i, $tglawal[2]));
            if ($tglweekend == 0 || $tglweekend == 6) {
                $jmlkurangweekend++;
            }
        }

        // cari di table tanggal libur
        $jmlliburtabel = 0;
        for ($i = 0; $i < $kurang; $i++) {
            $tglacuan = date('Y-m-d', mktime(0, 0, 0, $tglawal[1], $tglawal[0] + $i, $tglawal[2]));
            $jmlharilibur = $this->master_pegawai_cuti_model->cekHariLibur($tglacuan);
            if ($jmlharilibur > 0) {
                $jmlliburtabel++;
            }
        }

        if (in_array($jeniscuti, array('01', '03'))) {
            $jmltotal = (int) $kurang;
        } else {
            $jmltotal = (int) $kurang - ((int) $jmlkurangweekend + (int) $jmlliburtabel);
        }

        return $jmltotal;
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_cuti'] = $this->list_model->list_cuti();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/cuti/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_cuti', 'Jenis Cuti', 'required|min_length[1]|max_length[2]|trim');
        $this->form_validation->set_rules('tgl_mulai_cuti', 'Tgl Mulai Cuti', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_selesai_cuti', 'Tgl Selesai Cuti', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_pengajuan', 'Tgl Pengajuan Cuti', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('lama_cuti', 'Lama Cuti', 'min_length[1]|max_length[4]|trim|is_natural');
        $this->form_validation->set_rules('nip_atasan', 'NIP Atasan Langsung', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('nama_atasan', 'Nama Atasan Langsung', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('jabatan_atasan', 'Jabatan Atasan Langsung', 'min_length[1]|max_length[1000]');
        $this->form_validation->set_rules('nip_penilai_atasan', 'NIP Penilai Atasan', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('nama_atasan', 'Nama Penilai Atasan', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('jabatan_atasan', 'Jabatan Penilai Atasan', 'min_length[1]|max_length[1000]');
        $this->form_validation->set_rules('kota', 'Kota', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('alamat_cuti', 'Alamat Cuti', 'min_length[1]|max_length[500]');
        $this->form_validation->set_rules('keperluan_cuti', 'Keperluan Cuti', 'min_length[1]|max_length[500]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[60]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[4]|max_length[4]|trim|is_natural_no_zero');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRCUTI_ID" => trim($this->input->post('jenis_cuti',TRUE)),
                "LAMA" => trim($this->input->post('lama_cuti',TRUE)),
                "NIP_ATASAN" => ltrim(rtrim($this->input->post('nip_atasan',TRUE))),
                "NAMA_ATASAN" => ltrim(rtrim($this->input->post('nama_atasan',TRUE))),
                "JABATAN_ATASAN" => ltrim(rtrim($this->input->post('jabatan_atasan',TRUE))),
                "GOL_PANGKAT_ATASAN" => ltrim(rtrim($this->input->post('golpangkat_atasan',TRUE))),
                "TRGOLONGANID_ATASAN" => ltrim(rtrim($this->input->post('idgolpangkat_atasan',TRUE))),
                "TRESELONID_ATASAN" => ltrim(rtrim($this->input->post('eselon_atasan',TRUE))),
                "TRJABATANID_ATASAN" => trim($this->input->post('id_jabatan_atasan',TRUE)),
                "TRLOKASIID_ATASAN" => trim($this->input->post('trlokasiid_atasan',TRUE)),
                "KDU1_ATASAN" => trim($this->input->post('kdu1_atasan',TRUE)),
                "KDU2_ATASAN" => trim($this->input->post('kdu2_atasan',TRUE)),
                "KDU3_ATASAN" => trim($this->input->post('kdu3_atasan',TRUE)),
                "KDU4_ATASAN" => trim($this->input->post('kdu4_atasan',TRUE)),
                "KDU5_ATASAN" => trim($this->input->post('kdu5_atasan',TRUE)),
                "NIP_PEJABAT" => ltrim(rtrim($this->input->post('nip_penilai_atasan',TRUE))),
                "NAMA_PEJABAT" => ltrim(rtrim($this->input->post('nama_penilai_atasan',TRUE))),
                "JABATAN_PEJABAT" => ltrim(rtrim($this->input->post('jabatan_penilai_atasan',TRUE))),
                "GOL_PANGKAT_PEJABAT" => ltrim(rtrim($this->input->post('golpangkat_penilai_atasan',TRUE))),
                "TRGOLONGANID_PEJABAT" => ltrim(rtrim($this->input->post('idgolpangkat_penilai_atasan',TRUE))),
                "TRESELONID_PEJABAT" => ltrim(rtrim($this->input->post('eselon_penilai_atasan',TRUE))),
                "TRJABATANID_PEJABAT" => trim($this->input->post('id_jabatan_penilai_atasan',TRUE)),
                "TRLOKASIID_PEJABAT" => trim($this->input->post('trlokasiid_penilai_atasan',TRUE)),
                "KDU1_PEJABAT" => trim($this->input->post('kdu1_penilai_atasan',TRUE)),
                "KDU2_PEJABAT" => trim($this->input->post('kdu2_penilai_atasan',TRUE)),
                "KDU3_PEJABAT" => trim($this->input->post('kdu3_penilai_atasan',TRUE)),
                "KDU4_PEJABAT" => trim($this->input->post('kdu4_penilai_atasan',TRUE)),
                "KDU5_PEJABAT" => trim($this->input->post('kdu5_penilai_atasan',TRUE)),
                "KOTA" => ltrim(rtrim($this->input->post('kota',TRUE))),
                "ALAMAT_CUTI" => ltrim(rtrim($this->input->post('alamat_cuti',TRUE))),
                "KEPERLUAN" => ltrim(rtrim($this->input->post('keperluan_cuti',TRUE))),
                "SK_PERSETUJUAN" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "TAHUN" => ltrim(rtrim($this->input->post('tahun',TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_MULAI" => datepickertodb(trim($this->input->post('tgl_mulai_cuti',TRUE))),
                "TGL_AKHIR" => datepickertodb(trim($this->input->post('tgl_selesai_cuti',TRUE))),
                "TGL_PENGAJUAN" => datepickertodb(trim($this->input->post('tgl_pengajuan',TRUE))),
                "TGL_PERSETUJUAN" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            
            if (($insert = $this->master_pegawai_cuti_model->insert($post,$tanggal)) == true) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_cuti_model->get_by_id($this->input->get('id'));
            $this->data['list_cuti'] = $this->list_model->list_cuti();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/cuti/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_cuti', 'Jenis Cuti', 'required|min_length[1]|max_length[2]|trim');
        $this->form_validation->set_rules('tgl_mulai_cuti', 'Tgl Mulai Cuti', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_selesai_cuti', 'Tgl Selesai Cuti', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_pengajuan', 'Tgl Pengajuan Cuti', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('lama_cuti', 'Lama Cuti', 'min_length[1]|max_length[4]|trim|is_natural');
        $this->form_validation->set_rules('nip_atasan', 'NIP Atasan Langsung', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('nama_atasan', 'Nama Atasan Langsung', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('jabatan_atasan', 'Jabatan Atasan Langsung', 'min_length[1]|max_length[1000]');
        $this->form_validation->set_rules('nip_penilai_atasan', 'NIP Penilai Atasan', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('nama_atasan', 'Nama Penilai Atasan', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('jabatan_atasan', 'Jabatan Penilai Atasan', 'min_length[1]|max_length[1000]');
        $this->form_validation->set_rules('kota', 'Kota', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('alamat_cuti', 'Alamat Cuti', 'min_length[1]|max_length[500]');
        $this->form_validation->set_rules('keperluan_cuti', 'Keperluan Cuti', 'min_length[1]|max_length[500]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[60]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[4]|max_length[4]|trim|is_natural_no_zero');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            $post = [
                "TRCUTI_ID" => trim($this->input->post('jenis_cuti',TRUE)),
                "LAMA" => trim($this->input->post('lama_cuti',TRUE)),
                "NIP_ATASAN" => ltrim(rtrim($this->input->post('nip_atasan',TRUE))),
                "NAMA_ATASAN" => ltrim(rtrim($this->input->post('nama_atasan',TRUE))),
                "JABATAN_ATASAN" => ltrim(rtrim($this->input->post('jabatan_atasan',TRUE))),
                "GOL_PANGKAT_ATASAN" => ltrim(rtrim($this->input->post('golpangkat_atasan',TRUE))),
                "TRGOLONGANID_ATASAN" => ltrim(rtrim($this->input->post('idgolpangkat_atasan',TRUE))),
                "TRESELONID_ATASAN" => ltrim(rtrim($this->input->post('eselon_atasan',TRUE))),
                "TRJABATANID_ATASAN" => trim($this->input->post('id_jabatan_atasan',TRUE)),
                "TRLOKASIID_ATASAN" => trim($this->input->post('trlokasiid_atasan',TRUE)),
                "KDU1_ATASAN" => trim($this->input->post('kdu1_atasan',TRUE)),
                "KDU2_ATASAN" => trim($this->input->post('kdu2_atasan',TRUE)),
                "KDU3_ATASAN" => trim($this->input->post('kdu3_atasan',TRUE)),
                "KDU4_ATASAN" => trim($this->input->post('kdu4_atasan',TRUE)),
                "KDU5_ATASAN" => trim($this->input->post('kdu5_atasan',TRUE)),
                "NIP_PEJABAT" => ltrim(rtrim($this->input->post('nip_penilai_atasan',TRUE))),
                "NAMA_PEJABAT" => ltrim(rtrim($this->input->post('nama_penilai_atasan',TRUE))),
                "JABATAN_PEJABAT" => ltrim(rtrim($this->input->post('jabatan_penilai_atasan',TRUE))),
                "GOL_PANGKAT_PEJABAT" => ltrim(rtrim($this->input->post('golpangkat_penilai_atasan',TRUE))),
                "TRGOLONGANID_PEJABAT" => ltrim(rtrim($this->input->post('idgolpangkat_penilai_atasan',TRUE))),
                "TRESELONID_PEJABAT" => ltrim(rtrim($this->input->post('eselon_penilai_atasan',TRUE))),
                "TRJABATANID_PEJABAT" => trim($this->input->post('id_jabatan_penilai_atasan',TRUE)),
                "TRLOKASIID_PEJABAT" => trim($this->input->post('trlokasiid_penilai_atasan',TRUE)),
                "KDU1_PEJABAT" => trim($this->input->post('kdu1_penilai_atasan',TRUE)),
                "KDU2_PEJABAT" => trim($this->input->post('kdu2_penilai_atasan',TRUE)),
                "KDU3_PEJABAT" => trim($this->input->post('kdu3_penilai_atasan',TRUE)),
                "KDU4_PEJABAT" => trim($this->input->post('kdu4_penilai_atasan',TRUE)),
                "KDU5_PEJABAT" => trim($this->input->post('kdu5_penilai_atasan',TRUE)),
                "KOTA" => ltrim(rtrim($this->input->post('kota',TRUE))),
                "ALAMAT_CUTI" => ltrim(rtrim($this->input->post('alamat_cuti',TRUE))),
                "KEPERLUAN" => ltrim(rtrim($this->input->post('keperluan_cuti',TRUE))),
                "SK_PERSETUJUAN" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "TAHUN" => ltrim(rtrim($this->input->post('tahun',TRUE))),
            ];
            $tanggal = [
                "TGL_MULAI" => datepickertodb(trim($this->input->post('tgl_mulai_cuti',TRUE))),
                "TGL_AKHIR" => datepickertodb(trim($this->input->post('tgl_selesai_cuti',TRUE))),
                "TGL_PENGAJUAN" => datepickertodb(trim($this->input->post('tgl_pengajuan',TRUE))),
                "TGL_PERSETUJUAN" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            
            if ($this->master_pegawai_cuti_model->update($post,$tanggal,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        if (empty($_GET['id'])) {
            redirect('/master_pegawai');
        }
        $id = $this->input->get('id');
        $list = $this->master_pegawai_cuti_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_CUTI;
            $row[] = $val->PERIODE;
            $row[] = $val->LAMA;
            $row[] = '<a target="_blank" href="'.site_url('master_pegawai/master_pegawai_cuti/cetak_form_cuti?id='.$val->ID).'" class="btn btn-xs green-haze" title="Cetak Dokumen Cuti"><i class="fa fa-file-pdf-o"></i></a><a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_cuti/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_cuti/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_cuti/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_cuti_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_cuti_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function cetak_form_cuti() {
        $model = $this->master_pegawai_cuti_model->get_pegawai_by_id($this->input->get('id'));
        $this->load->helper('download');
        if ($model) {
            $namapegawai = (!empty($model['GELAR_DEPAN'])) ? $model['GELAR_DEPAN'] . " " : "";
            $namapegawai .= $model['NAMA'];
            $namapegawai .= (!empty($model['GELAR_BLKG'])) ? ", " . $model['GELAR_BLKG'] : "";
            
            $jabatan_mutakhir = $this->master_pegawai_model->jabatan_mutakhir($model['TMPEGAWAI_ID']);
            $jabatan_pegawai = (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['JABATAN'])) ? $jabatan_mutakhir['JABATAN'] : '-';
            $unitkerja_pegawai = (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['NMUNIT'])) ? $jabatan_mutakhir['NMUNIT'] : '-';
            
            $pangkat_mutakhir = $this->master_pegawai_model->pangkat_mutakhir($model['TMPEGAWAI_ID']);
            $pangkatgol = (isset($pangkat_mutakhir) && !empty($pangkat_mutakhir['PANGKAT'])) ? ($model['TRSTATUSKEPEGAWAIAN_ID'] == 1 ? $pangkat_mutakhir['PANGKAT'] . " (" . $pangkat_mutakhir['GOLONGAN'] . ")" : $pangkat_mutakhir['PANGKAT']) : '-';
            
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("./_uploads/template_word/FormCuti.docx");
            $templateProcessor->setValue('tempatpengajuancuti', $model['KOTA']);
            $templateProcessor->setValue('tglpengajuancuti', $model['TGL_PENGAJUAN2']);
            $templateProcessor->setValue('namapegawai', $namapegawai);
            $templateProcessor->setValue('nippegawai', $model["NIPNEW"]);
            $templateProcessor->setValue('pangkatgol', $pangkatgol);
            $templateProcessor->setValue('jabatanpegawai', $jabatan_pegawai);
            $templateProcessor->setValue('unitkerjapegawai', $unitkerja_pegawai);
            $templateProcessor->setValue('alasancuti', $model['ALAMAT_CUTI']);
            $templateProcessor->setValue('haricuti', $model['LAMA']);
            $templateProcessor->setValue('textharicuti', terbilang($model['LAMA']));
            $templateProcessor->setValue('mulaicuti', $model['TGL_MULAI2']);
            $templateProcessor->setValue('selesaicuti', $model['TGL_AKHIR2']);
            $templateProcessor->setValue('alamatcuti', $model['ALAMAT_CUTI']);
            $templateProcessor->setValue('tlppegawai', $model['TELP_HP']);
            $templateProcessor->setValue('unoratasancuti', $model['JABATAN_ATASAN']);
            $templateProcessor->setValue('namaatasancuti', $model['NAMA_ATASAN']);
            $templateProcessor->setValue('nipatasancuti', $model['NIP_ATASAN']);
            $templateProcessor->setValue('unotpejabat', $model['JABATAN_PEJABAT']);
            $templateProcessor->setValue('namapejabat', $model['NAMA_PEJABAT']);
            $templateProcessor->setValue('nippejabat', $model['NIP_PEJABAT']);
            
            for ($j=0;$j<=6;$j++) {
                if ($model['TRCUTI_ID'] == "0".$j)
                    $templateProcessor->setImageValue('cuti0'.$j,  array('path' => './assets/img/check.png', 'width' => 9, 'height' => 9, 'ratio' => false));
                else
                    $templateProcessor->setValue('cuti0'.$j, '');
            }
            
            $filename = 'Berkas Cuti Pegawai '.$model["NIPNEW"]." - ".str_replace("/","-",$model['TGL_PENGAJUAN2']).'.docx'; //save our document as this file name
            $pathToSave = './_uploads/tmp_template_word/'.$filename;
            
            if(file_exists($pathToSave)){
                unlink($pathToSave);
            }
            $templateProcessor->saveAs($pathToSave);
            
            force_download($pathToSave,NULL);
            
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_cuti_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_cuti_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_cuti_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/cuti/info', $this->data);
    }

}
