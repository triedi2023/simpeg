<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Master_pegawai_penghargaan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_penghargaan_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Penghargaan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/penghargaan/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
            $this->data['list_tanda_jasa'] = $this->list_model->list_tanda_jasa();
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/penghargaan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_tandajasa', 'Jenis Tanda Jasa', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_tandajasa', 'Nama Tanda Jasa', 'required|min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nomor', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[4]|max_length[4]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('instansi', 'Instansi', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRJENISTANDAJASA_ID" => trim($this->input->post('jenis_tandajasa',TRUE)),
                "TRTANDAJASA_ID" => trim($this->input->post('nama_tandajasa',TRUE)),
                "NOMOR" => ltrim(rtrim($this->input->post('nomor',TRUE))),
                "THN_PRLHN" => trim($this->input->post('tahun',TRUE)),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                'TMPEGAWAI_ID' => $id,
                "INSTANSI" => ltrim(rtrim($this->input->post('instansi',TRUE))),
            ];
            $tanggal = [
                "TGL_PENGHARGAAN" => datepickertodb(trim($this->input->post('tanggal',TRUE))),
            ];
            
            if (($insert = $this->master_pegawai_penghargaan_model->insert($post,$tanggal)) == true) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_penghargaan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_SERTIFIKAT' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SERTIFIKAT' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_penghargaan_model->update($dokumen,[],$insert_id);
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
            $this->data['model'] = $this->master_pegawai_penghargaan_model->get_by_id($this->input->get('id'));
            $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
            if ($this->data['model']['TRJENISTANDAJASA_ID'] != "") {
                $this->data['list_tanda_jasa'] = $this->list_model->list_tanda_jasa($this->data['model']['TRJENISTANDAJASA_ID']);
            }
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/penghargaan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_tandajasa', 'Jenis Tanda Jasa', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_tandajasa', 'Nama Tanda Jasa', 'required|min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nomor', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[4]|max_length[4]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('instansi', 'Instansi', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            $post = [
                "TRJENISTANDAJASA_ID" => trim($this->input->post('jenis_tandajasa',TRUE)),
                "TRTANDAJASA_ID" => trim($this->input->post('nama_tandajasa',TRUE)),
                "NOMOR" => ltrim(rtrim($this->input->post('nomor',TRUE))),
                "THN_PRLHN" => trim($this->input->post('tahun',TRUE)),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "INSTANSI" => ltrim(rtrim($this->input->post('instansi',TRUE))),
            ];
            $tanggal = [
                "TGL_PENGHARGAAN" => datepickertodb(trim($this->input->post('tanggal',TRUE))),
            ];
            
            $model = $this->master_pegawai_penghargaan_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_penghargaan_model->update($post,$tanggal,$this->input->get('id'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_penghargaan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_SERTIFIKAT']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT']);
                            }
                            $dokumen = ['DOC_SERTIFIKAT' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SERTIFIKAT' => NULL];
                    }
                    unset($config);
                    $this->master_pegawai_penghargaan_model->update($dokumen,[],$insert_id);
                }
                
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
        $list = $this->master_pegawai_penghargaan_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SERTIFIKAT) && $val->DOC_SERTIFIKAT != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_penghargaan/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_penghargaan/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JENIS_TANDA_JASA;
            $row[] = $val->TANDA_JASA;
            $row[] = $val->THN_PRLHN;
            $row[] = $val->NAMA_NEGARA;
            $row[] = $val->INSTANSI;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_penghargaan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_penghargaan/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_penghargaan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_penghargaan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_penghargaan_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_penghargaan_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_SERTIFIKAT']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT']);
                    }
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_penghargaan_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_penghargaan_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SERTIFIKAT'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SERTIFIKAT'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_penghargaan_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/penghargaan/info', $this->data);
    }
    
    public function import_penghargaan_pegawai() {
        $this->data['title_utama'] = "Penghargaan Pegawai";
        $this->data['title_form'] = "Penghargaan Pegawai";
        $this->data['content'] = 'master_pegawai/penghargaan/import_penghargaan_pegawai';

        if ($this->input->method() === "post") {
            try {
                $inputFileType = PHPExcel_IOFactory::identify($_FILES['file_excel']['tmp_name']);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($_FILES['file_excel']['tmp_name']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            $totaldata = 0;
            $sukses = 0;
            $gagal = 0;
            $tampung = [];
            for ($row = 3; $row <= $highestRow; ++$row) {
                $getpegawai = $this->master_pegawai_model->get_by_nipnew_select(trim($objWorksheet->getCellByColumnAndRow(0, $row)), "ID");
                
                if (!empty($getpegawai['ID'])) {
                    $post = [
                        "TRJENISTANDAJASA_ID" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(1, $row))),
                        "TRTANDAJASA_ID" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(2, $row))),
                        "NOMOR" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(3, $row))),
                        "THN_PRLHN" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(4, $row))),
                        "TRNEGARA_ID" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(6, $row))),
                        'TMPEGAWAI_ID' => $getpegawai['ID'],
                        "INSTANSI" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(7, $row))),
                    ];
                    $pecah = explode('-', trim(str_replace(" ", "",$objWorksheet->getCellByColumnAndRow(5, $row))));
                    $tanggal = [
                        "TGL_PENGHARGAAN" => $pecah[2]."-".$pecah[1]."-".$pecah[0],
                    ];
                    if ($this->master_pegawai_penghargaan_model->get_exist($getpegawai['ID'],ltrim(rtrim($getgolpangkat['ID'])),ltrim(rtrim($objWorksheet->getCellByColumnAndRow(1, $row))),ltrim(rtrim($objWorksheet->getCellByColumnAndRow(2, $row))),($pecah[2]."-".$pecah[1]."-".$pecah[0])) < 1) {
                        if ($this->master_pegawai_penghargaan_model->insert($post, $tanggal)) {
                            $sukses++;
                        } else {
                            $tampung[] = trim($objWorksheet->getCellByColumnAndRow(0, $row));
                            $gagal++;
                        }
                    } else {
                        $tampung[] = trim($objWorksheet->getCellByColumnAndRow(0, $row));
                        $gagal++;
                    }
                }
                $totaldata++;
            }

            $jmlnipgagal = count($tampung) > 0 ? (implode(", ", $tampung)) : 0;
            
            $html = '<div class="note note-info">
                <h4 class="block">Total Data '.$totaldata.'</h4>
                <h4 class="block bold font-yellow-haze">Sukses!</h4>
                <p class="font-yellow-haze"> Jumlah data berhasil ter-import = '.$sukses.'. </p>
                <h4 class="block font-red-sunglo bold">Gagal!</h4>
                <p class="font-red-sunglo"> Jumlah data Gagal ter-import = '.$gagal.'. </p>
                <p class="font-red-sunglo"> NIP Gagal ter-import = '.$jmlnipgagal.'. </p>
            </div>';
            
            $this->session->set_flashdata('pesan',$html);
            redirect('/master_pegawai/master_pegawai_penghargaan/import_penghargaan_pegawai');
        }

        $this->load->view('layouts/main', $this->data);
    }
    
    public function format_excel_penghargaan() {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Kepegawaian")
                ->setLastModifiedBy("Kepegawaian")
                ->setTitle($this->config->item('instansi_panjang'))
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription($this->data['title_utama'])
                ->setKeywords($this->data['title_utama'])
                ->setCategory($this->data['title_utama']);

        $styleHeader = array(
            'font' => array(
                'bold' => TRUE,
                'size' => 12
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'getStartColor' => array(
                    'argb' => '000000'
                )
            ),
        );

        $styleHeaderTable = array(
            'font' => array(
                'bold' => TRUE,
                'size' => 12
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

        $styleMerah = array(
            'font' => array(
                'bold' => TRUE,
                'size' => 12,
                'color' => array('rgb' => 'F20505'),
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NIP Baru');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Kode Jenis Tanda Jasa');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Kode Nama Tanda Jasa');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Nomor');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Tahun');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Tanggal');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Kode Negara');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Instansi');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', '1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', '2019');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', '30 - 08 - 2019');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '<-- Contoh');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', '<-- Mulai di-sini');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->setTitle("Import Penghargaan");

        $list_jenis_tj = $this->list_model->list_jenis_tanda_jasa();
        $list_tj = $this->list_model->list_tanda_jasa_all();
        $list_negara = $this->list_model->list_negara();

        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'Referensi Jenis Tanda Jasa');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Referensi Nama Tanda Jasa');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D2', 'Kode Jenis Tanda Jasa');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E2', 'Kode Nama Tanda Jasa');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F2', 'Nama Tanda Jasa');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getStyle('D1:F1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('D2:F2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('D1:F1');
        $objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Referensi Negara');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getStyle('H1:I1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('H2:I2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('H1:I1');
        $objPHPExcel->getActiveSheet()->getStyle('H2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $row = 3;
        foreach ($list_jenis_tj as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $row, $rowj['ID'])->setCellValue('B' . $row, $rowj['NAMA']);
            $row++;
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HIMPORT PANGKAT GOLONGAN PEGAWAI ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet(1)->setTitle("Referensi Penghargaan");
        $row = 3;
        foreach ($list_tj as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $row, $rowj['TRJENISTANDAJASA_ID'])->setCellValue('E' . $row, $rowj['ID'])->setCellValue('F' . $row, $rowj['NAMA']);
            $row++;
        }
        
        $row = 3;
        foreach ($list_negara as $rowh) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $row, $rowh['ID'])->setCellValue('I' . $row, $rowh['NAMA']);
            $row++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="IMPORT PENGHARGAAN PEGAWAI ' . date('d-m-Y') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
