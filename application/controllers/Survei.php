<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Survei extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('beranda_model'));
        $this->data['title_utama'] = 'Survei';
    }

    public function survey() {
        $this->load->helper(array('form'));
        $this->data['content'] = 'survei/survey';
        $this->data['survey'] = $this->beranda_model->get_survey();
        $this->data['pertanyaan'] = $this->beranda_model->get_survey_pertanyaan_jawaban();
        
        if (count($this->data['pertanyaan']) > 0) {
            $this->load->view('layouts/main', $this->data);
        } else {
            redirect('akses/logout', 'refresh');
        }
    }

    public function proses_survey() {
        $survey = $this->beranda_model->get_survey();
        $pertanyaan = $this->beranda_model->get_survey_pertanyaan_jawaban();
        $belumjawab = [];

        if (isset($_POST['pertanyaan']) && $survey):
            $c=0;
            foreach ($survey as $val):
                if ($pertanyaan[$val['ID']]):
                    foreach ($pertanyaan[$val['ID']] as $isi):
                        if (!isset($_POST['pertanyaan'][$isi['id']]) || empty($_POST['pertanyaan'][$isi['id']])) {
                            $c++;
                        }
                    endforeach;
                else:
                    $belumjawab[] = $c;
                    $c++;
                endif;
            endforeach;
        else:
            $c++;
        endif;
        if ($c > 0) {
            $this->session->set_flashdata('error', 'Ada error');
            redirect('survei/survey', 'refresh');
        } else {
            if (isset($_POST['pertanyaan']) && $survey):
                foreach ($survey as $val):
                    if ($pertanyaan[$val['ID']]):
                        foreach ($pertanyaan[$val['ID']] as $isi):
                            $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
                            $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                            $this->db->set('TRSURVEYPERTANYAAN_ID', $isi['id'], FALSE);
                            $this->db->set('TRSURVEY_JAWABAN', $_POST['pertanyaan'][$isi['id']]);
                            $this->db->insert("TR_SURVEY_HASIL");
                        endforeach;
                    endif;
                endforeach;
            endif;

            $this->session->set_flashdata('sukses', 'Ok');
            redirect('survei/survey', 'refresh');
        }
    }
}
