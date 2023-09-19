<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Integrasi_bkn extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
//        if (!$this->ion_auth->logged_in()) {
//            redirect('akses/logout', 'refresh');
//        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
//            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
//        }
        $this->load->model(array('integrasi_bkn/integrasi_bkn_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js', 'assets/plugins/select2/js/select2.min.js', 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js']);
        $this->data['custom_js'] = ['integrasi_bkn/js'];
        $this->data['title_utama'] = 'Integrasi BKN';
    }

    public function index() {
        $this->data['content'] = 'integrasi_bkn/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function parameter() {
        $this->data['content'] = 'integrasi_bkn/parameter';
        $this->data['nip_pegawai'] = $this->input->get('nip_pegawai');
        
        $this->load->view('layouts/main', $this->data);
    }

    public function hasil() {
        $this->load->library('apibkn');

        if (empty($_GET['kriteria'])) {
            redirect('/integrasi_bkn');
        }

        if ((isset($_GET['nip_pegawai']) && !empty($_GET['nip_pegawai']))) {
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pokok') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-utama/" . $_GET['nip_pegawai']);
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = json_decode($result['data'], true);
                }
                
                $this->data['bkn'] = $bkn;
                $this->data['simpeg'] = $this->master_pegawai_model->get_by_nipnew_bkn($_GET['nip_pegawai']);
                $this->data['daftar_agama'] = $this->list_model->daftar_agama();
                $this->data['daftar_sts_nikah'] = $this->list_model->daftar_sts_nikah();

                $this->data['content'] = 'integrasi_bkn/data_pokok_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_ortu') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-ortu/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-ortu/" . $_GET['nip_pegawai']);
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
                $_GET['pegawai_id'] = $datapegawai['ID'];
                $lists = [];
                if ($bkn):
                    $this->db->select("TH_PEGAWAI_ORTU.*, to_char(TGL_LAHIR,'DD/MM/YYYY') as TGL_LAHIR2");
                    $this->db->from("TH_PEGAWAI_ORTU");
                    $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                    $this->db->where("to_char(TGL_LAHIR,'DD-MM-YYYY')", $bkn['ayah']['tglLahir']);
                    $this->db->like("lower(NAMA)", strtolower($bkn['ayah']['nama']), false);
                    $query = $this->db->get();
                    $row = $query->row_array();

                    $bknadadisimpegayah = true;
                    if (!$row) {
                        $this->db->select("TH_PEGAWAI_ORTU.*, to_char(TGL_LAHIR,'DD/MM/YYYY') as TGL_LAHIR2");
                        $this->db->from("TH_PEGAWAI_ORTU");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->like("TMSTATUSORTU_ID", 1);
                        $query = $this->db->get();
                        $row = $query->row_array();
                        $bknadadisimpegayah = false;
                    }

                    $lists[0] = (object) [
                        'ID' => $row['ID'],
                        'NAMA' => $row['NAMA'],
                        'TGL_LAHIR' => $row['TGL_LAHIR2'],
                    ];

                    $this->db->select("TH_PEGAWAI_ORTU.*, to_char(TGL_LAHIR,'DD/MM/YYYY') as TGL_LAHIR2");
                    $this->db->from("TH_PEGAWAI_ORTU");
                    $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                    $this->db->where("to_char(TGL_LAHIR,'DD-MM-YYYY')", $bkn['ibu']['tglLahir']);
                    $this->db->like("lower(NAMA)", strtolower($bkn['ibu']['nama']), false);
                    $query1 = $this->db->get();
                    $row1 = $query1->row_array();

                    $bknadadisimpegibu = true;
                    if (!$row1) {
                        $this->db->select("TH_PEGAWAI_ORTU.*, to_char(TGL_LAHIR,'DD/MM/YYYY') as TGL_LAHIR2");
                        $this->db->from("TH_PEGAWAI_ORTU");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->like("TMSTATUSORTU_ID", 2);
                        $query1 = $this->db->get();
                        $row1 = $query1->row_array();
                        $bknadadisimpegibu = false;
                    }

                    $lists[1] = (object) [
                        'ID' => $row1['ID'],
                        'NAMA' => $row1['NAMA'],
                        'TGL_LAHIR' => $row1['TGL_LAHIR2'],
                    ];
                endif;

                $this->data['simpeg'] = $lists;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['bknadadisimpegayah'] = $bknadadisimpegayah;
                $this->data['bknadadisimpegibu'] = $bknadadisimpegibu;

                $this->data['content'] = 'integrasi_bkn/data_ortu_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pasangan') {
                $this->load->model(array('master_pegawai/master_pegawai_pasangan_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-pasangan/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-pasangan/" . $_GET['nip_pegawai']);
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $bknadadisimpeg = true;
                $row = [];
                if ($bkn) {
                    $this->db->select("TH_PEGAWAI_PASANGAN.DOC_AKTENIKAH,TH_PEGAWAI_PASANGAN.ID,TH_PEGAWAI_PASANGAN.JENIS_PASANGAN,TH_PEGAWAI_PASANGAN.PASANGAN_KE,TH_PEGAWAI_PASANGAN.NAMA,TH_PEGAWAI_PASANGAN.TEMPAT_LHR,TH_PEGAWAI_PASANGAN.TGL_LAHIR,TO_CHAR(TH_PEGAWAI_PASANGAN.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2,TO_CHAR(TH_PEGAWAI_PASANGAN.TGL_NIKAH,'DD/MM/YYYY') AS TGL_NIKAH2");
                    $this->db->from("TH_PEGAWAI_PASANGAN");
                    $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                    $this->db->where("to_char(TGL_LAHIR,'DD-MM-YYYY')", $bkn['listPasangan'][0]['dataOrang']['tglLahir']);
                    $this->db->like("lower(NAMA)", strtolower($bkn['listPasangan'][0]['dataOrang']['nama']), false);
                    $query = $this->db->get();
                    $row = $query->result();

                    if (!$row) {
                        $bknadadisimpeg = false;
                    }
                }

                $_POST['pegawai_id'] = $datapegawai['ID'];
                $this->data['simpeg'] = $row;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['bknadadisimpeg'] = $bknadadisimpeg;
                $this->data['content'] = 'integrasi_bkn/data_pasangan_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_anak') {
                $this->load->model(array('master_pegawai/master_pegawai_anak_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-anak/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-anak/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }

                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
                $_POST['pegawai_id'] = $datapegawai['ID'];

                $list = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn['listAnak'] as $val):
                        $this->db->select("TH_PEGAWAI_ANAK.ID,TH_PEGAWAI_ANAK.NAMA,TH_PEGAWAI_ANAK.TMPEGAWAI_ID,TH_PEGAWAI_ANAK.SEX,TH_PEGAWAI_ANAK.PEKERJAAN,TH_PEGAWAI_ANAK.TEMPAT_LHR,TH_PEGAWAI_ANAK.TGL_LAHIR,TO_CHAR(TH_PEGAWAI_ANAK.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2,TH_PEGAWAI_ANAK.DOC_AKTEANAK,TR_STATUS_ANAK.NAMA AS STATUS_ANAK");
                        $this->db->from("TH_PEGAWAI_ANAK");
                        $this->db->join("TR_STATUS_ANAK", "TR_STATUS_ANAK.ID=TH_PEGAWAI_ANAK.TRSTATUSANAK_ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where("to_char(TGL_LAHIR,'DD-MM-YYYY')", $val['tglLahir']);
//                        $this->db->like("lower(TH_PEGAWAI_ANAK.NAMA)", strtolower($val['nama']), false);
                        $sex = array_keys($this->config->item('daftar_jk'),'Wanita');
                        $this->db->where("SEX", $sex[0]);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $list[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $list[] = (object) [];

                    endforeach;
                endif;
                
                $this->db->select("TH_PEGAWAI_ANAK.ID,TH_PEGAWAI_ANAK.NAMA,TH_PEGAWAI_ANAK.TMPEGAWAI_ID,TH_PEGAWAI_ANAK.SEX,TH_PEGAWAI_ANAK.PEKERJAAN,TH_PEGAWAI_ANAK.TEMPAT_LHR,TH_PEGAWAI_ANAK.TGL_LAHIR,TO_CHAR(TH_PEGAWAI_ANAK.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2,TH_PEGAWAI_ANAK.DOC_AKTEANAK,TR_STATUS_ANAK.NAMA AS STATUS_ANAK");
                $this->db->from("TH_PEGAWAI_ANAK");
                $this->db->join("TR_STATUS_ANAK", "TR_STATUS_ANAK.ID=TH_PEGAWAI_ANAK.TRSTATUSANAK_ID", "LEFT");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_ANAK.ID', $listid);
                }

                $sql = $this->db->get();
                $result = $sql->result();
                
                $merge = array_merge($list, $result);

                $this->data['bkn'] = $bkn;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_anak_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pangkat') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-golongan/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-golongan/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("MK_GOLONGAN_V.*");
                        $this->db->from("MK_GOLONGAN_V");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where("TMT_GOL2", str_replace("-", "/", $val['tmtGolongan']));
                        $this->db->where("ID_BKN_GOL", $val['golonganId']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("MK_GOLONGAN_V.*");
                $this->db->from("MK_GOLONGAN_V");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('ID', $listid);
                }
                $sql = $this->db->get();
                $hasil = $sql->result();

                $merge = array_merge($listsobject, $hasil);
//                $merge = $listsobject + $hasil;
                $this->data['simpeg'] = $merge;
//                print '<pre>';
////                echo $datapegawai['ID']."<br />";
//                print_r($bkn);
//                print_r($hasil);
//                print_r($listsobject);
//                print_r($merge);
//                print '</pre>';
//                exit;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_pangkat_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_jabatan') {
                $this->load->model(array('master_pegawai/master_pegawai_jabatan_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-jabatan/" . $_GET['nip_pegawai']);
//                $outcome = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-jabatan/" . $_GET['nip_pegawai']);
                $outcome = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,
                        TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK2,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN,
                        TRE.ESELON,TRJ.JABATAN");
                        $this->db->from("TH_PEGAWAI_JABATAN TPJ");
                        $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
                        $this->db->join("TR_STRUKTUR_ORGANISASI TSO", "TSO.TRLOKASI_ID=TPJ.TRLOKASI_ID AND TSO.KDU1=TPJ.KDU1 AND TSO.KDU2=TPJ.KDU2 AND TSO.KDU3=TPJ.KDU3 AND TSO.KDU4=TPJ.KDU4 AND TSO.KDU5=TPJ.KDU5", "LEFT");
                        $this->db->join("TR_JABATAN TRJ", "TPJ.TRJABATAN_ID=TRJ.ID", "LEFT");
                        $this->db->join("TR_ESELON TRE", "TPJ.TRESELON_ID=TRE.ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
//                        $this->db->where('TSO.ID_BKN', $val['unorId']);
                        $this->db->where('TPJ.NO_SK', $val['nomorSk']);
                        $this->db->where("TO_CHAR(TPJ.TGL_SK,'DD-MM-YYYY')", $val['tanggalSk']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,
                TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK2,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN,
                TRE.ESELON,TRJ.JABATAN");
                $this->db->from("TH_PEGAWAI_JABATAN TPJ");
                $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
                $this->db->join("TR_STRUKTUR_ORGANISASI TSO", "TSO.TRLOKASI_ID=TPJ.TRLOKASI_ID AND TSO.KDU1=TPJ.KDU1 AND TSO.KDU2=TPJ.KDU2 AND TSO.KDU3=TPJ.KDU3 AND TSO.KDU4=TPJ.KDU4 AND TSO.KDU5=TPJ.KDU5", "LEFT");
                $this->db->join("TR_JABATAN TRJ", "TPJ.TRJABATAN_ID=TRJ.ID", "LEFT");
                $this->db->join("TR_ESELON TRE", "TPJ.TRESELON_ID=TRE.ID", "LEFT");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TPJ.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($outcome);
//                print_r($listsobject);
//                print_r($merge);
//                print '</pre>';
//                echo count($merge)."<br />";
//                echo max(count($merge),count($bkn));
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];

                $this->data['content'] = 'integrasi_bkn/data_jabatan_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pendidikan') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pendidikan/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pendidikan/" . $_GET['nip_pegawai']);

                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_PENDIDIKAN.ID,TR_TINGKAT_PENDIDIKAN.TINGKAT_PENDIDIKAN,NAMA_LBGPDK,NAMA_FAKULTAS,NAMA_JURUSAN,NO_STTB,THN_LULUS,DOC_IJASAH,ID_BKN,NAMA_BKN,GROUP_ID_BKN");
                        $this->db->join("TR_TINGKAT_PENDIDIKAN", "(TR_TINGKAT_PENDIDIKAN.ID=TH_PEGAWAI_PENDIDIKAN.TRTINGKATPENDIDIKAN_ID)", "LEFT");
                        $this->db->join("TR_FAKULTAS", "(TR_FAKULTAS.ID=TH_PEGAWAI_PENDIDIKAN.TRFAKULTAS_ID)", "LEFT");
                        $this->db->join("TR_JURUSAN", "(TR_JURUSAN.ID=TH_PEGAWAI_PENDIDIKAN.TRJURUSAN_ID)", "LEFT");
                        $this->db->from("TH_PEGAWAI_PENDIDIKAN");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TR_TINGKAT_PENDIDIKAN.ID_BKN', $val['tkPendidikanId']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_PENDIDIKAN.ID,TR_TINGKAT_PENDIDIKAN.TINGKAT_PENDIDIKAN,NAMA_LBGPDK,NAMA_FAKULTAS,NAMA_JURUSAN,NO_STTB,THN_LULUS,DOC_IJASAH,ID_BKN,NAMA_BKN,GROUP_ID_BKN");
                $this->db->join("TR_TINGKAT_PENDIDIKAN", "(TR_TINGKAT_PENDIDIKAN.ID=TH_PEGAWAI_PENDIDIKAN.TRTINGKATPENDIDIKAN_ID)", "LEFT");
                $this->db->join("TR_FAKULTAS", "(TR_FAKULTAS.ID=TH_PEGAWAI_PENDIDIKAN.TRFAKULTAS_ID)", "LEFT");
                $this->db->join("TR_JURUSAN", "(TR_JURUSAN.ID=TH_PEGAWAI_PENDIDIKAN.TRJURUSAN_ID)", "LEFT");
                $this->db->from("TH_PEGAWAI_PENDIDIKAN");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_PENDIDIKAN.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($listsobject);
//                print '</pre>';
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_pendidikan_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_kursus') {
                $this->load->model(array('master_pegawai/master_pegawai_seminar_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-kursus/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-kursus/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
                $_POST['pegawai_id'] = $datapegawai['ID'];
                $this->data['simpeg'] = $this->master_pegawai_seminar_model->get_datatables($datapegawai['ID']);
                
//                print '<pre>';
//                print_r($bkn);
//                print_r($listsobject);
//                print '</pre>';
//                exit;
                
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_kursus_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_penghargaan') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-penghargaan/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-penghargaan/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_PENGHARGAAN.ID,JENIS_TANDA_JASA,TANDA_JASA,NOMOR,THN_PRLHN,NAMA_NEGARA,INSTANSI,DOC_SERTIFIKAT,TR_TANDA_JASA.ID_BKN,TR_TANDA_JASA.NAMA_BKN");
                        $this->db->join("TR_JENIS_TANDA_JASA", "(TR_JENIS_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRJENISTANDAJASA_ID)", "LEFT");
                        $this->db->join("TR_TANDA_JASA", "(TR_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRTANDAJASA_ID)", "LEFT");
                        $this->db->join("TR_NEGARA", "(TR_NEGARA.ID=TH_PEGAWAI_PENGHARGAAN.TRNEGARA_ID)", "LEFT");
                        $this->db->from("TH_PEGAWAI_PENGHARGAAN");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TR_TANDA_JASA.ID_BKN', $val['jenisHarga']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_PENGHARGAAN.ID,JENIS_TANDA_JASA,TANDA_JASA,NOMOR,THN_PRLHN,NAMA_NEGARA,INSTANSI,DOC_SERTIFIKAT,TR_TANDA_JASA.ID_BKN,TR_TANDA_JASA.NAMA_BKN");
                $this->db->join("TR_JENIS_TANDA_JASA", "(TR_JENIS_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRJENISTANDAJASA_ID)", "LEFT");
                $this->db->join("TR_TANDA_JASA", "(TR_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRTANDAJASA_ID)", "LEFT");
                $this->db->join("TR_NEGARA", "(TR_NEGARA.ID=TH_PEGAWAI_PENGHARGAAN.TRNEGARA_ID)", "LEFT");
                $this->db->from("TH_PEGAWAI_PENGHARGAAN");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_PENGHARGAAN.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($merge);
//                print '</pre>';
//                echo count($merge)."<br />";
//                echo max(count($merge),count($bkn));
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_penghargaan_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_diklat') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-diklat/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-diklat/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_DIKLAT_PENJENJANGAN.ID,NAMA_JENJANG,THN_DIKLAT,JPL,NO_STTPP,TGL_STTPP,DOC_PENJENJANGAN,ID_BKN,NAMA_BKN,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2");
                        $this->db->from("TH_PEGAWAI_DIKLAT_PENJENJANGAN");
                        $this->db->join("TR_TINGKAT_DIKLAT_KEPEMIMPINAN", "TR_TINGKAT_DIKLAT_KEPEMIMPINAN.ID=TH_PEGAWAI_DIKLAT_PENJENJANGAN.TRTINGKATDIKLATKEPEMIMPINAN_ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TR_TINGKAT_DIKLAT_KEPEMIMPINAN.ID_BKN', $val['latihanStrukturalId']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_DIKLAT_PENJENJANGAN.ID,NAMA_JENJANG,THN_DIKLAT,JPL,NO_STTPP,TGL_STTPP,DOC_PENJENJANGAN,ID_BKN,NAMA_BKN,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2");
                $this->db->from("TH_PEGAWAI_DIKLAT_PENJENJANGAN");
                $this->db->join("TR_TINGKAT_DIKLAT_KEPEMIMPINAN", "TR_TINGKAT_DIKLAT_KEPEMIMPINAN.ID=TH_PEGAWAI_DIKLAT_PENJENJANGAN.TRTINGKATDIKLATKEPEMIMPINAN_ID", "LEFT");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_DIKLAT_PENJENJANGAN.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($merge);
//                print '</pre>';
//                exit;

                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_diklat_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_angkakredit') {
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-angkakredit/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-angkakredit/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_AK.ID,TAHUN_KREDIT,JABATAN,AK_UTAMA,AK_PENUNJANG,AK_JUMLAH,DOC_AK,TO_CHAR(PERIODE_AWAL,'MM/YYYY') PERIODE_AWAL,TO_CHAR(PERIODE_AKHIR,'MM/YYYY') PERIODE_AKHIR,NO_SK,TO_CHAR(TGL_SK,'DD-MM-YYYY') TGL_SK");
                        $this->db->from("TH_PEGAWAI_AK");
                        $this->db->join("TR_JABATAN", "TR_JABATAN.ID=TH_PEGAWAI_AK.TRJABATAN_ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('NO_SK', $val['nomorSk']);
                        $this->db->where("to_char(PERIODE_AWAL,'fmmm')", $val['bulanMulaiPenailan']);
                        $this->db->where("to_char(PERIODE_AWAL,'yyyy')", $val['tahunMulaiPenailan']);
                        $this->db->where("to_char(PERIODE_AKHIR,'fmmm')", $val['bulanSelesaiPenailan']);
                        $this->db->where("to_char(PERIODE_AKHIR,'yyyy')", $val['tahunSelesaiPenailan']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_AK.ID,TAHUN_KREDIT,JABATAN,AK_UTAMA,AK_PENUNJANG,AK_JUMLAH,DOC_AK,TO_CHAR(PERIODE_AWAL,'MM/YYYY') PERIODE_AWAL,TO_CHAR(PERIODE_AKHIR,'MM/YYYY') PERIODE_AKHIR,NO_SK,TO_CHAR(TGL_SK,'DD-MM-YYYY') TGL_SK");
                $this->db->from("TH_PEGAWAI_AK");
                $this->db->join("TR_JABATAN", "TR_JABATAN.ID=TH_PEGAWAI_AK.TRJABATAN_ID", "LEFT");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_AK.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($listsobject);
//                print_r($hasil);
//                print_r($merge);
//                print '</pre>';
//                exit;

                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_angkakredit_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_skp') {
                $this->load->model(array('master_pegawai/master_pegawai_skp_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-skp/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-skp/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                $pnsId = '';
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_SKP.ID, PERIODE_AWAL,PERIODE_AKHIR,PERIODE_TAHUN,TH_PEGAWAI_SKP_DETAIL.NILAI_AKHIR,ORIENTASI_PELAYANAN,
                        INTEGRITAS,KOMITMEN,DISIPLIN,KERJASAMA,KEPEMIMPINAN");
                        $this->db->from("TH_PEGAWAI_SKP");
                        $this->db->join("TH_PEGAWAI_SKP_DETAIL", "TH_PEGAWAI_SKP_DETAIL.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                        $this->db->join("TH_PEGAWAI_SKP_PERILAKUKERJA", "TH_PEGAWAI_SKP_PERILAKUKERJA.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                        $this->db->where('NIP_YGDINILAI', $datapegawai['NIPNEW']);
                        $this->db->where('PERIODE_TAHUN', $val['tahun']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                        $pnsId = $val['pns'];
                    endforeach;
                    $this->master_pegawai_model->updateidpnsbkn($pnsId,$datapegawai['ID']);
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_SKP.ID, PERIODE_AWAL,PERIODE_AKHIR,PERIODE_TAHUN,TH_PEGAWAI_SKP_DETAIL.NILAI_AKHIR,ORIENTASI_PELAYANAN,
                INTEGRITAS,KOMITMEN,DISIPLIN,KERJASAMA,KEPEMIMPINAN");
                $this->db->from("TH_PEGAWAI_SKP");
                $this->db->join("TH_PEGAWAI_SKP_DETAIL", "TH_PEGAWAI_SKP_DETAIL.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                $this->db->join("TH_PEGAWAI_SKP_PERILAKUKERJA", "TH_PEGAWAI_SKP_PERILAKUKERJA.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                $this->db->where('NIP_YGDINILAI', $datapegawai['NIPNEW']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_SKP.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($listsobject);
//                print_r($result);
//                print '</pre>';
//                echo max(count($simpeg),count($this->data['bkn']))."<br />";
//                exit;

                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_skp_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_hukdis') {
//                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-hukdis/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-hukdis/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_SANKSI.ID,TKT_HUKUMAN_DISIPLIN,JENIS_HUKDIS,ALASAN_HKMN,TO_CHAR(TMT_HKMN,'DD/MM/YYYY') TMT_HKMN,NO_SK,TO_CHAR(TGL_SK,'DD/MM/YYYY') TGL_SK,TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AKHIR_HKMN,
                        TO_CHAR(TMT_HKMN,'DD/MM/YYYY')||' - '||TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AS PERIODE,DOC_SANKSI,TR_JENIS_HUKUMAN_DISIPLIN.ID_BKN,TR_JENIS_HUKUMAN_DISIPLIN.NAMA_BKN");
                        $this->db->join("TR_TKT_HUKUMAN_DISIPLIN", "(TR_TKT_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRTKTHUKUMANDISIPLIN_ID)", "LEFT");
                        $this->db->join("TR_JENIS_HUKUMAN_DISIPLIN", "(TR_JENIS_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRJENISHUKUMANDISIPLIN_ID)", "LEFT");
                        $this->db->from("TH_PEGAWAI_SANKSI");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TR_JENIS_HUKUMAN_DISIPLIN.ID_BKN', $val['jenisHukuman']);
                        $this->db->where("TO_CHAR(TH_PEGAWAI_SANKSI.TGL_SK,'YYYY-MM-DD')", $val['skTanggal']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_SANKSI.ID,TKT_HUKUMAN_DISIPLIN,JENIS_HUKDIS,ALASAN_HKMN,TO_CHAR(TMT_HKMN,'DD/MM/YYYY') TMT_HKMN,NO_SK,TO_CHAR(TGL_SK,'DD/MM/YYYY') TGL_SK,TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AKHIR_HKMN,
                TO_CHAR(TMT_HKMN,'DD/MM/YYYY')||' - '||TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AS PERIODE,DOC_SANKSI,TR_JENIS_HUKUMAN_DISIPLIN.ID_BKN,TR_JENIS_HUKUMAN_DISIPLIN.NAMA_BKN");
                $this->db->join("TR_TKT_HUKUMAN_DISIPLIN", "(TR_TKT_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRTKTHUKUMANDISIPLIN_ID)", "LEFT");
                $this->db->join("TR_JENIS_HUKUMAN_DISIPLIN", "(TR_JENIS_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRJENISHUKUMANDISIPLIN_ID)", "LEFT");
                $this->db->from("TH_PEGAWAI_SANKSI");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_SANKSI.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($merge);
//                print '</pre>';
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_hukdis_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pemberhentian') {
//                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pemberhentian/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pemberhentian/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
                
                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TH_PEGAWAI_SANKSI.ID,TKT_HUKUMAN_DISIPLIN,JENIS_HUKDIS,ALASAN_HKMN,TO_CHAR(TMT_HKMN,'DD/MM/YYYY') TMT_HKMN,NO_SK,TO_CHAR(TGL_SK,'DD/MM/YYYY') TGL_SK,TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AKHIR_HKMN,
                        TO_CHAR(TMT_HKMN,'DD/MM/YYYY')||' - '||TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AS PERIODE,DOC_SANKSI,TR_JENIS_HUKUMAN_DISIPLIN.ID_BKN,TR_JENIS_HUKUMAN_DISIPLIN.NAMA_BKN");
                        $this->db->join("TR_TKT_HUKUMAN_DISIPLIN", "(TR_TKT_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRTKTHUKUMANDISIPLIN_ID)", "LEFT");
                        $this->db->join("TR_JENIS_HUKUMAN_DISIPLIN", "(TR_JENIS_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRJENISHUKUMANDISIPLIN_ID)", "LEFT");
                        $this->db->from("TH_PEGAWAI_SANKSI");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TR_JENIS_HUKUMAN_DISIPLIN.ID', 3);
                        $this->db->where("TO_CHAR(TH_PEGAWAI_SANKSI.TGL_SK,'YYYY-MM-DD')", $val['skTanggal']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $this->db->select("TH_PEGAWAI_SANKSI.ID,TKT_HUKUMAN_DISIPLIN,JENIS_HUKDIS,ALASAN_HKMN,TO_CHAR(TMT_HKMN,'DD/MM/YYYY') TMT_HKMN,NO_SK,TO_CHAR(TGL_SK,'DD/MM/YYYY') TGL_SK,TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AKHIR_HKMN,
                TO_CHAR(TMT_HKMN,'DD/MM/YYYY')||' - '||TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AS PERIODE,DOC_SANKSI,TR_JENIS_HUKUMAN_DISIPLIN.ID_BKN,TR_JENIS_HUKUMAN_DISIPLIN.NAMA_BKN");
                $this->db->join("TR_TKT_HUKUMAN_DISIPLIN", "(TR_TKT_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRTKTHUKUMANDISIPLIN_ID)", "LEFT");
                $this->db->join("TR_JENIS_HUKUMAN_DISIPLIN", "(TR_JENIS_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRJENISHUKUMANDISIPLIN_ID)", "LEFT");
                $this->db->from("TH_PEGAWAI_SANKSI");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                $this->db->where('TR_JENIS_HUKUMAN_DISIPLIN.ID', 3);
                if (count($listid) > 0) {
                    $this->db->where_not_in('TH_PEGAWAI_SANKSI.ID', $listid);
                }
                $query = $this->db->get();
                $hasil = $query->result();

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($hasil);
//                print_r($merge);
//                print '</pre>';
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                $this->data['content'] = 'integrasi_bkn/data_pemberhentian_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pindahinstansi') {
//                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pindahinstansi/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pindahinstansi/" . $_GET['nip_pegawai']);
                
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,
                        TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK2,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN,
                        TRE.ESELON,TRJ.JABATAN");
                        $this->db->from("TH_PEGAWAI_JABATAN TPJ");
                        $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
                        $this->db->join("TR_STRUKTUR_ORGANISASI TSO", "TSO.TRLOKASI_ID=TPJ.TRLOKASI_ID AND TSO.KDU1=TPJ.KDU1 AND TSO.KDU2=TPJ.KDU2 AND TSO.KDU3=TPJ.KDU3 AND TSO.KDU4=TPJ.KDU4 AND TSO.KDU5=TPJ.KDU5", "LEFT");
                        $this->db->join("TR_JABATAN TRJ", "TPJ.TRJABATAN_ID=TRJ.ID", "LEFT");
                        $this->db->join("TR_ESELON TRE", "TPJ.TRESELON_ID=TRE.ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
//                        $this->db->where('TSO.ID_BKN', $val['unorId']);
                        $this->db->where('TPJ.NO_SK', $val['skUsulNomor']);
                        $this->db->where("TO_CHAR(TPJ.TGL_SK,'DD-MM-YYYY')", $val['skUsulTanggal']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($outcome);
//                print_r($listsobject);
//                print_r($merge);
//                print '</pre>';
//                echo count($merge)."<br />";
//                echo max(count($merge),count($bkn));
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                
                $this->data['content'] = 'integrasi_bkn/data_pindahinstansi_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_masakerja') {
//                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-masakerja/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-masakerja/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);

                $listsobject = [];
                $listid = [];
                if ($bkn):
                    foreach ($bkn as $val):
                        $this->db->select("TMP.*");
                        $this->db->from("TM_PEGAWAI TMP");
                        $this->db->join("TH_PEGAWAI_CPNS TPC", "TMP.ID=TPC.TMPEGAWAI_ID", "LEFT");
                        $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                        $this->db->where('TPC.BLN_MASAKERJA', $val['masaKerjaBulan']);
                        $this->db->where('TPC.THN_MASAKERJA', $val['masaKerjaTahun']);
                        $query = $this->db->get();
                        $row = $query->row();

                        if (isset($row->ID)) {
                            $listsobject[] = $row;
                            $listid[] = $row->ID;
                        } else
                            $listsobject[] = [];
                    endforeach;
                endif;

                $hasil = [];
                $merge = array_merge($listsobject, $hasil);

//                print '<pre>';
//                print_r($bkn);
//                print_r($outcome);
//                print_r($listsobject);
//                print_r($merge);
//                print '</pre>';
//                echo count($merge)."<br />";
//                echo max(count($merge),count($bkn));
//                exit;
                $this->data['simpeg'] = $merge;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['pegawaiid'] = $datapegawai['ID'];
                
                $this->data['content'] = 'integrasi_bkn/data_masakerja_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pnsunor') {
//                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
//                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
//                $_GET['pegawai_id'] = $datapegawai['ID'];
//                $this->data['simpeg'] = $this->master_pegawai_sanksi_model->get_datatables($_GET['nip_pegawai']);
                print '<pre>';
                print_r($bkn);
//                print_r($this->data['simpeg']);
                exit;
                $this->data['content'] = 'integrasi_bkn/data_hukdis_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_ctln') {
                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-cltn/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-cltn/" . $_GET['nip_pegawai']);

                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }
                $this->data['bkn'] = $bkn;
                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
                $_GET['pegawai_id'] = $datapegawai['ID'];
                $this->data['simpeg'] = [];
//                print '<pre>';
//                print_r($bkn);
//                print_r($this->data['simpeg']);
//                exit;
                $this->data['pegawainipnew'] = $datapegawai['NIPNEW'];
                $this->data['content'] = 'integrasi_bkn/data_ctln_hasil';
                $this->load->view('layouts/main', $this->data);
            }
            if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_pinwilayahkerja') {
                $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
//                $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-cltn/" . $_GET['nip_pegawai']);
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pwk/" . $_GET['nip_pegawai']);

//                $bkn = [];
//                if (isset($result['code']) && $result['code'] == 1) {
//                    $bkn = $result['data'];
//                }
//                $this->data['bkn'] = $bkn;
//                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
//                $_GET['pegawai_id'] = $datapegawai['ID'];
//                $this->data['simpeg'] = $this->master_pegawai_sanksi_model->get_datatables($_GET['nip_pegawai']);
                print '<pre>';
                print_r($result);
//                print_r($this->data['simpeg']);
                exit;
                $this->data['content'] = 'integrasi_bkn/data_hukdis_hasil';
                $this->load->view('layouts/main', $this->data);
            }
        }

        if (isset($_GET['kriteria']) && $_GET['kriteria'] == 'data_kposk') {
            $this->load->model(array('integrasi_bkn/kpo_bkn_model'));
            while (true) {
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/kpo/sk");
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }

                if ($bkn) {
                    foreach ($bkn as $val) {
                        $biasa = [
                            'ID' => $val['id'],
                            'NIPBARU' => $val['nipBaru'],
                            'GOLONGAN_ID' => $val['golongan']['id'],
                            'NO_SK' => $val['noSk'],
                            'NOTAPERTEK' => $val['notaPertek'],
                            'MK_GOL_BULAN' => $val['masaKerjaGolonganBulan'],
                            'JENISKP_ID' => $val['jenisKp']['id'],
                        ];
                        $tgl = [
                            'TMT_GOLONGAN' => $val['tmtGolongan'],
                            'TGL_SK' => datepickertodb(trim(str_replace("-", "/", $val['tglSk']))),
                        ];
                        $this->kpo_bkn_model->insert($biasa, $tgl);
                    }
                    continue;
                } else {
                    redirect("/integrasi_bkn/index_kposk");
                }
                
            }
        }

        if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_ppo') {
            $this->load->model(array('integrasi_bkn/ppo_bkn_model'));
            while (true) {
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/ppo/sk");
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }

                if ($bkn) {
                    foreach ($bkn as $val) {
                        $biasa = [
                            'ID' => $val['id'],
                            'NIPNEW' => $val['nipBaru'],
                            'KEDUDUKANHUKUM_ID' => $val['kedudukanHukum']['id'],
                            'KEDUDUKANHUKUM_NAMA' => $val['kedudukanHukum']['nama'],
                            'GOLONGAN_ID' => $val['golonganTerakhir']['id'],
                            'NO_SK' => $val['noSk'],
                            'NOMOR_PERTEK' => $val['nomorPertek'],
                            'MK_BULAN' => $val['masaKerjaPensiunBulan'],
                            'MK_BULAN' => $val['masaKerjaPensiunBulan'],
                            'NO_SK_TMS' => isset($val['noSkTms'])?$val['noSkTms']:NULL,
                            'NOMOR_USUL' => $val['nomorUsul'],
                            'TAHUN_GAPOK' => $val['tahunGapok'],
                            'JENIS_PENSIUN' => $val['jenisPensiun'],
                        ];
                        $tgl = [
                            'TMT_GOLONGAN' => $val['tmtGolongan'],
                            'TGL_SK' => datepickertodb(trim(str_replace("-", "/", $val['tglSk']))),
                            'TMT_PENSIUN' => datepickertodb(trim(str_replace("-", "/", $val['tmtPensiun']))),
                            'TGL_USUL' => datepickertodb(trim(str_replace("-", "/", $val['tglUsul']))),
                        ];
                        $this->ppo_bkn_model->insert($biasa, $tgl);
                    }
                    continue;
                } else {
                    redirect("/integrasi_bkn/index_pposk");
                }
                
            }
        }
        
        if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_ppowafat') {
            $this->load->model(array('integrasi_bkn/ppo_wafat_bkn_model'));
            while (true) {
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/ppo/usul/wafat");
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }

                if ($bkn) {
                    foreach ($bkn as $val) {
                        $biasa = [
                            'ID' => $val['id'],
                            'NIPNEW' => $val['nipBaru'],
                            'NIPLAMA' => $val['nipLama'],
                            'jenisPensiun' => $val['jenisPensiun'],
                            'AKTEMENINGGAL' => $val['golonganTerakhir']['id'],
                        ];
                        $tgl = [
                            'TGL_MENINGGAL' => datepickertodb(trim(str_replace("-", "/", $val['tglMeninggal']))),
                        ];
                        $this->ppo_wafat_bkn_model->insert($biasa, $tgl);
                    }
                    continue;
                } else {
                    redirect("/integrasi_bkn/index_ppowafat");
                }
                
            }
        }
        
        if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_updated_sapk') {
            $this->load->model(array('integrasi_bkn/updated_bkn_model'));
//            print '<pre>';
//            print_r($result);
//            exit;
            while (true) {
                $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/updated/pns");
                $bkn = [];
                if (isset($result['code']) && $result['code'] == 1) {
                    $bkn = $result['data'];
                }

                if ($bkn) {
                    foreach ($bkn as $val) {
                        $biasa = [
                            'ID' => $val['id'],
                            'NIPBARU' => isset($val['nipBaru']) ? $val['nipBaru'] : null,
                            'TMJENISRIWAYATBKN_ID' => $val['idJenisRiwayat'],
                            'IDRIWAYAT' => $val['idRiwayat'],
                            'LASTACTION' => $val['lastAction'],
                            'INSTANSIID' => $val['instansiId'],
                            'PNSORANGID' => $val['pnsOrangId'],
                        ];
                        
                        $tgl = [
                            'LASTUPDATETIME' => date('Y-m-d H:i:s', 1635758001574/1000),
                        ];
                        $this->updated_bkn_model->insert($biasa, $tgl);
                    }
                    continue;
                } else {
                    redirect("/integrasi_bkn/index_updated");
                }
                
            }
        }
        if (isset($_GET['kriteria']) && $_GET['kriteria'] === 'data_updated_hist_sapk') {
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/updated/hist/01-01-2021/30-06-2021");
            print '<pre>';
            print_r($result);
            exit;
        }
    }

    public function proses() {
        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_pokok') {
            if ($_POST['action'] === 'toSimpeg') {
                $this->load->model(array('master_pegawai/master_pegawai_cpns_model', 
                'master_pegawai/master_pegawai_pns_model','master_pegawai/master_pegawai_pangkat_model'));
                $datakawin = null;
                if (in_array('perkawinan', $_POST['pilih'])) {
                    $datakawin = $this->list_model->list_sts_nikah_bkn($_POST['simpeg_perkawinan'])['ID'];
                }

                $data_pokok = [
                    'nip_lama' => ["NIP" => $_POST['simpeg_nip_lama']],
                    'nip_baru' => ["NIPNEW" => $_POST['simpeg_nip_baru']],
                    'id_bkn' => ["ID_BKN" => $_POST['simpeg_id_bkn']],
                    'gelar_depan' => ["GELAR_DEPAN" => $_POST['simpeg_gelar_depan']],
                    'nama' => ["NAMA" => $_POST['simpeg_nama']],
                    'gelar_belakang' => ["GELAR_BLKG" => $_POST['simpeg_gelar_belakang']],
                    'tempat_lahir' => ["TPTLAHIR" => $_POST['simpeg_tempat_lahir']],
                    'agama' => ["TRAGAMA_ID" => $_POST['simpeg_agama']],
                    'jk' => ["SEX" => $_POST['simpeg_jk']],
                    'perkawinan' => ["TRSTATUSPERNIKAHAN_ID" => $_POST['simpeg_perkawinan']],
                    'email' => ["EMAIL" => $_POST['simpeg_email']],
                    'no_hp' => ["TELP_HP" => $_POST['simpeg_no_hp']],
                    'no_tlp' => ["TELP_RMH" => $_POST['simpeg_no_tlp']],
                    'no_ktp' => ["NO_KTP" => $_POST['simpeg_no_ktp']],
                    'no_karpeg' => ["NO_KARPEG" => $_POST['simpeg_no_karpeg']],
                    'no_taspen' => ["NO_TASPEN" => $_POST['simpeg_no_taspen']],
                    'no_npwp' => ["NO_NPWP" => $_POST['simpeg_no_npwp']],
                    'no_askes' => ["NO_ASKES" => $_POST['simpeg_no_askes']],
                    'no_bpjs' => ["NO_BPJS" => $_POST['simpeg_no_bpjs']],
                ];

                $data_pangkatcpns = [
                    'no_sk_cpns' => ["NO_SK" => $_POST['simpeg_no_sk_cpns']],
                ];
                $data_pangkattglcpns = [
                    'tmt_pns' => ["TMT_GOL" => bkntodb($_POST['simpeg_tmt_cpns'])],
                    'tgl_sk_cpns' => ["TGL_SK" => bkntodb($_POST['simpeg_tgl_sk_cpns'])],
                ];
                $data_pangkatpns = [
                    'no_sk_pns' => ["NO_SK" => $_POST['simpeg_no_sk_pns']],
                ];
                $data_pangkattglpns = [
                    'tmt_pns' => ["TMT_GOL" => bkntodb($_POST['simpeg_tmt_pns'])],
                    'tgl_sk_pns' => ["TGL_SK" => bkntodb($_POST['simpeg_tgl_sk_pns'])],
                ];
                $data_pns = [
                    'no_surat_dokter' => ["NO_STLK" => $_POST['simpeg_no_surat_dokter']],
                    'no_surat_napza' => ["NO_NAPZA" => $_POST['simpeg_no_surat_napza']],
                ];
                $data_pnstanggal = [
                    'tgl_surat_dokter' => ["TGL_STLK" => bkntodb($_POST['simpeg_tgl_surat_dokter'])],
                    'tgl_surat_napza' => ["TGL_NAPZA" => bkntodb($_POST['simpeg_tgl_surat_napza'])],
                ];

                if (count($_POST['pilih']) > 0) {
                    $ambildatapokok = [];
                    $ambilcpnspangkat = [];
                    $ambilcpnspangkattanggal = [];
                    $ambilpnspangkat = [];
                    $ambilpnspangkattanggal = [];
                    $ambilpns = [];
                    $ambilpnstanggal = [];
                    foreach ($_POST['pilih'] as $key => $value) {
                        if (isset($data_pokok[$value]))
                            $ambildatapokok[] = $data_pokok[$value];
                        if (isset($data_pangkatcpns[$value]))
                            $ambilcpnspangkat[] = $data_pangkatcpns[$value];
                        if (isset($data_pangkattglcpns[$value]))
                            $ambilcpnspangkattanggal[] = $data_pangkattglcpns[$value];
                        if (isset($data_pangkatpns[$value]))
                            $ambilpnspangkat[] = $data_pangkatpns[$value];
                        if (isset($data_pangkattglpns[$value]))
                            $ambilpnspangkattanggal[] = $data_pangkattglpns[$value];
                        if (isset($data_pns[$value]))
                            $ambilpns[] = $data_pns[$value];
                        if (isset($data_pnstanggal[$value]))
                            $ambilpnstanggal[] = $data_pnstanggal[$value];
                    }
                    $updatedatapokok = array_reduce($ambildatapokok, 'array_merge', array());
                    $updatepangkatcpns = array_reduce($ambilcpnspangkat, 'array_merge', array());
                    $updatepangkatcpnstanggal = array_reduce($ambilcpnspangkattanggal, 'array_merge', array());
                    $updatepangkatpns = array_reduce($ambilpnspangkat, 'array_merge', array());
                    $updatepangkatpnstanggal = array_reduce($ambilpnstanggal, 'array_merge', array());
                    $updatepns = array_reduce($ambilpns, 'array_merge', array());
                    $updatepnstanggal = array_reduce($ambilpnstanggal, 'array_merge', array());

                    $data_pokok_tanggal = [];
                    if (in_array('tanggal_lahir', $_POST['pilih'])) {
                        $data_pokok_tanggal = [
                            "TGLLAHIR" => bkntodb($_POST['simpeg_tanggal_lahir'])
                        ];
                    }

                    $this->master_pegawai_model->update($updatedatapokok, $data_pokok_tanggal, $_POST['id_pegawai_simpeg']);
                    $jmltglcpns = 0;
                    if (in_array('tmt_cpns', $_POST['pilih'])) {
                        $jmltglcpns = 1;
                        $data_tanggal_cpns = [
                            "TMT_CPNS" => bkntodb($_POST['simpeg_tmt_cpns'])
                        ];
                        $this->master_pegawai_cpns_model->update([], $data_tanggal_cpns, $_POST['id_pegawai_simpeg']);
                    }
                    $this->master_pegawai_pangkat_model->update($updatepangkatcpns, $updatepangkatcpnstanggal, $_POST['id_pegawai_simpeg'], 5);
                    $this->master_pegawai_pns_model->update($updatepns, $updatepnstanggal, $_POST['id_pegawai_simpeg']);

                    $jumlah = count($updatedatapokok) + count($updatepangkatcpns) + count($updatepangkatcpnstanggal) + count($updatepangkatpns) + count($updatepangkatpnstanggal) + count($updatepns) + count($updatepnstanggal) + count($data_pokok_tanggal) + $jmltglcpns;
                    $html = '<div class="note note-info">
                        <h4 class="block bold font-yellow-haze">Sukses!</h4>
                        <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                    </div>';

                    $this->session->set_flashdata('pesan', $html);
                    redirect('/integrasi_bkn/hasil?kriteria=data_pokok&nip_pegawai=' . $_POST['bkn_nip_baru'], 'refresh');
                }
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_ortu') {
            $this->load->model(array('master_pegawai/master_pegawai_ortu_model'));

            $data_ortu_ayah = [
                'nama_ayah' => ["NAMA" => $_POST['simpeg_nama_ayah']],
            ];
            $data_ortu_ibu = [
                'nama_ibu' => ["NAMA" => $_POST['simpeg_nama_ibu']],
            ];

            if (count($_POST['pilih']) > 0) {
                $ambilayah = [];
                $ambilibu = [];
                foreach ($_POST['pilih'] as $key => $value) {
                    if (isset($data_ortu_ayah[$value]))
                        $ambilayah[] = $data_ortu_ayah[$value];
                    if (isset($data_ortu_ibu[$value]))
                        $ambilibu[] = $data_ortu_ibu[$value];
                }
                $updateayah = array_reduce($ambilayah, 'array_merge', array());
                $updateibu = array_reduce($ambilibu, 'array_merge', array());

                $data_ayah_tanggal = [];
                if (in_array('tgl_lahir_ayah', $_POST['pilih'])) {
                    $data_ayah_tanggal = [
                        "TGLLAHIR" => bkntodb($_POST['simpeg_tgl_lahir_ayah'])
                    ];
                }

                $data_ibu_tanggal = [];
                if (in_array('tgl_lahir_ayah', $_POST['pilih'])) {
                    $data_ibu_tanggal = [
                        "TGLLAHIR" => bkntodb($_POST['simpeg_tgl_lahir_ibu'])
                    ];
                }

                $this->master_pegawai_ortu_model->update($updateayah, $data_ayah_tanggal, $_POST['id_pegawai_simpeg_ayah']);
                $this->master_pegawai_ortu_model->update($updateibu, $data_ibu_tanggal, $_POST['id_pegawai_simpeg_ibu']);

                $jumlah = count($updateayah) + count($updateibu) + count($data_ayah_tanggal) + count($data_ibu_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';

                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_ortu&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_pasangan') {
            $this->load->model(array('master_pegawai/master_pegawai_pasangan_model'));

            $data_biasa = [
                'nama' => ["NAMA" => $_POST['simpeg_nama']],
                'tempat_lahir' => ["TEMPAT_LHR" => $_POST['simpeg_tempat_lahir']],
            ];

            if (count($_POST['pilih']) > 0) {
                $ambilbiasa = [];
                foreach ($_POST['pilih'] as $key => $value) {
                    if (isset($data_biasa[$value]))
                        $ambilbiasa[] = $data_biasa[$value];
                }
                $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                $data_tanggal = [];
                if (in_array('tanggal_lahir', $_POST['pilih'])) {
                    $data_tanggal = [
                        "TGL_LAHIR" => datepickertodb($_POST['simpeg_tanggal_lahir'])
                    ];
                }

                if (in_array('tanggal_nikah', $_POST['pilih'])) {
                    $data_tanggal = [
                        "TGL_NIKAH" => datepickertodb($_POST['simpeg_tgl_nikah'])
                    ];
                }

                $this->master_pegawai_pasangan_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai']);

                $jumlah = count($updatebiasa) + count($data_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';

                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_pasangan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_anak') {
            $this->load->model(array('master_pegawai/master_pegawai_anak_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'status_anak' => ["TRSTATUSANAK_ID" => $_POST['simpeg_status_anak'][$kuncinya]],
                        'nama' => ["NAMA" => $_POST['simpeg_nama'][$kuncinya]],
                        'jk' => ["SEX" => $_POST['simpeg_jk'][$kuncinya]],
                        'tpt_lahir' => ["TEMPAT_LHR" => $_POST['simpeg_tpt_lahir'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]))
                                $ambilbiasa[] = $data_biasa[$value];
                        }
                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $data_tanggal = [];
                        if (in_array('tgl_lahir', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = [
                                "TGL_LAHIR" => datepickertodb($_POST['simpeg_tgl_lahir'][$kuncinya])
                            ];
                        }

                        $this->master_pegawai_anak_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa) + count($data_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_anak&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_pangkat') {
            $this->load->model(array('master_pegawai/master_pegawai_pangkat_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'gol_pangkat' => ["TRGOLONGAN_ID" => $_POST['simpeg_gol_pangkat'][$kuncinya]],
                        'jenis_pangkat' => ["TRJENISKENAIKANPANGKAT_ID" => $_POST['simpeg_jenis_pangkat'][$kuncinya]],
                        'no_sk' => ["NO_SK" => $_POST['simpeg_no_sk'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]) && $value == "jenis_pangkat") {
                                $kodebkn = $this->master_pegawai_pangkat_model->get_jenispangkat_bkn($_POST['simpeg_jenis_pangkat'][$kuncinya]);
                                $ambilbiasa[] = ['TRJENISKENAIKANPANGKAT_ID' => $kodebkn['ID']];
                            } else {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }
                        }
                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $data_tanggal = [];
                        if (in_array('tmt_golongan', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = [
                                "TMT_GOL" => datepickertodb($_POST['simpeg_tmt_golongan'][$kuncinya])
                            ];
                        }
                        if (in_array('tgl_sk', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = array_merge($data_tanggal, [
                                "TGL_SK" => datepickertodb($_POST['simpeg_tgl_sk'][$kuncinya])
                            ]);
                        }

                        $this->master_pegawai_pangkat_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa) + count($data_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_pangkat&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_pendidikan') {
            $this->load->model(array('master_pegawai/master_pegawai_pendidikan_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'tkt_pend' => ["TRTINGKATPENDIDIKAN_ID" => $_POST['simpeg_tkt_pend'][$kuncinya]],
                        'thn_lulus' => ["THN_LULUS" => $_POST['simpeg_thn_lulus'][$kuncinya]],
                        'no_ijasah' => ["NO_STTB" => $_POST['simpeg_no_ijasah'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]) && $value == "tkt_pend") {
                                $kodebkn = $this->master_pegawai_pendidikan_model->get_tingkatpendidikan_bkn($_POST['simpeg_tkt_pend'][$kuncinya]);
                                $ambilbiasa[] = ['TRTINGKATPENDIDIKAN_ID' => $kodebkn['ID']];
                            } else {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }
                        }
//                        print '<pre>';
//                        print_r($_POST);
//                        print_r($ambilbiasa);
//                        exit;
                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $this->master_pegawai_pendidikan_model->update($updatebiasa, [], $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_pendidikan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_penghargaan') {
            $this->load->model(array('master_pegawai/master_pegawai_penghargaan_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'jenis_tdjasa' => ["TRTANDAJASA_ID" => $_POST['simpeg_jenis'][$kuncinya]],
                        'thn' => ["THN_PRLHN" => $_POST['simpeg_thn'][$kuncinya]],
                        'nomor' => ["NOMOR" => $_POST['simpeg_nomor'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]) && $value == "jenis_tdjasa") {
                                $kodebkn = $this->master_pegawai_penghargaan_model->get_tandajasa_by_idbkn($_POST['simpeg_jenis'][$kuncinya]);
                                $ambilbiasa[] = ['TRTANDAJASA_ID' => $kodebkn['ID']];
                            } else {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }
                        }
//                        print '<pre>';
//                        print_r($_POST);
//                        print_r($ambilbiasa);
//                        exit;
                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $this->master_pegawai_penghargaan_model->update($updatebiasa, [], $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_penghargaan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }

        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_hukdis') {
            $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'jenis_huk' => ["TRJENISHUKUMANDISIPLIN_ID" => $_POST['simpeg_jenis_huk'][$kuncinya]],
                        'alasan' => ["ALASAN_HKMN" => $_POST['simpeg_alasan'][$kuncinya]],
                        'no_sk' => ["NO_SK" => $_POST['simpeg_no_sk'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]) && $value == "jenis_tdjasa") {
                                $kodebkn = $this->master_pegawai_sanksi_model->get_hukdis_by_idbkn($_POST['simpeg_jenis'][$kuncinya]);
                                $ambilbiasa[] = ['TRJENISHUKUMANDISIPLIN_ID' => $kodebkn['ID'], 'TRTKTHUKUMANDISIPLIN_ID' => $kodebkn['TRTKTHUKUMANDISIPLIN_ID']];
                            } else {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }
                        }
//                        print '<pre>';
//                        print_r($_POST);
//                        print_r($ambilbiasa);
//                        exit;
                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $data_tanggal = [];
                        if (in_array('tgl_hukum', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = [
                                "TMT_HKMN" => $_POST['simpeg_tgl_hukum'][$kuncinya]
                            ];
                        }
                        if (in_array('tgl_hukum_akhir', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = array_merge($data_tanggal, [
                                "AKHIR_HKMN" => datepickertodb($_POST['simpeg_tgl_hukum_akhir'][$kuncinya])
                            ]);
                        }
                        if (in_array('tgl_sk', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = array_merge($data_tanggal, [
                                "TGL_SK" => datepickertodb($_POST['simpeg_tgl_sk'][$kuncinya])
                            ]);
                        }

                        $this->master_pegawai_sanksi_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa) + count($data_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_penghargaan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }
        
        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_pemberhentian') {
            $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));

            if (count(array_keys($_POST['pilih'])) > 0) {
                foreach (array_keys($_POST['pilih']) as $kuncinya) {

                    $data_biasa = [
                        'no_sk' => ["NO_SK" => $_POST['simpeg_no_sk'][$kuncinya]],
                    ];

                    if (count($_POST['pilih'][$kuncinya]) > 0) {
                        $ambilbiasa = [];
                        foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                            if (isset($data_biasa[$value]) && $value == "jenis_tdjasa") {
                                $kodebkn = $this->master_pegawai_sanksi_model->get_hukdis_by_idbkn($_POST['simpeg_jenis'][$kuncinya]);
                                $ambilbiasa[] = ['TRJENISHUKUMANDISIPLIN_ID' => $kodebkn['ID'], 'TRTKTHUKUMANDISIPLIN_ID' => $kodebkn['TRTKTHUKUMANDISIPLIN_ID']];
                            } else {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }
                        }

                        $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                        $data_tanggal = [];
                        if (in_array('tgl_sk', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = array_merge($data_tanggal, [
                                "TGL_SK" => datepickertodb($_POST['simpeg_tgl_sk'][$kuncinya])
                            ]);
                        }

                        $this->master_pegawai_sanksi_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai'][$kuncinya]);
                    }
                }

                $jumlah = count($updatebiasa) + count($data_tanggal);
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_penghargaan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }
        
        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_skp') {
            $this->load->model(array('master_pegawai/master_pegawai_skp_model','master_pegawai/master_pegawai_model'));
            
            if ($_POST['action'] === 'toSimpeg') {
                if (count(array_keys($_POST['pilih'])) > 0) {
                    foreach (array_keys($_POST['pilih']) as $kuncinya) {

                        $data_biasa = [
                            'tahun_nilai' => ["PERIODE_TAHUN" => $_POST['simpeg_tahun_nilai'][$kuncinya]],
                            'nilai_skp' => ["NILAI_AKHIR" => $_POST['simpeg_nilai_skp'][$kuncinya]]
                        ];

                        if (count($_POST['pilih'][$kuncinya]) > 0) {
                            $ambilbiasa = [];
                            foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }

                            $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());

                            $this->master_pegawai_skp_model->update_detail($updatebiasa, $_POST['id_pegawai'][$kuncinya]);
                        }

                        $data_prilaku = [
                            'orientasi' => ["ORIENTASI_PELAYANAN" => $_POST['simpeg_orientasi'][$kuncinya]],
                            'integritas' => ["INTEGRITAS" => $_POST['simpeg_integritas'][$kuncinya]],
                            'komitmen' => ["KOMITMEN" => $_POST['simpeg_komitmen'][$kuncinya]],
                            'disiplin' => ["DISIPLIN" => $_POST['simpeg_disiplin'][$kuncinya]],
                            'kerjasama' => ["KERJASAMA" => $_POST['simpeg_kerjasama'][$kuncinya]],
                            'kepemimpinan' => ["KEPEMIMPINAN" => $_POST['simpeg_kepemimpinan'][$kuncinya]],
                        ];

                        if (count($_POST['pilih'][$kuncinya]) > 0) {
                            $ambilprilaku = [];
                            foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                                if (isset($data_prilaku[$value]))
                                    $ambilprilaku[] = $data_prilaku[$value];
                            }

                            $updateprilaku = array_reduce($ambilprilaku, 'array_merge', array());

                            $this->master_pegawai_skp_model->update_perilaku($updateprilaku, $_POST['id_pegawai'][$kuncinya]);
                        }
                    }

                    $jumlah = count($updateprilaku) + count($updatebiasa);
                    $html = '<div class="note note-info">
                        <h4 class="block bold font-yellow-haze">Sukses!</h4>
                        <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                    </div>';
                    $this->session->set_flashdata('pesan', $html);
                    redirect('/integrasi_bkn/hasil?kriteria=data_skp&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
                }
            }
            
            if ($_POST['action'] === 'toBkn') {
                $this->load->library('apibkn');
                $datapegawai = $this->master_pegawai_model->get_by_nipnewskp($_POST['id_pegawai_simpeg']);
//                print '<pre>';
//                print_r($_GET);
//                print_r($_POST);
//                print_r($datapegawai);
//                print_r(array_keys($_POST['id_pegawai']));
//                exit;
                $json = '';
                if (count(array_keys($_POST['pilih'])) > 0) {
                    
                    $jenisjabatan = '';
                    if ($datapegawai['TRESELON_ID'] > '00' && $datapegawai['TRESELON_ID'] < '11') {
                        $jenisjabatan = '1';
                    }
                    if (in_array($datapegawai['TRESELON_ID'],['13'])) {
                        $jenisjabatan = '2';
                    }
                    if (in_array($datapegawai['TRESELON_ID'],['15'])) {
                        $jenisjabatan = '4';
                    }

                    $arraybkn = array (
                        "id" => "",
                        "tahun" => "",
                        "nilaiSkp" => "",
                        "orientasiPelayanan" => "",
                        "integritas" => "",
                        "komitmen" => "",
                        "disiplin" => "",
                        "kerjasama" => "",
                        "nilaiPerilakuKerja" => "",
                        "nilaiPrestasiKerja" => "",
                        "kepemimpinan" => "",
                        "jumlah" => "",
                        "nilairatarata" => "",
                        "atasanPejabatPenilai" => "",
                        "pejabatPenilai" => "",
                        "pns" => "",
                        "atasanNonPns" => "",
                        "penilaiNonPns" => "",
                        "penilaiNipNrp" => "",
                        "atasanPenilaiNipNrp" => "",
                        "penilaiNama" => "",
                        "atasanPenilaiNama" => "",
                        "penilaiUnorNama" => "",
                        "atasanPenilaiUnorNama" => "",
                        "penilaiJabatan" => "",
                        "atasanPenilaiJabatan" => "",
                        "penilaiGolongan" => "",
                        "atasanPenilaiGolongan" => "",
                        "penilaiTmtGolongan" => "",
                        "atasanPenilaiTmtGolongan" => "",
                        "statusPenilai" => "PNS",
                        "statusAtasanPenilai" => "PNS",
                        "jenisJabatan" => ""
                    );
                    
                    foreach (array_keys($_POST['pilih']) as $kuncinya) {
//                        echo $kuncinya.'<br />';
                        $this->db->select("TH_PEGAWAI_SKP.ID, PERIODE_AWAL,PERIODE_AKHIR,PERIODE_TAHUN,TH_PEGAWAI_SKP_DETAIL.NILAI_AKHIR,ORIENTASI_PELAYANAN,
                        INTEGRITAS,KOMITMEN,DISIPLIN,KERJASAMA,KEPEMIMPINAN");
                        $this->db->from("TH_PEGAWAI_SKP");
                        $this->db->join("TH_PEGAWAI_SKP_DETAIL", "TH_PEGAWAI_SKP_DETAIL.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                        $this->db->join("TH_PEGAWAI_SKP_PERILAKUKERJA", "TH_PEGAWAI_SKP_PERILAKUKERJA.THPEGAWAISKP_ID=TH_PEGAWAI_SKP.ID", "LEFT");
                        $this->db->where('TH_PEGAWAI_SKP.ID', $kuncinya);
                        $query = $this->db->get();
                        $row = $query->row_array();
                        
                        $nilaiorientasi_pelayanan = (isset($row['ORIENTASI_PELAYANAN']) && !empty($row['ORIENTASI_PELAYANAN'])) ? $row['ORIENTASI_PELAYANAN'] : 0;
                        $jmlnilaiorientasi = (isset($row['ORIENTASI_PELAYANAN']) && !empty($row['ORIENTASI_PELAYANAN'])) ? 1 : 0;
                        $nilai_integritas = (isset($row['INTEGRITAS']) && !empty($row['INTEGRITAS'])) ? $row['INTEGRITAS'] : 0;
                        $jmlnilaiintegritas = (isset($row['INTEGRITAS']) && !empty($row['INTEGRITAS'])) ? 1 : 0;
                        $nilai_komitmen = (isset($row['KOMITMEN']) && !empty($row['KOMITMEN'])) ? $row['KOMITMEN'] : 0;
                        $jmlnilaikomitmen = (isset($row['KOMITMEN']) && !empty($row['KOMITMEN'])) ? 1 : 0;
                        $nilai_disiplin = (isset($row['DISIPLIN']) && !empty($row['DISIPLIN'])) ? $row['DISIPLIN'] : 0;
                        $jmlnilaidisiplin = (isset($row['DISIPLIN']) && !empty($row['DISIPLIN'])) ? 1 : 0;
                        $nilai_kerjasama = (isset($row['KERJASAMA']) && !empty($row['KERJASAMA'])) ? $row['KERJASAMA'] : 0;
                        $jmlnilaikerjasama = (isset($row['KERJASAMA']) && !empty($row['KERJASAMA'])) ? 1 : 0;
                        $nilai_kepemimpinan = (isset($row['KEPEMIMPINAN']) && !empty($row['KEPEMIMPINAN'])) ? $row['KEPEMIMPINAN'] : 0;
                        $jmlnilaikepemimpinan = (isset($row['KEPEMIMPINAN']) && !empty($row['KEPEMIMPINAN'])) ? 1 : 0;
                        
                        $nilaiprilakukerja = isset($row) ? number_format(number_format((((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan)/($jmlnilaiorientasi+$jmlnilaiintegritas+$jmlnilaikomitmen+$jmlnilaidisiplin+$jmlnilaikerjasama+$jmlnilaikepemimpinan))*40)/100),2)) * 0.4 : 0;
                        
                        $data_skp = [
                            "tahun" => $row['PERIODE_TAHUN'],
                            "nilaiSkp" => sprintf("%0.2f", $row['NILAI_AKHIR']),
                            "orientasiPelayanan" => sprintf("%0.2f", $row['ORIENTASI_PELAYANAN']),
                            "integritas" => sprintf("%0.2f", $row['INTEGRITAS']),
                            "komitmen" => sprintf("%0.2f", $row['KOMITMEN']),
                            "disiplin" => sprintf("%0.2f", $row['KOMITMEN']),
                            "kerjasama" => sprintf("%0.2f", $row['KERJASAMA']),
                            "kepemimpinan" => sprintf("%0.2f", $row['KEPEMIMPINAN']),
                            'nilaiPerilakuKerja' => sprintf("%0.2f", $nilaiprilakukerja),
                            'nilaiPrestasiKerja'=> sprintf("%0.2f", $row['NILAI_AKHIR']),
                            'jumlah' => sprintf("%0.2f", $nilaiprilakukerja),
                            'nilairatarata' => sprintf("%0.2f",  (isset($row) ? number_format(($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan)/($jmlnilaiorientasi+$jmlnilaiintegritas+$jmlnilaikomitmen+$jmlnilaidisiplin+$jmlnilaikerjasama+$jmlnilaikepemimpinan),2) : 0)),
                        ];

                        $updatedatapokok = array_merge($arraybkn, array('id'=>$_POST['id_bkn'][$kuncinya],'pnsDinilaiOrang'=>$datapegawai['ID_BKN'],'pnsUserId'=>$datapegawai['ID_BKN'],"jenisJabatan" => $jenisjabatan));
                        $join = array_merge($updatedatapokok,$data_skp);
                        $json = json_encode($join);
//                        $result = $this->apibkn->apiKirim("https://wstraining.bkn.go.id/api/skp/save", $json);
//                        print '<pre>';
//                        print_r($row);
//                        print_r($json);
                        
                        $result = $this->apibkn->apiKirim("https://wsrv-duplex.bkn.go.id/api/skp/save", $json);
                        $message = [];
                        $jml = 0;
                        if (isset($result['success']) == 1) {
                            $message = $result['success'];
                            $jml = $jml+1;
                        } else {
                            $message = 'Gagal';
                        }
                    }
                }
                
                $html = '<div class="note note-info">
                    <h4 class="block bold font-yellow-haze">Sukses!</h4>
                    <p class="font-yellow-haze"> Jumlah data berhasil terkirim ke BKN = ' . $jml . '. </p>
                </div>';
                $this->session->set_flashdata('pesan', $html);
                redirect('/integrasi_bkn/hasil?kriteria=data_skp&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
            }
        }
        
        if (isset($_POST['integrasi']) && isset($_POST['pilih']) && $_POST['integrasi'] === 'data_jabatan') {
            $this->load->model(array('master_pegawai/master_pegawai_jabatan_model'));
//            print '<pre>';
//            print_r($_POST);
//            exit;
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-jabatan/" . $_GET['nip_pegawai']);
//            $outcome = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);
//            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-jabatan/" . $_GET['nip_pegawai']);
//            $outcome = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pnsunor/" . $_GET['nip_pegawai']);

//            $bkn = [];
//            if (isset($result['code']) && $result['code'] == 1) {
//                $bkn = $result['data'];
//            }
//            $key = array_search($ambil, array_column($bkn, 'id'));
//            $this->data['bkn'] = $bkn[$key];

            if (count(array_keys($_POST['pilih'])) > 0) {
                if (isset($_POST['action']) && $_POST['action'] == 'toSimpeg') {
                    foreach (array_keys($_POST['pilih']) as $kuncinya) {

                        $data_biasa = [
                            'eselon' => ["TRESELON_ID" => $_POST['simpeg_eselon'][$kuncinya]],
                            'jabatan' => ["TRJABATAN_ID" => $_POST['simpeg_jabatan'][$kuncinya]],
                            'no_sk' => ["NO_SK" => $_POST['simpeg_jabatan'][$kuncinya]]
                        ];

                        $updatebiasa = [];
                        if (count($_POST['pilih'][$kuncinya]) > 0) {
                            $ambilbiasa = [];
                            foreach ($_POST['pilih'][$kuncinya] as $key => $value) {
                                if (isset($data_biasa[$value]))
                                    $ambilbiasa[] = $data_biasa[$value];
                            }

                            $updatebiasa = array_reduce($ambilbiasa, 'array_merge', array());
                        }

                        $data_tanggal = [];
                        if (in_array('tmt_jabatan', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = [
                                "TMT_JABATAN" => datepickertodb($_POST['simpeg_tmt_jabatan'][$kuncinya])
                            ];
                        }

                        if (in_array('tgl_sk', $_POST['pilih'][$kuncinya])) {
                            $data_tanggal = [
                                "TGL_SK" => datepickertodb($_POST['simpeg_tgl_sk'][$kuncinya])
                            ];
                        }

                        $this->master_pegawai_jabatan_model->update($updatebiasa, $data_tanggal, $_POST['id_pegawai'][$kuncinya]);
                    }

                    $jumlah = count($updatebiasa) + count($data_tanggal);
                    $html = '<div class="note note-info">
                        <h4 class="block bold font-yellow-haze">Sukses!</h4>
                        <p class="font-yellow-haze"> Jumlah data berhasil ter-integrasi = ' . $jumlah . '. </p>
                    </div>';
                    $this->session->set_flashdata('pesan', $html);
                    redirect('/integrasi_bkn/hasil?kriteria=data_jabatan&nip_pegawai=' . $_POST['id_pegawai_simpeg'], 'refresh');
                }
                if (isset($_POST['action']) && $_POST['action'] == 'toBkn') {
                    $this->load->library('apibkn');
                    $datapegawai = $this->master_pegawai_model->get_by_nipnew($_POST['id_pegawai_simpeg']);
                    $json = '';
                    if (count(array_keys($_POST['pilih'])) > 0) {
                        
                        $arraybkn = array (
                            "id" => "",
                            "jenisJabatan" => "",
                            "unorId" => "",
                            "eselonId" => "",
                            "instansiId" => "A5EB03E23D34F6A0E040640A040252AD",
                            "pnsId" => "",
                            "jabatanFungsionalId" => "",
                            "jabatanFungsionalUmumId" => "",
                            "nomorSk" => "",
                            "tanggalSk" => "",
                            "tmtJabatan" => "",
                            "tmtPelantikan" => "",
                            "pnsUserId" => "",
                        );
                        
                        foreach (array_keys($_POST['pilih']) as $kuncinya) {
                            $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,
                            TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK2,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN,
                            TRE.ESELON,TRJ.JABATAN,TSO.ID_BKN,TSO.INSTANSI_ID_BKN,TRJ.ID_JABFUNGT_BKN,TRJ.ID_JABFUNGU_BKN,TO_CHAR(TGL_LANTIK,'DD/MM/YYYY') as TGL_LANTIK2");
                            $this->db->from("TH_PEGAWAI_JABATAN TPJ");
                            $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
                            $this->db->join("TR_STRUKTUR_ORGANISASI TSO", "TSO.TRLOKASI_ID=TPJ.TRLOKASI_ID AND TSO.KDU1=TPJ.KDU1 AND TSO.KDU2=TPJ.KDU2 AND TSO.KDU3=TPJ.KDU3 AND TSO.KDU4=TPJ.KDU4 AND TSO.KDU5=TPJ.KDU5", "LEFT");
                            $this->db->join("TR_JABATAN TRJ", "TPJ.TRJABATAN_ID=TRJ.ID", "LEFT");
                            $this->db->join("TR_ESELON TRE", "TPJ.TRESELON_ID=TRE.ID", "LEFT");
                            $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                            $this->db->where('TPJ.ID', $kuncinya);
                            $query = $this->db->get();
                            $row = $query->row_array();
                            
                            if ($row) {
                                $data_jabatan = [
                                    'id' => isset($_POST['id_bkn'][$kuncinya]) ? $_POST['id_bkn'][$kuncinya] : '',
                                    "unorId" => isset($row['ID_BKN'])?$row['ID_BKN']:'',
                                    "instansiId" => $row['INSTANSI_ID_BKN'],
                                    "pnsId" => $datapegawai['ID_BKN'],
                                    "jabatanFungsionalId" => $row['ID_JABFUNGT_BKN'],
                                    "jabatanFungsionalUmumId" => $row['ID_JABFUNGU_BKN'],
                                    "nomorSk" => $row['NO_SK'],
                                    "tanggalSk" => str_replace("/","-",$row['TGL_SK2']),
                                    "tmtJabatan" => str_replace("/","-",$row['TMT_JABATAN2']),
                                    "tmtPelantikan" => str_replace("/","-",$row['TGL_LANTIK2']),
                                    "pnsUserId" => $datapegawai['ID_BKN'],
                                ];

                                $join = array_merge($arraybkn,$data_jabatan);
                                $json = json_encode($join);
                            }
                        }
                    }
                    
                    $result = $this->apibkn->apiKirim("https://wsrv-duplex.bkn.go.id/api/jabatan/save", $json);
                    print '<pre>';
                    print_r($json);
                    print_r($result);
                    exit;
                }
            }
        }

        redirect('/integrasi_bkn/', 'refresh');
//        exit;
    }

    public function tambah_ortu_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->library('apibkn');
            $kode = $this->input->get('kode');
            $this->data['title_form'] = "Tambah";
            $this->data['list_sts_ortu'] = $this->list_model->list_sts_ortu($kode);
            $this->data['id'] = $_POST['id'];

            $datapegawai = $this->master_pegawai_model->get_by_id($_POST['id']);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-ortu/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-ortu/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                if ($kode == 1)
                    $bkn = $result['data']['ayah'];
                if ($kode == 2)
                    $bkn = $result['data']['ibu'];
            }
            $this->data['bkn'] = $bkn;

            $this->load->view("integrasi_bkn/ortu_form_create", $this->data);
        } else {
            redirect('/integrasi_bkn');
        }
    }

    public function tambah_ortu_proses() {
        $this->load->model(array('master_pegawai/master_pegawai_ortu_model'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status_ortu', 'Status Orang Tua', 'required|min_length[1]|max_length[1]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[60]');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[100]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TMSTATUSORTU_ID" => trim($this->input->post('status_ortu', TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap', TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan', TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir', TRUE))),
            ];
            if ($insert = $this->master_pegawai_ortu_model->insert($post, $tanggal)) {
                $nippegawai = $this->master_pegawai_model->get_by_id_select($id, "NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_ortu&nip_pegawai=' . $nippegawai['NIPNEW'], 'refresh');
            }
        }
    }

    public function tambah_pasangan_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_pasangan_model'));
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
            $this->data['list_jenis_pasangan'] = ($datapegawai['SEX'] == "L") ? [['ID' => 2, "NAMA" => 'Istri']] : [['ID' => 1, "NAMA" => 'Suami']];
            $this->data['list_pekerjaan'] = $this->list_model->list_pekerjaan();
            $this->data['pasangan_ke'] = $this->master_pegawai_pasangan_model->count_pasangan($id) + 1;
            $this->data['id'] = $id;
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-pasangan/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-pasangan/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $this->data['bkn'] = $bkn;

            $this->load->view("integrasi_bkn/pasangan_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_pasangan_proses() {
        $this->load->model(array('master_pegawai/master_pegawai_pasangan_model'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_pasangan', 'Status Pasangan', 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('pasangan_ke', 'Pasangan Ke', 'required|min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[100]');
        $this->form_validation->set_rules('trpekerjaan_id', 'Pekerjaan Pasangan', 'min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir Pasangan', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[0]|max_length[100]');
        $this->form_validation->set_rules('karis', 'No Karis', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('nik', 'NIK', 'max_length[18]|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'min_length[18]|max_length[18]|trim|is_natural');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "JENIS_PASANGAN" => ltrim(rtrim($this->input->post('jenis_pasangan', TRUE))),
                "PASANGAN_KE" => ltrim(rtrim($this->input->post('pasangan_ke', TRUE))),
                "TRPEKERJAAN_ID" => ltrim(rtrim($this->input->post('trpekerjaan_id', TRUE))),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap', TRUE))),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir', TRUE))),
                "KET" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_NIKAH" => datepickertodb(trim($this->input->post('tanggal_nikah', TRUE))),
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir', TRUE))),
            ];
            if ($insert = $this->master_pegawai_pasangan_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_pasangan&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            }
        }
    }

    public function tambah_anak_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_anak_model'));
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['list_sts_anak'] = $this->list_model->list_sts_anak();
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-anak/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/data-anak/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn['listAnak'], 'id'));
            $this->data['bkn'] = $bkn['listAnak'][$key];
            $this->data['id'] = $id;

            $this->load->view("integrasi_bkn/anak_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_anak_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_anak_model'));
        $this->form_validation->set_rules('status_anak', 'Status Anak', 'required|min_length[1]|max_length[1]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[60]');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required|min_length[1]|max_length[1]|alpha|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[50]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TRSTATUSANAK_ID" => trim($this->input->post('status_anak', TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap', TRUE))),
                "SEX" => trim($this->input->post('jk', TRUE)),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir', TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan', TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan', TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir', TRUE))),
            ];
            if ($insert = $this->master_pegawai_anak_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_anak&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function tambah_pangkat_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_pangkat_model','integrasi_bkn/kpo_bkn_model'));
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat($datapegawai['TRSTATUSKEPEGAWAIAN_ID']);
            $this->data['list_jenis_kenaikan_pangkat'] = $this->list_model->list_jenis_kenaikan_pangkat();
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-golongan/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-golongan/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];

            $bkncek = $this->kpo_bkn_model->get_by_id($ambil);
            $this->data['cekpangkat'] = false;

            if ($bkncek) {
                $this->db->select("MK_GOLONGAN_V.*");
                $this->db->from("MK_GOLONGAN_V");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                $this->db->where("TMT_GOL2", $bkncek['TMT_GOLONGAN2']);
                $this->db->where("ID_BKN_GOL", $bkncek['GOLONGAN_ID']);
                $query = $this->db->get();
                $row = $query->row();
                if (isset($row->ID)) {
                    $this->data['cekpangkat'] = true;
                }
            }
            
            $this->data['id'] = $id;
            $this->data['jenispangkat'] = $this->master_pegawai_pangkat_model->get_jenispangkat_bkn($bkn[$key]['jenisKPId']);
            $this->data['pangkatbkn'] = $this->master_pegawai_pangkat_model->get_pangkat_bkn($bkn[$key]['golonganId']);

            $this->load->view("integrasi_bkn/pangkat_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_pangkatkpo_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_pangkat_model','integrasi_bkn/kpo_bkn_model'));
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat($datapegawai['TRSTATUSKEPEGAWAIAN_ID']);
            $this->data['list_jenis_kenaikan_pangkat'] = $this->list_model->list_jenis_kenaikan_pangkat();
            
            $bkncek = $this->kpo_bkn_model->get_by_id($ambil);
            $this->data['cekpangkat'] = false;
            $this->data['bkn'] = [];
            if ($bkncek) {
                $this->db->select("MK_GOLONGAN_V.*");
                $this->db->from("MK_GOLONGAN_V");
                $this->db->where('TMPEGAWAI_ID', $datapegawai['ID']);
                $this->db->where("TMT_GOL2", $bkncek['TMT_GOLONGAN2']);
                $this->db->where("ID_BKN_GOL", $bkncek['GOLONGAN_ID']);
                $query = $this->db->get();
                $row = $query->row();
                if (isset($row->ID)) {
                    $this->data['cekpangkat'] = true;
                }
                $this->data['bkn'] = $bkncek;
                $this->data['jenispangkat'] = $this->master_pegawai_pangkat_model->get_jenispangkat_bkn($bkncek['JENISKP_ID']);
                $this->data['pangkatbkn'] = $this->master_pegawai_pangkat_model->get_pangkat_bkn($bkncek['GOLONGAN_ID']);
            }
            
            $this->data['id'] = $id;

            $this->load->view("integrasi_bkn/pangkat_kpo_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_pangkat_proses() {
        $this->load->model(array('master_pegawai/master_pegawai_pangkat_model'));
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
                
                redirect('/integrasi_bkn/hasil?kriteria=data_pangkat&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function tambah_pendidikan_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_pendidikan_model'));
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-pendidikan/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-pendidikan/".$datapegawai['NIPNEW']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];

            $this->data['id'] = $id;
            $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_fakultas'] = $this->list_model->list_fakultas();
            $this->data['tingkatpendidikan'] = $this->master_pegawai_pendidikan_model->get_tingkatpendidikan_bkn($bkn[$key]['tkPendidikanId']);

            $this->load->view("integrasi_bkn/pendidikan_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_pendidikan_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_pendidikan_model'));
        
        $this->form_validation->set_rules('tkt_pendidikan', 'Tingkat Pendidikan', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('no_ijasah', 'No Ijasah', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRTINGKATPENDIDIKAN_ID" => trim($this->input->post('tkt_pendidikan',TRUE)),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                'TMPEGAWAI_ID' => $id,
                "THN_LULUS" => trim($this->input->post('tahun_lulus',TRUE)),
                "NO_STTB" => ltrim(rtrim($this->input->post('no_ijasah',TRUE))),
                "NAMA_DIREKTUR" => ltrim(rtrim($this->input->post('nama_pimpinan',TRUE))),
            ];
            $tanggal = [
                "TGL_IJAZAH" => datepickertodb(trim($this->input->post('tgl_ijasah',TRUE))),
            ];
            if (($insert = $this->master_pegawai_pendidikan_model->insert($post,$tanggal)) == true) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_pendidikan&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }

    }
    
    public function tambah_penghargaan_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }
            $this->load->model(array('master_pegawai/master_pegawai_penghargaan_model'));
            $this->data['title_form'] = "Tambah";
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-penghargaan/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-penghargaan/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];
            $refbkn = $this->master_pegawai_penghargaan_model->get_tandajasa_by_idbkn($bkn[$key]['jenisHarga']);
//            print '<pre>';
//            print_r($refbkn);
//            exit;
            $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
            $this->data['list_tanda_jasa'] = $this->list_model->list_tanda_jasa($refbkn['TRJENISTANDAJASA_ID']);
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['id'] = $id;
            $this->data['refbkn'] = $refbkn;

            $this->load->view("integrasi_bkn/penghargaan_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_penghargaan_proses() {
        $this->load->model(array('master_pegawai/master_pegawai_penghargaan_model'));
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
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
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
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_penghargaan&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function tambah_diklat_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_diklat_penjenjangan_model'));
            $this->data['title_form'] = "Tambah";
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-diklat/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-diklat/".$_GET['nip_pegawai']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];
            $refbkn = $this->master_pegawai_diklat_penjenjangan_model->get_diklat_by_idbkn($bkn[$key]['latihanStrukturalId']);
//            print '<pre>';
//            print_r($this->data['bkn']);
//            print_r($refbkn);
//            exit;
            $this->data['list_tingkat_diklat_kepemimpinan'] = $this->list_model->list_tingkat_diklat_kepemimpinan();
            $this->data['list_kualifikasi_kelulusan'] = $this->list_model->list_kualifikasi_kelulusan();
            $this->data['id'] = $id;
            $this->data['refbkn'] = $refbkn;

            $this->load->view("integrasi_bkn/diklat_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_diklat_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_diklat_penjenjangan_model'));
        $this->form_validation->set_rules('penjenjangan', 'Penjenjangan', 'required|min_length[1]|max_length[2]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'min_length[1]|max_length[8]|trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[4]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('jpl', 'JPL', 'min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('peringkat', 'Peringkat', 'min_length[1]|max_length[8]|trim');
        $this->form_validation->set_rules('kelulusan', 'Kelulusan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $namadiklat = $this->master_pegawai_diklat_penjenjangan_model->get_namadiklat_by_id(trim($this->input->post('penjenjangan',TRUE)));
            $post = [
                'NAMA_DIKLAT' => $namadiklat,
                "TRTINGKATDIKLATKEPEMIMPINAN_ID" => trim($this->input->post('penjenjangan',TRUE)),
                "TRPREDIKATKELULUSAN_ID" => trim($this->input->post('kelulusan',TRUE)),
                "THN_DIKLAT" => trim($this->input->post('tahun',TRUE)),
                "JPL" => trim($this->input->post('jpl',TRUE)),
                "ANGKATAN_DIKLAT" => trim($this->input->post('angkatan',TRUE)),
                "PERINGKAT" => trim($this->input->post('peringkat',TRUE)),
                "PENYELENGGARA" => ltrim(rtrim($this->input->post('penyelenggara',TRUE))),
                "NO_STTPP" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PJBT_STTPP" => ltrim(rtrim($this->input->post('pejabat',TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_STTPP" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            
            if ($insert = $this->master_pegawai_diklat_penjenjangan_model->insert($post,$tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_diklat&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function tambah_hukdis_form() {
//        if ($this->input->is_ajax_request()) {
//            if (!isset($_POST['id']) || empty($_POST['id'])) {
//                redirect('/master_pegawai');
//            }

        $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
        $this->load->library('apibkn');
        $id = $this->input->post('id');
        $ambil = $this->input->get('ambil');
        $this->data['title_form'] = "Tambah";

        $datapegawai = $this->master_pegawai_model->get_by_id($id);

//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-hukdis/" . $datapegawai['NIPNEW']);
        $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-hukdis/" . $datapegawai['NIPNEW']);
        $bkn = [];
        if (isset($result['code']) && $result['code'] == 1) {
            $bkn = $result['data'];
        }
        $key = array_search($ambil, array_column($result['data'], 'id'));
        $this->data['bkn'] = $bkn[$key];
//            print_r($key);
//            print_r($bkn[$key]);
//            exit;
        $caritingkat = $this->master_pegawai_sanksi_model->get_hukdis_by_idbkn($bkn[$key]['jenisHukuman']);
        $this->data['list_tkt_hukdis'] = $this->list_model->list_tkt_hukdis(isset($caritingkat['TRTKTHUKUMANDISIPLIN_ID']) ? $caritingkat['TRTKTHUKUMANDISIPLIN_ID'] : NULL);
        $this->data['list_jenis_hukdis'] = $this->list_model->list_jenis_hukdis(isset($this->data['list_tkt_hukdis'][0]['ID']) ? $this->data['list_tkt_hukdis'][0]['ID'] : NULL);
//            print '<pre>';
//            print_r($bkn[$key]);
//            print_r($caritingkat);
//            echo $caritingkat['TRTKTHUKUMANDISIPLIN_ID']."<br />";
//            echo $caritingkat['ID']."<br />";
//            exit;
        $this->data['id'] = $id;
        $this->data['idtingkathukdis'] = $caritingkat['TRTKTHUKUMANDISIPLIN_ID'];
        $this->data['idjenishukdis'] = $caritingkat['ID'];
        $this->load->view("integrasi_bkn/hukdis_form_create", $this->data);
//        } else {
//            redirect('/master_pegawai');
//        }
    }

    public function tambah_hukdis_proses() {
        $this->load->model(array('master_pegawai/master_pegawai_sanksi_model'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tingkat_hukuman', 'Tingkat Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jenis_hukuman', 'Jenis Hukuman', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('alasan_hukuman', 'Alasan Hukuman', 'min_length[1]|max_length[3000]');
        $this->form_validation->set_rules('tmt_hukuman', 'Tmt Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('akhir_hukuman', 'Akhir Hukuman', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[100]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TRTKTHUKUMANDISIPLIN_ID" => trim($this->input->post('tingkat_hukuman', TRUE)),
                "TRJENISHUKUMANDISIPLIN_ID" => trim($this->input->post('jenis_hukuman', TRUE)),
                "ALASAN_HKMN" => ltrim(rtrim($this->input->post('alasan_hukuman', TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TMT_HKMN" => datepickertodb(trim($this->input->post('tmt_hukuman', TRUE))),
                "AKHIR_HKMN" => datepickertodb(trim($this->input->post('akhir_hukuman', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
            ];

            if ($insert = $this->master_pegawai_sanksi_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_hukdis&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function tambah_angkakredit_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_ak_model'));
            $this->data['title_form'] = "Tambah";
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-angkakredit/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-angkakredit/".$datapegawai['NIPNEW']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];
//            print '<pre>';
//            print_r($this->data['bkn']);
//            print_r($refbkn);
//            exit;
            $this->data['list_tahun'] = $this->list_model->list_tahun();
            $this->data['id'] = $id;

            $this->load->view("integrasi_bkn/angkakredit_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_angkakredit_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_ak_model'));
        $this->form_validation->set_rules('tahun_penilaian', 'Tahun Penilaian', 'required|min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('nilai_penunjang', 'Nilai Penunjang', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[300]');
        $this->form_validation->set_rules('lembaga', 'Lembaga', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tgl mulai', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_slesai', 'Tgl slesai', 'min_length[10]|max_length[10]|trim');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TAHUN_KREDIT" => trim($this->input->post('tahun_penilaian',TRUE)),
                "AK_UTAMA" => trim($this->input->post('nilai_utama',TRUE)),
                "AK_PENUNJANG" => trim($this->input->post('nilai_penunjang',TRUE)),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "LEMBAGA" => ltrim(rtrim($this->input->post('lembaga',TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "AK_JUMLAH" => trim($this->input->post('nilai_utama',TRUE)) + trim($this->input->post('nilai_penunjang',TRUE)),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
                "PERIODE_AWAL" => datepickertodb(trim($this->input->post('tgl_mulai',TRUE))),
                "PERIODE_AKHIR" => datepickertodb(trim($this->input->post('tgl_slesai',TRUE))),
            ];
            
            if ($insert = $this->master_pegawai_ak_model->insert($post,$tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
                redirect('/integrasi_bkn/hasil?kriteria=data_angkakredit&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function tambah_skp_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_skp_model'));
            $this->data['title_form'] = "Tambah";
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-skp/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-skp/".$datapegawai['NIPNEW']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = $bkn[$key];
//            print '<pre>';
//            print_r($result);
//            print_r($this->data['bkn']);
//            print_r($refbkn);
//            exit;
            $this->data['list_tahun'] = $this->list_model->list_tahun();
            $this->data['id'] = $id;

            $this->load->view("integrasi_bkn/skp_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_skp_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_skp_model'));
        $this->form_validation->set_rules('periode_tahun', 'Periode Tahun', 'required|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
            $post = [
                "PERIODE_TAHUN" => trim($this->input->post('periode_tahun',TRUE)),
                "IDPEGAWAI" => $id,
                "NIPNEW" => $data_pegawai['NIPNEW']
            ];
            
            if ($insert = $this->master_pegawai_skp_model->insert($post)) {
                $insert_id = $insert['id'];
                $detail = [
                    "THPEGAWAISKP_ID" => $insert_id,
                    "NILAI_AKHIR" => trim($this->input->post('nilai_utama',TRUE)),
                ];
                $this->master_pegawai_skp_model->insert_detail($detail);
                
                $prilaku = [
                    "THPEGAWAISKP_ID" => $insert_id,
                    "ORIENTASI_PELAYANAN" => trim($this->input->post('isi_orientasi_pelayanan',TRUE)),
                    "INTEGRITAS" => trim($this->input->post('isi_integritas',TRUE)),
                    "KOMITMEN" => trim($this->input->post('isi_komitmen',TRUE)),
                    "DISIPLIN" => trim($this->input->post('isi_disiplin',TRUE)),
                    "KERJASAMA" => trim($this->input->post('isi_kerjasama',TRUE)),
                    "KEPEMIMPINAN" => trim($this->input->post('isi_kepemimpinan',TRUE)),
                    "KET_ORIENTASI_PELAYANAN" => $this->input->post('kategori_orientasi_pelayanan',TRUE),
                    "KET_INTEGRITAS" => $this->input->post('kategori_integritas',TRUE),
                    "KET_KOMITMEN" => $this->input->post('kategori_komitmen',TRUE),
                    "KET_DISIPLIN" => $this->input->post('kategori_disiplin',TRUE),
                    "KET_KERJASAMA" => $this->input->post('kategori_kerjasama',TRUE),
                    "KET_KEPEMIMPINAN" => $this->input->post('kategori_kepemimpinan',TRUE),
                ];
                $this->master_pegawai_skp_model->insert_perilaku($prilaku);
                
                redirect('/integrasi_bkn/hasil?kriteria=data_skp&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function tambah_jabatan_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                redirect('/master_pegawai');
            }

            $this->load->model(array('master_pegawai/master_pegawai_jabatan_model'));
            $this->data['title_form'] = "Tambah";
            $this->load->library('apibkn');
            $id = $this->input->post('id');
            $kode = $this->input->get('kode');
            $ambil = $this->input->get('ambil');
            $this->data['title_form'] = "Tambah";
            $datapegawai = $this->master_pegawai_model->get_by_id($id);
//            $result = $this->apibkn->apiResult("https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-jabatan/" . $datapegawai['NIPNEW']);
            $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/pns/rw-jabatan/".$datapegawai['NIPNEW']);
            $bkn = [];
            if (isset($result['code']) && $result['code'] == 1) {
                $bkn = $result['data'];
            }
            $key = array_search($ambil, array_column($bkn, 'id'));
            $this->data['bkn'] = [];
            $eselonnya = '';
            $kodejabatan = '';
            if ($bkn[$key]) {
                $this->data['bkn'] = $bkn[$key];
                $getsrukturbkn = $this->master_pegawai_jabatan_model->get_struktur_by_id_bkn($bkn[$key]['unorId']);
                if (!$getsrukturbkn) {
                    $this->data['unortanpakoderef'] = $bkn[$key]['jabatanFungsionalUmumNama']." - ".$bkn[$key]['namaUnor']." - ".$bkn[$key]['unorIndukNama'];
                }
                if (!empty($bkn[$key]['jenisJabatan']) && $bkn[$key]['jenisJabatan']=='STRUKTURAL') {
//                    $kodejabatan = $bkn[$key]['namaJabatan'];
                    $geteselonbkn = $this->master_pegawai_jabatan_model->get_eselon_by_id_bkn($bkn[$key]['eselonId']);
                    $eselonnya = $geteselonbkn['ID'];
                    $getjabatanbkn = $this->master_pegawai_jabatan_model->get_jabatan_by_id_bkn($getsrukturbkn['JENIS_UNOR_BKN'],$bkn[$key]['jenisJabatan']);
                    $kodejabatan = isset($getjabatanbkn['ID'])?$getjabatanbkn['ID']:NULL;
                }
                if (!empty($bkn[$key]['jenisJabatan']) && $bkn[$key]['jenisJabatan']=='FUNGSIONAL_TERTENTU') {
                    $getjabatanbkn = $this->master_pegawai_jabatan_model->get_jabatan_by_id_bkn($bkn[$key]['jabatanFungsionalId'],$bkn[$key]['jenisJabatan']);
                    $kodejabatan = isset($getjabatanbkn['ID'])?$getjabatanbkn['ID']:NULL;
                    $eselonnya = '13';
                }
                if (!empty($bkn[$key]['jenisJabatan']) && $bkn[$key]['jenisJabatan']=='FUNGSIONAL_UMUM') {
                    $getjabatanbkn = $this->master_pegawai_jabatan_model->get_jabatan_by_id_bkn($bkn[$key]['jabatanFungsionalUmumId'],$bkn[$key]['jenisJabatan']);
                    $kodejabatan = isset($getjabatanbkn['ID'])?$getjabatanbkn['ID']:NULL;
                    $eselonnya = "15";
                }
            }
//            print '<pre>';
//            print_r($this->data['bkn']);
//            print_r($refbkn);
//            exit;
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            if (!empty($eselonnya)) {
                $this->data['list_jabatan'] = $this->list_model->list_jabatan($eselonnya);
                $this->data['model']['TRESELON_ID'] = $eselonnya;
                $this->data['model']['TRJABATAN_ID'] = $kodejabatan;
            }
//            $getstruktur = $this->master_pegawai_jabatan_model->get_struktur_bkn($this->data['bkn']);
            $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
            $this->data['list_golongan'] = $this->master_pegawai_jabatan_model->list_golongan_pegawai($id);
            $this->data['list_keterangan_jabatan'] = $this->list_model->list_keterangan_jabatan();
            $this->data['id'] = $id;

            $this->load->view("integrasi_bkn/jabatan_form_create", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_jabatan_proses() {
        $this->load->library('form_validation');
        $this->load->model(array('master_pegawai/master_pegawai_jabatan_model'));
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
        $this->form_validation->set_rules('trlokasi_id', 'Lokasi', 'min_length[1]|max_length[6]');
        $this->form_validation->set_rules('pangkat_id', 'Pangkat', 'min_length[1]|max_length[3]');
        $this->form_validation->set_rules('keteranganjabatan_id', 'Keterangan Jabatan', 'min_length[1]|max_length[5]');

        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");
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
                $nmjabatannmunit = $nmjabatan . "" . $nmunit['NMUNITKERJA'];
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
                redirect('/integrasi_bkn/hasil?kriteria=data_jabatan&nip_pegawai=' . $data_pegawai['NIPNEW'], 'refresh');
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function index_kposk() {
        $this->data['custom_js'] = ['integrasi_bkn/js','integrasi_bkn/js_kpo'];
        $this->data['content'] = 'integrasi_bkn/data_kpo_hasil';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function index_pposk() {
        $this->data['custom_js'] = ['integrasi_bkn/js','integrasi_bkn/js_ppo'];
        $this->data['content'] = 'integrasi_bkn/data_ppo_hasil';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function index_updated() {
        $this->data['custom_js'] = ['integrasi_bkn/js','integrasi_bkn/js_updated'];
        $this->data['content'] = 'integrasi_bkn/data_updated_hasil';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function index_ppowafat() {
        $this->data['custom_js'] = ['integrasi_bkn/js','integrasi_bkn/js_ppowafat'];
        $this->data['content'] = 'integrasi_bkn/data_ppowafat_hasil';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function ajax_list_kposk() {
        $this->load->model(array('integrasi_bkn/kpo_bkn_model'));
        
        if (isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])) {
            $this->getKpoHist(str_replace("/", "-", $_POST['tgl_awal']), str_replace("/", "-", $_POST['tgl_akhir']));
        }
        
        $list = $this->kpo_bkn_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA;
            $row[] = $val->NIPNEW;
            $row[] = $val->JENIS_KENAIKAN_PANGKAT;
            $row[] = $val->TMT_GOLONGAN2;
            $row[] = $val->GOLONGAN." (".$val->PANGKAT.")";
            $row[] = $val->NO_SK;
            $row[] = $val->TGL_SK2;
            $row[] = '<a href="javascript:;" data-url="'. site_url('integrasi_bkn/tambah_pangkatkpo_form?ambil='.$val->ID).'" data-id="'.$val->IDPEGAWAI.'" class="popuplarge btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-check"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->kpo_bkn_model->count_all(),
            "recordsFiltered" => $this->kpo_bkn_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function ajax_list_pposk() {
        $this->load->model(array('integrasi_bkn/ppo_bkn_model'));
        
        if (isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])) {
            $this->getPpoHist(str_replace("/", "-", $_POST['tgl_awal']), str_replace("/", "-", $_POST['tgl_akhir']));
        }
        
        $list = $this->ppo_bkn_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA;
            $row[] = $val->NIPNEW;
            $row[] = $val->TMT_PENSIUN2;
            $row[] = $val->TMT_GOLONGAN2;
            $row[] = $val->GOLONGAN." (".$val->PANGKAT.")";
            $row[] = $val->NO_SK;
            $row[] = $val->TGL_SK2;
//            $row[] = '<a href="javascript:;" data-url="'. site_url('integrasi_bkn/tambah_pangkatkpo_form?ambil='.$val->ID).'" data-id="'.$val->IDPEGAWAI.'" class="popuplarge btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-check"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->ppo_bkn_model->count_all(),
            "recordsFiltered" => $this->ppo_bkn_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function ajax_list_updated() {
        $this->load->model(array('integrasi_bkn/updated_bkn_model'));
        
        if (isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])) {
            $this->getUpdatedHist(str_replace("/", "-", $_POST['tgl_awal']), str_replace("/", "-", $_POST['tgl_akhir']));
        }
        
        $list = $this->updated_bkn_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->PNSORANGID;
            $row[] = $val->NAMARIWAYAT;
            $row[] = $val->LASTACTION;
            $row[] = $val->LASTUPDATETIME2;
//            $row[] = '<a href="javascript:;" data-url="'. site_url('integrasi_bkn/tambah_pangkatkpo_form?ambil='.$val->ID).'" data-id="'.$val->IDPEGAWAI.'" class="popuplarge btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-check"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->updated_bkn_model->count_all(),
            "recordsFiltered" => $this->updated_bkn_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function ajax_list_ppowafat() {
        $this->load->model(array('integrasi_bkn/ppo_wafat_bkn_model'));
        
        if (isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])) {
            $this->getPpoWafatHist(str_replace("/", "-", $_POST['tgl_awal']), str_replace("/", "-", $_POST['tgl_akhir']));
        }
        
        $list = $this->ppo_wafat_bkn_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->PNSORANGID;
            $row[] = $val->NAMARIWAYAT;
            $row[] = $val->LASTACTION;
            $row[] = $val->LASTUPDATETIME2;
//            $row[] = '<a href="javascript:;" data-url="'. site_url('integrasi_bkn/tambah_pangkatkpo_form?ambil='.$val->ID).'" data-id="'.$val->IDPEGAWAI.'" class="popuplarge btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-check"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->ppo_wafat_bkn_model->count_all(),
            "recordsFiltered" => $this->ppo_wafat_bkn_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    private function getKpoHist($tglawal,$tglakhir) {
        $this->load->library('apibkn');
        $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/kpo/sk/hist/01-10-2018/31-12-2018");
//            $bkn = [];
//            if (isset($result['code']) && $result['code'] == 1) {
//                $bkn = $result['data'];
//            }
//            $this->data['bkn'] = $bkn;
//                $datapegawai = $this->master_pegawai_model->get_by_nipnew($_GET['nip_pegawai']);
//                $_GET['pegawai_id'] = $datapegawai['ID'];
//                $this->data['simpeg'] = $this->master_pegawai_sanksi_model->get_datatables($_GET['nip_pegawai']);
        print '<pre>';
        print_r($result);
//                print_r($this->data['simpeg']);
        exit;
    }
    
    private function getPpoHist($tglawal,$tglakhir) {
        $this->load->library('apibkn');
        $this->load->model(array('integrasi_bkn/ppo_bkn_model'));

        $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/ppo/sk/hist/$tglawal/$tglakhir");
        
        $bkn = [];
        if (isset($result['code']) && $result['code'] == 1) {
            $bkn = $result['data'];
        }
        
        if ($bkn) {
            
            foreach ($bkn as $val) {
                $biasa = [
                    'ID' => $val['id'],
                    'NIPNEW' => $val['nipBaru'],
                    'KEDUDUKANHUKUM_ID' => $val['kedudukanHukum']['id'],
                    'KEDUDUKANHUKUM_NAMA' => $val['kedudukanHukum']['nama'],
                    'GOLONGAN_ID' => $val['golonganTerakhir']['id'],
                    'NO_SK' => $val['noSk'],
                    'NOMOR_PERTEK' => $val['nomorPertek'],
                    'MK_BULAN' => $val['masaKerjaPensiunBulan'],
                    'MK_BULAN' => $val['masaKerjaPensiunBulan'],
                    'NO_SK_TMS' => isset($val['noSkTms'])?$val['noSkTms']:NULL,
                    'NOMOR_USUL' => $val['nomorUsul'],
                    'TAHUN_GAPOK' => $val['tahunGapok'],
                    'JENIS_PENSIUN' => $val['jenisPensiun'],
                ];
                $tgl = [
                    'TMT_GOLONGAN' => $val['tmtGolongan'],
                    'TGL_SK' => datepickertodb(trim(str_replace("-", "/", $val['tglSk']))),
                    'TMT_PENSIUN' => datepickertodb(trim(str_replace("-", "/", $val['tmtPensiun']))),
                    'TGL_USUL' => datepickertodb(trim(str_replace("-", "/", $val['tglUsul']))),
                ];
                $this->ppo_bkn_model->insert($biasa, $tgl);
            }
        }
        
        return true;
    }
    
    private function getUpdatedHist($tglawal,$tglakhir) {
        $this->load->library('apibkn');
        $this->load->model(array('integrasi_bkn/updated_bkn_model'));

        $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/updated/hist/$tglawal/$tglakhir");
        
        $bkn = [];
        if (isset($result['code']) && $result['code'] == 1) {
            $bkn = $result['data'];
        }
        
        if ($bkn) {
            
            foreach ($bkn as $val) {
                $biasa = [
                    'ID' => $val['id'],
                    'NIPBARU' => isset($val['nipBaru']) ? $val['nipBaru'] : null,
                    'TMJENISRIWAYATBKN_ID' => $val['idJenisRiwayat'],
                    'IDRIWAYAT' => $val['idRiwayat'],
                    'LASTACTION' => $val['lastAction'],
                    'INSTANSIID' => $val['instansiId'],
                    'PNSORANGID' => $val['pnsOrangId'],
                ];
                $tgl = [
                    'LASTUPDATETIME' => date('Y-m-d H:i:s', 1635758001574/1000),
                ];
                $this->updated_bkn_model->insert($biasa, $tgl);
            }
        }
        
        return true;
    }
    
    private function getPpoWafatHist($tglawal,$tglakhir) {
        $this->load->library('apibkn');
        $this->load->model(array('integrasi_bkn/ppo_wafat_bkn_model'));

        $result = $this->apibkn->apiResult("https://wsrv.bkn.go.id/api/ppo/usul/wafat/hist/$tglawal/$tglakhir");
        
        $bkn = [];
        if (isset($result['code']) && $result['code'] == 1) {
            $bkn = $result['data'];
        }
        
        if ($bkn) {
            
            foreach ($bkn as $val) {
                $biasa = [
                    'ID' => $val['id'],
                    'NIPNEW' => $val['nipBaru'],
                    'NIPLAMA' => $val['nipLama'],
                    'jenisPensiun' => $val['jenisPensiun'],
                    'AKTEMENINGGAL' => $val['golonganTerakhir']['id'],
                ];
                $tgl = [
                    'TGL_MENINGGAL' => datepickertodb(trim(str_replace("-", "/", $val['tglMeninggal']))),
                ];
                $this->ppo_wafat_bkn_model->insert($biasa, $tgl);
            }
        }
        
        return true;
    }

}
