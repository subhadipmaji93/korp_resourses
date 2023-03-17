<?php
    namespace App\Controllers\Dispatch;
    use App\Controllers\BaseController;
    use App\Libraries\ChallanPdf;

    class Challan extends BaseController
    {
        private $data = [
            'view'=>'Challan',
            'saveData'=>false,
            'active'=>'challan'
        ];

        public function __construct()
        {
            $session = session();
            $this->data['role'] = $session->role;
            $this->data['username'] = $session->username;
        }

        public function index(){
            return view('dispatch/challan', $this->data);
        }

        public function generate(){
            $requestData = $this->request->getVar();

            $buyerInfo = ["name"=>$requestData['buyerName'], "address"=>$requestData["buyerAddress"],
                        "gst"=>$requestData["buyerGST"], "state"=>$requestData["buyerState"],
                        "cin"=>$requestData["buyerCIN"]];

            $challanInfo = ["no"=>$requestData["challanNo"], "date"=>$requestData["challanDate"],
                            "sname"=>$requestData["shipName"], "sadd"=>$requestData["shipAddress"],
                            "truck"=>$requestData["shipTruckNo"], "spincode"=>$requestData["shipPincode"],
                            "tp"=>$requestData["tpNo"]];
            
            $materialInfo = ["name"=>$requestData["materialName"], "grade"=>$requestData["materialGrade"],
                            "size"=>$requestData["materialSize"], "qnty"=>$requestData["materialQnty"],
                            "rate"=>$requestData["materialRate"], "hsn"=>$requestData["hsnCode"]];

            $amountInfo = ["amount"=>$requestData["amount"], "tamount"=>$requestData["totalAmount"], "words"=>$requestData["amountWord"],
                        "round"=>$requestData["roundOff"], "gstType"=>$requestData["selectGST"]];

            switch ($requestData["selectGST"]) {
                case 'c-s':
                    $amountInfo["cgstp"]=$requestData["cgstPrcnt"]; $amountInfo["cgstv"]=$requestData["cgstVal"];
                    $amountInfo["sgstp"]=$requestData["sgstPrcnt"]; $amountInfo["sgstv"]=$requestData["sgstVal"];
                    break;
                
                case 'i':
                    $amountInfo["igstp"]=$requestData["igstPrcnt"]; $amountInfo["igstv"]=$requestData["igstVal"];
                    break;
            }
                        
            if(isset($requestData["tcsVal"])){
                $amountInfo["gamount"] = $requestData["grandAmount"]; $amountInfo["tcsVal"] = $requestData["tcsVal"];
            } 

            $challanData = ["buyerInfo"=>$buyerInfo, "challanInfo"=>$challanInfo,
                            "challanBody"=>["materialInfo"=>$materialInfo, "amountInfo"=>$amountInfo]];
            

            // $this->response->setHeader("Content-Type", "application/pdf");
            $pdf = new ChallanPdf();
            $pdf->AddPage();
            $pdf->body($challanData);
            $pdf->Output('D', $requestData["challanNo"].'.pdf');
        }
    }
?>