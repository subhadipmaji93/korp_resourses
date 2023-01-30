<?php

namespace App\Controllers\Production;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\I18n\Time;
use App\Libraries\GenerateIdFromDateTime;
use App\Libraries\DataTablePdf;

class Tantra extends BaseController
{
    private $data = [
        "saveData" => false,
        'view' => 'Tantra',
        'active' => 'production'
    ];

    public function __construct()
    {
        helper('form');
        $this->dataModel = model('App\Models\ProductionDataModel');
        $this->dataModel->access_table($this->data['view']);
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }

    public function index(){
        $selectDate = $this->request->getVar('date');
        $selectType = $this->request->getVar('type');
        $action = $this->request->getVar('action');
        if(!$selectDate) return view('production/tantra', $this->data);

        $nextDate = Time::parse($selectDate)->addDays(1)->toDateString();
        $result = $this->dataModel->fetch($selectDate, $nextDate, $selectType);
        $this->data['tableData'] = $result;
        $this->data['date'] = $selectDate;
        $this->data['type'] = $selectType;
        
        if($action == 'Export') {
            $name = "{$this->data['date']}-{$this->data['view']}-{$this->data['type']}.pdf";
            $pdf = new DataTablePdf(['view'=>$this->data['view'], 'date'=>$this->data['date'], 'type'=>$this->data['type']]);
            $pdf->AddPage();
            $pdf->LoadTable($this->data['tableData']);
            $pdf->Output('D', $name);
        } else {
            return view('production/tantra', $this->data);
        }
    }

    public function save(){
        $this->validation = Services::validation();
        if(! $this->validate($this->validation->getRuleGroup('AddProductionDataRule'))){
            $this->data['validation'] = $this->validator;
            return view('production/tantra', $this->data);
        } else {
            $fieldData = $this->request->getPost();
            $this->time = Time::now();
            $fieldData['date'] = $this->time->toDateString();
            $fieldData['time'] = $this->time->toTimeString();
            $fieldData['time'] = $this->time->toTimeString();
            $fieldData['id'] = GenerateIdFromDateTime::generate($fieldData['date'], $fieldData['time']);
            $fieldData['mineral_weight'] = floatval($fieldData['gross_weight']) - floatval($fieldData['tare_weight']);


            $result = $this->dataModel->insert($fieldData, false);
            if($result) $this->data['success'] = true;
            else $this->data['success'] = false;
            
            return view('production/tantra', $this->data);
        }
    }
}