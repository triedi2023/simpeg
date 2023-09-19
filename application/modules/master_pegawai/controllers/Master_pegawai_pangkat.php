<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Master_pegawai_pangkat extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_pangkat_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Golongan Pangkat Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIPNEW");
        $this->load->view('master_pegawai/pangkat/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "TRSTATUSKEPEGAWAIAN_ID");
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat($data_pegawai['TRSTATUSKEPEGAWAIAN_ID']);
            $this->data['list_jenis_kenaikan_pangkat'] = $this->list_model->list_jenis_kenaikan_pangkat();
            $this->data['id'] = $id;

            $this->load->view("master_pegawai/pangkat/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('golpangkat', 'Status Pasangan', 'required|min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('jeniskenaikanpangkat', 'Jenis Pangkat', 'required|min_length[1]|max_length[2]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('peraturan', 'Peraturan Yang Dijadikan Dasar', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('mk_thn', 'MK Tambahan Tahun', 'min_length[1]|max_length[2]');
        $this->form_validation->set_rules('mk_bln', 'MK Tambahan Bulan', 'min_length[1]|max_length[2]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TRGOLONGAN_ID" => ltrim(rtrim($this->input->post('golpangkat', TRUE))),
                "TRJENISKENAIKANPANGKAT_ID" => ltrim(rtrim($this->input->post('jeniskenaikanpangkat', TRUE))),
                "DASAR_PANGKAT" => ltrim(rtrim($this->input->post('peraturan', TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "THN_GOL" => ltrim(rtrim($this->input->post('mk_thn', TRUE))),
                "BLN_GOL" => ltrim(rtrim($this->input->post('mk_bln', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat', TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TMT_GOL" => datepickertodb(trim($this->input->post('tmt_golongan', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
            ];
            if ($insert = $this->master_pegawai_pangkat_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW,TRSTATUSKEPEGAWAIAN_ID");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_pangkat_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name']))
                            $dokumen = ['DOC_SKPANGKAT' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SKPANGKAT' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_pangkat_model->update($dokumen, [], $insert_id);
                $latest = $this->master_pegawai_pangkat_model->pangkat_mutakhir($id);
                if ($latest['TRSTATUSKEPEGAWAIAN_ID'] == "") {
                    $pangkatterahir = "-;-";
                } elseif ($latest['TRSTATUSKEPEGAWAIAN_ID'] == 1) {
                    $pangkatterahir = $latest['PANGKAT'] . ";" . $latest['GOLONGAN'];
                } else {
                    $pangkatterahir = $latest['PANGKAT'] . ";-";
                }
                
                $htmllog = "Golongan / Pangkat = ".$this->list_model->list_golongan_pangkat($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'],trim($this->input->post('golpangkat', TRUE)))[0]['NAMA']
                .";TMT Golongan = ".trim($this->input->post('tmt_golongan', TRUE)).";Jenis Pangkat = ".$this->list_model->list_jenis_kenaikan_pangkat(ltrim(rtrim($this->input->post('jeniskenaikanpangkat', TRUE))))[0]['NAMA']
                .";MK Tambahan Tahun = ".ltrim(rtrim($this->input->post('mk_thn', TRUE)))." Bulan = ".ltrim(rtrim($this->input->post('mk_bln', TRUE)));
                $this->Log_model->insert_log("Menambah", "Data Pangkat Pegawai Dengan NIP " . ($data_pegawai['NIPNEW']) . ";".$htmllog);
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.', 'data' => $pangkatterahir]);
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
            $this->data['id'] = $id;
            $this->data['model'] = $this->master_pegawai_pangkat_model->get_by_id($id);
            $this->data['title_form'] = "Ubah";
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->data['model']['TMPEGAWAI_ID'], "TRSTATUSKEPEGAWAIAN_ID");
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat($data_pegawai['TRSTATUSKEPEGAWAIAN_ID']);
            $this->data['list_jenis_kenaikan_pangkat'] = $this->list_model->list_jenis_kenaikan_pangkat();
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/pangkat/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('golpangkat', 'Status Pasangan', 'required|min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('jeniskenaikanpangkat', 'Jenis Pangkat', 'required|min_length[1]|max_length[2]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('peraturan', 'Peraturan Yang Dijadikan Dasar', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('mk_thn', 'MK Tambahan Tahun', 'min_length[1]|max_length[2]');
        $this->form_validation->set_rules('mk_bln', 'MK Tambahan Bulan', 'min_length[1]|max_length[2]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            if (!isset($_GET['kode']) || empty($_GET['kode'])) {
                redirect('/master_pegawai');
            }

            $post = [
                "TRGOLONGAN_ID" => ltrim(rtrim($this->input->post('golpangkat', TRUE))),
                "TRJENISKENAIKANPANGKAT_ID" => ltrim(rtrim($this->input->post('jeniskenaikanpangkat', TRUE))),
                "DASAR_PANGKAT" => ltrim(rtrim($this->input->post('peraturan', TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "THN_GOL" => ltrim(rtrim($this->input->post('mk_thn', TRUE))),
                "BLN_GOL" => ltrim(rtrim($this->input->post('mk_bln', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat', TRUE))),
            ];
            $tanggal = [
                "TMT_GOL" => datepickertodb(trim($this->input->post('tmt_golongan', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
            ];
            $model = $this->master_pegawai_pangkat_model->get_by_id($this->input->get('kode'));

            if ($this->master_pegawai_pangkat_model->update($post, $tanggal, $this->input->get('kode'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP,NIPNEW,TRSTATUSKEPEGAWAIAN_ID");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_pangkat_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                            if (!empty($model['DOC_SKPANGKAT']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKPANGKAT'])) {
                                unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKPANGKAT']);
                            }
                            $dokumen = ['DOC_SKPANGKAT' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SKPANGKAT' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_pangkat_model->update($dokumen, [], $insert_id);
                $latest = $this->master_pegawai_pangkat_model->pangkat_mutakhir($this->input->get('id'));
                if ($latest['TRSTATUSKEPEGAWAIAN_ID'] == "") {
                    $pangkatterahir = "-;-";
                } elseif ($latest['TRSTATUSKEPEGAWAIAN_ID'] == 1) {
                    $pangkatterahir = $latest['PANGKAT'] . ";" . $latest['GOLONGAN'];
                } else {
                    $pangkatterahir = $latest['PANGKAT'] . ";-";
                }

                $htmllog = "Golongan / Pangkat = ".$this->list_model->list_golongan_pangkat($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'],$model['TRGOLONGAN_ID'])[0]['NAMA']." => ".$this->list_model->list_golongan_pangkat($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'],trim($this->input->post('golpangkat', TRUE)))[0]['NAMA']
                .";TMT Golongan = ".$model['TMT_GOL2']." => ".trim($this->input->post('tmt_golongan', TRUE)).";Jenis Pangkat = ".$this->list_model->list_jenis_kenaikan_pangkat(ltrim(rtrim($this->input->post('jeniskenaikanpangkat', TRUE))))[0]['NAMA']." => ".$this->list_model->list_jenis_kenaikan_pangkat(ltrim(rtrim($this->input->post('jeniskenaikanpangkat', TRUE))))[0]['NAMA']
                .";MK Tambahan Tahun = ".$model['THN_GOL']." => ".ltrim(rtrim($this->input->post('mk_thn', TRUE)))." Bulan = ".$model['BLN_GOL']." => ".ltrim(rtrim($this->input->post('mk_bln', TRUE)));
                $this->Log_model->insert_log("Mengubah", "Data Pangkat Pegawai Dengan NIP " . ($data_pegawai['NIPNEW']) . ";".$htmllog);
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.', 'data' => $pangkatterahir]);
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
        $list = $this->master_pegawai_pangkat_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SKPANGKAT) && $val->DOC_SKPANGKAT != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="' . site_url('master_pegawai/master_pegawai_pangkat/view_dokumen?id=' . $val->ID) . '" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="' . site_url('master_pegawai/master_pegawai_pangkat/hapus_data') . '" data-id="' . $val->ID . '" data-identify="updatepangkatpegawai" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == '1') ? $val->PANGKAT . " (" . $val->GOLONGAN . ") " : $val->PANGKAT;
            $row[] = $val->TMT_GOL2;
            $row[] = $val->JENIS_KENAIKAN_PANGKAT;
            $row[] = ($val->THN_GOL == "" ? 0 : $val->THN_GOL) . " Tahun " . ($val->BLN_GOL == "" ? 0 : $val->BLN_GOL) . " Bulan";
            $row[] = $file . '<a href="javascript:;" data-url="' . site_url('master_pegawai/master_pegawai_pangkat/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="' . ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data') . '"><i class="fa fa-edit"></i></a>' . $delete . '<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="' . site_url('master_pegawai/master_pegawai_pangkat/view_info?id=' . $val->ID) . '" data-id="' . $val->ID . '" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_pangkat_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_pangkat_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_pangkat_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'], "NIP,NIPNEW");
                if ($this->master_pegawai_pangkat_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_AKTENIKAH']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_AKTENIKAH'])) {
                        unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_AKTENIKAH']);
                    }

                    $latest = $this->master_pegawai_pangkat_model->pangkat_mutakhir($model['TMPEGAWAI_ID']);
                    if ($latest['TRSTATUSKEPEGAWAIAN_ID'] == "") {
                        $pangkatterahir = "-;-";
                    } elseif ($latest['TRSTATUSKEPEGAWAIAN_ID'] == 1) {
                        $pangkatterahir = $latest['PANGKAT'] . ";" . $latest['GOLONGAN'];
                    } else {
                        $pangkatterahir = $latest['PANGKAT'] . ";-";
                    }

                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.', 'data' => $pangkatterahir]);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_pangkat_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function view_dokumen() {
        $model = $this->master_pegawai_pangkat_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP']) . "/" . $model['DOC_SKPANGKAT'])) {
                $this->data['file'] = base_url() . "_uploads/doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP']) . "/" . $model['DOC_SKPANGKAT'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }

    public function view_info() {
        $this->data['model'] = $this->master_pegawai_pangkat_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/pangkat/info', $this->data);
    }

    public function format_excel_pagol() {
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Jenis KP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Golongan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'TMT Golongan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'NO SK');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Tanggal SK');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Pejabat');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Kode KP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'IV/a');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', '30 - 08 - 2019');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', '30 - 08 - 2019');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', '<-- Contoh');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', '<-- Mulai di-sini');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->setTitle("Import Gol Pangkat");

        $list_golongan_pangkat = $this->list_model->list_golongan_pangkat('1');
        $list_jenis_kenaikan_pangkat = $this->list_model->list_jenis_kenaikan_pangkat();

        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'Referensi Pangkat / Golongan');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Referensi Jenis KP');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('D1:E1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('D1:E1');
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $row = 3;
        foreach ($list_golongan_pangkat as $rowj) {
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
        $objPHPExcel->getActiveSheet(1)->setTitle("Referensi Golongan Pangkat");
        $row = 3;
        foreach ($list_jenis_kenaikan_pangkat as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $row, $rowj['ID'])->setCellValue('E' . $row, $rowj['NAMA']);
            $row++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="IMPORT PANGKAT GOLONGAN PEGAWAI ' . date('d-m-Y') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function import_golongan_pegawai() {
        $this->data['title_utama'] = "Pangkat / Golongan Pegawai";
        $this->data['title_form'] = "Pangkat / Golongan Pegawai";
        $this->data['content'] = 'master_pegawai/pangkat/import_golongan_pegawai';

        if ($this->input->method() === "post") {
            try {
                $inputFileType = PHPExcel_IOFactory::identify($_FILES['file_excel']['tmp_name']);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($_FILES['file_excel']['tmp_name']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            $sheet = $objPHPExcel->getSheet(0);
            $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestDataRow();
            $highestColumn = $objWorksheet->getHighestDataColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $totaldata = 0;
            $sukses = 0;
            $gagal = 0;
            $tampung = [];
            for ($row = 3; $row <= $highestRow; ++$row) {
//                echo trim($objWorksheet->getCellByColumnAndRow(0, $row))."<br />";
                $getpegawai = $this->master_pegawai_model->get_by_nipnew_select(trim($objWorksheet->getCellByColumnAndRow(0, $row)), "ID");
//                echo $getpegawai['ID']."<br />";
                $getgolpangkat = $this->master_pegawai_pangkat_model->get_pangkat_by_id(trim($objWorksheet->getCellByColumnAndRow(2, $row)), "ID");
//                echo $getgolpangkat['ID']." <- test <br />";
                if (!empty($getpegawai['ID']) && !empty($getgolpangkat['ID'])) {
                    $post = [
                        "TRGOLONGAN_ID" => ltrim(rtrim($getgolpangkat['ID'])),
                        "TRJENISKENAIKANPANGKAT_ID" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(1, $row))),
                        "NO_SK" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(4, $row))),
                        "PEJABAT_SK" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(6, $row))),
                        'TMPEGAWAI_ID' => $getpegawai['ID'],
                    ];
                    $pecah = explode('-', trim(str_replace(" ", "",$objWorksheet->getCellByColumnAndRow(3, $row))));
                    $belah = explode('-', trim(str_replace(" ", "",$objWorksheet->getCellByColumnAndRow(5, $row))));
                    $tanggal = [
                        "TMT_GOL" => $pecah[2]."-".$pecah[1]."-".$pecah[0],
                        "TGL_SK" => $belah[2]."-".$belah[1]."-".$belah[0],
                    ];
//                    print '<pre>';
//                    print_r($post);
//                    print_r($tanggal);
                    if ($this->master_pegawai_pangkat_model->get_exist($getpegawai['ID'],ltrim(rtrim($getgolpangkat['ID'])),ltrim(rtrim($objWorksheet->getCellByColumnAndRow(1, $row))),($pecah[2]."-".$pecah[1]."-".$pecah[0])) < 1) {
                        if ($this->master_pegawai_pangkat_model->insert($post, $tanggal)) {
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
//            exit;
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
            redirect('/master_pegawai/master_pegawai_pangkat/import_golongan_pegawai');
        }

        $this->load->view('layouts/main', $this->data);
    }

}
