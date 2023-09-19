<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Akses extends CI_Controller {

    public $data = [];

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'menu_helper']);
        $this->lang->load('auth');
    }
    
    public function index() {
        redirect('akses/login');
    }

    /**
     * Log the user in
     */
    public function login() {
       /**
        * require_once '/var/www/html/simpeg/pub_libs/session2.php';
        */
        require_once '/home/adminpusdatin/Public/simpeg1/pub_libs/session2.php';
        $this->load->model(array('menu_model', 'list_model'));
        $authsess = $sess;
        if (isset($authsess) || !empty($authsess) || $authsess !== NULL) {
			if (($model = $this->ion_auth->login($authsess->username)) == true) {
					$nama = $this->ion_auth->get_pegawai($model->ID);
					$data = ['menu' => buildMenu($this->menu_model->list_menu($nama['idgroup'])), 'identity' => $model->USERNAME, 'last_check' => time(),
					'config' => $this->list_model->list_config(),'nama'=>$nama['nama'],
					'group' => $nama['group'], 'nip'=>$nama['NIPNEW'], 'user_id' => $model->ID,
					'trlokasi_id'=>$nama['trlokasi_id'],'kdu1'=>$nama['kdu1'],'kdu2'=>$nama['kdu2'],'kdu3'=>$nama['kdu3'],'kdu4'=>$nama['kdu4'],'kdu5'=>$nama['kdu5'],'idgroup'=>$nama['idgroup'],
					'auth' => $this->menu_model->list_menu_group($nama['idgroup'])];

					$this->session->set_userdata($data);
					if (in_array($nama['idgroup'], [3,4])) {
							redirect('/master_pegawai');
					} else {
							redirect('/beranda');
					}
			} else {
					redirect('http://portalsso.basarnas.go.id');
			}
		} else {
				redirect('http://portalsso.basarnas.go.id');
		}
    }

    /**
     * Log the user out
     */
    public function logout() {
		
		$this->load->model(array('menu_model', 'list_model'));
		$jmlsurvei = $this->menu_model->get_survey_aktif();
		$jmlpertanyaan = $this->menu_model->get_survey_pertanyaan_jawaban();
		
		if ($jmlsurvei > 0 && count($jmlpertanyaan) > 0) {
			redirect('survei/survey','refresh');
		}
		
		$this->data['title'] = "Logout";
		unset($_SESSION['menu']);
        unset($_SESSION['config']);
        unset($_SESSION['auth']);

		$this->session->unset_userdata('menu');
		$this->session->unset_userdata('config');
		$this->session->unset_userdata('auth');

        // log the user out
        $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('http://portalsso.basarnas.go.id/?logout', 'refresh');
    }

}
