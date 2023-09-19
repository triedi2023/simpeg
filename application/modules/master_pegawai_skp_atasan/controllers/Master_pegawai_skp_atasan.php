<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_skp_atasan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('master_pegawai_skp_atasan/master_pegawai_skp_atasan_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'Atasan Pegawai';
        $this->data['custom_js'] = ['layouts/widget/main/js_crud', 'master_pegawai_skp_atasan/js'];
    }

    public function index() {
        $this->data['content'] = 'master_pegawai_skp_atasan/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            $this->data['data_pegawai'] = $this->master_pegawai_skp_atasan_model->get_pegawai();
            $this->data['list_satuan_skp'] = $this->list_model->list_satuan_skp();
            $this->load->view("master_pegawai_skp_atasan/form", $this->data);
        } else {
            redirect('/master_pegawai_skp_atasan');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nip_pejabat_penilai', 'NIP / NRP Pejabat Penilai', 'required|trim');
        $this->form_validation->set_rules('nip_atasan_pejabat_penilai', 'NIP / NRP Atasan Pejabat Penilai', 'required|trim');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $pecah = explode("(", $this->input->post('pangkatgol_pejabat_penilai_input', TRUE));
            $mecah = explode("(", $this->input->post('pangkatgol_atasan_pejabat_penilai_input', TRUE));
            $dataskppribadi = $this->master_pegawai_skp_atasan_model->get_pegawai();
            $post = [
                "PERIODE_AWAL" => ltrim(rtrim($this->input->post('periode_awal', TRUE))),
                "PERIODE_AKHIR" => ltrim(rtrim($this->input->post('periode_akhir', TRUE))),
                "PERIODE_TAHUN" => ltrim(rtrim($this->input->post('periode_tahun', TRUE))),
                "NIP_YGDINILAI" => $dataskppribadi['NIP'],
                "PANGKAT_YGDINILAI" => $dataskppribadi['PANGKAT'],
                "GOLONGAN_YGDINILAI" => $dataskppribadi['GOLONGAN'],
                "JABATAN_YGDINILAI" => $dataskppribadi['N_JABATAN'],
                "NIP_PEJABAT_PENILAI" => trim(rtrim($this->input->post('nip_pejabat_penilai', TRUE))),
                "PANGKAT_PEJABAT_PENILAI" => $pecah[0],
                "GOLONGAN_PEJABAT_PENILAI" => str_replace(')', "", $pecah[1]),
                "JABATAN_PEJABAT_PENILAI" => trim(rtrim($this->input->post('jabatan_pejabat_penilai_input', TRUE))),
                "NIP_ATASAN_PEJABAT_PENILAI" => trim(rtrim($this->input->post('nip_atasan_pejabat_penilai', TRUE))),
                "PANGKAT_ATASAN_PEJABAT_PENILAI" => $mecah[0],
                "GOLONGAN_ATASAN_PJBT_PENILAI" => str_replace(')', "", $mecah[1]),
                "JABATAN_ATASAN_PJBT_PENILAI" => trim(rtrim($this->input->post('jabatan_atasan_pejabat_penilai_input', TRUE))),
            ];
            if ($insert = $this->master_pegawai_skp_atasan_model->insert($post)) {
                $lastid = $insert['id'];

                $tugas = [];
                if (count(array_filter($_POST['utama_pokok'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_pokok'])); $i++) {
                        $isinya = "'".$_POST['utama_pokok'][$i]."'";
                        $tugas[] = "OBJECT_ARRAY_TEXT(".$isinya.")";
                    }
                }
                $itugas = implode(",", $tugas);

                $ak = [];
                if (count(array_filter($_POST['utama_ak'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_ak'])); $i++) {
                        $ak[] = "OBJECT_ARRAY_NUMERIC(".$_POST['utama_ak'][$i].")";
                    }
                }
                $iak = implode(",", $ak);

                $kuantitas = [];
                if (count(array_filter($_POST['utama_kuantitas'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_kuantitas'])); $i++) {
                        $kuantitas[] = "OBJECT_ARRAY_INTEGER(".$_POST['utama_kuantitas'][$i].")";
                    }
                }
                $ikuantitas = implode(",", $kuantitas);
                $satuan = [];
                if (count(array_filter($_POST['utama_satuan'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_satuan'])); $i++) {
                        $satuan[] = "OBJECT_ARRAY_INTEGER(".$_POST['utama_satuan'][$i].")";
                    }
                }
                $isatuan = implode(",", $satuan);
                $kualitas = [];
                if (count(array_filter($_POST['utama_kualitas'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_kualitas'])); $i++) {
                        $kualitas[] = "OBJECT_ARRAY_INTEGER(".$_POST['utama_kualitas'][$i].")";
                    }
                }
                $ikualitas = implode(",", $kualitas);
                $waktu = [];
                if (count(array_filter($_POST['utama_waktu'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_waktu'])); $i++) {
                        $waktu[] = "OBJECT_ARRAY_INTEGER(".$_POST['utama_waktu'][$i].")";
                    }
                }
                $iwaktu = implode(",", $waktu);
                $biaya = [];
                if (count(array_filter($_POST['utama_biaya'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['utama_biaya'])); $i++) {
                        $biaya[] = "OBJECT_ARRAY_INTEGER(".$_POST['utama_biaya'][$i].")";
                    }
                }
                $ibiaya = implode(",", $biaya);
                $detail = [
                    'THPEGAWAISKP_ID' => $lastid,
                    'TUGAS_POKOK_JABATAN' => "OBJECT_ARRAY_TEXT_TABLE(".$itugas.")",
                    'AK_TARGET' => "OBJECT_ARRAY_NUMERIC_TABLE(".$iak.")",
                    'KUANTITAS_TARGET' => "OBJECT_ARRAY_INTEGER_TABLE(".$ikuantitas.")",
                    'SATUAN_TARGET' => "OBJECT_ARRAY_INTEGER_TABLE(".$isatuan.")",
                    'KUALITAS_TARGET' => "OBJECT_ARRAY_INTEGER_TABLE(".$ikualitas.")",
                    'WAKTU_TARGET' => "OBJECT_ARRAY_INTEGER_TABLE(".$iwaktu.")",
                    'BIAYA_TARGET' => "OBJECT_ARRAY_INTEGER_TABLE(".$ibiaya.")",
                    'KATEGORI' => 1
                ];
                $this->master_pegawai_skp_atasan_model->insert_detail($detail);
                
                $tambahan = [];
                if (count(array_filter($_POST['tambahan_pokok'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['tambahan_pokok'])); $i++) {
                        $isinya = "'".$_POST['tambahan_pokok'][$i]."'";
                        $tambahan[] = "OBJECT_ARRAY_TEXT(".$isinya.")";
                    }
                }
                $itambahan = implode(",", $tambahan);
                $detail = [
                    'THPEGAWAISKP_ID' => $lastid,
                    'TUGAS_POKOK_JABATAN' => "OBJECT_ARRAY_TEXT_TABLE(".$itambahan.")",
                    'KATEGORI' => 2
                ];
                $this->master_pegawai_skp_atasan_model->insert_detail($detail);
                
                $kreativitas = [];
                if (count(array_filter($_POST['kreativitas_pokok'])) > 0) {
                    for ($i = 0; $i < count(array_filter($_POST['kreativitas_pokok'])); $i++) {
                        $isinya = "'".$_POST['kreativitas_pokok'][$i]."'";
                        $kreativitas[] = "OBJECT_ARRAY_TEXT(".$isinya.")";
                    }
                }
                $ikreativitas = implode(",", $kreativitas);
                $detail = [
                    'THPEGAWAISKP_ID' => $lastid,
                    'TUGAS_POKOK_JABATAN' => "OBJECT_ARRAY_TEXT_TABLE(".$ikreativitas.")",
                    'KATEGORI' => 3
                ];
                $this->master_pegawai_skp_atasan_model->insert_detail($detail);

                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->master_pegawai_skp_atasan_model->get_by_id($this->input->get('id'));
            $this->data['title_form'] = "Ubah";
            $this->data['data_pegawai'] = $this->master_pegawai_skp_atasan_model->get_pegawai($this->data['model']->NIP_YGDINILAI);
            $this->data['utama'] = $this->master_pegawai_skp_atasan_model->get_detail_utama($this->input->get('id'));
            $this->data['tambahan'] = $this->master_pegawai_skp_atasan_model->get_detail_tambahan($this->input->get('id'));
            $this->data['kreativitas'] = $this->master_pegawai_skp_atasan_model->get_detail_kreativitas($this->input->get('id'));
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            $this->data['list_satuan_skp'] = $this->list_model->list_satuan_skp();
            
            $this->load->view("master_pegawai_skp_atasan/form_edit", $this->data);
        } else {
            redirect('/master_pegawai_skp_atasan');
        }
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'required|min_length[2]|max_length[50]|callback_unique_edit');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[100]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TINGKAT_PENDIDIKAN" => ltrim(rtrim($this->input->post('tingkat_pendidikan', TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                "STATUS" => $this->input->post('status', TRUE)
            ];
            if ($this->master_pegawai_skp_atasan_model->update($post, $this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->master_pegawai_skp_atasan_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "Bulan " . $val->PERIODE;
            $row[] = $val->PANGKATGOL;
            $row[] = $val->JABATAN_YGDINILAI;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai_skp_atasan/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubah btn btn-xs yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_skp_atasan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_skp_atasan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_skp_atasan_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_skp_atasan_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('tingkat_pendidikan'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
