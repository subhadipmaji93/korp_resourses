<?php
    namespace App\Controllers\Dispatch;
    use App\Controllers\BaseController;

    class ShipInfo extends BaseController
    {
        private $data = [
            'view'=>'Ship Info',
            'saveData'=>false,
            'active'=>'shipInfo'
        ];

        public function __construct()
        {
            $session = session();
            $this->data['role'] = $session->role;
            $this->data['username'] = $session->username;
        }

        public function index()
        {
            return view('dispatch/ship_info', $this->data);
        }

        public function ship()
        {
            if($this->request->isAJAX()){
                $shipInfoModel = model("App\Models\ShipInfoModel");
                $requestType = $this->request->getMethod(true);

                switch ($requestType) {
                    case 'GET':
                        if($this->request->getVar('client_id')){
                            $clientId = $this->request->getVar('client_id');
                            $result = $shipInfoModel->shipList($clientId);
                            return $this->response->setJSON($result);
                        } else if($this->request->getVar('id')){
                            $shipId = $this->request->getVar('id');
                            $result = $shipInfoModel->find($shipId);
                            return $this->response->setJSON($result);
                        }
                        break;
                    case 'POST':
                        $shipData = $this->request->getJSON();
                        $shipId = $shipInfoModel->insert($shipData, false);
                        if($shipId){
                            $result = ['alert'=>'success', 'message'=>['name'=>'Ship Info added succesfully']];
                            return $this->response->setJSON($result);
                        }
                        $result = ['alert'=>'error', 'message'=>['name'=>'Something went wrong']];
                        return $this->response->setJSON($result);
                        break;
                    
                    case 'PUT':
                        $shipData = $this->request->getJSON();
                        $shipInfoModel->update($shipData->id, $shipData);
                        $result = ['alert'=>'success', 'message'=>['name'=>'Ship Info edited succesfully']];
                        return $this->response->setJSON($result);
                        break;

                    case 'DELETE':
                        $shipId = $this->request->getJsonVar('id');
                        $shipInfoModel->delete($shipId, true);
                        $result = ['alert'=>'success', 'message'=>['name'=>'Client deleted succesfully']];
                        return $this->response->setJSON($result);
                        break;
                    default:
                        return $this->response->setJSON(['alert'=>'error', 'message'=>['name'=>'Method not allowed!!']]);
                        break;
                }
            } else {return $this->response->redirect("/ship-info");}
        }

        public function shipNameList()
        {
            if($this->request->isAJAX() && $this->request->getMethod(true) === 'GET'){
                if($this->request->getVar('client_id')){
                    $shipInfoModel = model("App\Models\ShipInfoModel");
                    $clientId = $this->request->getVar('client_id');
                    $result = $shipInfoModel->shipBasicInfo($clientId);
                    return $this->response->setJSON($result);
                } else {
                    return $this->response->setJSON(["message"=>"Missing Client Id"]);
                }
            }
        }
    }
?>