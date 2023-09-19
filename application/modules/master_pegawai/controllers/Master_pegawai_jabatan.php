<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_jabatan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_jabatan_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Jabatan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
        $this->load->view('master_pegawai/jabatan/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = [];
            $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
            $this->data['list_golongan'] = $this->master_pegawai_jabatan_model->list_golongan_pegawai($id);
            $this->data['list_keterangan_jabatan'] = $this->list_model->list_keterangan_jabatan();
            $this->data['id'] = $id;

            $this->load->view("master_pegawai/jabatan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('eselon_id', 'Eselon', 'required|min_length[1]|max_length[6]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tmt_eselon', 'Tmt Eselon', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'trim');
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'max_length[400]');
        $this->form_validation->set_rules('tmt_jabatan_awal', 'Tmt Jabatan', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tmt_jabatan_akhir', 'Tmt Jabatan Akhir', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('jml_ak', 'Jumlah Angka Kredit', 'min_length[1]|max_length[9]|trim');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[400]');
        $this->form_validation->set_rules('tgl_pelantikan', 'Tgl Pelantikan', 'min_length[10]|max_length[10]');
        $this->form_validation->set_rules('lokasi_kppn', 'Lokasi Kppn', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('lokasi_taspen', 'Lokasi Taspen', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('trlokasi_id', 'Lokasi', 'required|min_length[1]|max_length[6]');
        $this->form_validation->set_rules('pangkat_id', 'Pangkat', 'min_length[1]|max_length[3]');
        $this->form_validation->set_rules('keteranganjabatan_id', 'Keterangan Jabatan', 'min_length[1]|max_length[5]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            
            $nmjabatan = '';
            if (empty($_POST['jabatan_id']) || strlen($_POST['jabatan_id']) > 4) {
                $nmjabatan = ltrim(rtrim($this->input->post('nama_jabatan', TRUE)))." - ";
            } else {
                $getjabatan = (isset($_POST['jabatan_id']) && !empty($_POST['jabatan_id'])) ? $this->master_pegawai_jabatan_model->nama_jabatan($_POST['jabatan_id']) : [];
                if (isset($getjabatan['KETERANGAN']) && !empty($getjabatan['KETERANGAN'])) {
                    $nmjabatan = $getjabatan['KETERANGAN']." ";
                } else {
                    $nmjabatan = $getjabatan['JABATAN']." ";
                }
            }

            $namaunit = '';
            $nmjabatannmunit = '';
            if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef'])) {
                $namaunit = $_POST['unitkerjanokoderef'];
                $nmjabatannmunit = $nmjabatan . ", " . $_POST['unitkerjanokoderef'];
            } else {
                $nmunit = $this->master_pegawai_jabatan_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
                $namaunit = $nmunit['NMUNITKERJA'];
                $nmjabatannmunit = $nmjabatan . " " . $nmunit['NMUNITKERJA'];
            }

            $post = [
                "TRESELON_ID" => trim($this->input->post('eselon_id', TRUE)),
                "TRJABATAN_ID" => strlen($_POST['jabatan_id']) > 4 ? NULL : ltrim(rtrim($this->input->post('jabatan_id', TRUE))),
                "K_JABATAN_NOKODE" => ltrim(rtrim($this->input->post('nama_jabatan', TRUE))),
                "TRGOLONGAN_ID" => trim($this->input->post('pangkat_id', TRUE)),
                "A_KREDIT" => ltrim(rtrim($this->input->post('jml_ak', TRUE))),
                'TMPEGAWAI_ID' => $id,
                'TRLOKASI_ID' => $lokasi,
                'KDU1' => $kdu1,
                'KDU2' => $kdu2,
                'KDU3' => $kdu3,
                'KDU4' => $kdu4,
                'KDU5' => $kdu5,
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                "KPPN" => ltrim(rtrim($this->input->post('lokasi_kppn', TRUE))),
                "LOK_TASPEN" => ltrim(rtrim($this->input->post('lokasi_taspen', TRUE))),
                'N_JABATAN' => $nmjabatannmunit,
                'NMUNIT' => $namaunit,
                "TRKETERANGANJABATAN_ID" => ltrim(rtrim($this->input->post('keteranganjabatan_id', TRUE))),
            ];
            $tanggal = [
                "TMT_ESELON" => datepickertodb(trim($this->input->post('tmt_eselon', TRUE))),
                "TMT_JABATAN" => datepickertodb(trim($this->input->post('tmt_jabatan_awal', TRUE))),
                "TGL_AKHIR" => datepickertodb(trim($this->input->post('tmt_jabatan_akhir', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
                "TGL_LANTIK" => datepickertodb(trim($this->input->post('tgl_pelantikan', TRUE))),
            ];
            if ($insert = $this->master_pegawai_jabatan_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($data_pegawai['NIP']);
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_jabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name']))
                            $dokumen = ['DOC_SKJABATAN' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SKJABATAN' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_jabatan_model->update($dokumen, [], $insert_id);
                $jabatan_mutakhir = $this->master_pegawai_jabatan_model->jabatan_mutakhir($id);
                
                $htmllog = "Eselon = ".$this->list_model->list_eselon(trim($this->input->post('eselon_id', TRUE)))[0]['NAMA']
                .";TMT Eselon = ".trim($this->input->post('tmt_eselon', TRUE))
                .";Jabatan = ".$nmjabatannmunit.";TMT Jabatan = ".trim($this->input->post('tmt_jabatan_awal', TRUE));
                $this->Log_model->insert_log("Menambah","Data Jabatan Pegawai Dengan NIP ".($data_pegawai['NIPNEW']).";".$htmllog);
                
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
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
            $kode = $this->input->get('kode');
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_jabatan_model->get_by_id($this->input->get('id'));
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            
            if (!empty($this->data['model']['TRJABATAN_ID'])) {
                $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            }
            if (!empty($this->data['model']['TRLOKASI_ID'])) {
                $option = "";
                foreach ($this->list_model->list_lokasi_tree() as $val) {
                    $selec = '';
                    if ($val['id'] == $this->data['model']['TRLOKASI_ID']) {
                        $selec = 'selected=""';
                    }
                    if (isset($val['children']) && count(array_filter($val['children'])) > 0) {
                        $option .= '<optgroup label="'.$val['text'].'">';
                        foreach ($val['children'] as $children) {
                            if ($children['id'] == $this->data['model']['TRLOKASI_ID']) {
                                $selec = 'selected=""';
                            }
                            $option .= '<option '.$selec.' value="'.$children['id'].'">'.$children['text'].'</option>';
                        }
                        $option .= '</optgroup>';
                    } else {
                        $option .= '<option '.$selec.' value="'.$val['id'].'">'.$val['text'].'</option>';
                    }
                }
                $this->data['list_lokasi'] = $option;
            }
            if (!empty($this->data['model']['KDU1'])) {
                $this->data['list_kdu1'] = $this->list_model->list_kdu1($this->data['model']['TRLOKASI_ID']);
            }
            if (!empty($this->data['model']['KDU2'])) {
                $this->data['list_kdu2'] = $this->list_model->list_kdu2($this->data['model']['TRLOKASI_ID'],$this->data['model']['KDU1']);
            }
            if (!empty($this->data['model']['KDU3'])) {
                $this->data['list_kdu3'] = $this->list_model->list_kdu3($this->data['model']['TRLOKASI_ID'],$this->data['model']['KDU1'],$this->data['model']['KDU2']);
            }
            if (!empty($this->data['model']['KDU4'])) {
                $this->data['list_kdu4'] = $this->list_model->list_kdu4($this->data['model']['TRLOKASI_ID'],$this->data['model']['KDU1'],$this->data['model']['KDU2'],$this->data['model']['KDU3']);
            }
            if (!empty($this->data['model']['KDU5'])) {
                $this->data['list_kdu5'] = $this->list_model->list_kdu5($this->data['model']['TRLOKASI_ID'],$this->data['model']['KDU1'],$this->data['model']['KDU2'],$this->data['model']['KDU3'],$this->data['model']['KDU4']);
            }
            
            $this->data['list_golongan'] = $this->master_pegawai_jabatan_model->list_golongan_pegawai($this->data['model']['TMPEGAWAI_ID']);
            $this->data['list_keterangan_jabatan'] = $this->list_model->list_keterangan_jabatan();
            $this->data['id'] = $id;

            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/jabatan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('eselon_id', 'Eselon', 'required|min_length[1]|max_length[6]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tmt_eselon', 'Tmt Eselon', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'trim');
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'max_length[400]');
        $this->form_validation->set_rules('tmt_jabatan_awal', 'Tmt Jabatan', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tmt_jabatan_akhir', 'Tmt Jabatan Akhir', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('jml_ak', 'Jumlah Angka Kredit', 'min_length[1]|max_length[9]|trim');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[400]');
        $this->form_validation->set_rules('tgl_pelantikan', 'Tgl Pelantikan', 'min_length[10]|max_length[10]');
        $this->form_validation->set_rules('lokasi_kppn', 'Lokasi Kppn', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('lokasi_taspen', 'Lokasi Taspen', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('trlokasi_id', 'Lokasi', 'required|min_length[1]|max_length[6]');
        $this->form_validation->set_rules('pangkat_id', 'Pangkat', 'min_length[1]|max_length[3]');
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
            
            $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            
            $nmjabatan = '';
            if (empty($_POST['jabatan_id']) || strlen($_POST['jabatan_id']) > 4) {
                $nmjabatan = (ltrim(rtrim($this->input->post('nama_jabatan', TRUE))))." - ";
            } else {
                $getjabatan = (isset($_POST['jabatan_id']) && !empty($_POST['jabatan_id'])) ? $this->master_pegawai_jabatan_model->nama_jabatan($_POST['jabatan_id']) : [];
                if (isset($getjabatan['KETERANGAN']) && !empty($getjabatan['KETERANGAN'])) {
                    $nmjabatan = $getjabatan['KETERANGAN']." ";
                } else {
                    $nmjabatan = $getjabatan['JABATAN']." ";
                }
            }

            $namaunit = '';
            $nmjabatannmunit = '';
            if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef']) && explode("/", $this->input->post('tmt_jabatan_awal', TRUE))[2] < 2017) {
                $namaunit = $_POST['unitkerjanokoderef'];
                $nmjabatannmunit = $nmjabatan . $_POST['unitkerjanokoderef'];
            } else {
                $nmunit = $this->master_pegawai_jabatan_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
                $namaunit = $nmunit['NMUNITKERJA'];
                $nmjabatannmunit = $nmjabatan . " " . $nmunit['NMUNITKERJA'];
            }
            $post = [
                "TRESELON_ID" => trim($this->input->post('eselon_id', TRUE)),
                "TRJABATAN_ID" => strlen($_POST['jabatan_id']) > 4 ? NULL : ltrim(rtrim($this->input->post('jabatan_id', TRUE))),
                "K_JABATAN_NOKODE" => ltrim(rtrim($this->input->post('nama_jabatan', TRUE))),
                "TRGOLONGAN_ID" => trim($this->input->post('pangkat_id', TRUE)),
                "A_KREDIT" => ltrim(rtrim($this->input->post('jml_ak', TRUE))),
                'TRLOKASI_ID' => $lokasi,
                'KDU1' => $kdu1,
                'KDU2' => $kdu2,
                'KDU3' => $kdu3,
                'KDU4' => $kdu4,
                'KDU5' => $kdu5,
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                "KPPN" => ltrim(rtrim($this->input->post('lokasi_kppn', TRUE))),
                "LOK_TASPEN" => ltrim(rtrim($this->input->post('lokasi_taspen', TRUE))),
                'N_JABATAN' => $nmjabatannmunit,
                'NMUNIT' => $namaunit,
                "TRKETERANGANJABATAN_ID" => ltrim(rtrim($this->input->post('keteranganjabatan_id', TRUE)))
            ];
            $tanggal = [
                "TMT_ESELON" => datepickertodb(trim($this->input->post('tmt_eselon', TRUE))),
                "TMT_JABATAN" => datepickertodb(trim($this->input->post('tmt_jabatan_awal', TRUE))),
                "TGL_AKHIR" => datepickertodb(trim($this->input->post('tmt_jabatan_akhir', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
                "TGL_LANTIK" => datepickertodb(trim($this->input->post('tgl_pelantikan', TRUE))),
            ];
            $model = $this->master_pegawai_jabatan_model->get_by_id($this->input->get('kode'));
            
            if ($this->master_pegawai_jabatan_model->update($post, $tanggal, $this->input->get('kode'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP,NIPNEW");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_jabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                            if (!empty($model['DOC_SKJABATAN']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKJABATAN'])) {
                                unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKJABATAN']);
                            }
                            $dokumen = ['DOC_SKJABATAN' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SKJABATAN' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_jabatan_model->update($dokumen, [], $insert_id);
                $jabatan_mutakhir = $this->master_pegawai_jabatan_model->jabatan_mutakhir($model['TMPEGAWAI_ID']);
                
                $htmllog = "Eselon = ".$this->list_model->list_eselon($model['TRESELON_ID'])[0]['NAMA']." => ".$this->list_model->list_eselon(trim($this->input->post('eselon_id', TRUE)))[0]['NAMA']
                .";TMT Eselon = ".$model['TMT_ESELON2']." => ".trim($this->input->post('tmt_eselon', TRUE))
                .";Jabatan = ".$model['N_JABATAN']." => ".$nmjabatannmunit.";TMT Jabatan = ".$model['TMT_JABATAN2']." => ".trim($this->input->post('tmt_jabatan_awal', TRUE));
                $this->Log_model->insert_log("Mengubah","Data Jabatan Pegawai Dengan NIP ".($data_pegawai['NIPNEW'])."; ".$htmllog);
                
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
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
        $list = $this->master_pegawai_jabatan_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SKJABATAN) && $val->DOC_SKJABATAN != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_jabatan/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="' . site_url('master_pegawai/master_pegawai_jabatan/hapus_data') . '" data-id="' . $val->ID . '" data-identify="updatejabatanpegawai" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->N_JABATAN;
            $row[] = $val->NO_SK;
            $row[] = $val->TMT_JABATAN2;
            $row[] = $val->KETERANGAN_JABATAN;
            $row[] = $file.'<a href="javascript:;" data-url="' . site_url('master_pegawai/master_pegawai_jabatan/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_jabatan/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_jabatan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_jabatan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_jabatan_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'], "NIP,NIPNEW");
                if ($this->master_pegawai_jabatan_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_AKTENIKAH']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $model['DOC_AKTENIKAH'])) {
                        unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $model['DOC_AKTENIKAH']);
                    }
                    
                    $jabatan_mutakhir = $this->master_pegawai_jabatan_model->jabatan_mutakhir($model['TMPEGAWAI_ID']);
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_jabatan_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_jabatan_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKJABATAN'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKJABATAN'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_jabatan_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/jabatan/info', $this->data);
    }

}
