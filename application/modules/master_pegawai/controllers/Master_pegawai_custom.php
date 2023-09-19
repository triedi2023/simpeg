<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_custom extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/Master_pegawai_custom_model', 'master_pegawai/master_pegawai_pangkat_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Orang Tua Pegawai';
    }

    public function index() {
        if (!$this->input->is_ajax_request()) {
            redirect('master_pegawai/');
        }
        $this->data['id'] = $this->input->get('id');
        $this->data['data_pegawai'] = $this->master_pegawai_model->get_by_id_select($this->data['id'], "ID,TRSTATUSKEPEGAWAIAN_ID,NIP,NIPNEW,GELAR_DEPAN,NAMA,GELAR_BLKG,to_char(TGLLAHIR,'DD/MM/YYYY') as TGLLAHIR");
        $this->data['data_cpns'] = $this->master_pegawai_cpns_model->get_by_id($this->data['id']);
        $this->data['model'] = $this->master_pegawai_cpns_model->get_by_id($this->data['id']);
        $this->data['pangkat_cpns'] = $this->master_pegawai_pangkat_model->get_by_pegawai_idpangkat($this->data['id']);
        $this->data['list_status_kepegawaian'] = json_encode($this->list_model->list_status_kepegawaian_tree());
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat($this->data['data_pegawai']['TRSTATUSKEPEGAWAIAN_ID']);
        $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
        $this->data['list_eselon'] = $this->list_model->list_eselon();
        $this->data['list_jabatan'] = $this->list_model->list_jabatan(($this->data['data_cpns']['TRESELON_ID'] == "" ? '-1' : $this->data['data_cpns']['TRESELON_ID']));
        if (!empty($this->data['data_cpns']['TRLOKASI_ID'])) {
            $option = "";
            foreach ($this->list_model->list_lokasi_tree() as $val) {
                $selec = '';
                if ($val['id'] == $this->data['data_cpns']['TRLOKASI_ID']) {
                    $selec = 'selected=""';
                }
                if (isset($val['children']) && count(array_filter($val['children'])) > 0) {
                    $option .= '<optgroup label="' . $val['text'] . '">';
                    foreach ($val['children'] as $children) {
                        if ($children['id'] == $this->data['data_cpns']['TRLOKASI_ID']) {
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
            $this->data['list_lokasi_tree'] = json_encode($this->list_model->list_lokasi_tree());
        }
        if (!empty($this->data['data_cpns']['KDU1'])) {
            $this->data['list_kdu1'] = $this->list_model->list_kdu1($this->data['data_cpns']['TRLOKASI_ID']);
        }
        if (!empty($this->data['data_cpns']['KDU2'])) {
            $this->data['list_kdu2'] = $this->list_model->list_kdu2($this->data['data_cpns']['TRLOKASI_ID'], $this->data['data_cpns']['KDU1']);
        }
        if (!empty($this->data['data_cpns']['KDU3'])) {
            $this->data['list_kdu3'] = $this->list_model->list_kdu3($this->data['data_cpns']['TRLOKASI_ID'], $this->data['data_cpns']['KDU1'], $this->data['data_cpns']['KDU2']);
        }
        if (!empty($this->data['data_cpns']['KDU4'])) {
            $this->data['list_kdu4'] = $this->list_model->list_kdu4($this->data['data_cpns']['TRLOKASI_ID'], $this->data['data_cpns']['KDU1'], $this->data['data_cpns']['KDU2'], $this->data['data_cpns']['KDU3']);
        }
        if (!empty($this->data['data_cpns']['KDU5'])) {
            $this->data['list_kdu5'] = $this->list_model->list_kdu5($this->data['data_cpns']['TRLOKASI_ID'], $this->data['data_cpns']['KDU1'], $this->data['data_cpns']['KDU2'], $this->data['data_cpns']['KDU3'], $this->data['data_cpns']['KDU4']);
        }

        $this->load->view('master_pegawai/cpns/index', $this->data);
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pangkat', 'Pangkat', 'min_length[1]|max_length[3]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('tktpendidikan_id', 'Tingkat Pendidikan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('eselon', 'Eselon', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'min_length[1]|trim');
        $this->form_validation->set_rules('jabatan_nokoderef', 'Jabatan Tanpa Kode Referensi', 'min_length[1]|max_length[50]|regex_match[/^([a-z ])+$/i]');
        $this->form_validation->set_rules('unitkerjanokoderef', 'Unit Kerja Tanpa Kode Referensi', 'min_length[1]|max_length[100]|regex_match[/^([a-z,. ])+$/i]');
        $this->form_validation->set_rules('kdu1', 'Jabatan Pimpinan Tinggi Madya', 'trim');
        $this->form_validation->set_rules('kdu2', 'Jabatan Pimpinan Tinggi Pratama', 'trim');
        $this->form_validation->set_rules('kdu3', 'Jabatan Administrator', 'trim');
        $this->form_validation->set_rules('kdu4', 'Pengawas', 'trim');
        $this->form_validation->set_rules('kdu5', 'Pelaksana (Eselon V)', 'trim');
        $this->form_validation->set_rules('fiktif_thn', 'Masa Kerja Fiktif Tahun', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('fiktif_bln', 'Masa Kerja Fiktif Bulan', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('honorer_thn', 'Masa Kerja Honorer Tahun', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('honorer_bln', 'Masa Kerja Honorer Bulan', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('swasta_thn', 'Masa Kerja Swasta Tahun', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('swasta_bln', 'Masa Kerja Swasta Bulan', 'min_length[1]|max_length[2]|trim|is_natural');
        $this->form_validation->set_rules('no_sk', 'No SK', 'max_length[100]');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat', 'max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $lokasi = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : NULL;
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            $kodejabatan = (isset($_POST['jabatan_id']) && !empty($_POST['jabatan_id']) && $_POST['jabatan_id'] != -1) ? trim($this->input->post('jabatan_id', TRUE)) : NULL;

            $bln_masakerja = ltrim(rtrim($this->input->post('swasta_bln', TRUE))) + ltrim(rtrim($this->input->post('honorer_bln', TRUE))) + ltrim(rtrim($this->input->post('fiktif_bln', TRUE)));
            $thn_masakerja = ltrim(rtrim($this->input->post('swasta_thn', TRUE))) + ltrim(rtrim($this->input->post('honorer_thn', TRUE))) + ltrim(rtrim($this->input->post('fiktif_thn', TRUE)));

            $post = [
                "TRTKTPENDIDIKAN_ID" => trim($this->input->post('tktpendidikan_id', TRUE)),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon', TRUE))),
                "TRJABATAN_ID" => $kodejabatan,
                "NAMA_JABATAN_NOKODEREF" => ltrim(rtrim($this->input->post('jabatan_nokoderef', TRUE))),
                "TRLOKASI_ID" => $lokasi,
                "KDU1" => $kdu1,
                "KDU2" => $kdu2,
                "KDU3" => $kdu3,
                "KDU4" => $kdu4,
                "KDU5" => $kdu5,
                "UNITKERJA_NOKODEREF" => ltrim(rtrim($this->input->post('jabatan_nokoderef', TRUE))),
                "FIKTIF_TAHUN" => ltrim(rtrim($this->input->post('fiktif_thn', TRUE))),
                "FIKTIF_BULAN" => ltrim(rtrim($this->input->post('fiktif_bln', TRUE))),
                "HONORER_TAHUN" => ltrim(rtrim($this->input->post('honorer_thn', TRUE))),
                "HONORER_BULAN" => ltrim(rtrim($this->input->post('honorer_bln', TRUE))),
                "SWASTA_TAHUN" => ltrim(rtrim($this->input->post('swasta_thn', TRUE))),
                "SWASTA_BULAN" => ltrim(rtrim($this->input->post('swasta_bln', TRUE))),
                "BLN_MASAKERJA" => $bln_masakerja,
                "THN_MASAKERJA" => $thn_masakerja,
            ];
            $tanggal = [
                "TMT_CPNS" => datepickertodb(trim($this->input->post('tmt_cpns', TRUE))),
                "TMT_KERJA" => datepickertodb(trim($this->input->post('tmt_kerja', TRUE))),
            ];

            $idpangkat = NULL;
            if ($this->input->post('pangkat', TRUE) != "") {
                $idpangkat = trim($this->input->post('pangkat', TRUE));
            }

            $datapangkat = [
                'TRGOLONGAN_ID' => $idpangkat,
                'NO_SK' => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                'PEJABAT_SK' => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
                'THN_GOL' => $thn_masakerja,
                'BLN_GOL' => $bln_masakerja
            ];

            $datapangkattanggal = [
                "TMT_GOL" => datepickertodb(trim($this->input->post('tmt_cpns', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE)))
            ];

            if ($this->master_pegawai_cpns_model->update($post, $tanggal, $this->input->get('id'))) {
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP");
                if ($this->input->post('pangkat', TRUE) != "") {
                    $this->master_pegawai_cpns_model->save_pangkat($datapangkat, $datapangkattanggal, $this->input->get('id'));

                    $dokumen = [];
                    if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                        mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                    }

                    if (!empty($_FILES['doc_sk']['name'])) {
                        $pangkat_cpns = $this->master_pegawai_pangkat_model->get_by_pegawai_idpangkat($this->input->get('id'));

                        $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                        $config['allowed_types'] = 'pdf';
                        $config['max_size'] = '2048';
                        $config['overwrite'] = true;
                        $config['file_name'] = "doc_pangkat_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('doc_sk')) {
                            if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                                $dokumen = ['DOC_SKPANGKAT' => $config['file_name']];
                                if (!empty($pangkat_cpns['DOC_SKPANGKAT']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $pangkat_cpns['DOC_SKPANGKAT'])) {
                                    unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $pangkat_cpns['DOC_SKPANGKAT']);
                                }
                            } else
                                $dokumen = ['DOC_SKPANGKAT' => NULL];
                        }
                        unset($config);
                        $this->master_pegawai_cpns_model->save_pangkat_dok($dokumen, $this->input->get('id'));
                    }
                }

                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

}
