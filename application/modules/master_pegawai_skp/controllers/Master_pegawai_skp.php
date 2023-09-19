<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "vendor/autoload.php";
use PhpOffice\PhpWord\PhpWord;

class Master_pegawai_skp extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('master_pegawai_skp/master_pegawai_skp_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'SKP Pegawai';
        $this->data['custom_js'] = ['layouts/widget/main/js_crud', 'master_pegawai_skp/js'];
    }

    public function index() {
        $this->data['content'] = 'master_pegawai_skp/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            $this->data['data_pegawai'] = $this->master_pegawai_skp_model->get_pegawai();
            $this->data['list_satuan_skp'] = $this->list_model->list_satuan_skp();
            $this->load->view("master_pegawai_skp/form", $this->data);
        } else {
            redirect('/master_pegawai_skp');
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
            $dataskppribadi = $this->master_pegawai_skp_model->get_pegawai();
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
            if ($insert = $this->master_pegawai_skp_model->insert($post)) {
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
                $this->master_pegawai_skp_model->insert_detail($detail);
                
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
                $this->master_pegawai_skp_model->insert_detail($detail);
                
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
                $this->master_pegawai_skp_model->insert_detail($detail);

                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->master_pegawai_skp_model->get_by_id($this->input->get('id'));
            $this->data['title_form'] = "Ubah";
            $this->data['data_pegawai'] = $this->master_pegawai_skp_model->get_pegawai($this->data['model']->NIP_YGDINILAI);
            $this->data['utama'] = $this->master_pegawai_skp_model->get_detail_utama($this->input->get('id'));
            $this->data['tambahan'] = $this->master_pegawai_skp_model->get_detail_tambahan($this->input->get('id'));
            $this->data['kreativitas'] = $this->master_pegawai_skp_model->get_detail_kreativitas($this->input->get('id'));
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            $this->data['list_satuan_skp'] = $this->list_model->list_satuan_skp();
            
            $this->load->view("master_pegawai_skp/form_edit", $this->data);
        } else {
            redirect('/master_pegawai_skp');
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
            if ($this->master_pegawai_skp_model->update($post, $this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->master_pegawai_skp_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "Bulan " . $val->PERIODE;
            $row[] = $val->PANGKATGOL;
            $row[] = $val->JABATAN_YGDINILAI;
            $row[] = '<a href="'.site_url('master_pegawai_skp/print_document_skp?id=' . $val->ID).'" target="_blank" class="btn btn-xs green-haze" title="Cetak SKP"><i class="fa fa-file-word-o"></i></a><a href="javascript:;" data-url="' . site_url('master_pegawai_skp/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubah btn btn-xs yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-xs red" data-url="' . site_url('master_pegawai_skp/hapus_data') . '" data-id="' . $val->ID . '" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_skp_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_skp_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_skp_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_skp_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('tingkat_pendidikan'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function print_document_skp() {
        $logogaruda = "./assets/img/lambang_garuda.png";

        $bulanlist = array(
            1 => '1 Bulan',
            2 => '2 Bulan',
            3 => '3 Bulan',
            4 => '4 Bulan',
            5 => '5 Bulan',
            6 => '6 Bulan',
            7 => '7 Bulan',
            8 => '8 Bulan',
            9 => '9 Bulan',
            10 => '10 Bulan',
            11 => '11 Bulan',
            12 => '12 Bulan'
        );
        $bulan_list = $bulanlist;

        $list_satuan_skp = $this->list_model->list_satuan_skp();
        $dataskp = $this->master_pegawai_skp_model->get_by_id($this->input->get('id'));
        $data_pegawai = $this->master_pegawai_skp_model->get_pegawai($dataskp->NIP_YGDINILAI);
        $list_bulan = $this->list_model->list_bulan();
        $utama = $this->master_pegawai_skp_model->get_detail_utama($this->input->get('id'));
        $tambahan = $this->master_pegawai_skp_model->get_detail_tambahan($this->input->get('id'));
        $kreativitas = $this->master_pegawai_skp_model->get_detail_kreativitas($this->input->get('id'));
        $kreativitasnilai = $this->master_pegawai_skp_model->get_detail_kreativitas_nilai($this->input->get('id'));
        $perilakukerja = $this->master_pegawai_skp_model->get_perilakukerja($this->input->get('id'));

        $bulanperiodeawal = '';
        foreach ($list_bulan as $key => $val):
            if ($dataskp->PERIODE_AWAL == $val['kode'])
                $bulanperiodeawal = $val['nama'];
        endforeach;

        $bulanperiodeakhir = '';
        foreach ($list_bulan as $key => $val):
            if ($dataskp->PERIODE_AKHIR == $val['kode'])
                $bulanperiodeakhir = $val['nama'];
        endforeach;

        $pegawai = (empty($data_pegawai['GELAR_DEPAN'])) ? '' : $data_pegawai['GELAR_DEPAN'] . " ";
        $pegawai .= $data_pegawai['NAMA'];
        $pegawai .= (empty($data_pegawai['GELAR_BLKG'])) ? '' : " " . $data_pegawai['GELAR_BLKG'];

        $namapejabat = empty($dataskp->GELAR_DEPAN2) ? '' : $dataskp->GELAR_DEPAN2 . ' ';
        $namapejabat .= $dataskp->NAMA2;
        $namapejabat .= empty($dataskp->GELAR_BLKG2) ? '' : ', ' . $dataskp->GELAR_BLKG2;

        $namapenilai = empty($dataskp->GELAR_DEPAN3) ? '' : $dataskp->GELAR_DEPAN3 . ' ';
        $namapenilai .= $dataskp->NAMA3;
        $namapenilai .= empty($dataskp->GELAR_BLKG3) ? '' : ', ' . $dataskp->GELAR_BLKG3;

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle(
            'multisatuTab', array(
            'tabs' => array(
                new \PhpOffice\PhpWord\Style\Tab('left', 360),
                new \PhpOffice\PhpWord\Style\Tab('center', 2300)
            )
                )
        );
        $phpWord->addFontStyle('rStyle', array('bold' => true, 'size' => 14));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center'));
        $phpWord->addParagraphStyle('StyleP', array('align' => 'center','spaceAfter' => 2));
        $phpWord->addParagraphStyle('pStyleLeft', array('align' => 'left'));
        $phpWord->addParagraphStyle('pStyleRight', array('align' => 'right'));

        $phpWord->addFontStyle('rStyle2', array('size' => 10));

        $phpWord->addFontStyle('rStyle3', array('size' => 10, 'bold' => true));
        $phpWord->addFontStyle('rStyle4', array('size' => 12, 'bold' => true));
        $phpWord->addFontStyle('rStyle5', array('size' => 12, 'underline' => 'single'));
        $phpWord->addFontStyle('rStyle6', array('size' => 12, 'underline' => 'single', 'bold' => true));
        $phpWord->addFontStyle('rStyle7', array('size' => 12));
        $phpWord->addFontStyle('rStyle8', array('size' => 10, 'underline' => 'single', 'bold' => true));
        $phpWord->addFontStyle('rStyle9', array('size' => 9));
        $phpWord->addFontStyle('rStyle10', array('size' => 8));
        $phpWord->addFontStyle('rStyle11', array('size' => 8, 'bold' => true));
        $phpWord->addFontStyle('rStyle12', array('size' => 8, 'underline' => 'single'));

        /* Note: any element you append to a document must reside inside of a Section. */
        $section = $phpWord->addSection();

        // Adding an empty Section to the document...
        $section->addTextBreak();
        $section->addText("DATA SASARAN KERJA PEGAWAI", 'rStyle4', 'pStyle');
        $section->addTextBreak();

        $tabel = $section->addTable(array('borderSize' => 1, 'borderColor' => '999999'));
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("1."), 'rStyle7');
        $tabel->addCell(8600, array('gridSpan' => 3))->addText(htmlspecialchars("YANG DINILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($pegawai)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($data_pegawai['NIPNEW']), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == 1 ? $data_pegawai['PANGKAT'] . " (" . $data_pegawai['GOLONGAN'] . ")" : $data_pegawai['PANGKAT']), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($data_pegawai['N_JABATAN']), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("2."), 'rStyle7');
        $tabel->addCell(8600, array('gridSpan' => 3))->addText(htmlspecialchars("PEJABAT PENILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($namapejabat)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_PEJABAT_PENILAI . " (" . $dataskp->GOLONGAN_PEJABAT_PENILAI.")"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("3."), 'rStyle7');
        $tabel->addCell(8600, array('gridSpan' => 3))->addText(htmlspecialchars("ATASAN PEJABAT PENILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($namapenilai)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_ATASAN_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_ATASAN_PEJABAT_PENILAI . " / " . $dataskp->GOLONGAN_ATASAN_PJBT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_ATASAN_PJBT_PENILAI), 'rStyle7');

        $section->addPageBreak();
        $section->addImage($logogaruda, array('align' => 'center'));
        $section->addTextBreak(2);
        $section->addText(htmlspecialchars('PENILAIAN PRESTASI KERJA'), 'rStyle4', 'pStyle');
        $section->addText(htmlspecialchars('PEGAWAI NEGERI SIPIL'), 'rStyle4', 'pStyle');

        $section->addTextBreak(3);
        $section->addText(htmlspecialchars('Jangka Waktu Penilaian'), 'rStyle4', 'pStyle');
        $section->addText(htmlspecialchars("1 " . $bulanperiodeawal . " - " . $bulanperiodeakhir . " " . $dataskp->PERIODE_TAHUN), 'rStyle4', 'pStyle');
        $section->addTextBreak(3);

        $tabel = $section->addTable();
        $tabel->addRow();
        $tabel->addCell(3000)->addText(htmlspecialchars("Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($pegawai)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(3000)->addText(htmlspecialchars("NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_YGDINILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(3000)->addText(htmlspecialchars("Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_YGDINILAI . ", " . $dataskp->GOLONGAN_YGDINILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(3000)->addText(htmlspecialchars("Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_YGDINILAI), 'rStyle7');

        $section->addTextBreak(3);
        $section->addText(htmlspecialchars('BADAN PENCARIAN DAN PERTOLONGAN'), 'rStyle4', 'pStyle');
        $section->addText(htmlspecialchars(date('Y')), 'rStyle4', 'pStyle');

        $section->addPageBreak();
        $section = $phpWord->addSection(
                array(
                    'marginLeft' => 400,
                    'marginRight' => 200,
                    'marginTop' => 1000,
                    'marginBottom' => 200,
                )
        );

        $section->addText(htmlspecialchars('FORMULIR SASARAN KERJA'), 'rStyle4', 'pStyle');
        $section->addText(htmlspecialchars('PEGAWAI NEGERI SIPIL'), 'rStyle4', 'pStyle');
        $section->addTextBreak(2);

        $styleTable = array('borderSize' => 1, 'borderColor' => '999999');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('align' => 'center');
        $cellVCentered = array('valign' => 'center');

        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $tabel = $section->addTable('Colspan Rowspan');
        $tabel->addRow();
        $tabel->addCell(600, $cellHCentered)->addText('NO', 'rStyle3');
        $tabel->addCell(5000, array('align' => 'center'))->addText('I. PEJABAT PENILAI', 'rStyle3');
        $tabel->addCell(600, $cellHCentered)->addText('NO', 'rStyle3');
        $tabel->addCell(5000, array('align' => 'center', 'gridSpan' => 4))->addText('II. PEGAWAI NEGERI SIPIL YANG DINILAI', 'rStyle3');
        $tabel->addRow();
        $tabel->addCell(600)->addText("1");
        $tabel->addCell(2000)->addText("Nama", 'rStyle2');
        $tabel->addCell(3000)->addText(strtoupper($namapejabat), 'rStyle2');
        $tabel->addCell(600)->addText("1");
        $tabel->addCell(2000)->addText("Nama", 'rStyle2');
        $tabel->addCell(3000, array('gridSpan' => 2))->addText(strtoupper($pegawai), 'rStyle2');
        $tabel->addRow();
        $tabel->addCell(600)->addText("2");
        $tabel->addCell(2000)->addText("NIP", 'rStyle2');
        $tabel->addCell(3000)->addText($dataskp->NIP_PEJABAT_PENILAI, 'rStyle2');
        $tabel->addCell(600)->addText("2");
        $tabel->addCell(2000)->addText("NIP", 'rStyle2');
        $tabel->addCell(3000, array('gridSpan' => 2))->addText($data_pegawai['NIPNEW'], 'rStyle2');
        $tabel->addRow();
        $tabel->addCell(600)->addText("3");
        $tabel->addCell(2000)->addText("Pangkat/Gol.Ruang", 'rStyle2');
        $tabel->addCell(3000)->addText($dataskp->PANGKAT_PEJABAT_PENILAI . " / " . $dataskp->GOLONGAN_PEJABAT_PENILAI, 'rStyle2');
        $tabel->addCell(600)->addText("3");
        $tabel->addCell(2000)->addText("Pangkat/Gol.Ruang", 'rStyle2');
        $tabel->addCell(3000, array('gridSpan' => 2))->addText($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == 1 ? $data_pegawai['PANGKAT'] . " (" . $data_pegawai['GOLONGAN'] . ")" : $data_pegawai['PANGKAT'], 'rStyle2');
        $tabel->addRow();
        $tabel->addCell(600)->addText("4");
        $tabel->addCell(2000)->addText("Jabatan", 'rStyle2');
        $tabel->addCell(3000)->addText($dataskp->JABATAN_PEJABAT_PENILAI, 'rStyle2');
        $tabel->addCell(600)->addText("4");
        $tabel->addCell(2000)->addText("Jabatan", 'rStyle2');
        $tabel->addCell(3000, array('gridSpan' => 2))->addText($data_pegawai['N_JABATAN'], 'rStyle2');
        $tabel->addRow();
        $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('NO', 'rStyle3', 'pStyle');
        $tabel->addCell(5000, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('III. KEGIATAN TUGAS JABATAN', 'rStyle3', 'pStyle');
        $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('AK', 'rStyle3', 'pStyle');
        $tabel->addCell(5000, array('align' => 'center', 'gridSpan' => 4))->addText('TARGET', 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(600, array('vMerge' => 'continue'));
        $tabel->addCell(5000, array('vMerge' => 'continue'));
        $tabel->addCell(600, array('vMerge' => 'continue'));
        $tabel->addCell(1250)->addText('KUANT/OUTPUT', 'rStyle3', 'pStyle');
        $tabel->addCell(1250)->addText('KUAL/MUTU', 'rStyle3', 'pStyle');
        $tabel->addCell(1250)->addText('WAKTU', 'rStyle3', 'pStyle');
        $tabel->addCell(1250)->addText('BIAYA', 'rStyle3', 'pStyle');
        if ($utama):
            $tugas_pokok_jabatan = $utama['utama_pokok'];
            $ak_target = $utama['utama_ak'];
            $kuantitas_target = $utama['utama_kuantitas'];
            $satuan_target = $utama['utama_satuan'];
            $kualitas_target = $utama['utama_kualitas'];
            $jmldatakuantitastarget = count($kualitas_target);
            $waktu_target = $utama['utama_waktu'];
            $biaya_target = $utama['utama_biaya'];
            $perhitungan = $utama['perhitungan'];
            $nilai_capaian_skp = $utama['nilai'];

            // realisasi
            $ak_realisasi = $utama['realiasi_ak'];
            $kuantitas_realisasi = $utama['realiasi_kuantitas'];
            $satuan_realisasi = $utama['realiasi_satuan'];
            $kualitas_realisasi = $utama['realiasi_kualitas'];
            $waktu_realisasi = $utama['realiasi_waktu'];
            $biaya_realisasi = $utama['realiasi_biaya'];

            for ($i = 0; $i < count($tugas_pokok_jabatan); $i++):
                $tabel->addRow();
                $tabel->addCell(600)->addText(htmlspecialchars($i + 1));
                $tabel->addCell(5000)->addText(str_replace("||", ",", $tugas_pokok_jabatan[$i]['TEXT_ARRAY']));
                if (is_array($ak_target)) {
                    $tabel->addCell(600)->addText($ak_target[$i]['NUMERIC_ARRAY']);
                } else {
                    $tabel->addCell(600)->addText(0);
                }

                $kuantitasrealisasi = 0;
                if (is_array($kuantitas_target)) {
                    $kuantitasrealisasi = $kuantitas_target[$i]['INTEGER_ARRAY'];
                }

                $satuantarget = "";
                if (is_array($satuan_target)) {
                    foreach ($list_satuan_skp as $value):
                        if ($value['ID'] == $satuan_target[$i]['INTEGER_ARRAY'])
                            $satuantarget = $value['NAMA'];
                    endforeach;
                }

                $tabel->addCell(1250)->addText($kuantitasrealisasi . " " . $satuantarget, 'rStyle2', 'pStyle');

                if (is_array($kualitas_target)) {
                    $tabel->addCell(1250)->addText($kualitas_target[$i]['INTEGER_ARRAY'], 'rStyle2', 'pStyle');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'pStyle');
                }

                if (is_array($waktu_target)) {
                    $waktutarget = '';
                    foreach ($bulan_list as $key => $bulanlist):
                        if ($key == $waktu_target[$i])
                            $waktutarget = $bulanlist;
                    endforeach;

                    $tabel->addCell(1250)->addText($waktutarget, 'rStyle2', 'pStyle');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'pStyle');
                }
                if (is_array($biaya_target)) {
                    $tabel->addCell(1250)->addText($biaya_target[$i]['INTEGER_ARRAY'], 'rStyle2', 'pStyle');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'pStyle');
                }
            endfor;
        endif;

        $section->addTextBreak(1);
        $tabel = $section->addTable();
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3');
        $tabel->addCell(5600, array('align' => 'center'))->addText('Jakarta, ' . date('d-M-Y'), 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText('Pejabat Penilai,', 'rStyle3', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText('Pegawai Negeri Sipil Yang Dinilai', 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText('', 'rStyle3', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText(strtolower($namapejabat), 'rStyle8', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText(strtolower($pegawai), 'rStyle8', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(5600, array('align' => 'center'))->addText($dataskp->NIP_PEJABAT_PENILAI, 'rStyle2', 'pStyle');
        $tabel->addCell(5600, array('align' => 'center'))->addText($data_pegawai['NIPNEW'], 'rStyle2', 'pStyle');
        $section->addPageBreak();

        $capaianpage = $phpWord->addSection(array(
            'orientation' => 'landscape',
            'marginLeft' => 600,
            'marginRight' => 200,
            'marginTop' => 400,
            'marginBottom' => 200
        ));
        $capaianpage->addText(htmlspecialchars('PENILAIAN CAPAIAN SASARAN KERJA'), 'rStyle4', 'pStyle');
        $capaianpage->addText(htmlspecialchars('PEGAWAI NEGERI SIPIL'), 'rStyle4', 'pStyle');
        $capaianpage->addTextBreak(0);

        $capaianpage->addText("Jangka Waktu Penilaian ", 'rStyle2');
        $capaianpage->addText("1 " . $bulanperiodeawal . " - 31 " . $bulanperiodeakhir . " " . $dataskp->PERIODE_TAHUN, 'rStyle2');

        $tabel = $capaianpage->addTable(array('borderSize' => 1, 'borderColor' => '999999','cellMargin'=>2));
        $tabel->addRow();
        $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('NO', 'rStyle11', 'StyleP');
        $tabel->addCell(4000, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('I. KEGIATAN TUGAS JABATAN', 'rStyle11', 'StyleP');
        $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('AK', 'rStyle11', 'StyleP');
        $tabel->addCell(4500, array('align' => 'center','gridSpan' => 4))->addText('TARGET', 'rStyle11', 'StyleP');
        $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('AK', 'rStyle11', 'StyleP');
        $tabel->addCell(4500, array('align' => 'center','gridSpan' => 4))->addText('REALISASI', 'rStyle11', 'StyleP');
        $tabel->addCell(500, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('Perhitungan', 'rStyle11', 'StyleP');
        $tabel->addCell(500, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('Nilai Capaian SKP', 'rStyle11', 'StyleP');
        $tabel->addRow();
        $tabel->addCell(600, array('vMerge' => 'continue'));
        $tabel->addCell(4000, array('vMerge' => 'continue'));
        $tabel->addCell(600, array('vMerge' => 'continue'));
        $tabel->addCell(1125)->addText('KUANT/OUTPUT', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('KUAL/MUTU', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('WAKTU', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('BIAYA', 'rStyle10', 'StyleP');
        $tabel->addCell(600)->addText('', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('KUANT/OUTPUT', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('KUAL/MUTU', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('WAKTU', 'rStyle10', 'StyleP');
        $tabel->addCell(1125)->addText('BIAYA', 'rStyle10', 'StyleP');
        $tabel->addCell(null, array('vMerge' => 'continue'));
        $tabel->addCell(null, array('vMerge' => 'continue'));
        $tabel->addRow();
        $tabel->addCell(600)->addText("1", 'rStyle11', 'StyleP');
        $tabel->addCell(4000)->addText("2", 'rStyle11', 'StyleP');
        $tabel->addCell(600)->addText("3", 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('4', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('5', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('6', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('7', 'rStyle11', 'StyleP');
        $tabel->addCell(600)->addText("8", 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('9', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('10', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('11', 'rStyle11', 'StyleP');
        $tabel->addCell(1125)->addText('12', 'rStyle11', 'StyleP');
        $tabel->addCell(500)->addText("13", 'rStyle11', 'StyleP');
        $tabel->addCell(500)->addText('14', 'rStyle11', 'StyleP');

        if ($utama):
            $tugas_pokok_jabatan = $utama['utama_pokok'];
            $ak_target = $utama['utama_ak'];
            $kuantitas_target = $utama['utama_kuantitas'];
            $satuan_target = $utama['utama_satuan'];
            $kualitas_target = $utama['utama_kualitas'];
            $jmldatakuantitastarget = count($kualitas_target);
            $waktu_target = $utama['utama_waktu'];
            $biaya_target = $utama['utama_biaya'];
            $perhitungan = $utama['perhitungan'];
            $nilai_capaian_skp = $utama['nilai'];

            // realisasi
            $ak_realisasi = $utama['realiasi_ak'];
            $kuantitas_realisasi = $utama['realiasi_kuantitas'];
            $satuan_realisasi = $utama['realiasi_satuan'];
            $kualitas_realisasi = $utama['realiasi_kualitas'];
            $waktu_realisasi = $utama['realiasi_waktu'];
            $biaya_realisasi = $utama['realiasi_biaya'];
            
            $jmldatautama = 0;
            $jmlnilaiskp = 0;
            for ($i = 0; $i < count($tugas_pokok_jabatan); $i++):
                $tabel->addRow();
                $tabel->addCell(600)->addText(htmlspecialchars($i + 1));
                $tabel->addCell(5000)->addText(str_replace("||", ", ", $tugas_pokok_jabatan[$i]['TEXT_ARRAY']));
                if (is_array($ak_target)) {
                    $tabel->addCell(600)->addText($ak_target[$i]['NUMERIC_ARRAY']);
                } else {
                    $tabel->addCell(600)->addText(0);
                }

                $kuantitasrealisasi = 0;
                if (is_array($kuantitas_target)) {
                    $kuantitasrealisasi = $kuantitas_target[$i]['INTEGER_ARRAY'];
                }

                $satuantarget = "";
                if (is_array($satuan_target)) {
                    foreach ($list_satuan_skp as $value):
                        if ($value['ID'] == $satuan_target[$i]['INTEGER_ARRAY'])
                            $satuantarget = $value['NAMA'];
                    endforeach;
                }

                $tabel->addCell(1250)->addText($kuantitasrealisasi . " " . $satuantarget, 'rStyle2', 'StyleP');

                if (is_array($kualitas_target)) {
                    $tabel->addCell(1250)->addText($kualitas_target[$i]['INTEGER_ARRAY'], 'rStyle2', 'StyleP');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'StyleP');
                }

                if (is_array($waktu_target)) {
                    $waktutarget = '';
                    foreach ($bulan_list as $key => $bulanlist):
                        if ($key == $waktu_target[$i]['INTEGER_ARRAY'])
                            $waktutarget = $bulanlist;
                    endforeach;

                    $tabel->addCell(1250)->addText($waktutarget, 'rStyle2', 'StyleP');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'StyleP');
                }

                if (is_array($biaya_target)) {
                    $tabel->addCell(1250)->addText($biaya_target[$i]['INTEGER_ARRAY'], 'rStyle2', 'StyleP');
                } else {
                    $tabel->addCell(1250)->addText(0, 'rStyle2', 'StyleP');
                }

                if (is_array($ak_realisasi) && count($ak_realisasi) > 0) {
                    $tabel->addCell(600)->addText($ak_realisasi[$i]['NUMERIC_ARRAY']);
                } else {
                    $tabel->addCell(600)->addText("0");
                }

                $kuanreal = 0;
                if (is_array($kuantitas_realisasi) && count($kuantitas_realisasi) > 0) {
                    $kuanreal = $kuantitas_realisasi[$i]['INTEGER_ARRAY'];
                }

                $satuanreal = '';
                foreach ($list_satuan_skp as $value):
                    if ($value['ID'] == $satuan_target[$i]['INTEGER_ARRAY'])
                        $satuanreal = $value['NAMA'];
                endforeach;

                $tabel->addCell(1250)->addText($kuanreal . " " . $satuanreal, 'rStyle2', 'StyleP');

                if (is_array($kualitas_realisasi) && count($kualitas_realisasi) > 0) {
                    $tabel->addCell(1250)->addText($kualitas_realisasi[$i]['INTEGER_ARRAY']);
                } else {
                    $tabel->addCell(1250)->addText("0");
                }

                $waktureal = '';
                if (is_array($waktu_realisasi) && count($waktu_realisasi) > 0) {
                    foreach ($bulan_list as $key => $bulanlist):
                        if ($key == $waktu_realisasi[$i]['INTEGER_ARRAY'])
                            $waktureal = $bulanlist;
                    endforeach;
                }
                $tabel->addCell(1250)->addText($waktureal);

                $biayareal = 0;
                if (is_array($biaya_realisasi) && count($biaya_realisasi) > 0) {
                    if ($biaya_target[$i] == 0) {
                        $biayareal = 0;
                    } else {
                        $biayareal = $biaya_realisasi[$i]['INTEGER_ARRAY'];
                    }
                } else {
                    $biayareal = 0;
                }
                $tabel->addCell(1250)->addText($biayareal);

                if (is_array($perhitungan) && count($perhitungan) > 0) {
                    $tabel->addCell(1250)->addText(number_format($perhitungan[$i]['NUMERIC_ARRAY'], 2));
                } else {
                    $tabel->addCell(1250)->addText(0);
                }

                if (is_array($nilai_capaian_skp) && count($nilai_capaian_skp) > 0) {
                    $jmlnilaiskp += $nilai_capaian_skp[$i]['NUMERIC_ARRAY'];
                    $tabel->addCell(1250)->addText(number_format($nilai_capaian_skp[$i]['NUMERIC_ARRAY'], 2));
                } else {
                    $tabel->addCell(1250)->addText(0);
                }
                
                $jmldatautama++;
            endfor;

            $tabel->addRow();
            $tabel->addCell(600)->addText("");
            $tabel->addCell(15200, array('align' => 'center', 'gridSpan' => 13))->addText("II. TUGAS TAMBAHAN :", 'rStyle11');
            $jmlunsurtambahan = 1;
            if ($tambahan):
                $tugas_pokok_jabatan = $tambahan;
                $jmldata = count($tugas_pokok_jabatan);
                if ($jmldata == 0) {
                    $jmldata = $jmldata;
                } else {
                    $jmldata = $jmldata - 1;
                }

                for ($i = 0; $i <= $jmldata; $i++):
                    $tabel->addRow();
                    $tabel->addCell(600)->addText($i, 'rStyle11', 'StyleP');
                    $tabel->addCell(4000)->addText(str_replace("||", ", ", $tugas_pokok_jabatan[$i]['TEXT_ARRAY']), 'rStyle10');
                    $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(600)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(600)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('', 'rStyle10', 'StyleP');
                    $i + 1;
                    $jmlunsurtambahan++;
                endfor;
            endif;

            if ($jmlunsurtambahan > 0) {
                if ($jmldata != "" && $jmlunsurtambahan < 4)
                    $jmlunsurtambahan = 1;
                elseif ($jmlunsurtambahan > 3 && $jmlunsurtambahan < 7)
                    $jmlunsurtambahan = 2;
                elseif ($jmlunsurtambahan > 6)
                    $jmlunsurtambahan = 3;
                else
                    $jmlunsurtambahan = 0;
            }

            $tabel->addRow();
            $tabel->addCell(600)->addText("");
            $tabel->addCell(15200, array('align' => 'center', 'gridSpan' => 13))->addText("III. TUGAS KREATIVITAS :", 'rStyle11');

            $jmldatarealkreativitas = 0;
            $jmldatareal = 0;
            if ($kreativitas):
                $tugas_pokok_jabatan = $kreativitas;
                $jmldatarealkreativitas = $kreativitasnilai;
//                $jmldatarealkreativitas = $jmldatarealkreativitas[0]['NUMERIC_ARRAY'];
                $jmldata = count($tugas_pokok_jabatan);
                $jmldatareal = $jmldata;
                if ($jmldata == 0) {
                    $jmldata = $jmldata;
                } else {
                    $jmldata = $jmldata - 1;
                }
                for ($i = 0; $i <= $jmldata; $i++):
                    $tabel->addRow();
                    $tabel->addCell(600)->addText($i, 'rStyle11', 'StyleP');
                    $tabel->addCell(4000)->addText(str_replace("||", ", ", $tugas_pokok_jabatan[$i]['TEXT_ARRAY']), 'rStyle10');
                    $tabel->addCell(600, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(600)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(600)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(4500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $tabel->addCell(500)->addText('-', 'rStyle10', 'StyleP');
                    $i + 1;
                endfor;
            endif;
        endif;

        $jmldatarealkreativitas = 0;
        if ($jmldatareal == 0) {
            $jmldatarealkreativitas = 0;
        }
        
        $hasilakhirskpnya = $jmlnilaiskp+$jmlunsurtambahan+$jmldatarealkreativitas;
        $totnilaicapaianskp = ($jmlnilaiskp+$jmlunsurtambahan+$jmldatarealkreativitas)/$jmldatautama;

        $tabel->addRow();
        $tabel->addCell(15300, array('gridSpan' => 13))->addText("");
        $tabel->addCell(500)->addText(htmlspecialchars(number_format($hasilakhirskpnya,2)));
        $tabel->addRow();
        $tabel->addCell(15300, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center', 'gridSpan' => 13))->addText("Nilai Capaian SKP", 'rStyle11', 'StyleP');
        $tabel->addCell(500)->addText(number_format($totnilaicapaianskp,2), 'rStyle11');
        $tabel->addRow();
        $tabel->addCell(15300, array('vMerge' => 'continue', 'gridSpan' => 13));
        $tabel->addCell(500, array('align' => 'center', 'valign' => 'center'))->addText('0', 'rStyle11', 'StyleP');

        $capaianpage->addTextBreak();
        $tabel = $capaianpage->addTable();
        $tabel->addRow();
        $tabel->addCell(7900)->addText("");
        $tabel->addCell(7900)->addText("Jakarta, " . date('d-m-Y'), 'rStyle11', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(7900)->addText("");
        $tabel->addCell(7900)->addText("Pejabat Penilai", 'rStyle11', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(7900)->addText("");
        $tabel->addCell(7900)->addText("", 'rStyle11', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(7900)->addText("");
        $tabel->addCell(7900)->addText($namapejabat, 'rStyle12', 'pStyle');
        $tabel->addRow();
        $tabel->addCell(7900)->addText("");
        $tabel->addCell(7900)->addText($dataskp->NIP_PEJABAT_PENILAI, 'rStyle10', 'pStyle');
        $capaianpage->addPageBreak();

        $section = $phpWord->addSection();
        $section->addText(htmlspecialchars('BUKU CATATAN PENILAIAN PERILAKU PNS'), 'rStyle4', 'pStyle');
        $section->addTextBreak(2);

        $tabel = $section->addTable();
        $tabel->addRow();
        $tabel->addCell(2000)->addText("Nama");
        $tabel->addCell(500)->addText(":");
        $tabel->addCell(4000)->addText($pegawai);
        $tabel->addRow();
        $tabel->addCell(2000)->addText("NIP");
        $tabel->addCell(500)->addText(":");
        $tabel->addCell(4000)->addText($data_pegawai['NIPNEW']);

        $section->addTextBreak(2);
        $tabel = $section->addTable('Colspan Rowspan');
        $tabel->addRow();
        $tabel->addCell(500)->addText("No");
        $tabel->addCell(2000)->addText("Tanggal");
        $tabel->addCell(4000)->addText("Uraian");
        $tabel->addCell(3000)->addText("Nama/NIP dan Paraf Pejabat Penilai");
        $tabel->addRow();
        $tabel->addCell(500)->addText("1");
        $tabel->addCell(2000)->addText("2");
        $tabel->addCell(4000)->addText("3");
        $tabel->addCell(3000)->addText("4");
        $tabel->addRow();
        $tabel->addCell(500)->addText("");
        $tabel->addCell(2000)->addText("");
        $tabel->addCell(4000)->addText("");
        $paraf = $tabel->addCell(3000, array('vMerge' => 'restart', 'align' => 'center', 'valign' => 'center'))->addTable();
        $paraf->addRow();
        $paraf->addCell(3000)->addText($dataskp->JABATAN_PEJABAT_PENILAI);
        $paraf->addRow();
        $paraf->addCell(3000);
        $paraf->addRow();
        $paraf->addCell(3000);
        $paraf->addRow();
        $paraf->addCell(3000);
        $paraf->addRow();
        $paraf->addCell(3000)->addText($namapejabat, 'rStyle12');
        $paraf->addRow();
        $paraf->addCell(3000)->addText($dataskp->NIP_PEJABAT_PENILAI, 'rStyle10');
        $tabel->addRow();
        $tabel->addCell(500)->addText("1");
        $tabel->addCell(2000)->addText("1 " . $bulanperiodeawal . " - 31 " . $bulanperiodeakhir . " " . $dataskp->PERIODE_TAHUN);
        $tabel->addCell(4000)->addText("Penilaian SKP sampai dengan akhir $bulanperiodeakhir " . $dataskp->PERIODE_TAHUN . " jml = " . $hasilakhirskpnya . " = ".number_format($totnilaicapaianskp,2));
        $tabel->addCell(3000, array('vMerge' => 'continue'));
        $tabel->addRow();
        $tabel->addCell(500)->addText("");
        $tabel->addCell(2000)->addText("");
        $tabel->addCell(4000)->addText("sedangkan penilaian perilaku kerjanya adalah");
        $tabel->addCell(3000, array('vMerge' => 'continue'));
        $tabel->addRow();
        $tabel->addCell(500)->addText("");
        $tabel->addCell(2000)->addText("");
        $tabel->addCell(4000)->addText("sebagai berikut :");
        $tabel->addCell(3000, array('vMerge' => 'continue'));
        $tabel->addRow();
        $tabel->addCell(500)->addText("");
        $tabel->addCell(2000)->addText("");
        $secondtable = $tabel->addCell(4000)->addTable();
        $secondtable->addRow();
        $nilaiorientasi_pelayanan = (isset($perilakukerja['ORIENTASI_PELAYANAN']) && !empty($perilakukerja['ORIENTASI_PELAYANAN'])) ? $perilakukerja['ORIENTASI_PELAYANAN'] : 0;
        $jmlnilaiorientasi = (isset($perilakukerja['ORIENTASI_PELAYANAN']) && !empty($perilakukerja['ORIENTASI_PELAYANAN'])) ? 1 : 0;
        $secondtable->addCell(1500)->addText("Orientasi Pelayanan");
        $secondtable->addCell(500)->addText("=");
        $secondtable->addCell(1000)->addText($nilaiorientasi_pelayanan);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_ORIENTASI_PELAYANAN']) && !empty($perilakukerja['KET_ORIENTASI_PELAYANAN'])) ? $perilakukerja['KET_ORIENTASI_PELAYANAN'] : '');
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Integritas");
        $secondtable->addCell(500)->addText("=");
        $nilai_integritas = (isset($perilakukerja['INTEGRITAS']) && !empty($perilakukerja['INTEGRITAS'])) ? $perilakukerja['INTEGRITAS'] : 0;
        $jmlnilaiintegritas = (isset($perilakukerja['INTEGRITAS']) && !empty($perilakukerja['INTEGRITAS'])) ? 1 : 0;
        $secondtable->addCell(1000)->addText($nilai_integritas);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_INTEGRITAS']) && !empty($perilakukerja['KET_INTEGRITAS'])) ? $perilakukerja['KET_INTEGRITAS'] : '');
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Komitmen");
        $secondtable->addCell(500)->addText("=");
        $nilai_komitmen = (isset($perilakukerja['KOMITMEN']) && !empty($perilakukerja['KOMITMEN'])) ? $perilakukerja['KOMITMEN'] : 0;
        $jmlnilaikomitmen = (isset($perilakukerja['KOMITMEN']) && !empty($perilakukerja['KOMITMEN'])) ? 1 : 0;
        $secondtable->addCell(1000)->addText($nilai_komitmen);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_KOMITMEN']) && !empty($perilakukerja['KET_KOMITMEN'])) ? $perilakukerja['KET_KOMITMEN'] : '');
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Disiplin");
        $secondtable->addCell(500)->addText("=");
        $nilai_disiplin = (isset($perilakukerja['DISIPLIN']) && !empty($perilakukerja['DISIPLIN'])) ? $perilakukerja['DISIPLIN'] : 0;
        $jmlnilaidisiplin = (isset($perilakukerja['DISIPLIN']) && !empty($perilakukerja['DISIPLIN'])) ? 1 : 0;
        $secondtable->addCell(1000)->addText($nilai_disiplin);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_DISIPLIN']) && !empty($perilakukerja['KET_DISIPLIN'])) ? $perilakukerja['KET_DISIPLIN'] : '');
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Kerjasama");
        $secondtable->addCell(500)->addText("=");
        $nilai_kerjasama = (isset($perilakukerja['KERJASAMA']) && !empty($perilakukerja['KERJASAMA'])) ? $perilakukerja['KERJASAMA'] : 0;
        $jmlnilaikerjasama = (isset($perilakukerja['KERJASAMA']) && !empty($perilakukerja['KERJASAMA'])) ? 1 : 0;
        $secondtable->addCell(1000)->addText($nilai_kerjasama);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_KERJASAMA']) && !empty($perilakukerja['KET_KERJASAMA'])) ? $perilakukerja['KET_KERJASAMA'] : '');
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Kepemimpinan");
        $secondtable->addCell(500)->addText("=");
        $nilai_kepemimpinan = (isset($perilakukerja['KEPEMIMPINAN']) && !empty($perilakukerja['KEPEMIMPINAN'])) ? $perilakukerja['KEPEMIMPINAN'] : 0;
        $jmlnilaikepemimpinan = (isset($perilakukerja['KEPEMIMPINAN']) && !empty($perilakukerja['KEPEMIMPINAN'])) ? 1 : 0;
        $secondtable->addCell(1000)->addText($nilai_kepemimpinan);
        $secondtable->addCell(1000)->addText((isset($perilakukerja['KET_KEPEMIMPINAN']) && !empty($perilakukerja['KET_KEPEMIMPINAN'])) ? $perilakukerja['KET_KEPEMIMPINAN'] : '');
        $tabel->addCell(3000, array('vMerge' => 'continue'));
        $tabel->addRow();
        $tabel->addCell(500)->addText("");
        $tabel->addCell(2000)->addText("");
        $secondtable = $tabel->addCell(4000)->addTable();
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Jumlah");
        $secondtable->addCell(500)->addText("=");
        $secondtable->addCell(1000)->addText($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan);
        $secondtable->addCell(1000)->addText("-");
        $secondtable->addRow();
        $secondtable->addCell(1500)->addText("Nilai Rata-rata");
        $secondtable->addCell(500)->addText("=");
//        $secondtable->addCell(1000)->addText((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan)));
        $secondtable->addCell(1000)->addText(0);
        $secondtable->addCell(1000)->addText("-");
        $tabel->addCell(3000, array('vMerge' => 'continue'));
        $section->addPageBreak();

        $section->addImage($logogaruda, array('align' => 'center'));
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('PENILAIAN PRESTASI KERJA'), 'rStyle4', 'pStyle');
        $section->addText(htmlspecialchars('PEGAWAI NEGERI SIPIL'), 'rStyle4', 'pStyle');
        $section->addTextBreak(1);

        $tabel = $section->addTable();
        $tabel->addRow();
        $tabel->addCell(4500)->addText("");
        $tabel->addCell(4500)->addText("JANGKA WAKTU PENILAIAN");
        $tabel->addRow();
        $tabel->addCell(4500)->addText("(BADAN PENCARIAN DAN PERTOLONGAN)");
        $tabel->addCell(4500)->addText("1 " . $bulanperiodeawal . " - 31 " . $bulanperiodeakhir . " " . $dataskp->PERIODE_TAHUN);
        $section->addTextBreak();
        
        $tabel = $section->addTable(array('borderSize' => 1, 'borderColor' => '999999', 'unit' => 'pct'));
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("1."), 'rStyle7');
        $tabel->addCell(8600,array('gridSpan' => 3))->addText(htmlspecialchars("YANG DINILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($pegawai)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_YGDINILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_YGDINILAI . ", " . $dataskp->GOLONGAN_YGDINILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_YGDINILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("2."), 'rStyle7');
        $tabel->addCell(8600,array('gridSpan' => 3))->addText(htmlspecialchars("PEJABAT PENILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($namapejabat)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_PEJABAT_PENILAI . " / " . $dataskp->GOLONGAN_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars("3."), 'rStyle7');
        $tabel->addCell(8600,array('gridSpan' => 3))->addText(htmlspecialchars("ATASAN PEJABAT PENILAI"), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("a. Nama"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars(strtoupper($namapenilai)), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("b. NIP"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->NIP_ATASAN_PEJABAT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("c. Pangkat/Gol.Ruang"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->PANGKAT_ATASAN_PEJABAT_PENILAI . " / " . $dataskp->GOLONGAN_ATASAN_PJBT_PENILAI), 'rStyle7');
        $tabel->addRow();
        $tabel->addCell(400)->addText(htmlspecialchars(""));
        $tabel->addCell(3000)->addText(htmlspecialchars("d. Jabatan"), 'rStyle7');
        $tabel->addCell(400)->addText(htmlspecialchars(":"), 'rStyle7');
        $tabel->addCell(5200)->addText(htmlspecialchars($dataskp->JABATAN_ATASAN_PJBT_PENILAI), 'rStyle7');
        
        $jmlnilaicapaian = $totnilaicapaianskp*0.6;
        
        $bawah = $tabel->addRow()->addCell(9000,array('gridSpan' => 4));
        $innercell = $bawah->addTable(array('borderSize' => 1, 'borderColor' => '999999'));
        $innercell->addRow();
        $innercell->addCell(950, array('valign' => 'center','vMerge' => 'restart'))->addText(htmlspecialchars("4"),'rStyle7','pStyle');
        $innercell->addCell(7100,array('gridSpan' => 7))->addText(htmlspecialchars("UNSUR YANG DINILAI"), 'rStyle7');
        $innercell->addCell(1500,array('valign' => 'center'))->addText(htmlspecialchars("JUMLAH"), 'rStyle7', 'pStyle');
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'restart'));
        $innercell->addCell(400)->addText(htmlspecialchars("a"));
        $innercell->addCell(5000,array('gridSpan' => 4))->addText(htmlspecialchars("Sasaran Kerja Pegawai"), 'rStyle7');
        $innercell->addCell(1000)->addText(htmlspecialchars(number_format($totnilaicapaianskp,2)), 'rStyle7');
        $innercell->addCell(1000)->addText(htmlspecialchars("X 60%"), 'rStyle7');
        $innercell->addCell(1500,array('valign' => 'center'))->addText(htmlspecialchars(number_format($totnilaicapaianskp*0.6, 2)));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'restart'))->addText(htmlspecialchars("b"));
        $innercell->addCell(1000, array('vMerge' => 'restart'))->addText(htmlspecialchars("Perilaku Kerja"), 'rStyle7');
        $innercell->addCell(500)->addText(htmlspecialchars("1"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Orientasi Pelayanan"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilaiorientasi_pelayanan), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_ORIENTASI_PELAYANAN']) && !empty($perilakukerja['KET_ORIENTASI_PELAYANAN'])) ? $perilakukerja['KET_ORIENTASI_PELAYANAN'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'restart'))->addText(htmlspecialchars(""), 'rStyle7');
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars("2"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Integritas"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilai_integritas), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_INTEGRITAS']) && !empty($perilakukerja['KET_INTEGRITAS'])) ? $perilakukerja['KET_INTEGRITAS'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars("3"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Komitmen"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilai_komitmen), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_KOMITMEN']) && !empty($perilakukerja['KET_KOMITMEN'])) ? $perilakukerja['KET_KOMITMEN'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars("4"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Disiplin"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilai_disiplin), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_DISIPLIN']) && !empty($perilakukerja['KET_DISIPLIN'])) ? $perilakukerja['KET_DISIPLIN'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars("5"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Kerjasama"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilai_kerjasama), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_KERJASAMA']) && !empty($perilakukerja['KET_KERJASAMA'])) ? $perilakukerja['KET_KERJASAMA'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars("6"), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Kepemimpinan"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilai_kepemimpinan), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars((isset($perilakukerja['KET_KEPEMIMPINAN']) && !empty($perilakukerja['KET_KEPEMIMPINAN'])) ? $perilakukerja['KET_KEPEMIMPINAN'] : ''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars(""), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Jumlah"), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars(''), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars(""), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Nilai Rata-rata"), 'rStyle7');
//        $innercell->addCell(4500)->addText(htmlspecialchars((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan))), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars(''), 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars(""), 'rStyle7');
        $innercell->addCell(4500, array('vMerge' => 'continue'));
        $innercell->addRow();
        $innercell->addCell(950, array('vMerge' => 'continue'));
        $innercell->addCell(400, array('vMerge' => 'continue'));
        $innercell->addCell(1000, array('vMerge' => 'continue'));
        $innercell->addCell(500)->addText(htmlspecialchars(""), 'rStyle7');
        $innercell->addCell(4500,array('gridSpan' => 2))->addText(htmlspecialchars("Nilai Perilaku kerja"), 'rStyle7');
//        $innercell->addCell(4500)->addText(htmlspecialchars((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan))), 'rStyle7');
        $innercell->addCell(4500)->addText(0, 'rStyle7');
        $innercell->addCell(4500)->addText(htmlspecialchars("X 40%"), 'rStyle7');
//        $innercell->addCell(4500)->addText(htmlspecialchars(number_format((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan))*0.4,2)), 'rStyle7');
        $innercell->addCell(4500)->addText(0, 'rStyle7');
        // mulai
//        $totnya = ($jmlnilaicapaian) + ((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan))*0.4);
        $totnya = 0;
        //
        $innercell->addRow();
        $innercell->addCell(7000, array('vMerge' => 'restart', 'gridSpan' => 8,'valign' => 'center'))->addText(htmlspecialchars("Nilai Prestasi Kerja"), 'rStyle7', 'pStyle');
        $innercell->addCell(1500,array('valign' => 'center'))->addText(htmlspecialchars(number_format($totnya,2)), 'rStyle7', 'pStyle');
        $innercell->addRow();
        $innercell->addCell(7000, array('vMerge' => 'continue', 'gridSpan' => 8));
        $innercell->addCell(1500, array('valign' => 'center'))->addText(htmlspecialchars("JUMLAH"), 'rStyle7', 'pStyle');
        $bawahya = $innercell->addRow()->addCell(9000, array('gridSpan' => 9));
        $palingbawah = $bawahya->addTable();
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 3))->addText(htmlspecialchars("5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI (APABILA ADA)"), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 3))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 3))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 3))->addText(htmlspecialchars("Tanggal ..............................."), 'rStyle7', 'pStyleRight');
        $bawahya = $innercell->addRow()->addCell(9000, array('gridSpan' => 9));
        $palingbawah = $bawahya->addTable();
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN"), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("Tanggal ..............................."), 'rStyle7', 'pStyleRight');
        $bawahya = $innercell->addRow()->addCell(9000, array('gridSpan' => 9));
        $palingbawah = $bawahya->addTable();
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN"), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("Tanggal ..............................."), 'rStyle7', 'pStyleRight');
        $bawahya = $innercell->addRow()->addCell(9000, array('gridSpan' => 3));
        $palingbawah = $bawahya->addTable();
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("8. REKOMENDASI"), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars(""), 'rStyle7');
        $palingbawah->addRow();
        $palingbawah->addCell(9000, array('gridSpan' => 9))->addText(htmlspecialchars("Tanggal ..............................."), 'rStyle7', 'pStyleRight');
        $bawahya = $innercell->addRow()->addCell(9000, array('gridSpan' => 9));
        $palingbawah = $bawahya->addTable();
        $palingbawah->addRow();
        $palingbawah->addCell(4500)->addText("");
        $palingbawah->addCell(4500)->addText(htmlspecialchars("9. DIBUAT TANGGAL, "));
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars("PEJABAT PENILAI"),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(strtoupper($namapejabat)),'rStyle5','pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars($dataskp->NIP_PEJABAT_PENILAI),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500)->addText(htmlspecialchars("10. DITERIMA TANGGAL,"));
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars("PEGAWAI NEGERI SIPIL YANG DINILAI,"),null,'pStyle');
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(strtoupper($pegawai)),'rStyle5','pStyle');
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars($dataskp->NIP_YGDINILAI),null,'pStyle');
        $palingbawah->addCell(4500);
        $palingbawah->addRow();
        $palingbawah->addCell(4500)->addText("");
        $palingbawah->addCell(4500)->addText(htmlspecialchars("11. DITERIMA TANGGAL, "));
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars("ATASAN PEJABAT YANG MENILAI"),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(""),null,'pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars(strtoupper($namapenilai)),'rStyle5','pStyle');
        $palingbawah->addRow();
        $palingbawah->addCell(4500);
        $palingbawah->addCell(4500, array('valign' => 'center'))->addText(htmlspecialchars($dataskp->NIP_ATASAN_PEJABAT_PENILAI),null,'pStyle');
        
        $filename = 'Formulir SKP Pegawai.docx'; //save our document as this file name
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
    }

}
