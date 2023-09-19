<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_dp3 extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_dp3_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'SKP Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $this->load->view('master_pegawai/dp3/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_dp3_model->list_jabatan_pegawai($_GET['id']);
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/dp3/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tahun_penilaian', 'Tahun Penilaian', 'required|min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('kesetiaan', 'Kesetiaan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('prestasi_kerja', 'Prestasi Kerja', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('tanggung_jawab', 'Tanggung Jawab', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('ketaatan', 'Ketaatan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kejujuran', 'Kejujuran', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kerja_sama', 'Kerja Sama', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('prakarsa', 'Prakarsa', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kepemimpinan', 'Kepemimpinan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('nip_pejabat', 'NIP Pejabat', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('nip_a_pejabat', 'NIP Atasan Pejabat', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('pejabat_a_sk', 'Pejabat Atasan', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nama_a_pejabat', 'Nama Atasan Pejabat', 'min_length[1]|max_length[150]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $jumlah = trim($this->input->post('kesetiaan',TRUE)) + trim($this->input->post('prestasi_kerja',TRUE)) + trim($this->input->post('tanggung_jawab',TRUE)) + trim($this->input->post('ketaatan',TRUE)) + trim($this->input->post('kejujuran',TRUE)) + trim($this->input->post('kerja_sama',TRUE)) + trim($this->input->post('prakarsa',TRUE)) + trim($this->input->post('kepemimpinan',TRUE));
            $n_rata = $jumlah / 8;
            
            $post = [
                "TAHUN_PENILAIAN" => trim($this->input->post('tahun_penilaian',TRUE)),
                "TRJABATAN_ID" => trim($this->input->post('jabatan',TRUE)),
                "N_KESETIAAN" => trim($this->input->post('kesetiaan',TRUE)),
                "N_PRESTASI_KERJA" => trim($this->input->post('prestasi_kerja',TRUE)),
                "N_TANGGUNG_JAWAB" => trim($this->input->post('tanggung_jawab',TRUE)),
                "N_KETAATAN" => trim($this->input->post('ketaatan',TRUE)),
                "N_KEJUJURAN" => trim($this->input->post('kejujuran',TRUE)),
                "N_KERJASAMA" => trim($this->input->post('kerja_sama',TRUE)),
                "N_PRAKARSA" => trim($this->input->post('prakarsa',TRUE)),
                "N_KEPEMIMPINAN" => trim($this->input->post('kepemimpinan',TRUE)),
                "NIP_PJBT" => ltrim(rtrim($this->input->post('nip_pejabat',TRUE))),
                "JABATAN_PJBT" => ltrim(rtrim($this->input->post('pejabat_sk',TRUE))),
                "NAMA_PJBT" => ltrim(rtrim($this->input->post('nama_pejabat',TRUE))),
                "NIP_A_PJBT" => ltrim(rtrim($this->input->post('nip_a_pejabat',TRUE))),
                "NAMA_A_PJBT" => ltrim(rtrim($this->input->post('nama_a_pejabat',TRUE))),
                "JABATAN_A_PJBT" => ltrim(rtrim($this->input->post('pejabat_a_sk',TRUE))),
                "N_RATA" => trim($n_rata),
                'TMPEGAWAI_ID' => $id,
            ];
            if ($insert = $this->master_pegawai_dp3_model->insert($post)) {
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
            $this->data['model'] = $this->master_pegawai_dp3_model->get_by_id($this->input->get('id'));
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_dp3_model->list_jabatan_pegawai();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/dp3/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tahun_penilaian', 'Tahun Penilaian', 'required|min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('kesetiaan', 'Kesetiaan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('prestasi_kerja', 'Prestasi Kerja', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('tanggung_jawab', 'Tanggung Jawab', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('ketaatan', 'Ketaatan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kejujuran', 'Kejujuran', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kerja_sama', 'Kerja Sama', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('prakarsa', 'Prakarsa', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('kepemimpinan', 'Kepemimpinan', 'required|min_length[1]|max_length[7]|trim');
        $this->form_validation->set_rules('nip_pejabat', 'NIP Pejabat', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('nip_a_pejabat', 'NIP Atasan Pejabat', 'min_length[1]|max_length[18]');
        $this->form_validation->set_rules('pejabat_a_sk', 'Pejabat Atasan', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nama_a_pejabat', 'Nama Atasan Pejabat', 'min_length[1]|max_length[150]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $jumlah = trim($this->input->post('kesetiaan',TRUE)) + trim($this->input->post('prestasi_kerja',TRUE)) + trim($this->input->post('tanggung_jawab',TRUE)) + trim($this->input->post('ketaatan',TRUE)) + trim($this->input->post('kejujuran',TRUE)) + trim($this->input->post('kerja_sama',TRUE)) + trim($this->input->post('prakarsa',TRUE)) + trim($this->input->post('kepemimpinan',TRUE));
            $n_rata = $jumlah / 8;
            
            $post = [
                "TAHUN_PENILAIAN" => trim($this->input->post('tahun_penilaian',TRUE)),
                "TRJABATAN_ID" => trim($this->input->post('jabatan',TRUE)),
                "N_KESETIAAN" => trim($this->input->post('kesetiaan',TRUE)),
                "N_PRESTASI_KERJA" => trim($this->input->post('prestasi_kerja',TRUE)),
                "N_TANGGUNG_JAWAB" => trim($this->input->post('tanggung_jawab',TRUE)),
                "N_KETAATAN" => trim($this->input->post('ketaatan',TRUE)),
                "N_KEJUJURAN" => trim($this->input->post('kejujuran',TRUE)),
                "N_KERJASAMA" => trim($this->input->post('kerja_sama',TRUE)),
                "N_PRAKARSA" => trim($this->input->post('prakarsa',TRUE)),
                "N_KEPEMIMPINAN" => trim($this->input->post('kepemimpinan',TRUE)),
                "NIP_PJBT" => ltrim(rtrim($this->input->post('nip_pejabat',TRUE))),
                "JABATAN_PJBT" => ltrim(rtrim($this->input->post('pejabat_sk',TRUE))),
                "NAMA_PJBT" => ltrim(rtrim($this->input->post('nama_pejabat',TRUE))),
                "NIP_A_PJBT" => ltrim(rtrim($this->input->post('nip_a_pejabat',TRUE))),
                "NAMA_A_PJBT" => ltrim(rtrim($this->input->post('nama_a_pejabat',TRUE))),
                "JABATAN_A_PJBT" => ltrim(rtrim($this->input->post('pejabat_a_sk',TRUE))),
                "N_RATA" => trim($n_rata),
            ];
            
            if ($this->master_pegawai_dp3_model->update($post,$this->input->get('id'))) {
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
        $list = $this->master_pegawai_dp3_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TAHUN_PENILAIAN;
            $row[] = $val->JABATAN;
            $row[] = $val->N_RATA;
            $row[] = '<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_dp3/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>&nbsp;<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-icon-only red" data-url="'. site_url('master_pegawai/master_pegawai_dp3/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_dp3_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_dp3_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_dp3_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_dp3_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
