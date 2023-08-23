<?php

namespace App\Controllers\Inwards;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\I18n\Time;
use App\Libraries\GenerateIdFromDateTime;
use App\Libraries\DataTablePdf;

class Rom extends BaseController
{   
    private $data = [
        "saveData" => false,
        'view' => 'Rom',
        'active' => 'inwards'
    ];
    private $dataModel;
    public function __construct()
    {
        helper('form');
        $this->dataModel = model('App\Models\InwardDataModel');
        $this->dataModel->access_table($this->data['view']);
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }

    public function index()
    {
        $selectDate = $this->request->getVar('date');
        $action = $this->request->getVar('action');
        if(!$selectDate) return view('inwards/rom', $this->data);

        $nextDate = Time::parse($selectDate)->addDays(1)->toDateString();
        $result = $this->dataModel->fetch($selectDate, $nextDate);
        $this->data['tableData'] = $result;
        $this->data['date'] = $selectDate;
        if($action == 'Export') {
            $name = "{$this->data['date']}-{$this->data['view']}.pdf";
            $pdf = new DataTablePdf(['view'=>$this->data['view'], 'date'=>$this->data['date']]);
            $pdf->AddPage();
            $pdf->LoadTable($this->data['tableData']);
            $pdf->Output('D', $name);
        } else {
            return view('inwards/rom', $this->data);
        }
    }

    public function save()
    {
        $validation = Services::validation();
        if(! $this->validate($validation->getRuleGroup('AddInwardDataRule'))){
            $this->data['validation'] = $this->validator;
            return view('inwards/rom', $this->data);
        } else {
            $fieldData = $this->request->getPost();
            $time = Time::now();
            $fieldData['date'] = $time->toDateString();
            $fieldData['time'] = $time->toTimeString();
            $fieldData['time'] = $time->toTimeString();
            $fieldData['id'] = GenerateIdFromDateTime::generate($fieldData['date'], $fieldData['time']);
            $fieldData['mineral_weight'] = floatval($fieldData['gross_weight']) - floatval($fieldData['tare_weight']);


            $result = $this->dataModel->insert($fieldData, false);
            if($result) $this->data['success'] = true;
            else $this->data['success'] = false;
            
            return view('inwards/rom', $this->data);
        }
       
    }

    public function currentMWeight(){
        if($this->request->isAJAX() && ($this->request->getMethod(true) == 'GET')){
            $currentDate = null;
            $nextDate = null;
            if($this->request->getVar('date')){
                $currentDate = $this->request->getVar('date');
                $nextDate = Time::parse($currentDate)->addDays(1)->toDateString();
            } else{
                $currentDate = Time::today()->toDateString();
                $nextDate = Time::tomorrow()->toDateString();
            }
            $mWeightList = $this->dataModel->currentMWeight($currentDate, $nextDate);
            $total = 0.000;
            foreach ($mWeightList as $data) {
                $total += $data->mineral_weight;
            }
            return $this->response->setJSON(["total"=>$total]);
        } else {
            return $this->response->redirect("/inwards/rom");
        }
    }
}
