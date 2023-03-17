<?php
namespace App\Libraries;
include APPPATH . 'ThirdParty/FPDF/fpdf.php';
use \FPDF;

class ChallanPdf extends FPDF
{
    public function __construct()
    {
        parent::__construct('P', 'mm', 'A4');
            $this->SetMargins(8,8,8);
    }

    public function header(){
        $this->SetFont('Arial','B', 20);
        $this->SetTextColor(128, 126, 126);
        $this->Cell(120,10,'KORP RESOURCES PVT. LTD.',0,1);
        $this->SetFontSize(15);
        $this->SetTextColor(5,5,5);
        $this->Cell(70,8,'TANTRA IRON ORE MINES',0,1);
        $this->SetFontSize(10);
        $this->Cell(60,5,'CIN: U515DDWB1994PTCD63926',0,1);
        $this->Cell(60,5,'GSTIN: 21AABCK3204C12J',0,1);
        $this->Line(8,38,200,38);
        $this->SetY(40);
        $this->SetTextColor(128, 126, 126);
        $this->Cell(75,5,'161, Rabindra Sarani KOLKATA - 700007',0,1);
        $this->Cell(75,5,'H.O. : 033-2269-0895 / 9196',0,1);
        $this->Cell(75,5,'Phone: 033-26582376 / 22683832',0,1);
        $this->Cell(75,5,'e-mail: onkargroup@hotmail.com',0,1);
        $this->Cell(75,5,'e-mail: korpresources@gmail.com',0,1);
        $this->SetXY(140,40);
        $this->Cell(20,5,'Mines',0,1);
        $this->SetX(140);
        $this->Cell(22,5,'Post: Tensa',0,1);
        $this->SetX(140);
        $this->Cell(45,5,'Dist: Sundergarh (Odisha)',0,1);
        $this->SetX(140);
        $this->Cell(50,5,'Phone: 066-25236305',0,1);
        $this->SetX(140);
        $this->Cell(65,5,'e-mail: korptantramines@gmail.com',0,1);
    }

    public function body($challanData){
        $this->SetY(70);
        $this->SetTextColor(5,5,5);
        $this->SetFont('Arial','',15);
        $this->SetX(85);
        $this->Cell(40,5,'TAX CHALLAN',0,1);
        $this->Rect(10,76,190,189,'D');
        $this->buyerDetails($challanData["buyerInfo"]);
        $this->challanInfo($challanData["challanInfo"]);
        $this->challanBody($challanData["challanBody"]);
        $this->footerInfo();
    }

    private function buyerDetails($buyerInfo){
        $this->Rect(10,76,100,60);
        $this->SetFontSize(12);
        $this->SetXY(12,78);
        $this->Cell(10,5,'Buyer',0,1);
        $this->SetFontSize(10);
        $this->SetX(12);
        $this->MultiCell(95,5,'M/s, ' . $buyerInfo["name"] ,0,'L');
        $this->Ln();
        $this->SetX(12);
        $this->MultiCell(95,5, $buyerInfo["address"], 0,'L');
        $this->Ln();
        $this->SetX(12);
        $this->Cell(95,5,'GSTIN: '. $buyerInfo["gst"],0,1);
        $this->SetX(12);
        $this->Cell(95,5,'STATE CODE: ' . $buyerInfo["state"], 0,1);
        $this->SetX(12);
        $this->Cell(95,5,'CIN: ' . $buyerInfo["cin"], 0,1);
    }

    private function challanInfo($challanInfo){
        $this->Rect(110,76,90,60);
        $this->SetXY(110,76);
        $this->Cell(45,5,'Challan No',1,0,'C');
        $this->SetX(155);
        $this->Cell(45,5,'Dated',1,0,'C');
        $this->Ln();
        $this->SetX(110);
        $this->Cell(45,5, $challanInfo["no"] ,1,0,'C');
        $this->SetX(155);
        $this->Cell(45,5, \date('d/m/Y', strtotime($challanInfo["date"])) ,1,1,'C');
        $this->Ln();
        $this->SetX(110);
        $this->MultiCell(90,5, $challanInfo["sname"],0,1);
        $this->Ln();
        $this->SetX(110);
        $this->MultiCell(90,5, $challanInfo["sadd"], 0,'L');
        $this->SetX(110);
        $this->Cell(90,5,'PINCODE: ' . $challanInfo["spincode"] ,0,1);
        $this->Ln();
        $this->SetX(110);
        $this->Cell(90,5,'TRUCK NO:   ' . $challanInfo["truck"] ,0,1);
        $this->SetX(110);
        $this->Cell(90,5,'T.P. NO:    ' . $challanInfo["tp"], 0,1);
    }

    private function challanBody($body){
        $materialInfo = $body["materialInfo"];
        $amountInfo = $body["amountInfo"];
        $fmt = new \NumberFormatter('en_IN', \NumberFormatter::CURRENCY);
        $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL,'');

        $this->SetFont('Arial','B', 12);
        $this->SetXY(10,136);
        $this->Cell(50,8,'Description (Goods)',1,0,'C');
        $this->Cell(20,8,'GRADE',1,0,'C');
        $this->Cell(25,8,'SIZE (MM)',1,0,'C');
        $this->Cell(15,8,'HSN',1,0,'C');
        $this->Cell(25,8,'QTY (MT)',1,0,'C');
        $this->Cell(25,8,'RATE',1,0,'C');
        $this->Cell(30,8,'AMOUNT',1,0,'C');
        $this->SetFont('Arial','','10');
        $this->SetXY(12,145);
        $this->MultiCell(45,5, $materialInfo["name"],0,'L');
        $this->Line(60,140,60,180);
        $this->SetXY(62,145);
        $this->MultiCell(16,5,$materialInfo["grade"],0,'L');
        $this->Line(80,140,80,180);
        $this->SetXY(84,145);
        $this->Cell(15,5,$materialInfo["size"],0);
        $this->Line(105,140,105,180);
        $this->SetXY(106,145);
        $this->Cell(10,5,$materialInfo["hsn"],0,0,'C');
        $this->Line(120,140,120,180);
        $this->SetXY(121,145);
        $this->Cell(20,5,$materialInfo["qnty"],0,0,'C');
        $this->Line(145,140,145,180);
        $this->SetXY(146,145);
        $this->Cell(20,5,$materialInfo["rate"],0,0,'C');
        $this->Line(170,140,170,180);
        $this->SetXY(171,145);
        $this->Cell(28,5,\substr($fmt->formatCurrency($amountInfo["amount"],'INR'),1),0,0,'C');
        $this->SetXY(10,180);
        $this->SetFontSize(8);
        if($amountInfo["gstType"] === "c-s"){
            $this->Cell(110,10,'Intregrated Tax',1,0,'R');
            $this->Cell(25,5,'(CGST)',1,0,'C');
            $this->Cell(25,5, $amountInfo["cgstp"].' %' ,1,0,'L');
            $this->Cell(30,5, $amountInfo["cgstv"] ,1,0,'R');
            $this->Ln();
            $this->SetX(120);
            $this->Cell(25,5,'(SGST)',1,0,'C');
            $this->Cell(25,5, $amountInfo["sgstp"].' %' ,1,0,'L');
            $this->Cell(30,5, $amountInfo["sgstv"] ,1,0,'R');
        } elseif($amountInfo["gstType"] === "i"){
            $this->Cell(110,5,'Intregrated Tax',1,0,'R');
            $this->Cell(25,5,'(IGST)',1,0,'C');
            $this->Cell(25,5, $amountInfo["igstp"].' %' ,1,0,'L');
            $this->Cell(30,5, $amountInfo["igstv"] ,1,0,'R');
        }
        $this->Ln();
        $this->SetX(10);
        $this->Cell(135,5,'Round Off',1,0,'R');
        $this->Cell(25,5,'',1);
        $this->Cell(30,5, $amountInfo["round"] ,1,0,'R');
        $this->Ln();
        $this->SetX(10);
        $this->Cell(135,10,'',1);
        $this->Cell(25,10,'TOTAL',1,0,'C');
        $this->Cell(30,10, \substr($fmt->formatCurrency($amountInfo["tamount"],'INR'),1) ,1,0,'R');
        $this->Ln();
        if(isset($amountInfo["tcsVal"])){
            $this->SetX(10);
            $this->Cell(135,5,'TCS',1,0,'R');
            $this->Cell(25,5,'1 %',1);
            $this->Cell(30,5, $amountInfo["tcsVal"] ,1,0,'R');
            $this->Ln();
            $this->SetX(10);
            $this->Cell(135,10,'',1);
            $this->Cell(25,10,'GRAND TOTAL',1,0,'C');
            $this->Cell(30,10, \substr($fmt->formatCurrency($amountInfo["gamount"],'INR'),1) ,1,0,'R');
            $this->Ln();
        }
        $this->SetX(10);
        $this->SetFontSize(9);
        $this->Cell(190,10,'Amount Chargeable (In Words): '.'('.$amountInfo["words"].')',1,0);
    }

    private function footerInfo(){
        $this->Rect(10,232,110,33);
        $this->SetXY(15,240);
        $this->SetFont('Arial','',10);
        $this->MultiCell(85,5,"Declaration: We declare that invoice shows the actual price of the goods described and all particulars are true and correct.",0,'L');
        $this->Rect(120,232,80,33);
        $this->SetXY(130,234);
        $this->Cell(5,5,'For: ');
        $this->SetFont('Arial','B',10);
        $this->SetX(138);
        $this->Cell(55,5,'KORP RESOURCES PVT LTD');
        $this->SetXY(140,260);
        $this->Cell(25,5,'Authorized Signatory');
        $this->SetXY(80,271);
        $this->SetFont('Arial','',8);
        $this->Cell(52,5,"* This is a Computer Generated Challan");
    }
}
?>