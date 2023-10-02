<?php
namespace App\Libraries;
include APPPATH . 'ThirdParty/FPDF/fpdf.php';
use \FPDF;

class DataTablePdf extends FPDF
{
    public $header;
    public function __construct($header)
    {
        parent::__construct('P', 'mm', 'A4');
        $this->SetMargins(5,5,5);
        $this->header = $header;
    }

    function Header(){
        $this->Rect(5, 5, 200, 287, 'D');
        $this->SetFont('Arial','B', 16);
        $this->SetX(70);
        $this->Cell(60,10,'ONKAR MINES',0,0,'C');
        $this->Ln();
        $this->SetX(70);
        $this->SetFont('Arial','', 14);
        $this->Cell(60, 10, 'Type: '.$this->header['view'],0,0,'C');
        $this->SetX(145);
        $this->Cell(60, 10, 'Date: '.$this->header['date'],0,0,'C');
        $this->Ln();
        $this->SetX(70);
        $this->Cell(60, 10, $this->header['cname'],0,0,'C');
        if(isset($this->header['type'])){
            $this->Ln();
            $this->SetFont('Arial','', 12);
            $this->SetX(70);
            $this->Cell(60, 10, 'Size: '.$this->header['type'],0,0,'C');
        }
        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(204,235,255);
        isset($this->header['type'])?$this->SetX(25):$this->SetX(15);
        $this->Cell(15,10,'Time',1,0,'C',true);
        isset($this->header['type'])?'':$this->Cell(22,10,'From',1,0,'C',true);
        $this->Cell(22,10,'To',1,0,'C',true);
        $this->Cell(20,10,'Vehicle No',1,0,'C',true);
        $this->Cell(20,10,'Gross w/t',1,0,'C',true);
        $this->Cell(20,10,'Tare w/t',1,0,'C',true);
        $this->Cell(20,10,'Mineral w/t',1,0,'C',true);
        $this->Cell(30,10,'Purpose',1,0,'C',true);
        $this->Ln();
    }

    function LoadTable($tableData){
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(255);

        $total = 0.000;
        $trip = 0;
        foreach($tableData as $data){
            $trip += 1;
            isset($this->header['type'])?$this->SetX(25):$this->SetX(15);
            $sw = ceil($this->GetStringWidth($data->purpose));
            $h = ceil($sw / 30);
            if($sw>30){
                $h = $h + 1;
            }
            $total = $total + $data->mineral_weight;
            $this->Cell(15,10*$h,$data->time,1,0,'C',true);
            isset($this->header['type'])?'':$this->Cell(22,10*$h,$data->from,1,0,'C',true);
            $this->Cell(22,10*$h,$data->to,1,0,'C',true);
            $this->Cell(20,10*$h,$data->vehicle,1,0,'C',true);
            $this->Cell(20,10*$h,$data->gross_weight,1,0,'C',true);
            $this->Cell(20,10*$h,$data->tare_weight,1,0,'C',true);
            $this->Cell(20,10*$h,$data->mineral_weight,1,0,'C',true);
            $this->MultiCell(30,10,$data->purpose,1);
        }
        $this->SetFillColor(204,235,255);
        if(isset($this->header['type'])){
            $this->SetX(25);
            $mnrl_width = 60;
        } else {
            $this->SetX(15);
            $mnrl_width = 82;
        }
        $this->Cell(37,10,'Trip: '.$trip,1,0,'C',true);
        $this->Cell($mnrl_width,10,'Total Mineral Weight:',1,0,'C',true);
        $this->Cell(50,10,number_format($total,3).' TON',1,0,'C',true);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I', 8);
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
}
?>