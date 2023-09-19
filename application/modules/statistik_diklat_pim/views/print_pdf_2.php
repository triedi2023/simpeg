<?php

$tahun = date('Y');

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

function GenerateSentence() {
    //Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}

$pdf = new PDF_MC_Table('L', 'mm', array(210, 297));
$pdf->AddPage();
$pdf->setTopMargin(23);
$pdf->setLeftMargin(13);
$pdf->SetFont('Arial', '', 9);
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 130, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 11));
$pdf->Cell(30, 7, "", 0, 0, 'L');
$pdf->Cell(30, 7, "", 0, 0, 'L');
$pdf->Cell(28, 5, "", 0, 0, 'L');
$pdf->Cell(100, 5, 'KOMPOSISI PEGAWAI', 0, 1, 'C');
$pdf->Cell(88, 5, "", 0, 0, 'L');
$pdf->Cell(100, 5, $this->config->item('title_lembaga') . " TAHUN " . $tahun, 0, 1, 'C');
$pdf->Cell(88, 5, "", 0, 0, 'L');
$pdf->Cell(100, 5, "MENURUT DIKLATPIM PER ESELON", 0, 1, 'C');
$pdf->Cell(10, 12, "NO", 1, 0, 'C');
$pdf->Cell(130, 12, "UNIT KERJA", 1, 0, 'C');
$pdf->Cell(20, 6, "PIM IV", 1, 0, 'C');
$pdf->Cell(20, 6, "PIM III", 1, 0, 'C');
$pdf->Cell(20, 6, "PIM II", 1, 0, 'C');
$pdf->Cell(20, 6, "PIM I", 1, 0, 'C');
$pdf->Cell(20, 6, "Lemhanas.", 1, 0, 'C');
$pdf->Cell(20, 6, "Jumlah", 1, 0, 'C');
$pdf->Cell(50, 6, "", 0, 1, 'L');
$pdf->Cell(50, 0, "", 0, 0, 'C');
$pdf->Cell(40, 0, "", 0, 0, 'L');
$pdf->Cell(50, 0, "", 0, 0, 'L');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');
$pdf->Cell(10, 6, "(L)", 1, 0, 'C');
$pdf->Cell(10, 6, "(P)", 1, 0, 'C');


$pdf->Cell(10, 6, "", 0, 1, 'C');

srand(microtime() * 1000000);
$i = 1;
foreach ($data_pdf as $p) {
    $pdf->Row(array($i, $p['parent_lokasi'], '', '', '', '', '', '', '', '', '', '', '', ''));
    $j = 1;
    $sum_l = 0;
    $sum_p = 0;
    $sum = 0;
    $es4l = 0;
    $es4p = 0;
    $es3l = 0;
    $es3p = 0;
    $es2l = 0;
    $es2p = 0;
    $es1l = 0;
    $es1p = 0;
    $es1_fk_l = 0;
    $es1_fk_p = 0;
    $tot_sum_l = 0;
    $tot_sum_p = 0;
    $tot_sum = 0;
    $tot_sum_l_all = 0;
    $tot_sum_p_all = 0;
    $tot_sum_all = 0;
    $total_es4l = 0;
    $total_es4p = 0;
    $total_es3l = 0;
    $total_es3p = 0;
    $total_es2l = 0;
    $total_es2p = 0;
    $total_es1l = 0;
    $total_es1p = 0;
    $total_es1_fk_l = 0;
    $total_es1_fk_p = 0;
    foreach ($p['detail_lokasi'] as $r) {
        $sum_l_all = $r['ES4L'] + $r['ES3L'] + $r['ES2L'] + $r['ES1L'] + $r['ES1_FK_L'];
        $sum_p_all = $r['ES4P'] + $r['ES3P'] + $r['ES2P'] + $r['ES1P'] + $r['ES1_FK_P'];
        $sum_l = $r['ES4L'] + $r['ES3L'] + $r['ES2L'] + $r['ES1L'] + $r['ES1_FK_L'];
        $sum_p = $r['ES4P'] + $r['ES3P'] + $r['ES2P'] + $r['ES1P'] + $r['ES1_FK_P'];
        $sum_all = $r['ES4P'] + $r['ES3P'] + $r['ES2P'] + $r['ES1P'] + $r['ES1_FK_P'] + $r['ES4L'] + $r['ES3L'] + $r['ES2L'] + $r['ES1L'] + $r['ES1_FK_L'];
        $sum = $sum_l + $sum_p;
        $total_es4l = $total_es4l + $r['ES4L'];
        $total_es4p = $total_es4p + $r['ES4P'];
        $total_es3l = $total_es3l + $r['ES3L'];
        $total_es3p = $total_es3p + $r['ES3P'];
        $total_es2l = $total_es2l + $r['ES2L'];
        $total_es2p = $total_es2p + $r['ES2P'];
        $total_es1l = $total_es1l + $r['ES1L'];
        $total_es1p = $total_es1p + $r['ES1P'];
        $total_es1_fk_l = $total_es1_fk_l + $r['ES1_FK_L'];
        $total_es1_fk_p = $total_es1_fk_p + $r['ES1_FK_P'];
        $es4l = $es4l + $r['ES4L'];
        $es4p = $es4p + $r['ES4P'];
        $es3l = $es3l + $r['ES3L'];
        $es3p = $es3p + $r['ES3P'];
        $es2l = $es2l + $r['ES2L'];
        $es2p = $es2p + $r['ES2P'];
        $es1l = $es1l + $r['ES1L'];
        $es1p = $es1p + $r['ES1P'];
        $es1_fk_l = $es1_fk_l + $r['ES1_FK_L'];
        $es1_fk_p = $es1_fk_p + $r['ES1_FK_P'];
        $tot_sum_l = $tot_sum_l + $sum_l;
        $tot_sum_l_all = $tot_sum_l_all + $sum_l_all;
        $tot_sum_p_all = $tot_sum_p_all + $sum_p_all;
        $tot_sum_all = $tot_sum_all + $sum_all;
        $tot_sum_p = $tot_sum_p + $sum_p;
        $tot_sum = $tot_sum + $sum;
        $pdf->Row(array($j, $r['NM_LOKASI'],
            $r['ES4L'],
            $r['ES4P'],
            $r['ES3L'],
            $r['ES3P'],
            $r['ES2L'],
            $r['ES2P'],
            $r['ES1L'],
            $r['ES1P'],
            $r['ES1_FK_L'],
            $r['ES1_FK_P'],
            $sum_l,
            $sum_p));
        $j++;
    }
    $pdf->Row(array('', 'Jumlah',
        $es4l, $es4p,
        $es3l, $es3p,
        $es2l, $es2p,
        $es1l, $es1p,
        $es1_fk_l, $es1_fk_p,
        $tot_sum_l, $tot_sum_p));
    $i++;
}
$pdf->Row(array('', 'Keseluruhan',
    $total_es4l, $total_es4p,
    $total_es3l, $total_es3p,
    $total_es2l, $total_es2p,
    $total_es1l, $total_es1p,
    $total_es1_fk_l, $total_es1_fk_p,
    $tot_sum_l_all, $tot_sum_p_all));
$pdf->Output();
?>
