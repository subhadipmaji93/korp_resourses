<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\GenerateIdFromDateTime;
use App\Libraries\CheckDateBefore;

class Returns extends BaseController
{
    private $data = [
        'view'=>'Return',
        'saveData' => false,
        'active' => 'return'
    ];

    public function __construct()
    {
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }
    public function index()
    {
        return view('return', $this->data);
    }

    public function returnList(){
        if($this->request->isAJAX()){
            $returnListModel = model('App\Models\ReturnListModel');
            $requestType = $this->request->getMethod(true);
            $requestData = $this->request->getJSON();

            switch($requestType){
                case 'GET':
                    $result = $returnListModel->findAll();
                    return $this->response->setJSON($result);
                    break;

                case 'POST':
                    $returnId = $returnListModel->insert($requestData);
                    if($returnId) {
                        $this->generateReturnData($returnId, $requestData->submit_date);
                        $result = ['alert'=>'success', 'message'=>['name'=>'Return added succesfully']];
                        return $this->response->setJSON($result);
                    }
                   break;

                case 'PUT':
                    $data = ['name'=>$requestData->name, 'type'=>$requestData->type,
                    'alert_day'=>$requestData->alert_day, 'submit_day'=>$requestData->submit_day];
                    if(isset($requestData->submit_month)){
                        $data['submit_month'] = $requestData->submit_month;
                    } else {
                        $data['submit_month'] = null;
                    }
                    $status =  $returnListModel->update($requestData->id, $data);
                    if($status == true) {
                        $result = ['alert'=>'success', 'message'=>['name'=>'Return Edited succesfully']];
                        return $this->response->setJSON($result);
                    }
                    break;
            }
        }  else {return $this->response->redirect("/return");}
    }


    private function generateReturnData($returnId, $initial_date=false){
        $returnListModel = model('App\Models\ReturnListModel');
        $returnDataModel = model('App\Models\ReturnDataModel');

        $returnListData = $returnListModel->find($returnId);
        $time = Time::now();

        // Intiliaze Return Data
        $setReturnData = array();
        $setReturnData['id'] = GenerateIdFromDateTime::generate($time->toDateString(), $time->toTimeString());
        $setReturnData['return_id'] = $returnId;
        $setReturnData['name'] = $returnListData['name'];

        if($initial_date != false){
            $time = Time::parse($initial_date);
            $setDate = $time->day - 5;
            $setReturnData['alert_date'] = Time::createFromDate($time->year, $time->month, $setDate<=0? 1:$setDate);
            $setReturnData['submit_date'] = $initial_date;
            $returnDataModel->insert($setReturnData);
            return;
        }

        switch ($returnListData['type']) {
            case 'Month':
                $setMonth = $time->month == 12 ? 1:$time->month + 1;
                $setReturnData['alert_date'] = Time::createFromDate($time->year, $setMonth, $returnListData["alert_day"]);
                $setReturnData['submit_date'] = Time::createFromDate($time->year, $setMonth, $returnListData["submit_day"]);
                break;

            case "Quater":
                $setMonth = $time->month == 12 ? 3:$time->month + 3;
                $setReturnData['alert_date'] = Time::createFromDate($time->year, $setMonth, $returnListData["alert_day"]);
                $setReturnData['submit_date'] = Time::createFromDate($time->year, $setMonth, $returnListData["submit_day"]);
                break;
                
            case 'Year':
                $setYear = $time->year + 1;
                $setReturnData['alert_date'] = Time::createFromDate($setYear, $returnListData['submit_month'], $returnListData["alert_day"]);
                $setReturnData['submit_date'] = Time::createFromDate($setYear, $returnListData['submit_month'], $returnListData["submit_day"]);
                break;

            case 'FiveYear':
                $setYear = $time->year + 5;
                $setReturnData['alert_date'] = Time::createFromDate($setYear, $returnListData['submit_month'], $returnListData["alert_day"]);
                $setReturnData['submit_date'] = Time::createFromDate($setYear, $returnListData['submit_month'], $returnListData["submit_day"]);
                break;

            default:
                break;
        }
        $returnDataModel->insert($setReturnData);
    }

    public function getAlertData(){
        if($this->request->isAJAX() && ($this->request->getMethod(true) == 'GET')){
            $time = Time::now();
            $returnDataModel = model('App\Models\ReturnDataModel');
            $result = $returnDataModel->fetchAlert($time->toDateString());
            return $this->response->setJSON($result);
        } else {
            return $this->response->redirect("/return");
        }
    }

    public function getReturnData(){
        if($this->request->isAJAX() && ($this->request->getMethod(true) == 'GET')){
            $date = $this->request->getVar('date');
            $returnDataModel = model('App\Models\ReturnDataModel');
            $result = $returnDataModel->fetchReturn($date);
            return $this->response->setJSON($result);
        }
    }

    public function uploadData(){
        if($this->request->isAJAX() && ($this->request->getMethod(true) == 'POST')){
            $currentDate = Time::now()->toDateString();
            $returnDataId = $this->request->getVar('id');
            $returnDataModel = model('App\Models\ReturnDataModel');
            $returnData = $returnDataModel->find($returnDataId);
            $files = $this->request->getFileMultiple('files');
            $filesName = array();
            foreach($files as $file){
                if($file->isValid() && !$file->hasMoved()){
                    if($file->getMimeType() !== 'application/pdf'){
                        continue;
                    }
                    $newName = $currentDate.'-'.$returnData['name'].'-'.$file->getName();
                    $file->move(WRITEPATH . 'uploads', $newName);
                    $filesName[] = $newName;
                }
            }

            switch ($this->request->getVar('type')) {
                case 'alert':
                    $status = $returnDataModel->update($returnDataId,['file_list'=>json_encode($filesName), 'is_active'=>0]);
                    if($status == true){
                        $this->generateReturnData($returnData['return_id']);
                    }
                    break;
                
                case 'view':
                    $newFiles = null;
                    if(is_null($returnData['file_list'])){
                        $newFiles = $filesName;
                    } else {
                        $previousFiles = json_decode($returnData['file_list']);
                        $newFiles = array_merge($previousFiles, $filesName);
                    }
                    $status = $returnDataModel->update($returnDataId,['file_list'=>json_encode($newFiles)]);
                    break;
            }

            
            if($status == true){
                $result = ['alert'=>'success', 'message'=>['name'=>"Data uploaded succesfully"]];
                return $this->response->setJSON($result);
            }
            
        }else {
            return $this->response->redirect("/return");
        }
    }

}
?>