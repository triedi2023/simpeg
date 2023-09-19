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
$pdf->Cell(100, 5, "MENURUT DIKLATPIM PER LOKASI UNIT KERJA", 0, 1, 'C');
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
$total_es1_fu_l = 0;
$total_es1_fu_p = 0;
$sum_l = 0;
$sum_p = 0;
$sum = 0;
$pim_tk4_l = 0;
$pim_tk4_p = 0;
$pim_tk3_l = 0;
$pim_tk3_p = 0;
$pim_tk2_l = 0;
$pim_tk2_p = 0;
$pim_tk1_l = 0;
$pim_tk1_p = 0;
$lemhanas_l = 0;
$lemhanas_p = 0;
$es1_fu_l = 0;
$es1_fu_p = 0;
$tot_sum_l = 0;
$tot_sum_p = 0;
$tot_sum = 0;
$tot_sum_l_all = 0;
$tot_sum_p_all = 0;
$tot_sum_all = 0;
foreach ($data_pdf as $p) {
    $sum_l_all = $p['PIM_TK4_L'] + $p['PIM_TK3_L'] + $p['PIM_TK2_L'] + $p['PIM_TK1_L'] + $p['LEMHANAS_L'];
    $sum_p_all = $p['PIM_TK4_P'] + $p['PIM_TK3_P'] + $p['PIM_TK2_P'] + $p['PIM_TK1_P'] + $p['LEMHANAS_P'];
    $sum_l = $p['PIM_TK4_L'] + $p['PIM_TK3_L'] + $p['PIM_TK2_L'] + $p['PIM_TK1_L'] + $p['LEMHANAS_L'];
    $sum_p = $p['PIM_TK4_P'] + $p['PIM_TK3_P'] + $p['PIM_TK2_P'] + $p['PIM_TK1_P'] + $p['LEMHANAS_P'];
    $sum_all = $p['PIM_TK4_P'] + $p['PIM_TK3_P'] + $p['PIM_TK2_P'] + $p['PIM_TK1_P'] + $p['LEMHANAS_P'] + $p['PIM_TK4_L'] + $p['PIM_TK3_L'] + $p['PIM_TK2_L'] + $p['PIM_TK1_L'] + $p['LEMHANAS_L'];
    $sum = $sum_l + $sum_p;
    $total_es4l = $total_es4l + $p['PIM_TK4_L'];
    $total_es4p = $total_es4p + $p['PIM_TK4_P'];
    $total_es3l = $total_es3l + $p['PIM_TK3_L'];
    $total_es3p = $total_es3p + $p['PIM_TK3_P'];
    $total_es2l = $total_es2l + $p['PIM_TK2_L'];
    $total_es2p = $total_es2p + $p['PIM_TK2_P'];
    $total_es1l = $total_es1l + $p['PIM_TK1_L'];
    $total_es1p = $total_es1p + $p['PIM_TK1_P'];
    $total_es1_fk_l = $total_es1_fk_l + $p['LEMHANAS_L'];
    $total_es1_fk_p = $total_es1_fk_p + $p['LEMHANAS_P'];

    $pim_tk4_l = $pim_tk4_l + $p['PIM_TK4_L'];
    $pim_tk4_p = $pim_tk4_p + $p['PIM_TK4_P'];
    $pim_tk3_l = $pim_tk3_l + $p['PIM_TK3_L'];
    $pim_tk3_p = $pim_tk3_p + $p['PIM_TK3_P'];
    $pim_tk2_l = $pim_tk2_l + $p['PIM_TK2_L'];
    $pim_tk2_p = $pim_tk2_p + $p['PIM_TK2_P'];
    $pim_tk1_l = $pim_tk1_l + $p['PIM_TK1_L'];
    $pim_tk1_p = $pim_tk1_p + $p['PIM_TK1_P'];
    $lemhanas_l = $lemhanas_l + $p['LEMHANAS_L'];
    $lemhanas_p = $lemhanas_p + $p['LEMHANAS_P'];

    $tot_sum_l = $tot_sum_l + $sum_l;
    $tot_sum_l_all = $tot_sum_l_all + $sum_l_all;
    $tot_sum_p_all = $tot_sum_p_all + $sum_p_all;
    $tot_sum_all = $tot_sum_all + $sum_all;
    $tot_sum_p = $tot_sum_p + $sum_p;
    $tot_sum = $tot_sum + $sum;
    
    $pdf->Row(array($i, $p['LOKASI_UNIT'],
        $p['PIM_TK4_L'],
        $p['PIM_TK4_P'],
        $p['PIM_TK3_L'],
        $p['PIM_TK3_P'],
        $p['PIM_TK2_L'],
        $p['PIM_TK2_P'],
        $p['PIM_TK1_L'],
        $p['PIM_TK1_P'],
        $p['LEMHANAS_L'],
        $p['LEMHANAS_P'],
        $sum_l,
        $sum_p));
    $i++;
}
$pdf->Row(array('a', 'Keseluruhan',
    $total_es4l,
    $total_es4p,
    $total_es3l,
    $total_es3p,
    $total_es2l,
    $total_es2p,
    $total_es1l,
    $total_es1p,
    $total_es1_fk_l,
    $total_es1_fk_p,
    $tot_sum_l_all,
    $tot_sum_p_all));
$pdf->Output();
?>
