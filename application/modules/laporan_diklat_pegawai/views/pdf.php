<?php

class PDF_MC_Table extends FPDF {

    var $widths;
    var $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function HeaderTable($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function Row($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

function GenerateWord() {
    //Get a random word
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++)
        $w .= chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence() {
    //Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}

$pdf = new PDF_MC_Table("L");
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 6, 'Laporan Periodik', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
if ($struktur):
    $nmstruktur = '';
    $pecah = explode(", ", $struktur['NMSTRUKTUR']);
    $nm4 = '';
    if (isset($pecah[0]) && !empty($pecah[0])) {
        $pdf->Cell(0, 6, $pecah[0], 0, 1, 'C');
    }
    $nm3 = '';
    if (isset($pecah[1]) && !empty($pecah[1])) {
        $pdf->Cell(0, 6, $pecah[1], 0, 1, 'C');
    }
    $nm2 = '';
    if (isset($pecah[2]) && !empty($pecah[2])) {
        $pdf->Cell(0, 6, $pecah[2], 0, 1, 'C');
    }
    $nm1 = '';
    if (isset($pecah[3]) && !empty($pecah[3])) {
        $pdf->Cell(0, 6, $pecah[3], 0, 1, 'C');
    }
    $nm0 = '';
    if (isset($pecah[4]) && !empty($pecah[4])) {
        $pdf->Cell(0, 6, $pecah[4], 0, 1, 'C');
    }
    $pdf->Cell(0, 6, $this->config->item('instansi_panjang'), 0, 1, 'C');
else:
    $pdf->Cell(0, 6, $this->config->item('instansi_panjang'), 0, 1, 'C');
endif;
$pdf->Cell(0, 6, "Periode " . month_indo(date('m')) . " " . date("Y"), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();

// content
$pdf->SetWidths(array(10, 40, 30, 45, 30, 30, 30, 30, 30));
$pdf->HeaderTable(['No', 'Nama / NIP / Tgl Lahir / Umur', 'Gol / Ruang / TMT', 'Jabatan / a. TMT Jabatan / b.TMT Eselon', 'Diklat PIM Tahun', 'Diklat Fungsional', 'Diklat Teknis', 'Diklat Lain', 'Pendidikan']);
$t = 1;
foreach ($model as $val):
    $dtl_jabatan = '';
    if ($val['dtl_jabatan']):
        $k = 1;
        foreach ($val['dtl_jabatan'] as $isi):
            $dtl_jabatan .= $k . ". " . $isi['N_JABATAN'] . "\n" . $isi['TMT_JABATAN'] . "\n" . $isi['TMT_ESELON'] . "---------------------\n";
            $k++;
        endforeach;
    endif;
    $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
    $pdf->Row([$t, $nama . "\n" . $val['NIPNEW'] . "\n" . $val['TGLLAHIR'] . "\n" . $val['UMUR'], $val['PANGKAT'] . " (" . $val['GOLONGAN_RUANG'] . ") " . "\n" . $val['TMT_GOL'],$dtl_jabatan,'','','','','']);
    $t++;
endforeach;

$pdf->Output('', $title_utama);
?>