<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apibkn {

    private $ci;
    public $data;
    
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('Api_bkn_model');
    }

    public function getToken() {
        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, "https://wstraining.bkn.go.id/oauth/token");
        curl_setopt($curl, CURLOPT_URL, "https://wsrv-auth.bkn.go.id/oauth/token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=basarnastr&grant_type=client_credentials");
        curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=bnppertolonganws&grant_type=client_credentials");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'origin: http://localhost:20000',
//            "Authorization: Basic " . base64_encode("basarnastr:tr6789")
            "Authorization: Basic " . base64_encode("bnppertolonganws:xpZDZRkZ2Ru")
        ));

        // receive server response ...
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (($jsondata = curl_exec($curl)) === false) {
            exit('Curl error: ' . curl_error($curl));
        } else {
            $obj = json_decode($jsondata, true);
            if (isset($obj['access_token'])) {
                $this->ci->Api_bkn_model->insert_token($obj);
            }
        }

        curl_close($curl);
    }
    
    public function apiResult($url = '') {
        $tokenKey = (object)[];
        if (($tokenKey = $this->ci->Api_bkn_model->get_token()) === null) {
            $this->getToken();
            $tokenKey = $this->ci->Api_bkn_model->get_token();
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data','Origin: http://localhost:20000', 'Authorization: Bearer '. $tokenKey->ACCESS_TOKEN));

        // receive server response ...
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (($jsondata = curl_exec($curl)) === false) {
            exit('Curl error: ' . curl_error($curl));
        } else {
            $obj = json_decode($jsondata, true);
            curl_close($curl);

            if (isset($obj['error']) && !empty($obj['error'])) {
                $this->getToken();
                $this->apiResult($url);
            }
            return $obj;
        }
    }
    
    public function apiKirim($url = '', $jsonData) {
        $tokenKey = (object)[];
        if (($tokenKey = $this->ci->Api_bkn_model->get_token()) === null) {
            $this->getToken();
            $tokenKey = $this->ci->Api_bkn_model->get_token();
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Origin: http://localhost:20000', 'Authorization: Bearer '. $tokenKey->ACCESS_TOKEN));

        // receive server response ...
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (($jsondata = curl_exec($curl)) === false) {
            exit('Curl error: ' . curl_error($curl));
        } else {
            $obj = json_decode($jsondata, true);
            curl_close($curl);

            if (isset($obj['error']) && !empty($obj['error'])) {
                $this->getToken();
                $this->apiResult($url);
            }
            return $obj;
        }
    }

}
