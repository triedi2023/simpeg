<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_sanksi extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_sanksi_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Sanksi Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/sanksi/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_tkt_hukdis'] = $this->list_model->list_tkt_hukdis();
            $this->data['list_jenis_hukdis'] = $this->list_model->list_jenis_hukdis();
            $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/sanksi/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tingkat_hukuman', 'Tingkat Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jenis_hukuman', 'Jenis Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('alasan_hukuman', 'Alasan Hukuman', 'min_length[1]|max_length[3000]');
        $this->form_validation->set_rules('tmt_hukuman', 'Tmt Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('akhir_hukuman', 'Akhir Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            $nmjabatannmunit = '';
            if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef'])) {
                $nmjabatannmunit = $_POST['unitkerjanokoderef'];
            } else {
                $nmunit = $this->master_pegawai_sanksi_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
                $nmjabatannmunit = $nmunit['NMUNITKERJA'];
            }
            
            $post = [
                "TRTKTHUKUMANDISIPLIN_ID" => trim($this->input->post('tingkat_hukuman',TRUE)),
                "TRJENISHUKUMANDISIPLIN_ID" => trim($this->input->post('jenis_hukuman',TRUE)),
                "ALASAN_HKMN" => ltrim(rtrim($this->input->post('alasan_hukuman',TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PJBT_SK" => ltrim(rtrim($this->input->post('pejabat',TRUE))),
                'TMPEGAWAI_ID' => $id,
                'TRLOKASI_ID' => $lokasi,
                'KDU1' => $kdu1,
                'KDU2' => $kdu2,
                'KDU3' => $kdu3,
                'KDU4' => $kdu4,
                'KDU5' => $kdu5,
                'NAMA_UNIT_KERJA' => $nmjabatannmunit
            ];
            $tanggal = [
                "TMT_HKMN" => datepickertodb(trim($this->input->post('tmt_hukuman',TRUE))),
                "AKHIR_HKMN" => datepickertodb(trim($this->input->post('akhir_hukuman',TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            if (($insert = $this->master_pegawai_sanksi_model->insert($post,$tanggal)) == true) {
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
                    $config['file_name'] = "doc_sanksi_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_SANKSI' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SANKSI' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_sanksi_model->update($dokumen,[],$insert_id);
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
            $this->data['model'] = $this->master_pegawai_sanksi_model->get_by_id($this->input->get('id'));
            $this->data['list_tkt_hukdis'] = $this->list_model->list_tkt_hukdis();
            if ($this->data['model']['TRTKTHUKUMANDISIPLIN_ID'] != "") {
                $this->data['list_jenis_hukdis'] = $this->list_model->list_jenis_hukdis($this->data['model']['TRTKTHUKUMANDISIPLIN_ID']);
            }
            $this->data['id'] = $id;
            if (!empty($this->data['model']['TRLOKASI_ID'])) {
                $option = "<option value=''>- Pilih -</option>";
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
            } else {
                $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
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
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/sanksi/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tingkat_hukuman', 'Tingkat Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jenis_hukuman', 'Jenis Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('alasan_hukuman', 'Alasan Hukuman', 'min_length[1]|max_length[3000]');
        $this->form_validation->set_rules('tmt_hukuman', 'Tmt Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('akhir_hukuman', 'Akhir Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            $nmjabatannmunit = '';
            if (isset($_POST['unitkerjanokoderef']) && !empty($_POST['unitkerjanokoderef'])) {
                $nmjabatannmunit = $_POST['unitkerjanokoderef'];
            } else {
                $nmunit = $this->master_pegawai_sanksi_model->nama_unitkerja($lokasi . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu4 . ";" . $kdu5);
                $nmjabatannmunit = $nmunit['NMUNITKERJA'];
            }
            
            $post = [
                "TRTKTHUKUMANDISIPLIN_ID" => trim($this->input->post('tingkat_hukuman',TRUE)),
                "TRJENISHUKUMANDISIPLIN_ID" => trim($this->input->post('jenis_hukuman',TRUE)),
                "ALASAN_HKMN" => ltrim(rtrim($this->input->post('alasan_hukuman',TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PJBT_SK" => ltrim(rtrim($this->input->post('pejabat',TRUE))),
                'TRLOKASI_ID' => $lokasi,
                'KDU1' => $kdu1,
                'KDU2' => $kdu2,
                'KDU3' => $kdu3,
                'KDU4' => $kdu4,
                'KDU5' => $kdu5,
                'NAMA_UNIT_KERJA' => $nmjabatannmunit
            ];
            $tanggal = [
                "TMT_HKMN" => datepickertodb(trim($this->input->post('tmt_hukuman',TRUE))),
                "AKHIR_HKMN" => datepickertodb(trim($this->input->post('akhir_hukuman',TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            
            $model = $this->master_pegawai_sanksi_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_sanksi_model->update($post,$tanggal,$this->input->get('id'))) {
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
                    $config['file_name'] = "doc_sanksi_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_SANKSI']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SANKSI'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SANKSI']);
                            }
                            $dokumen = ['DOC_SANKSI' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SANKSI' => NULL];
                    }
                    unset($config);
                    $this->master_pegawai_sanksi_model->update($dokumen,[],$insert_id);
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
        $list = $this->master_pegawai_sanksi_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SANKSI) && $val->DOC_SANKSI != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_sanksi/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_sanksi/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TKT_HUKUMAN_DISIPLIN;
            $row[] = $val->JENIS_HUKDIS;
            $row[] = $val->ALASAN_HKMN;
            $row[] = $val->PERIODE;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_sanksi/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_sanksi/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_sanksi_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_sanksi_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_sanksi_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_sanksi_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_SANKSI']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SANKSI'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SANKSI']);
                    }
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_sanksi_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_sanksi_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SANKSI'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SANKSI'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_sanksi_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/sanksi/info', $this->data);
    }

}
