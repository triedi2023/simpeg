<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Master_pegawai extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('master_pegawai/master_pegawai_model', 'list_model', 'laporan_drh/laporan_drh_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js', 'assets/plugins/select2/js/select2.min.js', 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'], list_js_datatable());
        $this->data['plugin_css'] = ['assets/css/profile.min.css', 'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'];
        $this->data['custom_js'] = ['layouts/widget/main/js_crud', 'master_pegawai/js'];
        $this->data['title_utama'] = 'Daftar Pegawai';
    }

    public function index() {
        $this->data['create'] = 1;
        $this->data['content'] = 'master_pegawai/index';
        $this->data['list_lokasi_filter'] = json_encode($this->list_model->list_lokasi_tree('', (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2 ? $this->session->userdata('trlokasi_id') : '')));
        $this->data['list_status_kepegawaian_filter'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['list_golongan_pangkat_filter'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_filter'] = $this->list_model->list_eselon();
        $this->data['list_kelompok_fungsional_filter'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_sts_nikah_filter'] = $this->list_model->list_sts_nikah();
        $this->data['list_pendidikan_filter'] = $this->list_model->list_pendidikan();
        $this->data['list_jk_filter'] = $this->config->item('list_jk');
        $this->data['list_tingkat_diklat_kepemimpinan_filter'] = $this->list_model->list_tingkat_diklat_kepemimpinan();
//        $this->Log_model->insert_log("Melihat","Daftar Pegawai");
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_status_kepegawaian'] = json_encode($this->list_model->list_status_kepegawaian_tree());
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['list_agama'] = $this->list_model->list_agama();
            $this->data['list_gol_darah'] = $this->list_model->list_gol_darah();
            $this->data['list_sts_nikah'] = $this->list_model->list_sts_nikah();
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();

            $this->load->view("master_pegawai/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nipold', 'NIP Lama', 'required|trim|min_length[4]|max_length[18]|is_unique[TM_PEGAWAI.NIP]');
        $this->form_validation->set_rules('nipnew', 'NIP Baru', 'required|trim|min_length[4]|max_length[18]|is_unique[TM_PEGAWAI.NIPNEW]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'min_length[1]|max_length[1]');
        $this->form_validation->set_rules('tragama_id', 'Agama', 'min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('gol_darah', 'Golongan Darah', 'min_length[1]|max_length[1]|is_natural_no_zero');
        $this->form_validation->set_rules('trstatuspernikahan_id', 'Golongan Darah', 'min_length[1]|max_length[1]|alpha');
        $this->form_validation->set_rules('tpt_lahir', 'Tempat Lahir', 'min_length[2]|max_length[50]');
        $this->form_validation->set_rules('trprovinsilahir_id', 'Tempat Provinsi Lahir', 'min_length[2]|max_length[2]|is_natural');
        $this->form_validation->set_rules('trkabupatenlahir_id', 'Tempat Kabupaten Lahir', 'min_length[1]|max_length[5]');
        $this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'min_length[10]|max_length[10]');
        $this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'numeric');
        $this->form_validation->set_rules('rambut', 'Bentuk Rambut', 'max_length[35]');
        $this->form_validation->set_rules('berat_badan', 'Berat Badan', 'numeric');
        $this->form_validation->set_rules('bentuk_muka', 'Bentuk Muka', 'max_length[35]');
        $this->form_validation->set_rules('ciri_khas', 'Ciri Khas', 'max_length[35]');
        $this->form_validation->set_rules('warna_kulit', 'Warna Kulit', 'max_length[35]');
        $this->form_validation->set_rules('alamat', 'Jalan', 'max_length[500]');
        $this->form_validation->set_rules('rt', 'RT', 'max_length[16]');
        $this->form_validation->set_rules('rw', 'RW', 'max_length[10]');
        $this->form_validation->set_rules('trprovinsitinggal_id', 'Provinsi Tinggal', 'min_length[2]|max_length[2]|is_natural');
        $this->form_validation->set_rules('trkabupatentinggal_id', 'Kabupaten Tinggal', 'min_length[1]|max_length[5]');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'max_length[50]');
        $this->form_validation->set_rules('kodepos', 'Kodepos', 'max_length[5]');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'max_length[50]');
        $this->form_validation->set_rules('telp_rmh', 'Telp Rumah', 'max_length[32]');
        $this->form_validation->set_rules('telp_hp', 'Telp HP', 'max_length[16]');
        $this->form_validation->set_rules('no_karpeg', 'No Karpeg', 'max_length[64]');
        $this->form_validation->set_rules('no_karisu', 'No Karis / Karsu', 'max_length[64]');
        $this->form_validation->set_rules('no_tapen', 'No Taspen', 'max_length[64]');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'max_length[36]');
        $this->form_validation->set_rules('no_askes', 'No Askes', 'max_length[64]');
        $this->form_validation->set_rules('no_npwp', 'No NPWP', 'max_length[64]');
        $this->form_validation->set_rules('no_bpjs', 'No BPJS', 'max_length[64]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $kablahir = NULL;
            if (!empty($_POST['trkabupatenlahir_id']) && $this->input->post('trkabupatenlahir_id') != '-1') {
                $kablahir = ltrim(rtrim($this->input->post('trkabupatenlahir_id', TRUE)));
            }
            $kabtinggal = NULL;
            if (!empty($_POST['trkabupatentinggal_id']) && $this->input->post('trkabupatentinggal_id') != '-1') {
                $kabtinggal = ltrim(rtrim($this->input->post('trkabupatentinggal_id', TRUE)));
            }
            $post = [
                "TRSTATUSKEPEGAWAIAN_ID" => ltrim(rtrim($this->input->post('trstatuskepegawaian_id', TRUE))),
                "NIP" => ltrim(rtrim($this->input->post('nipold', TRUE))),
                "NIPNEW" => ltrim(rtrim($this->input->post('nipnew', TRUE))),
                "GELAR_DEPAN" => ltrim(rtrim($this->input->post('gelar_dpn', TRUE))),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap', TRUE))),
                "GELAR_BLKG" => ltrim(rtrim($this->input->post('gelar_blkg', TRUE))),
                "SEX" => ltrim(rtrim($this->input->post('jk', TRUE))),
                "TRAGAMA_ID" => ltrim(rtrim($this->input->post('tragama_id', TRUE))),
                "TRGOLDARAH_ID" => ltrim(rtrim($this->input->post('gol_darah', TRUE))),
                "TRSTATUSPERNIKAHAN_ID" => ltrim(rtrim($this->input->post('trstatuspernikahan_id', TRUE))),
                "TPTLAHIR" => ltrim(rtrim($this->input->post('tpt_lahir', TRUE))),
                "TRPROPINSI_ID_LAHIR" => ltrim(rtrim($this->input->post('trprovinsilahir_id', TRUE))),
                "TRKABUPATEN_ID_LAHIR" => $kablahir,
                "TINGGI_BADAN" => ltrim(rtrim($this->input->post('tinggi_badan', TRUE))),
                "RAMBUT" => ltrim(rtrim($this->input->post('rambut', TRUE))),
                "BERAT_BADAN" => ltrim(rtrim($this->input->post('berat_badan', TRUE))),
                "BENTUK_MUKA" => ltrim(rtrim($this->input->post('bentuk_muka', TRUE))),
                "CIRI_KHAS" => ltrim(rtrim($this->input->post('ciri_khas', TRUE))),
                "WARNA_KULIT" => ltrim(rtrim($this->input->post('warna_kulit', TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat', TRUE))),
                "PROPINSI" => ltrim(rtrim($this->input->post('trprovinsitinggal_id', TRUE))),
                "RT" => ltrim(rtrim($this->input->post('rt', TRUE))),
                "RW" => ltrim(rtrim($this->input->post('rt', TRUE))),
                "KABUPATEN" => $kabtinggal,
                "KELURAHAN" => ltrim(rtrim($this->input->post('kelurahan', TRUE))),
                "KODEPOS" => ltrim(rtrim($this->input->post('kodepos', TRUE))),
                "KECAMATAN" => ltrim(rtrim($this->input->post('kecamatan', TRUE))),
                "TELP_RMH" => ltrim(rtrim($this->input->post('telp_rmh', TRUE))),
                "TELP_HP" => ltrim(rtrim($this->input->post('telp_hp', TRUE))),
                "NO_KARPEG" => ltrim(rtrim($this->input->post('no_karpeg', TRUE))),
                "NO_KARIS" => ltrim(rtrim($this->input->post('no_karisu', TRUE))),
                "NO_TASPEN" => ltrim(rtrim($this->input->post('no_tapen', TRUE))),
                "NO_KTP" => ltrim(rtrim($this->input->post('no_ktp', TRUE))),
                "NO_ASKES" => ltrim(rtrim($this->input->post('no_askes', TRUE))),
                "NO_NPWP" => ltrim(rtrim($this->input->post('no_npwp', TRUE))),
                "NO_BPJS" => ltrim(rtrim($this->input->post('no_bpjs', TRUE))),
                'EMAIL' => ltrim(rtrim($this->input->post('email', TRUE))),
                'HOBI' => ltrim(rtrim($this->input->post('hobi', TRUE)))
            ];
            $tanggal = [
                "TGLLAHIR" => ltrim(rtrim(datepickertodb($this->input->post('tgllahir', TRUE))))
            ];
            if ($this->master_pegawai_model->insert($post, $tanggal)) {
                $arrayerrorupload = [];
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)), 0777);
                }

                if (!empty($_FILES['doc_karpeg']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_karpeg.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_karpeg')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_KARPEG' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_KARPEG' => NULL];
                    }
                    unset($config);
                }

                if (!empty($_FILES['doc_karisu']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_karis.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_karisu')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_KARIS' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_KARIS' => NULL];
                    }
                    unset($config);
                }

                if (!empty($_FILES['doc_tapen']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_tapen.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_tapen')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_TASPEN' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_TASPEN' => NULL];
                    }
                    unset($config);
                }

                if (!empty($_FILES['doc_ktp']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_ktp.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_ktp')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_KTP' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_KTP' => NULL];
                    }
                    unset($config);
                }

                if (!empty($_FILES['doc_askes']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_askes.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_askes')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_ASKES' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_ASKES' => NULL];
                    }
                    unset($config);
                }

                if (!empty($_FILES['doc_npwp']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_npwp.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_npwp')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_NPWP' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_NPWP' => NULL];
                    }
                    unset($config);
                }
                
                if (!empty($_FILES['doc_bpjs']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_bpjs.pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_bpjs')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                            $dokumen = $dokumen + ['DOC_BPJS' => $config['file_name']];
                        else
                            $dokumen = $dokumen + ['DOC_BPJS' => NULL];
                    }
                    unset($config);
                }

                if (count(array_filter($dokumen)) > 0)
                    $this->master_pegawai_model->update_custom($dokumen, ["NIP" => ltrim(rtrim($this->input->post('nipold', TRUE))), "NIPNEW" => ltrim(rtrim($this->input->post('nipnew', TRUE)))]);

                $html = '<div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue-dark">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-th"></i> ' . $this->data['title_utama'] . '
                                </div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container" data-url="' . site_url('master_pegawai/ajax_list') . '">
                                    <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 10%"> No </th>
                                                <th class="text-center">NAMA</th>
                                                <th class="text-center">NIP</th>
                                                <th class="text-center">Golongan</th>
                                                <th class="text-center">TMT Golongan</th>
                                                <th class="text-center">Jabatan - Unit Organisasi</th>
                                                <th class="text-center">TMT Jabatan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
//                $this->Log_model->insert_log("Tambah","Tambah Pegawai Dengan NIP ".ltrim(rtrim($this->input->post('nipnew', TRUE))));
                echo json_encode(['status' => 1, 'cu' => 'di-tambah', 'html' => $html]);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-tambah']);
            }
        }
    }

    public function detail() {
        $id = $this->input->get('id');
        $this->data['data_pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['list_status_kepegawaian'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['biodata'] = 'master_pegawai/biodata';
        $this->data['list_jk'] = [['ID' => 'L', 'NAMA' => 'Laki-laki'], ['ID' => 'P', 'NAMA' => 'Perempuan']];
        $this->data['list_agama'] = $this->list_model->list_agama();
        $this->data['list_gol_darah'] = $this->list_model->list_gol_darah();
        $this->data['list_sts_nikah'] = $this->list_model->list_sts_nikah();
        $this->data['list_provinsi'] = $this->list_model->list_provinsi();
        if ($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR'] <> "" || !empty($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR'])) {
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR']);
        }
        if ($this->data['data_pegawai']['PROPINSI'] <> "" || !empty($this->data['data_pegawai']['PROPINSI'])) {
            $this->data['list_kabupaten_tempattinggal'] = $this->list_model->list_kabupaten($this->data['data_pegawai']['PROPINSI']);
        }
        $jabatan_mutakhir = $this->master_pegawai_model->jabatan_mutakhir($this->data['data_pegawai']['ID']);
        $this->data['jabatan_pegawai'] = (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-';
        $pangkat_mutakhir = $this->master_pegawai_model->pangkat_mutakhir($this->data['data_pegawai']['ID']);
        if ($pangkat_mutakhir['TRSTATUSKEPEGAWAIAN_ID'] == "") {
            $this->data['pangkat_pegawai'] = "-";
        } elseif ($pangkat_mutakhir['TRSTATUSKEPEGAWAIAN_ID'] == 1) {
            $this->data['pangkat_pegawai'] = $pangkat_mutakhir['PANGKAT'];
        } else {
            $this->data['pangkat_pegawai'] = $pangkat_mutakhir['PANGKAT'];
        }
        if ($pangkat_mutakhir['TRSTATUSKEPEGAWAIAN_ID'] == "") {
            $this->data['gol_pegawai'] = "-";
        } elseif ($pangkat_mutakhir['TRSTATUSKEPEGAWAIAN_ID'] == 1) {
            $this->data['gol_pegawai'] = $pangkat_mutakhir['GOLONGAN'];
        } else {
            $this->data['gol_pegawai'] = $pangkat_mutakhir['GOLONGAN'];
        }
        $pendidikan_mutakhir = $this->master_pegawai_model->pendidikan_mutakhir($this->data['data_pegawai']['ID']);
        $this->data['pendidikan_pegawai'] = (isset($pendidikan_mutakhir['TINGKAT_PENDIDIKAN']) && !empty($pendidikan_mutakhir['TINGKAT_PENDIDIKAN'])) ? $pendidikan_mutakhir['TINGKAT_PENDIDIKAN'] : '-';

        $this->data['foto'] = $this->data['data_pegawai']['FOTO'];
        if (!file_exists($this->config->item('uploadpath') . "photo_pegawai/thumbs/" . $this->data['data_pegawai']['FOTO'])) {
            $this->data['foto'] = 'no_photo.jpg';
        }
        
//        $this->Log_model->insert_log("Melihat","Biodata Pegawai Dengan NIP ".(isset($this->data['data_pegawai']['NIPNEW']) ? $this->data['data_pegawai']['NIPNEW'] : $this->data['data_pegawai']['NIP']).";");
        $this->load->view('master_pegawai/detail', $this->data);
    }

    public function biodata() {
        $id = $this->input->get('id');
        $this->data['data_pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['list_status_kepegawaian'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['list_jk'] = [['ID' => 'L', 'NAMA' => 'Laki-laki'], ['ID' => 'P', 'NAMA' => 'Perempuan']];
        $this->data['list_agama'] = $this->list_model->list_agama();
        $this->data['list_gol_darah'] = $this->list_model->list_gol_darah();
        $this->data['list_sts_nikah'] = $this->list_model->list_sts_nikah();
        $this->data['list_provinsi'] = $this->list_model->list_provinsi();
        if ($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR'] <> "" || !empty($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR'])) {
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['data_pegawai']['TRPROPINSI_ID_LAHIR']);
        }
        if ($this->data['data_pegawai']['PROPINSI'] <> "" || !empty($this->data['data_pegawai']['PROPINSI'])) {
            $this->data['list_kabupaten_tempattinggal'] = $this->list_model->list_kabupaten($this->data['data_pegawai']['PROPINSI']);
        }

//        $this->Log_model->insert_log("Melihat","Biodata Pegawai Dengan NIP ".(isset($this->data['data_pegawai']['NIPNEW']) ? $this->data['data_pegawai']['NIPNEW'] : $this->data['data_pegawai']['NIP']).";");
        $this->load->view('master_pegawai/biodata', $this->data);
    }

    public function ubah_datapokok_biodata() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nipold', 'NIP Lama', 'required|trim|min_length[4]|max_length[18]|callback_unique_edit_nip');
        $this->form_validation->set_rules('nipnew', 'NIP Baru', 'required|trim|min_length[4]|max_length[18]|callback_unique_edit_nipnew');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'min_length[1]|max_length[1]');
        $this->form_validation->set_rules('tragama_id', 'Agama', 'min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('gol_darah', 'Golongan Darah', 'min_length[1]|max_length[1]|is_natural_no_zero');
        $this->form_validation->set_rules('trstatuspernikahan_id', 'Golongan Darah', 'min_length[1]|max_length[1]|alpha');
        $this->form_validation->set_rules('hobi', 'Hobi', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tpt_lahir', 'Tempat Lahir', 'min_length[2]|max_length[50]');
        $this->form_validation->set_rules('trprovinsilahir_id', 'Tempat Provinsi Lahir', 'min_length[2]|max_length[2]|is_natural');
        $this->form_validation->set_rules('trkabupatenlahir_id', 'Tempat Kabupaten Lahir', 'min_length[1]|max_length[5]');
        $this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'min_length[10]|max_length[10]');
        $this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'numeric');
        $this->form_validation->set_rules('rambut', 'Bentuk Rambut', 'max_length[35]');
        $this->form_validation->set_rules('berat_badan', 'Berat Badan', 'numeric');
        $this->form_validation->set_rules('bentuk_muka', 'Bentuk Muka', 'max_length[35]');
        $this->form_validation->set_rules('ciri_khas', 'Ciri Khas', 'max_length[35]');
        $this->form_validation->set_rules('warna_kulit', 'Warna Kulit', 'max_length[35]');
        $this->form_validation->set_rules('alamat', 'Jalan', 'max_length[500]');
        $this->form_validation->set_rules('rt', 'RT', 'max_length[16]');
        $this->form_validation->set_rules('rw', 'RW', 'max_length[4]');
        $this->form_validation->set_rules('trprovinsitinggal_id', 'Provinsi Tinggal', 'min_length[2]|max_length[2]|is_natural');
        $this->form_validation->set_rules('trkabupatentinggal_id', 'Kabupaten Tinggal', 'min_length[1]|max_length[5]');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'max_length[50]');
        $this->form_validation->set_rules('kodepos', 'Kodepos', 'max_length[5]');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'max_length[50]');
        $this->form_validation->set_rules('telp_rmh', 'Telp Rumah', 'max_length[32]');
        $this->form_validation->set_rules('telp_hp', 'Telp HP', 'max_length[16]');
        $this->form_validation->set_rules('no_karpeg', 'No Karpeg', 'max_length[64]');
        $this->form_validation->set_rules('no_karisu', 'No Karis / Karsu', 'max_length[64]');
        $this->form_validation->set_rules('no_tapen', 'No Taspen', 'max_length[64]');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'max_length[36]');
        $this->form_validation->set_rules('no_askes', 'No Askes', 'max_length[64]');
        $this->form_validation->set_rules('no_npwp', 'No NPWP', 'max_length[64]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $data_pegawai = $this->master_pegawai_model->get_by_id($id);

            $kablahir = NULL;
            if (!empty($_POST['trkabupatenlahir_id']) && $this->input->post('trkabupatenlahir_id') != '-1') {
                $kablahir = ltrim(rtrim($this->input->post('trkabupatenlahir_id', TRUE)));
            }
            $kabtinggal = NULL;
            if (!empty($_POST['trkabupatentinggal_id']) && $this->input->post('trkabupatentinggal_id') != '-1') {
                $kabtinggal = ltrim(rtrim($this->input->post('trkabupatentinggal_id', TRUE)));
            }

            $post = [
                "TRSTATUSKEPEGAWAIAN_ID" => ltrim(rtrim($this->input->post('trstatuskepegawaian_id', TRUE))),
                "NIP" => ltrim(rtrim($this->input->post('nipold', TRUE))),
                "NIPNEW" => ltrim(rtrim($this->input->post('nipnew', TRUE))),
                "GELAR_DEPAN" => ltrim(rtrim($this->input->post('gelar_dpn', TRUE))),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap', TRUE))),
                "GELAR_BLKG" => ltrim(rtrim($this->input->post('gelar_blkg', TRUE))),
                "SEX" => ltrim(rtrim($this->input->post('jk', TRUE))),
                "TRAGAMA_ID" => ltrim(rtrim($this->input->post('tragama_id', TRUE))),
                "TRGOLDARAH_ID" => ltrim(rtrim($this->input->post('gol_darah', TRUE))),
                "TRSTATUSPERNIKAHAN_ID" => ltrim(rtrim($this->input->post('trstatuspernikahan_id', TRUE))),
                "HOBI" => ltrim(rtrim($this->input->post('hobi', TRUE))),
                "TPTLAHIR" => ltrim(rtrim($this->input->post('tpt_lahir', TRUE))),
                "TRPROPINSI_ID_LAHIR" => ltrim(rtrim($this->input->post('trprovinsilahir_id', TRUE))),
                "TRKABUPATEN_ID_LAHIR" => $kablahir,
                "TINGGI_BADAN" => ltrim(rtrim($this->input->post('tinggi_badan', TRUE))),
                "RAMBUT" => ltrim(rtrim($this->input->post('rambut', TRUE))),
                "BERAT_BADAN" => ltrim(rtrim($this->input->post('berat_badan', TRUE))),
                "BENTUK_MUKA" => ltrim(rtrim($this->input->post('bentuk_muka', TRUE))),
                "CIRI_KHAS" => ltrim(rtrim($this->input->post('ciri_khas', TRUE))),
                "WARNA_KULIT" => ltrim(rtrim($this->input->post('warna_kulit', TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat', TRUE))),
                "PROPINSI" => ltrim(rtrim($this->input->post('trprovinsitinggal_id', TRUE))),
                "RT" => ltrim(rtrim($this->input->post('rt', TRUE))),
                "RW" => ltrim(rtrim($this->input->post('rw', TRUE))),
                "KABUPATEN" => $kabtinggal,
                "KELURAHAN" => ltrim(rtrim($this->input->post('kelurahan', TRUE))),
                "KODEPOS" => ltrim(rtrim($this->input->post('kodepos', TRUE))),
                "KECAMATAN" => ltrim(rtrim($this->input->post('kecamatan', TRUE))),
                "TELP_RMH" => ltrim(rtrim($this->input->post('telp_rmh', TRUE))),
                "TELP_HP" => ltrim(rtrim($this->input->post('telp_hp', TRUE))),
                "NO_KARPEG" => ltrim(rtrim($this->input->post('no_karpeg', TRUE))),
                "NO_KARIS" => ltrim(rtrim($this->input->post('no_karisu', TRUE))),
                "NO_TASPEN" => ltrim(rtrim($this->input->post('no_tapen', TRUE))),
                "NO_KTP" => ltrim(rtrim($this->input->post('no_ktp', TRUE))),
                "NO_ASKES" => ltrim(rtrim($this->input->post('no_askes', TRUE))),
                "NO_NPWP" => ltrim(rtrim($this->input->post('no_npwp', TRUE))),
                "NO_BPJS" => ltrim(rtrim($this->input->post('no_bpjs', TRUE))),
                'EMAIL' => ltrim(rtrim($this->input->post('email', TRUE))),
                'HOBI' => ltrim(rtrim($this->input->post('hobi', TRUE)))
            ];
            $tanggal = [
                "TGLLAHIR" => ltrim(rtrim(datepickertodb($this->input->post('tgllahir', TRUE))))
            ];

            $arrayerrorupload = [];
            if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']))) {
                mkdir($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']), 0777);
            }

            if (trim($data_pegawai['NIP']) != trim($this->input->post('nipold', TRUE))) {
                rename($this->config->item('uploadpath') . "doc_pegawai/" . trim($data_pegawai['NIP']), $this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)));
            }

            $dokumen = [];
            if (!empty($_FILES['doc_karpeg']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_karpeg.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_karpeg.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_karpeg.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_karpeg')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                        $dokumen = $dokumen + ['DOC_KARPEG' => $config['file_name']];
                    else
                        $dokumen = $dokumen + ['DOC_KARPEG' => NULL];
                }
                unset($config);
            }

            if (!empty($_FILES['doc_karisu']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_karis.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_karis.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_karis.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_karisu')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                        $dokumen = $dokumen + ['DOC_KARIS' => $config['file_name']];
                    else
                        $dokumen = $dokumen + ['DOC_KARIS' => NULL];
                }
                unset($config);
            }

            if (!empty($_FILES['doc_tapen']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_tapen.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_tapen.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_tapen.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_tapen')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name'])) {
                        $dokumen = $dokumen + ['DOC_TASPEN' => $config['file_name']];
                    } else
                        $dokumen = $dokumen + ['DOC_TASPEN' => NULL];
                }
                unset($config);
            }

            if (!empty($_FILES['doc_ktp']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_ktp.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_ktp.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_ktp.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_ktp')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                        $dokumen = $dokumen + ['DOC_KTP' => $config['file_name']];
                    else
                        $dokumen = $dokumen + ['DOC_KTP' => NULL];
                }
                unset($config);
            }

            if (!empty($_FILES['doc_askes']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_akses.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_askes.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_askes.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_askes')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                        $dokumen = $dokumen + ['DOC_ASKES' => $config['file_name']];
                    else
                        $dokumen = $dokumen + ['DOC_ASKES' => NULL];
                }
                unset($config);
            }

            if (!empty($_FILES['doc_npwp']['name'])) {
                if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_npwp.pdf")) {
                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/doc_npwp.pdf");
                }
                $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . trim($this->input->post('nipold', TRUE));
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '2048';
                $config['overwrite'] = false;
                $config['file_name'] = "doc_npwp.pdf";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('doc_npwp')) {
                    if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . trim($this->input->post('nipold', TRUE)) . "/" . $config['file_name']))
                        $dokumen = $dokumen + ['DOC_NPWP' => $config['file_name']];
                    else
                        $dokumen = $dokumen + ['DOC_NPWP' => NULL];
                }
                unset($config);
            }

            if ($this->master_pegawai_model->update($post, $tanggal, $id)) {
//                $this->Log_model->insert_log("Ubah","Biodata Pegawai Dengan NIP ".(isset($data_pegawai['NIPNEW']) ? $data_pegawai['NIPNEW'] : $data_pegawai['NIP']));
                
                if (count(array_filter($dokumen)) > 0)
                    $this->master_pegawai_model->update_custom($dokumen, ["NIP" => trim($this->input->post('nipold', TRUE)), "NIPNEW" => trim($this->input->post('nipnew', TRUE))]);

                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->master_pegawai_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? ", " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai font-green-jungle" style="font-weight:600;" title="Ubah Data">' . $val->NIPNEW . '</a>';
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == 1) ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT;
            $row[] = $val->TMT_GOL;
            $row[] = $val->N_JABATAN;
            $row[] = $val->TMT_JABATAN;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>&nbsp;<a href="' . site_url('master_pegawai/drhs?id=' . $val->ID) . '" target="_blank" class="btn btn-icon-only btn-default" title="Daftar Riwayat Hidup Singkat"><i class="fa fa-newspaper-o"></i></a>&nbsp;<a target="_blank" class="btn btn-icon-only btn-default" href="' . site_url('master_pegawai/drp?id=' . $val->ID) . '" title="Daftar Riwayat Pekerjaan"><i class="fa fa-newspaper-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function index_struktural() {
        $this->data['create'] = 0;
        $this->data['title_utama'] = 'Daftar Pegawai Struktural';
        $this->data['content'] = 'master_pegawai/index_struktural';
        $this->data['list_lokasi_filter'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_status_kepegawaian_filter'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['list_golongan_pangkat_filter'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_filter'] = $this->list_model->list_eselon_struktural();
        $this->data['list_kelompok_fungsional_filter'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_sts_nikah_filter'] = $this->list_model->list_sts_nikah();
        $this->data['list_pendidikan_filter'] = $this->list_model->list_pendidikan();
        $this->data['list_jk_filter'] = $this->config->item('list_jk');
        $this->data['list_tingkat_diklat_kepemimpinan_filter'] = $this->list_model->list_tingkat_diklat_kepemimpinan();
        $this->load->view('layouts/main', $this->data);
    }

    public function ajax_list_struktural() {
        $list = $this->master_pegawai_model->get_datatables(1);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? " " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai font-green-jungle" style="font-weight:600;" title="Ubah Data">' . $val->NIPNEW . '</a>';
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == 1) ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT;
            $row[] = $val->TMT_GOL;
            $row[] = $val->N_JABATAN;
            $row[] = $val->TMT_JABATAN;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>&nbsp;<a href="' . site_url('master_pegawai/drhs?id=' . $val->ID) . '" target="_blank" class="btn btn-icon-only btn-default" title="Daftar Riwayat Hidup Singkat"><i class="fa fa-newspaper-o"></i></a>&nbsp;<a target="_blank" class="btn btn-icon-only btn-default" href="' . site_url('master_pegawai/drp?id=' . $val->ID) . '" title="Daftar Riwayat Pekerjaan"><i class="fa fa-newspaper-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_model->count_filtered(1),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function index_fungsional() {
        $this->data['create'] = 0;
        $this->data['title_utama'] = 'Daftar Pegawai Fungsional Tertentu';
        $this->data['content'] = 'master_pegawai/index_fungsional';
        $this->data['list_lokasi_filter'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_status_kepegawaian_filter'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['list_golongan_pangkat_filter'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_filter'] = $this->list_model->list_eselon_struktural();
        $this->data['list_kelompok_fungsional_filter'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_sts_nikah_filter'] = $this->list_model->list_sts_nikah();
        $this->data['list_pendidikan_filter'] = $this->list_model->list_pendidikan();
        $this->data['list_jk_filter'] = $this->config->item('list_jk');
        $this->data['list_tingkat_diklat_kepemimpinan_filter'] = $this->list_model->list_tingkat_diklat_kepemimpinan();
        $this->load->view('layouts/main', $this->data);
    }

    public function ajax_list_fungsional() {
        $list = $this->master_pegawai_model->get_datatables(2);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? " " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai font-green-jungle" style="font-weight:600;" title="Ubah Data">' . $val->NIPNEW . '</a>';
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == 1) ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT;
            $row[] = $val->TMT_GOL;
            $row[] = $val->N_JABATAN;
            $row[] = $val->TMT_JABATAN;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/detail?id=' . $val->ID) . '" class="btndetailpegawai btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>&nbsp;<a href="' . site_url('master_pegawai/drhs?id=' . $val->ID) . '" target="_blank" class="btn btn-icon-only btn-default" title="Daftar Riwayat Hidup Singkat"><i class="fa fa-newspaper-o"></i></a>&nbsp;<a target="_blank" class="btn btn-icon-only btn-default" href="' . site_url('master_pegawai/drp?id=' . $val->ID) . '" title="Daftar Riwayat Pekerjaan"><i class="fa fa-newspaper-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_model->count_filtered(2),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit_nip() {
        $model = $this->master_pegawai_model->check_unique_edit_by_id($this->input->get('id'), 'NIP', $this->input->post('nipold'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit_nip', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function unique_edit_nipnew() {
        $model = $this->master_pegawai_model->check_unique_edit_by_id($this->input->get('id'), 'NIPNEW', $this->input->post('nipnew'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit_nipnew', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function view_dokumen() {
        $this->output->delete_cache();
        $model = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), 'NIP');
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . $model['NIP'] . "/" . $this->input->get('dokumen') . ".pdf")) {
                $this->data['file'] = base_url() . "_uploads/doc_pegawai/" . $model['NIP'] . "/" . $this->input->get('dokumen') . ".pdf";
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }

    public function ubahfoto() {
        $this->data['id'] = $this->input->get('id', TRUE);
        if (isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name'])) {
            $data_pegawai = $this->master_pegawai_model->get_by_id($this->input->get('id'));
            
            $pathinfo = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $config['upload_path'] = $this->config->item('uploadpath') . 'photo_pegawai/thumbs';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '1024';
            $config['overwrite'] = true;
            $config['file_name'] = str_replace("/", "_", $data_pegawai['NIP']) . ".".$pathinfo;
            $namafile = str_replace("/", "_", $data_pegawai['NIP']) . ".".$pathinfo;
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (file_exists($this->config->item('uploadpath') . "photo_pegawai/thumbs/" . $data_pegawai['FOTO'])) {
                unlink($this->config->item('uploadpath') . "photo_pegawai/thumbs/" . $data_pegawai['FOTO']);
            }
            
            if ($this->upload->do_upload('foto')) {
                if ($this->master_pegawai_model->update_custom(['FOTO' => $namafile], ['ID' =>$data_pegawai['ID']])) {
                    echo json_encode(['status' => 1, 'success' => 'Record update successfully.', 'data' => $config['file_name']]);
                } else {
                    echo json_encode(['status' => 2]);
                }
            } else {
                echo json_encode(['status' => 2]);
            }
        } else {
            $this->load->view('master_pegawai/ubahfoto', $this->data);
        }
    }

    public function drhs() {
        $this->data['content'] = 'master_pegawai/drhs';
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? trim($this->input->get('id', TRUE)) : 0;

        $this->data['pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['pangkat'] = $this->master_pegawai_model->pangkat_mutakhir($id);
        $this->data['jabatan'] = $this->master_pegawai_model->jabatan_mutakhir($id);
        $this->data['pendidikan'] = $this->master_pegawai_model->pendidikan_mutakhir($id);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->load->view('layouts/main', $this->data);
    }

    public function drp() {
        $this->data['content'] = 'master_pegawai/drp';
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? trim($this->input->get('id', TRUE)) : 0;

        $this->data['pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['pangkat'] = $this->master_pegawai_model->pangkat_mutakhir($id);
        $this->data['jabatan'] = $this->master_pegawai_model->jabatan_mutakhir($id);
        $this->data['pendidikan'] = $this->laporan_drh_model->get_data_pegawai_pendidikan($id);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->load->view('layouts/main', $this->data);
    }

    public function export_excel() {
        $model = $this->master_pegawai_model->get_datatables_query_cetak();
        $jumlah = count($model);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Kepegawaian")
                ->setLastModifiedBy("Kepegawaian")
                ->setTitle($this->config->item('instansi_panjang'))
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription($this->data['title_utama'])
                ->setKeywords($this->data['title_utama'])
                ->setCategory($this->data['title_utama']);

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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Daftar Pegawai');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $judul = 2;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':G' . $judul);
        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':G' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, "No")
                ->setCellValue('B' . $judultabel, "Nama")
                ->setCellValue('C' . $judultabel, "NIP")
                ->setCellValue('D' . $judultabel, "Golongan")
                ->setCellValue('E' . $judultabel, "TMT Golongan")
                ->setCellValue('F' . $judultabel, "Jabatan - Unit Organisasi")
                ->setCellValue('G' . $judultabel, "TMT Jabatan");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':G' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':G' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':G' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        unset($styleArray);
        $j = $judultabel + 1;
        $no_detail = 1;
        if ($model) {
            foreach ($model as $val) {
                $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? " " . $val->GELAR_BLKG : '');
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, $nama)
                        ->setCellValue('C' . $j, "`" . $val->NIPNEW)
                        ->setCellValue('D' . $j, ($val->TRSTATUSKEPEGAWAIAN_ID == 1) ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT)
                        ->setCellValue('E' . $j, $val->TMT_GOL)
                        ->setCellValue('F' . $j, $val->N_JABATAN)
                        ->setCellValue('G' . $j, $val->TMT_JABATAN);

                $no_detail++;
                $j++;
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR PEGAWAI ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle($this->data['title_utama']);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function export_excel_drhs() {
        $id = $this->input->get('id',true);
        $objPHPExcel = new PHPExcel();
        // Set properties
        //echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle($this->config->item('title_lembaga'))
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
        $data = $this->master_pegawai_model->get_by_id($id);
        $pangkat = $this->master_pegawai_model->pangkat_mutakhir($id);
        $jabatan = $this->master_pegawai_model->jabatan_mutakhir($id);
        $data_pendidikan = $this->laporan_drh_model->get_data_pegawai_pendidikan($id);
        $data_jabatan = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $data_penghargaan = $this->laporan_drh_model->get_data_pegawai_penghargaan($data['ID']);
        $list_bulan = $this->list_model->list_bulan();
        /* -----------------------------------------------------------------I. keterangan perorangan------------------------------------------------------------------- */

        $path_file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', base_url());
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
                ->setCellValue('B11', 'NAMA LENGKAP')
                ->setCellValue('A12', '2')
                ->setCellValue('B12', 'NIP')
                ->setCellValue('A13', '3')
                ->setCellValue('B13', 'Tempat, Tgl.Lahir')
                ->setCellValue('A14', '4')
                ->setCellValue('B14', 'Pangkat / Golongan Ruang')
                ->setCellValue('A15', '5')
                ->setCellValue('B15', 'Jabatan Terakhir')
                ->setCellValue('A16', '6')
                ->setCellValue('B16', 'Instansi')
                ->setCellValue('A17', '7')
                ->setCellValue('B17', 'Jenis Kelamin')
                ->setCellValue('A18', '8')
                ->setCellValue('B18', 'Agama')
                ->setCellValue('A19', '9')
                ->setCellValue('B19', 'Pendidikan Terakhir')
                ->setCellValue('A20', '10')
                ->setCellValue('B20', 'Alamat Rumah')
                ->setCellValue('C20', 'a.jalan')
                ->setCellValue('C21', 'b.kelurahan desa')
                ->setCellValue('C22', 'c.kecamatan')
                ->setCellValue('C23', 'd.kabupaten/kodya')
                ->setCellValue('C24', 'e.provinsi');

        //utk membuat garis
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:I8');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:G9');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('B12:D12');
        $objPHPExcel->getActiveSheet()->mergeCells('B13:D13');
        $objPHPExcel->getActiveSheet()->mergeCells('B14:D14');
        $objPHPExcel->getActiveSheet()->mergeCells('B15:D15');
        $objPHPExcel->getActiveSheet()->mergeCells('B16:D16');
        $objPHPExcel->getActiveSheet()->mergeCells('B17:D17');
        $objPHPExcel->getActiveSheet()->mergeCells('B18:D18');
        $objPHPExcel->getActiveSheet()->mergeCells('B19:D19');
        $objPHPExcel->getActiveSheet()->mergeCells('C18:D18');
        $objPHPExcel->getActiveSheet()->mergeCells('C19:D19');
        $objPHPExcel->getActiveSheet()->mergeCells('C20:D20');
        $objPHPExcel->getActiveSheet()->mergeCells('C21:D21');
        $objPHPExcel->getActiveSheet()->mergeCells('C22:D22');
        $objPHPExcel->getActiveSheet()->mergeCells('C23:D23');
        $objPHPExcel->getActiveSheet()->mergeCells('C24:D24');
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

        $objPHPExcel->getActiveSheet()->getStyle('I2:I8')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A11:I24')->applyFromArray($styleArray);
        if ($data['NIPNEW'] == '' or $data['NIPNEW'] == Null) {
            $nip = $data['NIP'];
        } else {
            $nip = $data['NIPNEW'];
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'DAFTAR RIWAYAT HIDUP SINGKAT');
        $objPHPExcel->getActiveSheet()->getStyle('A2:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:F8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        //unset($styleArray);	
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A10', 'I')
                ->setCellValue('B10', 'KETERANGAN PERORANGAN');
        //$objPHPExcel->getActiveSheet()->getStyle('A10:B10')->applyFromArray($stylecss);
        if ($data['SEX'] == 'L') {
            $klm = "Laki-laki";
        } else {
            $klm = "Perempuan";
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E11', '' . (empty($data['GELAR_DEPAN']) ? '' : $data['GELAR_DEPAN'] . ' ') . $data['NAMA'] . (empty($data['GELAR_BLKG']) ? '' : ', ' . $data['GELAR_BLKG'] ) . '')
                ->setCellValue('E12', '\'' . $nip)
                ->setCellValue('E13', '' . $data['TPTLAHIR'] . ' ' . ', ' . ' ' . $data['TGLLAHIR2'])
                ->setCellValue('E14', '' . ($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT'])
                ->setCellValue('E15', '' . $jabatan['N_JABATAN'])
                ->setCellValue('E16', '' . "Badan Nasional Pencarian dan Pertolongan")
                ->setCellValue('E17', '' . $klm)
                ->setCellValue('E18', '' . $data['AGAMA'])
                ->setCellValue('E19', '' . $data_pendidikan[0]['TINGKAT_PENDIDIKAN']." ".$data_pendidikan[0]['NAMA_JURUSAN']." ".$data_pendidikan[0]['NAMA_UNIVERSITAS'])
                ->setCellValue('E20', '' . $data['ALAMAT'])
                ->setCellValue('E21', '' . $data['KELURAHAN'])
                ->setCellValue('E22', '' . $data['KECAMATAN']);

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

        $ip = 23;
        $ip_last = $ip + 1;

        /* -----------------------------------------------------------------IV. RIWAYAT PEKERJAAN-------------------------------------------------------------------- */
        //  1. ------------  Riwayat Kepangkatan Golongan Ruang Penggajian  -----------------------
        $firts = $ip_last + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'II')
                ->setCellValue('B' . $firts, 'RIWAYAT PEKERJAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $firts . ':C' . $firts);

        //  ---------------------  2.Pengalaman Jabatan /Pekerjaan  -------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $judul = $ip_last + 5;
        $penanda = $ip_last + 6;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'PANGKAT/GOLONGAN')
                ->setCellValue('C' . $pnhead, 'JABATAN')
                ->setCellValue('B' . $merge, 'RUANG')
                ->setCellValue('B' . $judul, 'TMT')
                ->setCellValue('C' . $judul, 'NAMA JABATAN')
                ->setCellValue('F' . $judul, 'PEJABAT YANG MENETAPKAN')
                ->setCellValue('H' . $judul, 'NOMOR DAN TANGGAL SKEP')
                ->setCellValue('A' . $penanda, '1')
                ->setCellValue('B' . $penanda, '2')
                ->setCellValue('C' . $penanda, '3')
                ->setCellValue('F' . $penanda, '4')
                ->setCellValue('H' . $penanda, '5');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $pnhead . ':A' . $judul);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $pnhead . ':I' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judul . ':E' . $judul);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $judul . ':G' . $judul);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $judul . ':I' . $judul);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $penanda . ':E' . $penanda);
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $penanda . ':G' . $penanda);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $penanda . ':I' . $penanda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $pnhead . ':I' . $merge)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $pnhead . ':I' . $merge)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $merge)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $judul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $judul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $ip = $penanda + 1;
        $no = 1;
        foreach ($data_jabatan as $rowj) {
            $mecah = explode(";;", $rowj['GOLPANGKAT']);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $ip)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $pnhead)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip . ':I' . $ip)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, (isset($mecah[0]) ? $mecah[0] : '') . "\n" . (isset($mecah[1]) ? $mecah[1] : ''))
                    ->setCellValue('C' . $ip, $rowj['N_JABATAN'])
                    ->setCellValue('F' . $ip, $rowj['PEJABAT_SK'])
                    ->setCellValue('H' . $ip, $rowj['NO_SK'] . " " . $rowj['TMT_JABATAN2']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $ip . ':E' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $ip . ':G' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);

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
        $pntitlelagi = $ip_last + 4;
        $pntitlelagilah = $ip_last + 5;
        $pnhead = $ip_last + 6;
        $merge = $ip_last + 7;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'III')
                ->setCellValue('B' . $firts, 'TANDA KEHORMATAN YANG TELAH DIMILIKI')
                ->setCellValue('A' . $pntitle, 'NO')
                ->setCellValue('B' . $pntitle, 'NAMA BINTANG')
                ->setCellValue('E' . $pntitle, 'SURAT KEPUTUSAN')
                ->setCellValue('H' . $pntitle, 'NAMA NEGARA/')
                ->setCellValue('B' . $pntitlelagi, 'SATYALANCANA')
                ->setCellValue('E' . $pntitlelagi, 'NOMOR')
                ->setCellValue('G' . $pntitlelagi, 'TANGGAL')
                ->setCellValue('H' . $pntitlelagi, 'INSTANSI')
                ->setCellValue('A' . $pntitlelagilah, '1')
                ->setCellValue('B' . $pntitlelagilah, '2')
                ->setCellValue('E' . $pntitlelagilah, '3')
                ->setCellValue('G' . $pntitlelagilah, '4')
                ->setCellValue('H' . $pntitlelagilah, '5');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitle . ':D' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $pntitle . ':A' . $pntitlelagi);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitlelagi . ':D' . $pntitlelagi);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitle . ':G' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitlelagi . ':F' . $pntitlelagi);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pntitle . ':I' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pntitlelagi . ':I' . $pntitlelagi);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pntitlelagilah . ':D' . $pntitlelagilah);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pntitlelagilah . ':F' . $pntitlelagilah);
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $pntitlelagilah . ':I' . $pntitlelagilah);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $pntitle)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $pntitlelagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $pntitlelagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $pntitle)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $pntitlelagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $pntitlelagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $pntitlelagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitlelagilah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $pntitlelagilah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $pntitlelagilah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $pntitlelagilah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $pntitlelagilah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $pntitle)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $ip = $pnhead + 0;
        $no = 1;
        foreach ($data_penghargaan as $rowp) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $rowp['JENIS_TANDA_JASA']." ".$rowp['TANDA_JASA'])
                    ->setCellValue('E' . $ip, $rowp['NOMOR'])
                    ->setCellValue('G' . $ip, $rowp['THN_PRLHN'])
                    ->setCellValue('H' . $ip, $rowp['NAMA_NEGARA']." ".$rowp['INSTANSI']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $ip)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('H' . $ip . ':I' . $ip);
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


        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $custom1 = $ip_last + 7;
        $custom2 = $ip_last + 8;
        $custom3 = $ip_last + 9;
        $custom4 = $ip_last + 10;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G' . $pntitle, date('d-m-Y'))
                ->setCellValue('G' . $pnhead, 'YANG MEMBUAT,')
                ->setCellValue('G' . $custom2, (empty($data['GELAR_DEPAN']) ? '' : $data['GELAR_DEPAN'] . ' ') . $data['NAMA'] . (empty($data['GELAR_BLKG']) ? '' : ', ' . $data['GELAR_BLKG'] ) . '')
                ->setCellValue('G' . $custom3, "NIP. " . $nip)
                ->setCellValue('G' . $custom4, ($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT']);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pntitle . ':I' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $custom1);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $custom2 . ':I' . $custom2);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */

        /* --------------------------------------------------------- .footer -------------------------------------------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDaftar Riwayat Hidup Singkat');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Printing');


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
    }
    
    public function export_pdf_drhs() {
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? trim($this->input->get('id', TRUE)) : 0;

        $this->data['pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['pangkat'] = $this->master_pegawai_model->pangkat_mutakhir($id);
        $this->data['jabatan'] = $this->master_pegawai_model->jabatan_mutakhir($id);
        $this->data['pendidikan'] = $this->master_pegawai_model->pendidikan_mutakhir($id);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->data['content'] = 'master_pegawai/drhs_pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->set_options(['isRemoteEnabled'=>TRUE]);
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream("Daftar Rwayat Hidup Singkat Periode ". month_indo(date('m')) . " " . date("Y"));
    }
    
    public function export_excel_drhp() {
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? trim($this->input->get('id', TRUE)) : 0;
        $objPHPExcel = new PHPExcel();
        // Set properties
        //echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle($this->config->item('title_lembaga'))
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
        $data = $this->master_pegawai_model->get_by_id($id);
        $pangkat = $this->master_pegawai_model->pangkat_mutakhir($id);
        $jabatan = $this->master_pegawai_model->jabatan_mutakhir($id);
        $data_pendidikan = $this->laporan_drh_model->get_data_pegawai_pendidikan($id);
        $data_jabatan = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $data_penghargaan = $this->laporan_drh_model->get_data_pegawai_penghargaan($id);
        
        $list_bulan = $this->list_model->list_bulan();
        /* -----------------------------------------------------------------I. keterangan perorangan------------------------------------------------------------------- */

        $path_file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', base_url());
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
                ->setCellValue('B11', 'NAMA LENGKAP')
                ->setCellValue('A12', '2')
                ->setCellValue('B12', 'NIP')
                ->setCellValue('A13', '3')
                ->setCellValue('B13', 'Tempat, Tgl.Lahir')
                ->setCellValue('A14', '4')
                ->setCellValue('B14', 'Pangkat / Golongan Ruang / TMT')
                ->setCellValue('A15', '5')
                ->setCellValue('B15', 'Jabatan / Eselon')
                ->setCellValue('A16', '6')
                ->setCellValue('B16', 'Pendidikan');

        //utk membuat garis
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:I8');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:G9');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('B12:D12');
        $objPHPExcel->getActiveSheet()->mergeCells('B13:D13');
        $objPHPExcel->getActiveSheet()->mergeCells('B14:D14');
        $objPHPExcel->getActiveSheet()->mergeCells('B15:D15');
        /* ------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->mergeCells('E11:I11');
        $objPHPExcel->getActiveSheet()->mergeCells('E12:I12');
        $objPHPExcel->getActiveSheet()->mergeCells('E13:I13');
        $objPHPExcel->getActiveSheet()->mergeCells('E14:I14');
        $objPHPExcel->getActiveSheet()->mergeCells('E15:I15');
        $objPHPExcel->getActiveSheet()->mergeCells('E16:I16');

        $objPHPExcel->getActiveSheet()->getStyle('I2:I8')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A11:I21')->applyFromArray($styleArray);
        if ($data['NIPNEW'] == '' or $data['NIPNEW'] == Null) {
            $nip = $data['NIP'];
        } else {
            $nip = $data['NIPNEW'];
        }
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'DAFTAR RIWAYAT PEKERJAAN');
        $objPHPExcel->getActiveSheet()->getStyle('A2:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:F8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        //unset($styleArray);	
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A10', 'I')
                ->setCellValue('B10', 'KETERANGAN PERORANGAN');
        //$objPHPExcel->getActiveSheet()->getStyle('A10:B10')->applyFromArray($stylecss);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E11', '' . (empty($data['GELAR_DEPAN']) ? '' : $data['GELAR_DEPAN'] . ' ') .$data['NAMA'] . (empty($data['GELAR_BLKG']) ? '' : ', ' . $data['GELAR_BLKG'] ). '')
                ->setCellValue('E12', '\'' . $nip)
                ->setCellValue('E13', '' . $data['TPTLAHIR'] . ' ' . ', ' . ' ' . $data['TGLLAHIR2'])
                ->setCellValue('E14', '' . (($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT']).' / '.($pangkat['TMT_GOL2']))
                ->setCellValue('E15', '' . $jabatan['N_JABATAN']." / ".$jabatan['ESELON']);
        $ip = 16;
        $no = 1;
        foreach ($data_pendidikan as $rowj) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $ip, $no.". ".$rowj['TINGKAT_PENDIDIKAN'] . " " . $rowj['NAMA_JURUSAN'] . " " . $rowj['NAMA_LBGPDK']);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$ip.':D'.$ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E'.$ip.':I'.$ip);
            $no++;
            $ip++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ip, '7')->setCellValue('B'.$ip, 'Status Perkawinan')->setCellValue('E'.$ip, $data['PERNIKAHAN']);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$ip.':D'.$ip);
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$ip.':I'.$ip);

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

        $ip = 23;
        $ip_last = $ip + 1;
        
        /* -----------------------------------------------------------------IV. RIWAYAT PEKERJAAN-------------------------------------------------------------------- */
        //  1. ------------  Riwayat Kepangkatan Golongan Ruang Penggajian  -----------------------
        $firts = $ip_last + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $firts, 'II')
                ->setCellValue('B' . $firts, 'RIWAYAT PEKERJAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $firts . ':C' . $firts);
        
        //  ---------------------  2.Pengalaman Jabatan /Pekerjaan  -------------------------------------
        $firts = $ip_last + 2;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $merge = $ip_last + 4;
        $judul = $ip_last + 5;
        $penanda = $ip_last + 6;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $pnhead, 'NO')
                ->setCellValue('B' . $pnhead, 'RIWAYAT PEKERJAAN')
                ->setCellValue('E' . $pnhead, 'DARI TGL/BLN/TH S/D TGL/BLN/TH')
                ->setCellValue('G' . $pnhead, 'GOL. RUANG')
                ->setCellValue('H' . $pnhead, 'INSTANSI INDUK')
                ->setCellValue('I' . $pnhead, 'KETERANGAN')
                ->setCellValue('A' . $merge, '1')
                ->setCellValue('B' . $merge, '2')
                ->setCellValue('E' . $merge, '3')
                ->setCellValue('G' . $merge, '4')
                ->setCellValue('H' . $merge, '5')
                ->setCellValue('I' . $merge, '6');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $pnhead . ':D' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $pnhead . ':F' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $merge . ':D' . $merge);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $merge . ':F' . $merge);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$pnhead.':I'.$merge)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$pnhead.':I'.$merge)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$merge)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$judul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$judul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$penanda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
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
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ip, $no)
                    ->setCellValue('B' . $ip, $rowj['N_JABATAN'])
                    ->setCellValue('E' . $ip, $rowj['TMT_JABATAN2'].(!empty($rowj['TGL_AKHIR2']) ? $rowj['TGL_AKHIR2'] : ''))
                    ->setCellValue('G' . $ip, (isset($mecah[1]) ? $mecah[1] : ''))
                    ->setCellValue('H' . $ip, "Basarnas")
                    ->setCellValue('I' . $ip, "");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$ip)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->mergeCells('B' . $ip . ':D' . $ip);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $ip . ':F' . $ip);
            
            $no++;
            $ip++;
        }
        if (count($data_jabatan) == 0) {
            $ip_last = $ip + 1;
        } else {
            $ip_last = $ip - 1;
        }
        
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pnhead . ':I' . $ip_last)->applyFromArray($styleArray);
        /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */


        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */
        $firts = $ip_last + 1;
        $pntitle = $ip_last + 2;
        $pnhead = $ip_last + 3;
        $custom1 = $ip_last + 7;
        $custom2 = $ip_last + 8;
        $custom3 = $ip_last + 9;
        $custom4 = $ip_last + 10;
        $merge = $ip_last + 4;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G' . $pntitle, date('d-m-Y'))
                ->setCellValue('G' . $pnhead, 'YANG MEMBUAT,')
                ->setCellValue('G' . $custom2, (empty($data['GELAR_DEPAN']) ? '' : $data['GELAR_DEPAN'] . ' ') .$data['NAMA'] . (empty($data['GELAR_BLKG']) ? '' : ', ' . $data['GELAR_BLKG'] ). '')
                ->setCellValue('G' . $custom3, "NIP. ".$nip)
                ->setCellValue('G' . $custom4, (($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT']));
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pntitle . ':I' . $pntitle);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $pnhead);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $pnhead . ':I' . $custom1);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $custom2 . ':I' . $custom2);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pntitle)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $pntitle . ':I' . $pnhead)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        /* -----------------------------------------------------------------  kata kata ----------------------------------------------------------------------------------- */

        /* --------------------------------------------------------- .footer -------------------------------------------------------------------------------------------- */
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDaftar Riwayat Hidup Pekerjaan');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Printing');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        // Save Excel 2007 file
        //echo date('H:i:s') . " Write to Excel2007 format\n";
        // Echo memory peak usage
        //echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_DRP.xls"');
        header('Cache-Control: max-age=0');
        // Echo done
        //echo date('H:i:s') . " Done writing file.\r\n";

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function export_pdf_drhp() {
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? trim($this->input->get('id', TRUE)) : 0;

        $this->data['pegawai'] = $this->master_pegawai_model->get_by_id($id);
        $this->data['pangkat'] = $this->master_pegawai_model->pangkat_mutakhir($id);
        $this->data['jabatan'] = $this->master_pegawai_model->jabatan_mutakhir($id);
        $this->data['pendidikan'] = $this->master_pegawai_model->pendidikan_mutakhir($id);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($id);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->data['content'] = 'master_pegawai/drhs_pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->set_options(['isRemoteEnabled'=>TRUE]);
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream("Daftar Rwayat Hidup Singkat Periode ". month_indo(date('m')) . " " . date("Y"));
    }
    
    public function import_cpns() {
        $this->data['title_utama'] = "CPNS";
        $this->data['title_form'] = "CPNS";
        $this->data['content'] = 'master_pegawai/import_cpns';

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
                if (trim($objWorksheet->getCellByColumnAndRow(0, $row)) != "" && trim($objWorksheet->getCellByColumnAndRow(1, $row)) != "") {
                    $post = [
                        "TRSTATUSKEPEGAWAIAN_ID" => 1,
                        "NIP" => trim($objWorksheet->getCellByColumnAndRow(0, $row)),
                        "NIPNEW" => trim($objWorksheet->getCellByColumnAndRow(1, $row)),
                        "GELAR_DEPAN" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(2, $row))),
                        "NAMA" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(3, $row))),
                        "GELAR_BLKG" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(4, $row))),
                        "SEX" => trim($objWorksheet->getCellByColumnAndRow(5, $row)),
                        "TRAGAMA_ID" => trim($objWorksheet->getCellByColumnAndRow(6, $row)),
                        "TRGOLDARAH_ID" => trim($objWorksheet->getCellByColumnAndRow(7, $row)),
                        "TRSTATUSPERNIKAHAN_ID" => trim($objWorksheet->getCellByColumnAndRow(8, $row)),
                        "TPTLAHIR" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(9, $row)))
                    ];

                    $pecah = explode('-', trim(str_replace(" ", "",$objWorksheet->getCellByColumnAndRow(10, $row))));
                    $tanggal = [
                        "TGLLAHIR" => $pecah[2]."-".$pecah[1]."-".$pecah[0],
                    ];

                    if ($this->master_pegawai_model->insert($post, $tanggal)) {
                        $sukses++;
                    } else {
                        $tampung[] = trim($objWorksheet->getCellByColumnAndRow(0, $row));
                        $gagal++;
                    }
                } else {
                    $gagal++;
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
            redirect('/master_pegawai/import_cpns');
        }

        $this->load->view('layouts/main', $this->data);
    }
    
    public function format_excel_cpns() {
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NIP Lama');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'NIP Baru');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Gelar Depan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Nama Lengkap');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Gelar Belakang');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Jenis Kelamin');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Agama');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Golongan Darah');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Status Perkawinan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Tempat Lahir');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Tanggal Lahir');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Gunakan Tanda Petik 1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Gunakan Tanda Petik 1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', 'Kode Referensi Agama');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'Kode Gol Darah');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', 'Kode Status Perkawinan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', '30 - 08 - 2019');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', '<-- Contoh');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', '<-- Mulai di-sini');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('L2:L3')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->setTitle("Import CPNS");

        $list_agama = $this->list_model->list_agama();
        $list_gol_darah = $this->list_model->list_gol_darah();
        $list_sts_nikah = $this->list_model->list_sts_nikah();

        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'Referensi Jenis Kelamin');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Referensi Agama');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E2', 'Nama');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Referensi Golongan Darah');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H2', 'Nama');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J1', 'Referensi Status Perkawinan');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J2', 'Kode');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K2', 'Nama');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('D1:E1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('D1:E1');
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('G1:H1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('G2:H2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('G1:H1');
        $objPHPExcel->getActiveSheet()->getStyle('G2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('J1:K1')->applyFromArray($styleHeader);
        $objPHPExcel->getActiveSheet()->getStyle('J2:K2')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->mergeCells('J1:K1');
        $objPHPExcel->getActiveSheet()->getStyle('J2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J2:K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        // jenis kelamin
        $row = 3;
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', "L")->setCellValue('B3', "Laki-laki");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4', "P")->setCellValue('B4', "Perempuan");

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HIMPORT CPNS ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet(1)->setTitle("Referensi");
        $row = 3;
        foreach ($list_agama as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $row, $rowj['ID'])->setCellValue('E' . $row, $rowj['NAMA']);
            $row++;
        }
        
        $row = 3;
        foreach ($list_gol_darah as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $row, $rowj['ID'])->setCellValue('H' . $row, $rowj['NAMA']);
            $row++;
        }
        
        $row = 3;
        foreach ($list_sts_nikah as $rowj) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $row, $rowj['ID'])->setCellValue('K' . $row, $rowj['NAMA']);
            $row++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="IMPORT CPNS ' . date('d-m-Y') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function format_excel_import_biodata() {
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Karpeg');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Karsu');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Taspen');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'KTP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'NPWP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Askes');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'BPJS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '<-- Mulai di-sini');
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
        $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->applyFromArray($styleMerah);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleHeaderTable);
        $objPHPExcel->getActiveSheet()->setTitle("Import Biodata");

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HIMPORT BIODATA PEGAWAI ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="IMPORT BIODATA PEGAWAI ' . date('d-m-Y') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function import_biodata_pegawai() {
        $this->data['title_utama'] = "Biodata Pegawai";
        $this->data['title_form'] = "Biodata Pegawai";
        $this->data['content'] = 'master_pegawai/import_biodata';

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
            for ($row = 2; $row <= $highestRow; ++$row) {
                $getpegawai = $this->master_pegawai_model->get_by_nipnew_select(trim($objWorksheet->getCellByColumnAndRow(0, $row)), "ID");

                if (!empty($getpegawai['ID'])) {
                    $post = [
                        "NO_KARPEG" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(1, $row))),
                        "NO_KARIS" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(2, $row))),
                        "NO_TASPEN" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(3, $row))),
                        "NO_KTP" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(4, $row))),
                        "NO_NPWP" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(5, $row))),
                        "NO_ASKES" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(6, $row))),
                        "NO_BPJS" => ltrim(rtrim($objWorksheet->getCellByColumnAndRow(7, $row))),
                    ];
                    
                    if ($this->master_pegawai_model->update($post, [], $getpegawai['ID'])) {
                        $sukses++;
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
            redirect('/master_pegawai/import_biodata_pegawai');
        }

        $this->load->view('layouts/main', $this->data);
    }

}
