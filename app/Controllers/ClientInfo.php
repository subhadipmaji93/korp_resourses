<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use Exception;

class ClientInfo extends BaseController
{
    private $data = [
        'view'=>'Client Info',
        'saveData' => false,
        'active' => 'clientInfo'
    ];

    public function __construct()
    {
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }

    public function index()
    {
        return view('client_info', $this->data);
    }

    public function client()
    {
        if($this->request->isAJAX()){
            $clientInfoModel = model('App\Models\ClientInfoModel');
            $requestType = $this->request->getMethod(true);
            
            switch ($requestType) {
                case 'GET':
                    if($this->request->getVar('id')){
                        $id = $this->request->getVar('id');
                        $result = $clientInfoModel->find($id);
                        return $this->response->setJSON($result);
                    } else {
                        $result = $clientInfoModel->clientList();
                        return $this->response->setJSON($result);
                    }
                    break;

                case 'POST':
                    $clientData = $this->request->getVar();
                    $files = $this->request->getFiles();
                    foreach($files as $key => $val){
                        if($val->isValid() && !$val->hasMoved()){
                            if(($val->getMimeType() !== 'application/pdf') && (explode('/', $val->getMimeType())[0] !== 'image')){
                                continue;
                            }
                            $newName = $clientData['name'] . "_$key." . explode('.',$val->getName())[1];
                            $val->move(WRITEPATH . 'clients', $newName);
                            $clientData[$key]=$newName;
                        }
                    }
                    $clientId =  $clientInfoModel->insert($clientData, false);
                    if($clientId){
                        $result = ['alert'=>'success', 'message'=>['name'=>'Client added succesfully']];
                        return $this->response->setJSON($result);
                    }
                    $result = ['alert'=>'error', 'message'=>['name'=>'Something went wrong']];
                    return $this->response->setJSON($result);
                    break;
                
                case 'PUT':
                    $clientReqData = $this->request->getVar();
                    $clientData = $clientInfoModel->find($clientReqData['id']);
                    unset($clientReqData['_method']);
                    unset($clientReqData['id']);
                    $files = $this->request->getFiles();

                    if(count($files)){
                        $filePath = WRITEPATH . 'clients/';
                        foreach ($files as $key => $val) {
                            if($val->isValid() && !$val->hasMoved()){
                                if(($val->getMimeType() !== 'application/pdf') && (explode('/', $val->getMimeType())[0] !== 'image')){
                                    continue;
                                }
                               try {
                                 unlink($filePath.$clientData[$key]);       // delete previous file
                               } catch (Exception $e) {
                                    //Do Nothing
                               }
                                $newName = $clientData['name'] . "_$key." . explode('.',$val->getName())[1];
                                $val->move(WRITEPATH . 'clients', $newName);
                                $clientReqData[$key]=$newName;
                            }
                        }
                    }
                    $clientInfoModel->update($clientData['id'], $clientReqData);
                    $result = ['alert'=>'success', 'message'=>['name'=>'Client edited succesfully']];
                    return $this->response->setJSON($result);
                    break;

                case 'DELETE':
                    $data = $this->request->getVar();
                    $clientData = $clientInfoModel->find($data->id);
                    
                    // delete files
                    $filePath = WRITEPATH . 'clients/';
                    try {
                        unlink($filePath.$clientData['form_d']);
                        unlink($filePath.$clientData['ibm']);
                        if($clientData['type'] !== "trader"){
                            unlink($filePath.$clientData['pollution']);
                            unlink($filePath.$clientData['address_proof']);
                        }
                    } catch (Exception $e) {
                        // Do Nothing
                    } finally {
                        $clientInfoModel->delete($data->id, true);
                        $result = ['alert'=>'success', 'message'=>['name'=>'Client deleted succesfully']];
                        return $this->response->setJSON($result);
                    }
                    break;
                default:
                    return $this->response->setJSON(['alert'=>'error', 'message'=>['name'=>'Method not allowed!!']]);
                    break;
            }




        } else {return $this->response->redirect("/client-info");}
    }
}
?>