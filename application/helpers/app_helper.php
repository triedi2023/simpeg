<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('list_js_datatable')) {

    function list_js_datatable() {
        return ['assets/plugins/datatables/datatable.js', 'assets/plugins/datatables/datatables.min.js', 'assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'];
    }

}

if (!function_exists('month_indo')) {

    function month_indo($key) {
        switch ($key) {
            default:
            case '01': $bulan = 'Januari';
                break;
            case '02': $bulan = 'Februari';
                break;
            case '03': $bulan = 'Maret';
                break;
            case '04': $bulan = 'April';
                break;
            case '05': $bulan = 'Mei';
                break;
            case '06': $bulan = 'Juni';
                break;
            case '07': $bulan = 'Juli';
                break;
            case '08': $bulan = 'Agustus';
                break;
            case '09': $bulan = 'September';
                break;
            case '10': $bulan = 'Oktober';
                break;
            case '11': $bulan = 'November';
                break;
            case '12': $bulan = 'Desember';
                break;
        }
        return $bulan;
    }

}
if (!function_exists('custom_js')) {

    function custom_js($files = [], $url_structure = NULL, $version = '1.0', $echo = FALSE) {
        $html = "";
        foreach ($files as $file) {
            if ($url_structure) {
                $file = sprintf($url_structure, $file);
            }
            $file_url = base_url($file);
            $html .= "<script src=\"{$file_url}?v={$version}\"></script>";
        }
        if ($echo) {
            echo $html;
        }
        return $html;
    }

}

if (!function_exists('datepickertodb')) {

    function datepickertodb($tanggal) {
        if ($tanggal) {
            $pecah = explode("/", $tanggal);
            return $pecah[2] . "-" . $pecah[1] . "-" . $pecah[0];
        }
        return NULL;
    }

}

if (!function_exists('bkntodb')) {

    function bkntodb($tanggal) {
        if ($tanggal) {
            $pecah = explode("-", $tanggal);
            return $pecah[2] . "-" . $pecah[1] . "-" . $pecah[0];
        }
        return NULL;
    }

}

if (!function_exists('month_indo_singkat')) {

    function month_from_oracle($key) {
        switch ($key) {
            default:
            case 'JAN': $bulan = '01';
                break;
            case 'FEB': $bulan = '02';
                break;
            case 'MAR': $bulan = '03';
                break;
            case 'APR': $bulan = '04';
                break;
            case 'MAY': $bulan = '05';
                break;
            case 'JUN': $bulan = '06';
                break;
            case 'JUL': $bulan = '07';
                break;
            case 'AUG': $bulan = '08';
                break;
            case 'SEPT': $bulan = '09';
                break;
            case 'OCT': $bulan = '10';
                break;
            case 'NOV': $bulan = '11';
                break;
            case 'DEC': $bulan = '12';
                break;
        }
        return $bulan;
    }

}

if (!function_exists('datefromdbtodaydatepicker')) {

    function datefromdbtodaydatepicker($tanggal) {
        if ($tanggal) {
            $pecah = explode("-", $tanggal);
            $namahari = nama_hari_by_nama(date("l", mktime(0, 0, 0, $pecah[1], $pecah[0], $pecah[2])));
            return $namahari . ", " . $pecah[0] . "/" . $pecah[1] . "/" . $pecah[2];
        }
        return NULL;
    }

}

if (!function_exists('nama_hari_by_nama')) {

    function nama_hari_by_nama($nama) {
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }

        return $nama_hari;
    }

}

if (!function_exists('Romawi')) {

    function Romawi($n) {
        if ($n) {
            $hasil = "";
            $iromawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", 20 => "XX", 30 => "XXX", 40 => "XL", 50 => "L",
                60 => "LX", 70 => "LXX", 80 => "LXXX", 90 => "XC", 100 => "C", 200 => "CC", 300 => "CCC", 400 => "CD", 500 => "D", 600 => "DC", 700 => "DCC",
                800 => "DCCC", 900 => "CM", 1000 => "M", 2000 => "MM", 3000 => "MMM");
            if (array_key_exists($n, $iromawi)) {
                $hasil = $iromawi[$n];
            } elseif ($n >= 11 && $n <= 99) {
                $i = $n % 10;
                $hasil = $iromawi[$n - $i] . Romawi($n % 10);
            } elseif ($n >= 101 && $n <= 999) {
                $i = $n % 100;
                $hasil = $iromawi[$n - $i] . Romawi($n % 100);
            } else {
                $i = $n % 1000;
                $hasil = $iromawi[$n - $i] . Romawi($n % 1000);
            }

            return $hasil;
        }

        return '';
    }

}

if (!function_exists('penyebut')) {

    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

}

if (!function_exists('terbilang')) {

    function terbilang($nilai) {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }

}
