<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_pns extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_pns_model', 'list_model', 'master_pegawai/master_pegawai_model', 'master_pegawai/master_pegawai_jabatan_model', 'master_pegawai/master_pegawai_diklat_prajabatan_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Jabatan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $this->data['data_pegawai'] = $this->master_pegawai_pns_model->get_by_id($this->data['id']);
//        $this->data['data_jabatan'] = $this->master_pegawai_pns_model->get_by_pegawai_jabatan_pns($this->data['id']);
        $this->data['data_jabatan'] = [];
        $this->data['data_prajab'] = $this->master_pegawai_pns_model->get_by_pegawai_prajab_pns($this->data['id']);
        $this->data['list_eselon'] = $this->list_model->list_eselon();

        if (!empty($this->data['data_jabatan']['TRJABATAN_ID'])) {
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['data_jabatan']['TRESELON_ID']);
        }

        if (!empty($this->data['data_jabatan']['TRLOKASI_ID'])) {
            $option = "";
            foreach ($this->list_model->list_lokasi_tree() as $val) {
                $selec = '';
                if ($val['id'] == $this->data['data_jabatan']['TRLOKASI_ID']) {
                    $selec = 'selected=""';
                }
                if (isset($val['children']) && count(array_filter($val['children'])) > 0) {
                    $option .= '<optgroup label="' . $val['text'] . '">';
                    foreach ($val['children'] as $children) {
                        if ($children['id'] == $this->data['data_jabatan']['TRLOKASI_ID']) {
                            $selec = 'selected=""';
                        }
                        $option .= '<option ' . $selec . ' value="' . $children['id'] . '">' . $children['text'] . '</option>';
                    }
                    $option .= '</optgroup>';
                } else {
                    $option .= '<option ' . $selec . ' value="' . $val['id'] . '">' . $val['text'] . '</option>';
                }
            }
            $this->data['list_lokasi'] = $option;
        } else {
            $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        }
        if (!empty($this->data['data_jabatan']['KDU1'])) {
            $this->data['list_kdu1'] = $this->list_model->list_kdu1($this->data['data_jabatan']['TRLOKASI_ID']);
        }
        if (!empty($this->data['data_jabatan']['KDU2'])) {
            $this->data['list_kdu2'] = $this->list_model->list_kdu2($this->data['data_jabatan']['TRLOKASI_ID'], $this->data['data_jabatan']['KDU1']);
        }
        if (!empty($this->data['data_jabatan']['KDU3'])) {
            $this->data['list_kdu3'] = $this->list_model->list_kdu3($this->data['data_jabatan']['TRLOKASI_ID'], $this->data['data_jabatan']['KDU1'], $this->data['data_jabatan']['KDU2']);
        }
        if (!empty($this->data['data_jabatan']['KDU4'])) {
            $this->data['list_kdu4'] = $this->list_model->list_kdu4($this->data['data_jabatan']['TRLOKASI_ID'], $this->data['data_jabatan']['KDU1'], $this->data['data_jabatan']['KDU2'], $this->data['data_jabatan']['KDU3']);
        }
        if (!empty($this->data['data_jabatan']['KDU5'])) {
            $this->data['list_kdu5'] = $this->list_model->list_kdu5($this->data['data_jabatan']['TRLOKASI_ID'], $this->data['data_jabatan']['KDU1'], $this->data['data_jabatan']['KDU2'], $this->data['data_jabatan']['KDU3'], $this->data['data_jabatan']['KDU4']);
        }
        
        $this->load->view('master_pegawai/pns/index', $this->data);
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('eselon_id', 'Eselon', 'min_length[1]|max_length[6]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'min_length[1]|max_length[400]');
        $this->form_validation->set_rules('unitkerjanokoderef', 'Unit Kerja', 'min_length[1]|max_length[400]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tmt_jabatan', 'TMT Jabatan', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('no_stlk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_stlk', 'Tanggal', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('rs', 'Rumah Sakit', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('pejabat_stlk', 'Pejabat', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('nama_prajab', 'Nama', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('no_prajab', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_prajab', 'Tanggal', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('pejabat_prajab', 'Pejabat', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $sukses = 0;

            $post = [
                "NO_STLK" => ltrim(rtrim($this->input->post('no_stlk', TRUE))),
                "PEJABAT_STLK" => ltrim(rtrim($this->input->post('pejabat_stlk', TRUE))),
                "RUMAH_SAKIT" => ltrim(rtrim($this->input->post('rs', TRUE))),
            ];
            $tanggal = [
                "TGL_STLK" => datepickertodb(trim($this->input->post('tgl_stlk', TRUE))),
            ];
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP,NIPNEW");

            if ($this->master_pegawai_pns_model->update($post, $tanggal, $this->input->get('id'))) {
                $insert_id = $this->input->get('id');

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_stlk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_stlk.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_stlk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                            if (!empty($model['DOC_STLK']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_STLK'])) {
                                unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_STLK']);
                            }
                            $dokumen = ['DOC_STLK' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_STLK' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_pns_model->update($dokumen, [], $insert_id);
                $sukses = $sukses + 1;
            }

            if ($this->master_pegawai_diklat_prajabatan_model->count_is_pns($this->input->get('id'),$this->input->post('no_prajab', TRUE),$this->input->post('tgl_prajab', TRUE)) < 1) {
                $post = [
                    "NAMA_DIKLAT" => ltrim(rtrim($this->input->post('nama_prajab', TRUE))),
                    "NO_STTPP" => ltrim(rtrim($this->input->post('no_prajab', TRUE))),
                    "PJBT_STTPP" => ltrim(rtrim($this->input->post('pejabat_prajab', TRUE))),
                    'TMPEGAWAI_ID' => $this->input->get('id'),
                    'IS_PNS' => 1
                ];
                $tanggal = [
                    "TGL_STTPP" => datepickertodb(trim($this->input->post('tgl_prajab', TRUE))),
                ];
                if ($insert = $this->master_pegawai_diklat_prajabatan_model->insert($post, $tanggal)) {
                    $insert_id = $insert['id'];

                    $dokumen = [];
                    if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                        mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                    }

                    if (!empty($_FILES['doc_prajab']['name'])) {
                        $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                        $config['allowed_types'] = 'pdf';
                        $config['max_size'] = '2048';
                        $config['overwrite'] = true;
                        $config['file_name'] = "doc_diklat_prajabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('doc_prajab')) {
                            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name']))
                                $dokumen = ['DOC_PRAJABATAN' => $config['file_name']];
                            else
                                $dokumen = ['DOC_PRAJABATAN' => NULL];
                        }
                        unset($config);
                    }

                    $this->master_pegawai_diklat_prajabatan_model->update($dokumen, [], $insert_id);
                }
                $sukses = $sukses + 1;
            } else {
                $model = $this->master_pegawai_pns_model->get_by_pegawai_prajab_pns($this->input->get('id'));
                $post = [
                    "NAMA_DIKLAT" => ltrim(rtrim($this->input->post('nama_prajab', TRUE))),
                    "NO_STTPP" => ltrim(rtrim($this->input->post('no_prajab', TRUE))),
                    "PJBT_STTPP" => ltrim(rtrim($this->input->post('pejabat_prajab', TRUE))),
                ];
                $tanggal = [
                    "TGL_STTPP" => datepickertodb(trim($this->input->post('tgl_prajab', TRUE))),
                ];
                if ($this->master_pegawai_diklat_prajabatan_model->update($post, $tanggal, $model['ID'])) {
                    $insert_id = $model['ID'];

                    $dokumen = [];
                    if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                        mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                    }

                    if (!empty($_FILES['doc_prajab']['name'])) {
                        $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                        $config['allowed_types'] = 'pdf';
                        $config['max_size'] = '2048';
                        $config['overwrite'] = true;
                        $config['file_name'] = "doc_diklat_prajabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('doc_prajab')) {
                            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                                if (!empty($model['DOC_PRAJABATAN']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_PRAJABATAN'])) {
                                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_PRAJABATAN']);
                                }
                                $dokumen = ['DOC_PRAJABATAN' => $config['file_name']];
                            } else
                                $dokumen = ['DOC_PRAJABATAN' => NULL];
                        }
                        unset($config);
                    }

                    $this->master_pegawai_diklat_prajabatan_model->update($dokumen, [], $insert_id);
                }
                $sukses = $sukses + 1;
            }

//            if ($this->master_pegawai_jabatan_model->count_is_pns($this->input->get('id'),$this->input->post('no_sk', TRUE),$this->input->post('tmt_jabatan', TRUE),$this->input->post('tgl_sk', TRUE)) < 1) {
//                $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
//                $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && strlen($_POST['kdu1']) == 2) ? trim($this->input->post('kdu1', TRUE)) : '00';
//                $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && strlen($_POST['kdu2']) == 2) ? trim($this->input->post('kdu2', TRUE)) : '00';
//                $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && strlen($_POST['kdu3']) == 3) ? trim($this->input->post('kdu3', TRUE)) : '000';
//                $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && strlen($_POST['kdu4']) == 3) ? trim($this->input->post('kdu4', TRUE)) : '000';
//                $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && strlen($_POST['kdu5']) == 2) ? trim($this->input->post('kdu5', TRUE)) : '00';
//
//                $nmjabatan = '';
//                if (empty($_POST['jabatan_id']) || strlen($_POST['jabatan_id']) > 4) {
//                    $nmjabatan = ltrim(rtrim($this->input->post('nama_jabatan', TRUE)))." - ";
//                } else {
//                    $getjabatan = (isset($_POST['jabatan_id']) && !empty($_POST['jabatan_id'])) ? $this->master_pegawai_jabatan_model->nama_jabatan($_POST['jabatan_id']) : [];
//                    if (isset($getjabatan['KETERANGAN']) && !empty($getjabatan['KETERANGAN'])) {
//                        $nmjabatan = $getjabatan['KETERANGAN'] . " ";
//                    } else {
//                        $nmjabatan = $getjabatan['JABATAN'] . " ";
//                    }
//                }
//
//                $namaunit = '';
//                $nmpnsnmunit = '';
//                if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef'])) {
//                    $namaunit = $_POST['unitkerjanokoderef'];
//                    $nmpnsnmunit = $nmjabatan . "" . $_POST['unitkerjanokoderef'];
//                } else {
//                    $nmunit = $this->master_pegawai_jabatan_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
//                    $namaunit = $nmunit['NMUNITKERJA'];
//                    $nmpnsnmunit = $nmjabatan . "" . $nmunit['NMUNITKERJA'];
//                }
//
//                $post = [
//                    "TRESELON_ID" => trim($this->input->post('eselon_id', TRUE)),
//                    "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan_id', TRUE))),
//                    "K_JABATAN_NOKODE" => ltrim(rtrim($this->input->post('nama_jabatan', TRUE))),
//                    'TMPEGAWAI_ID' => $this->input->get('id'),
//                    'TRLOKASI_ID' => $lokasi,
//                    'KDU1' => $kdu1,
//                    'KDU2' => $kdu2,
//                    'KDU3' => $kdu3,
//                    'KDU4' => $kdu4,
//                    'KDU5' => $kdu5,
//                    "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
//                    "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
//                    'IS_PNS' => 1,
//                    'N_JABATAN' => $nmpnsnmunit,
//                    'NMUNIT' => $namaunit
//                ];
//                $tanggal = [
//                    "TMT_JABATAN" => datepickertodb(trim($this->input->post('tmt_jabatan', TRUE))),
//                    "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
//                ];
//                if ($insert = $this->master_pegawai_jabatan_model->insert($post, $tanggal)) {
//                    $insert_id = $insert['id'];
//
//                    $dokumen = [];
//                    if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']))) {
//                        mkdir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']), 0777);
//                    }
//
//                    if (!empty($_FILES['doc_sk']['name'])) {
//                        $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($data_pegawai['NIP']);
//                        $config['allowed_types'] = 'pdf';
//                        $config['max_size'] = '2048';
//                        $config['overwrite'] = true;
//                        $config['file_name'] = "doc_jabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";
//
//                        $this->load->library('upload', $config);
//                        $this->upload->initialize($config);
//                        if ($this->upload->do_upload('doc_sk')) {
//                            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $config['file_name']))
//                                $dokumen = ['DOC_SKJABATAN' => $config['file_name']];
//                            else
//                                $dokumen = ['DOC_SKJABATAN' => NULL];
//                        }
//                        unset($config);
//                    }
//
//                    $this->master_pegawai_jabatan_model->update($dokumen, [], $insert_id);
//                }
//                $sukses = $sukses + 1;
//            } else {
//                $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
//                $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && strlen($_POST['kdu1']) == 2) ? trim($this->input->post('kdu1', TRUE)) : '00';
//                $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && strlen($_POST['kdu2']) == 2) ? trim($this->input->post('kdu2', TRUE)) : '00';
//                $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && strlen($_POST['kdu3']) == 3) ? trim($this->input->post('kdu3', TRUE)) : '000';
//                $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && strlen($_POST['kdu4']) == 3) ? trim($this->input->post('kdu4', TRUE)) : '000';
//                $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && strlen($_POST['kdu5']) == 2) ? trim($this->input->post('kdu5', TRUE)) : '00';
//
//                $nmjabatan = '';
//                if (empty($_POST['jabatan_id']) || strlen($_POST['jabatan_id']) > 4) {
//                    $nmjabatan = ltrim(rtrim($this->input->post('nama_jabatan', TRUE)));
//                } else {
//                    $getjabatan = (isset($_POST['jabatan_id']) && !empty($_POST['jabatan_id'])) ? $this->master_pegawai_jabatan_model->nama_jabatan($_POST['jabatan_id']) : [];
//                    if (isset($getjabatan['KETERANGAN']) && !empty($getjabatan['KETERANGAN'])) {
//                        $nmjabatan = $getjabatan['KETERANGAN'] . " ";
//                    } else {
//                        $nmjabatan = $getjabatan['JABATAN'] . ", ";
//                    }
//                }
//
//                $namaunit = '';
//                $nmpnsnmunit = '';
//                if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef'])) {
//                    $namaunit = $_POST['unitkerjanokoderef'];
//                    $nmpnsnmunit = $nmjabatan . "" . $_POST['unitkerjanokoderef'];
//                } else {
//                    $nmunit = $this->master_pegawai_jabatan_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
//                    $namaunit = $nmunit['NMUNITKERJA'];
//                    $nmpnsnmunit = $nmjabatan . "" . $nmunit['NMUNITKERJA'];
//                }
//
//                $post = [
//                    "TRESELON_ID" => trim($this->input->post('eselon_id', TRUE)),
//                    "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan_id', TRUE))),
//                    "K_JABATAN_NOKODE" => ltrim(rtrim($this->input->post('nama_jabatan', TRUE))),
//                    'TMPEGAWAI_ID' => $this->input->get('id'),
//                    'TRLOKASI_ID' => $lokasi,
//                    'KDU1' => $kdu1,
//                    'KDU2' => $kdu2,
//                    'KDU3' => $kdu3,
//                    'KDU4' => $kdu4,
//                    'KDU5' => $kdu5,
//                    "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
//                    "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
//                    'N_JABATAN' => $nmpnsnmunit,
//                    'NMUNIT' => $namaunit
//                ];
//                $tanggal = [
//                    "TMT_JABATAN" => datepickertodb(trim($this->input->post('tmt_jabatan', TRUE))),
//                    "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
//                ];
//                $model = $this->master_pegawai_pns_model->get_by_pegawai_jabatan_pns($this->input->get('id'));
//
//                if ($this->master_pegawai_jabatan_model->update($post, $tanggal, $model['ID'])) {
//                    $insert_id = $model['ID'];
//
//                    $dokumen = [];
//                    if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']))) {
//                        mkdir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']), 0777);
//                    }
//
//                    if (!empty($_FILES['doc_sk']['name'])) {
//                        $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($data_pegawai['NIP']);
//                        $config['allowed_types'] = 'pdf';
//                        $config['max_size'] = '2048';
//                        $config['overwrite'] = true;
//                        $config['file_name'] = "doc_jabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";
//
//                        $this->load->library('upload', $config);
//                        $this->upload->initialize($config);
//                        if ($this->upload->do_upload('doc_sk')) {
//                            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $config['file_name'])) {
//                                if (!empty($model['DOC_SKJABATAN']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $model['DOC_SKJABATAN'])) {
//                                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']) . "/" . $model['DOC_SKJABATAN']);
//                                }
//                                $dokumen = ['DOC_SKJABATAN' => $config['file_name']];
//                            } else
//                                $dokumen = ['DOC_SKJABATAN' => NULL];
//                        }
//                        unset($config);
//                    }
//
//                    $this->master_pegawai_jabatan_model->update($dokumen, [], $insert_id);
//                }
//                $sukses = $sukses + 1;
//            }
            
            $sukses = $sukses + 1;

            if ($sukses == 3) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_pns_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_pns_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".$model['NIP']."/".$model['DOC_STLK'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".$model['NIP']."/".$model['DOC_STLK'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }

}
