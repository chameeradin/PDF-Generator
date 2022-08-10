<?php
class CustomPdfGenerator extends TCPDF 
{
    public function Header() 
    {
        //$image_file = '/web/logo.png';
        //$this->Image($image_file, 10, 3, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 8, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('times', '', 8);
        $this->Cell(0, 10, 'IT Dienstleistungen Götz – Hopfenstr. 38 – 85290 Geisenfeld', 0, false, 'L', 0, '', 0, false, 'M');

    }
 
    public function Footer() 
    {
        $this->SetY(-30);
        $this->SetFont('times', '', 8);
        $this->writeHTML("<hr>");
        $this->Cell(60, 5, "IT Dienstleistungen Götz", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(60, 5, "Bank : 1822direkt", 0, false, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell(60, 5, "Tel. : 08452 73 50 800", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln();
        $this->Cell(60, 5, "Hopfenstr. 38", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(60, 5, "IBAN : DE88 5005 0201 1244 1114 39", 0, false, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell(60, 5, "E-Mail : info@minijob-energiepauschale.de", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln();
        $this->Cell(60, 5, "85290 Geisenfeld", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(60, 5, "BIC : HELADEF1822", 0, false, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell(60, 5, "Website : www.minijob-energiepauschale.de/", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln();
    }
 
    public function printTable($header, $data)
    {
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.7);
        $this->SetFont('times', 'B', 10);
 
        $w = array(7, 100, 15, 15, 20, 20);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
 
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('times', 'B', '10');
 
        // table data
        $fill = 0;
        $total = 0;
 
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill, 0, 1);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;;
        }
 
        $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[4], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->Ln();
 
        $this->Cell(array_sum($w), 0, '', 'T');

    }
}