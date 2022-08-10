<?php
require "./vendor/autoload.php";
require "./customPdfGenerator.php";
include_once("connection.php");
session_start();


$db = new dbObj();
$connString =  $db->getConnstring();
$display_heading = array('id'=>'ID', 'employee_name'=> 'Name', 'employee_age'=> 'Age','employee_salary'=> 'Salary',);
 
$result = mysqli_query($connString, "SELECT id, fname, lname, street_name, zip, city, email, phone, country, birthdate, pension_insurance_number, bank_information, referral_code, ipaddress, vers_typ, created FROM formdata") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM formdata");

$connString->close();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]. " - Name: " . $row["employee_name"]." - Age: ". $row["employee_age"]." - Salary: ". $row["employee_salary"]. "<br>";
    
        $pdf = new CustomPdfGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(false);
        $pdf->SetFont('times', 'B', 8, '', false);
        $pdf->Header();
        
        // start a new page
        $pdf->AddPage();

        // address
        $pdf->SetFont('times', 'B', '10');
        $pdf->Write(0, "\n\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->writeHTML($row["fname"]. ", " .$row["lname"]);
        $pdf->writeHTML($row["street_name"]);
        $pdf->writeHTML($row["zip"]. " " .$row["city"]);
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

        // date and invoice no
        $pdf->SetFont('times', 'B', '10');
        $pdf->writeHTML("Rechnungsdatum: ". date("d.m.Y") , true, false, false, false, 'R');
        $pdf->writeHTML("Lieferdatum/Leistungsdatum: " .date('d.m.Y', strtotime($row["created"])), true, false, false, false, 'R');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

        // Topic
        $pdf->SetFont('times', 'B', '15');
        $pdf->writeHTML("<h2 style='border-width: 5px; border-style: solid; background-color: #808080;'>Rechnung</h2>", 1, true, false, true, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Sub Headings
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Rechnungsnummer: 2022-".dechex($row["id"]), 0, 0, false, false, 'L');
        $pdf->writeHTML(" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ", 0, 0, false, false, '');
        $pdf->writeHTML("Kundennummer: ".dechex($row["id"]), 0, 0, false, false, '');
        $pdf->writeHTML("Datum: ". date("d.m.Y"), 0, 0, false, false, 'R');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Topic
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Sehr geehrte(r) Frau/Herr ".$row["lname"]. ",", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // First Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("vielen Dank für Ihr Vertrauen in die IT Dienstleistungen Götz. Hiermit stellen wir Ihnen folgende Leistungen in Rechnung:", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // invoice table starts here
        $header = array('Pos.', 'Bezeichnung', 'Menge', 'Einheit', 'Einzelpreis', 'Gesamtpreis');
        $data = array(
            array('1.','Kursgebühr „Erfolgreiches Empfehlen“ – Fort- und Weiterbildung für digitale Vertriebsmitarbeiter','1','Stück', '69,00 €', '69,00 €'),
        );
        $pdf->printTable($header, $data);
        $pdf->Ln();

        //Table bellow
        $pdf->SetFont('times', 'B', '12');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->writeHTML("<hr>");
        $pdf->writeHTML("Rechnungsbetrag", true, false, false, false, 'R');
        $pdf->writeHTML("69,00 €", true, false, false, false, 'R');
        $pdf->Ln();

        // Second Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Als Kleinunternehmer im Sinne von § 19 Abs. 1 UStG wird keine Umsatzsteuer berechnet.", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Third Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Die Kosten für diese Schulung können Sie entweder als Sonderausgaben, Werbungskosten oder Betriebsausgaben in Ihrer Einkommensteuererklärung absetzen.", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Fourth Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Der Rechnungsbetrag ist bis zum <b>31.12.2022</b> mit dem Verwendungszweck „2022-".dechex($row["id"])."“ auf folgendes Konto zu zahlen: Bank: 1822direkt - IBAN: DE88 5005 0201 1244 1114 39.", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Fifth Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->writeHTML("Mit freundlichen Grüßen", 0, 0, false, false, 'L');
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // Sixth Paragraph
        $pdf->SetFont('times', '', '12');
        $pdf->Write(0, "\n\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->writeHTML("Martin Götz");
        $pdf->writeHTML("IT Dienstleistungen Götz");
        $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
        $pdf->Ln();

        // save pdf file
        $pdf->Output(__DIR__ . '/invoice#'.$row["id"].'.pdf', 'F');
        // Redirect Back


        $_SESSION['success'] = "<div class='success' style='background-color: lightgreen; padding: 5px;'>PDFs Generated Successfully</div>";
        header("Location: index.php");

}
} else {
  echo "0 results";
}