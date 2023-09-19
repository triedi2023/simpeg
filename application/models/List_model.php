<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class List_model extends CI_Model {

    public function list_config() {
        $this->db->select("KUNCINYA,ISINYA");
        $this->db->from("SYSTEM_CONFIG");
        $query = $this->db->get();
        $config = [];
        foreach ($query->result_array() as $val) {
            $config[$val['KUNCINYA']] = $val['ISINYA'];
        }
        return $config;
    }

    public function list_config_by_key($key) {
        $this->db->select("ISINYA");
        $this->db->where("KUNCINYA", $key);
        $this->db->from("SYSTEM_CONFIG");
        $query = $this->db->get();

        return $query->row_array()['ISINYA'];
    }

    public function list_tahun() {
        $tahun = [];
        for ($t = date('Y'); $t >= 2010; $t--) {
            $tahun[] = $t;
        }
        return $tahun;
    }

    public function list_bulan() {
        $data = array(
            0 => array(
                'kode' => '01',
                'nama' => 'Januari'
            ),
            1 => array(
                'kode' => '02',
                'nama' => 'Februari'
            ),
            2 => array(
                'kode' => '03',
                'nama' => 'Maret'
            ),
            3 => array(
                'kode' => '04',
                'nama' => 'April'
            ),
            4 => array(
                'kode' => '05',
                'nama' => 'Mei'
            ),
            5 => array(
                'kode' => '06',
                'nama' => 'Juni'
            ),
            6 => array(
                'kode' => '07',
                'nama' => 'Juli'
            ),
            7 => array(
                'kode' => '08',
                'nama' => 'Agustus'
            ),
            8 => array(
                'kode' => '09',
                'nama' => 'September'
            ),
            9 => array(
                'kode' => '10',
                'nama' => 'Oktober'
            ),
            10 => array(
                'kode' => '11',
                'nama' => 'Nopember'
            ),
            11 => array(
                'kode' => '12',
                'nama' => 'Desember'
            )
        );

        return $data;
    }

    public function list_satuan_skp() {
        $this->db->select("ID,NAMA_SATUAN AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_SATUAN_SKP");
        $this->db->order_by("NAMA_SATUAN", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_keterangan_jabatan($id=0) {
        $this->db->select("ID,KETERANGAN_JABATAN AS NAMA");
        $this->db->where("STATUS", 1);
        if (!empty($id) && $id != 0) {
            $this->db->where("ID", $id);
        }
        $this->db->from("TR_KETERANGAN_JABATAN");
        $this->db->order_by("KETERANGAN_JABATAN", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_jenis_assessment_test() {
        $this->db->select("ID,JENIS_ASSESSMENT_TEST AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_JENIS_ASSESSMENT_TEST");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_tujuan_assessment_test() {
        $this->db->select("ID,TUJUAN_ASSESSMENT_TEST AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_TUJUAN_ASSESSMENT_TEST");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_rekomendasi() {
        $this->db->select("ID,REKOMENDASI AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_REKOMENDASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_bahasa() {
        $this->db->select("ID,JENIS_BAHASA AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_JENIS_BAHASA");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_data_kepangkatan() {
        $this->db->select("ID,JENIS_DATA_KEPANGKATAN AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_JENIS_DATA_KEPANGKATAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_penjenjangan_fungsional() {
        $this->db->select("ID,PENJENJANGAN_FUNGSIONAL AS NAMA");
        $this->db->from("TR_PENJENJANGAN_FUNGSIONAL");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_diklat_fungsional() {
        $this->db->select("ID,JENIS_DIKLAT_FUNGSIONAL AS NAMA");
        $this->db->from("TR_JENIS_DIKLAT_FUNGSIONAL");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_nama_penjenjangan($tingkat = 0, $jns_diklat = 0) {
        $this->db->select("ID,NAMA_PENJENJANGAN AS NAMA");
        $this->db->from("TR_NAMA_PENJENJANGAN");
        if ($tingkat == '') {
            $kode_jenis = 0;
        } else {
            $kode_jenis = $tingkat;
        }
        if ($jns_diklat == '1') {
            $this->db->where("KODE_JENIS", '99');
        } else {
            $this->db->where("KODE_JENIS", $kode_jenis);
        }
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_tanda_jasa() {
        $this->db->select("ID,JENIS_TANDA_JASA AS NAMA");
        $this->db->from("TR_JENIS_TANDA_JASA");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_tanda_jasa($jenistandajasa = '0') {
        $this->db->select("ID,TANDA_JASA AS NAMA");
        $this->db->from("TR_TANDA_JASA");
        $this->db->where("TRJENISTANDAJASA_ID", $jenistandajasa);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_tanda_jasa_all() {
        $this->db->select("ID,TANDA_JASA AS NAMA,TRJENISTANDAJASA_ID");
        $this->db->from("TR_TANDA_JASA");
        $this->db->where("STATUS", 1);
        $this->db->order_by("TRJENISTANDAJASA_ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_provinsi() {
        $this->db->select("ID,NAMA_PROPINSI AS NAMA");
        $this->db->from("TR_PROPINSI");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kabupaten($id = "") {
        $this->db->select("ID,KABUPATEN AS NAMA");
        if ($id) {
            $this->db->where("TRPROPINSI_ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_KABUPATEN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_tkt_hukdis($id = "") {
        $this->db->select("ID,TKT_HUKUMAN_DISIPLIN AS NAMA");
        $this->db->from("TR_TKT_HUKUMAN_DISIPLIN");
        $this->db->where("STATUS", 1);
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_hukdis($tkthukdis = 0) {
        $this->db->select("ID,JENIS_HUKDIS AS NAMA");
        $this->db->from("TR_JENIS_HUKUMAN_DISIPLIN");
        $this->db->where("TRTKTHUKUMANDISIPLIN_ID", $tkthukdis);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_cuti($tkthukdis = 0) {
        $this->db->select("ID,NAMA_CUTI AS NAMA");
        $this->db->from("TR_CUTI");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_status_fungsional($tkthukdis = 0) {
        $this->db->select("ID,STATUS_FUNGSIONAL AS NAMA");
        $this->db->from("TR_STATUS_FUNGSIONAL");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jenis_libur() {
        $this->db->select("ID,JENIS_LIBUR AS NAMA");
        $this->db->from("TR_JENIS_LIBUR");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_status_alasan_fungsional($parent_id = 0) {
        $this->db->select("ID,ALASAN_STATUS_FUNGSIONAL AS NAMA");
        $this->db->from("TR_ALASAN_STATUS_FUNGSIONAL");
        $this->db->where("TRSTATUSFUNGSIONAL_ID", (int) $parent_id);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_tingkat_diklat_kepemimpinan($parent_id = 0) {
        $this->db->select("ID,NAMA_JENJANG AS NAMA");
        $this->db->from("TR_TINGKAT_DIKLAT_KEPEMIMPINAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kualifikasi_kelulusan($parent_id = 0) {
        $this->db->select("ID,KUALIFIKASI_KELULUSAN AS NAMA");
        $this->db->from("TR_KUALIFIKASI_KELULUSAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kelompok_diklat_teknis($id = "") {
        $this->db->select("ID,NAMA_KELOMPOK AS NAMA");
        $this->db->from("TR_KELOMPOK_DKLT_TEKNIS");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_diklat_teknis($kelompok_id = '0') {
        $this->db->select("ID,NAMA_DIKLAT AS NAMA");
        $this->db->from("TR_DIKLAT_TEKNIS");
        if ($kelompok_id != '0')
            $this->db->where("TRKELOMPOKDKLTTEKNIS_ID", $kelompok_id);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_status_kepegawaian($id = "") {
        $this->db->select("ID,STATUS_KEPEGAWAIAN AS NAMA");
        $this->db->from("TR_STATUS_KEPEGAWAIAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_status_kepegawaian_html($id = "") {
        $option = "";
        foreach ($this->list_status_kepegawaian_tree() as $val) {
            $selec = '';
            if ($val['id'] == $id) {
                $selec = 'selected=""';
            }
            if (isset($val['children']) && count(array_filter($val['children'])) > 0) {
                $option .= '<optgroup label="' . $val['text'] . '">';
                foreach ($val['children'] as $children) {
                    if ($children['id'] == $id) {
                        $selec = 'selected=""';
                    }
                    $option .= '<option ' . $selec . ' value="' . $children['id'] . '">' . $children['text'] . '</option>';
                }
                $option .= '</optgroup>';
            } else {
                $option .= '<option ' . $selec . ' value="' . $val['id'] . '">' . $val['text'] . '</option>';
            }
        }

        return $option;
    }

    public function list_status_kepegawaian_tree($id = NULL) {
        $this->db->select("ID as id,PARENT_ID as parent_id,STATUS_KEPEGAWAIAN as text");
        if ($id <> NULL) {
            $this->db->where("PARENT_ID", $id);
        } else {
            $this->db->where("PARENT_ID IS NULL");
        }
        $this->db->from("TABEL_STS_PEGAWAI_RECURSIVE");
        $query = $this->db->get();

        $tree = [];
        if ($query->num_rows() > 0) {
            $parent_query = $query->result_array();
            if ($parent_query) {
                foreach ($parent_query as $val) {
                    if ($this->list_status_kepegawaian_tree($val['id'])) {
                        $tree[] = [
                            'id' => $val['id'],
                            'text' => $val['text'],
                            'children' => $this->list_status_kepegawaian_tree($val['id'])
                        ];
                    } else {
                        $tree[] = [
                            'id' => $val['id'],
                            'text' => $val['text']
                        ];
                    }
                }
            }
        }

        return $tree;
    }

    public function list_lokasi_tree($parent_id = NULL, $id = NULL) {
        $this->db->select("ID as id,PARENT_ID as parent_id,NAMA_LOKASI as text");
        if ($parent_id != NULL) {
            $this->db->where("PARENT_ID", $parent_id);
        } elseif ($id == NULL) {
            $this->db->where("PARENT_ID IS NULL");
        }
        if ($id != NULL) {
            $this->db->where("ID", $id);
        }
        $this->db->from("TABEL_LOKASI_KERJA_RECURSIVE");
        $query = $this->db->get();

        $tree = [];
        if ($query->num_rows() > 0) {
            $parent_query = $query->result_array();
            if ($parent_query) {
                foreach ($parent_query as $val) {
                    if ($this->list_lokasi_tree($val['id'])) {
                        $tree[] = [
                            'id' => $val['id'],
                            'text' => $val['text'],
                            'children' => $this->list_lokasi_tree($val['id'])
                        ];
                    } else {
                        $tree[] = [
                            'id' => $val['id'],
                            'text' => $val['text']
                        ];
                    }
                }
            }
        }

        return $tree;
    }

    public function list_lokasi_tree_html($id = "") {
        $option = "";
        if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2) {
            foreach ($this->list_lokasi($id) as $val) {
                $option .= '<option selected="" value="' . $val['ID'] . '">' . $val['NAMA'] . '</option>';
            }
        } else {
            foreach ($this->list_lokasi_tree() as $val) {
                $selec = '';
                if ($val['id'] == $id) {
                    $selec = 'selected=""';
                }
                if (isset($val['children']) && count(array_filter($val['children'])) > 0) {
                    $option .= '<optgroup label="' . $val['text'] . '">';
                    foreach ($val['children'] as $children) {
                        if ($id == "" && $children['id'] == 2) {
                            $selec = 'selected=""';
                        }
                        if ($children['id'] == $id) {
                            $selec = 'selected=""';
                        }
                        $option .= '<option ' . $selec . ' value="' . $children['id'] . '">' . $children['text'] . '</option>';
                    }
                    $option .= '</optgroup>';
                } else {
                    $option .= '<option ' . $selec . ' value="' . $val['id'] . '">' . $val['text'] . '</option>';
                }
            }
        }

        return $option;
    }

    public function list_lokasi($id = "") {
        $this->db->select("ID,NAMA_LOKASI AS NAMA");
        $this->db->from("TR_LOKASI");
        if ($id)
            $this->db->where("ID", $id);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_eselon($id = "") {
        $this->db->select("ID,ESELON AS NAMA");
        $this->db->from("TR_ESELON");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_eselon_bkn($id = "") {
        $this->db->select("ID,ESELON ||' ('||ID_BKN||')' AS NAMA");
        $this->db->from("TR_ESELON");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_eselon_struktural($id = "") {
        $this->db->select("ID,ESELON AS NAMA");
        $this->db->from("TR_ESELON");
        $this->db->where("TKTESELON <", 6);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kelompok_fungsional($id = "") {
        $this->db->select("ID,KELOMPOK_FUNGSIONAL AS NAMA");
        $this->db->from("TR_KELOMPOK_FUNGSIONAL");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_tingkat_fungsional($id = "") {
        $this->db->select("ID,TINGKAT_FUNGSIONAL AS NAMA");
        $this->db->from("TR_TINGKAT_FUNGSIONAL");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_golongan_pangkat($trstatuskepegawaianid = 1,$id="") {
        $this->db->select("ID,CASE WHEN TRSTATUSKEPEGAWAIAN_ID = 1 THEN PANGKAT||' ('||GOLONGAN||')' ELSE PANGKAT END AS NAMA");
        $this->db->from("TR_GOLONGAN");
        if ($trstatuskepegawaianid)
            $this->db->where("TRSTATUSKEPEGAWAIAN_ID", $trstatuskepegawaianid);
        else
            $this->db->where("TRSTATUSKEPEGAWAIAN_ID", 1);
        if ($id)
            $this->db->where("ID", $id);
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_golongan_pangkat_bkn($id="") {
        $this->db->from("TR_GOLONGAN");
        $this->db->where("ID_BKN", $id);
        $this->db->where("STATUS", 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function list_jenis_kenaikan_pangkat($id="") {
        $this->db->select("ID,JENIS_KENAIKAN_PANGKAT AS NAMA");
        $this->db->from("TR_JENIS_KENAIKAN_PANGKAT");
        if ($id)
            $this->db->where("ID", $id);
        $this->db->where("STATUS", 1);
        $this->db->order_by("URUTAN", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_pendidikan($id = 1, $tanda = "") {
        $this->db->select("ID,TINGKAT_PENDIDIKAN AS NAMA");
        $this->db->from("TR_TINGKAT_PENDIDIKAN");
        if ($tanda != "") {
            $this->db->where("ID " . $tanda, $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_fakultas($id = 1) {
        $this->db->select("ID,NAMA_FAKULTAS AS NAMA");
        $this->db->from("TR_FAKULTAS");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jurusan($id = 0) {
        $this->db->select("ID,NAMA_JURUSAN AS NAMA");
        $this->db->from("TR_JURUSAN");
        if ($id != 0) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_negara($id = 1) {
        $this->db->select("ID,NAMA_NEGARA AS NAMA");
        $this->db->from("TR_NEGARA");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kegiatan($id = 1) {
        $this->db->select("ID,JENIS_KEGIATAN AS NAMA");
        $this->db->from("TR_JENIS_KEGIATAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_pembiayaan($id = 1) {
        $this->db->select("ID,JENIS_PEMBIAYAAN AS NAMA");
        $this->db->from("TR_JENIS_PEMBIAYAAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kedudukan($id = 1) {
        $this->db->select("ID,KEDUDUKAN_DLM_KEGIATAN AS NAMA");
        $this->db->from("TR_KEDUDUKAN_DLM_KEGIATAN");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_organisasi($id = 1) {
        $this->db->select("ID,JENIS_ORGANISASI AS NAMA");
        $this->db->from("TR_JENIS_ORGANISASI");
        $this->db->where("STATUS", 1);
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_jabatan($id = "") {
        $this->db->select("ID,JABATAN AS NAMA");
        if ($id) {
            $this->db->where("TRESELON_ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_JABATAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_eselon_jabatan($id = "") {
        $this->db->select("TR_JABATAN.ID,JABATAN AS NAMAJABATAN,TR_ESELON.ID AS KODE,ESELON");
        if ($id) {
            $this->db->where("TRESELON_ID", $id);
        }
        $this->db->where("TR_JABATAN.STATUS", 1);
        $this->db->from("TR_JABATAN");
        $this->db->join("TR_ESELON","TR_JABATAN.TRESELON_ID=TR_ESELON.ID");
        $this->db->order_by("TR_JABATAN.TRESELON_ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_status_belajar($id = "") {
        $this->db->select("ID,STATUS_BELAJAR AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_BELAJAR");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kondisi_belajar($id = "") {
        $this->db->select("ID,KONDISI_BELAJAR AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_KONDISI_BELAJAR");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_agama($id = "") {
        $this->db->select("ID,AGAMA AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_AGAMA");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_agama_bkn($id = "") {
        $this->db->select("ID,AGAMA AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_AGAMA");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_pekerjaan($id = "") {
        $this->db->select("ID,PEKERJAAN AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_PEKERJAAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_gol_darah($id = "") {
        $this->db->select("ID,GOL_DARAH AS NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_GOL_DARAH");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_sts_nikah($id = "") {
        $this->db->select("ID,NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_PERNIKAHAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_sts_nikah_bkn($id = "") {
        $this->db->select("ID,NAMA");
        if ($id) {
            $this->db->where("ID_BKN", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_PERNIKAHAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function list_sts_anak($id = "") {
        $this->db->select("ID,NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_ANAK");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_sts_ortu($id = "") {
        $this->db->select("ID,NAMA");
        if ($id) {
            $this->db->where("ID", $id);
        }
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_ORANG_TUA");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu() {
        $this->db->select("KDU1,KDU2,KDU3,KDU4,KDU5,NMUNIT AS NAMA, TRLOKASI_ID");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_kdu1($trlokasi_id = 1) {
        $this->db->select("KDU1 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2) {
            $this->db->where("KDU1", $this->session->userdata('kdu1'));
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON < ", 2);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu2($trlokasi_id = 1, $kdu1 = "") {
        $this->db->select("KDU2 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) {
            $this->db->where("KDU2", $this->session->userdata('kdu2'));
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 2);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu3($trlokasi_id = 1, $kdu1 = "", $kdu2 = "") {
        $this->db->select("KDU3 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if (!empty($this->session->userdata('kdu3')) && $this->session->userdata('idgroup') == 2 && $this->session->userdata('trlokasi_id') > 2) {
            $this->db->where("KDU3", $this->session->userdata('kdu3'));
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 3);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu4($trlokasi_id = 1, $kdu1 = "", $kdu2 = "", $kdu3 = "") {
        $this->db->select("KDU4 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("KDU3", $kdu3);
        }
        if (!empty($this->session->userdata('kdu4')) && $this->session->userdata('idgroup') == 2 && $this->session->userdata('kdu3') == '017') {
            $this->db->where("KDU4", $this->session->userdata('kdu4'));
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 4);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu5($trlokasi_id = 1, $kdu1 = "", $kdu2 = "", $kdu3 = "", $kdu4 = "") {
        $this->db->select("KDU5 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("KDU3", $kdu3);
        }
        if ($kdu4) {
            $this->db->where("KDU4", $kdu4);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 5);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu1_jabatan($trlokasi_id = 1) {
        $this->db->select("KDU1 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON < ", 2);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu2_jabatan($trlokasi_id = 1, $kdu1 = "") {
        $this->db->select("KDU2 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 2);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu3_jabatan($trlokasi_id = 1, $kdu1 = "", $kdu2 = "") {
        $this->db->select("KDU3 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 3);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu4_jabatan($trlokasi_id = 1, $kdu1 = "", $kdu2 = "", $kdu3 = "") {
        $this->db->select("KDU4 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("KDU3", $kdu3);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 4);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_kdu5_jabatan($trlokasi_id = 1, $kdu1 = "", $kdu2 = "", $kdu3 = "", $kdu4 = "") {
        $this->db->select("KDU5 AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("KDU3", $kdu3);
        }
        if ($kdu4) {
            $this->db->where("KDU4", $kdu4);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 5);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function daftar_agama() {
        $this->db->select("ID,AGAMA AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_AGAMA");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        $list = [];
        if ($result) {
            foreach ($result as $val) {
                $list[$val['ID']] = $val['NAMA'];
            }
        }
        return $list;
    }
    
    public function daftar_sts_nikah() {
        $this->db->select("ID,NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("TR_STATUS_PERNIKAHAN");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        $list = [];
        if ($result) {
            foreach ($result as $val) {
                $list[$val['ID']] = $val['NAMA'];
            }
        }
        return $list;
    }
    
    public function daftar_verifikasi_cuti() {
        return array (
            1 => 'Disetujui',
            2 => 'Perubahan',
            3 => 'Ditangguhkan',
            4 => 'Tidak Disetujui'
        );
    }

}
