<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use Exception;

class StackInfo extends BaseController
{
    private $data = [
        'view'=>'Stack Info',
        'saveData'=>false,
        'active'=>'stackInfo'
    ];

    public function __construct()
    {
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }

    public function index()
    {
        return view('stack_info', $this->data);
    }

    public function stack(){
        if($this->request->isAJAX()){
            $stackInfoModel = model('App\Models\StackInfoModel');
            $requestType = $this->request->getMethod(true);

            switch($requestType){
                case 'GET':
                    if($this->request->getVar('id')){
                        $id = $this->request->getVar('id');
                        $result = $stackInfoModel->find($id);
                        return $this->response->setJSON($result);
                    } else {
                        $result = $stackInfoModel->stackList();
                        return $this->response->setJSON($result);
                    }
                    break;
                    
                case 'POST':
                    $stackData = $this->request->getVar();
                    $stackFormKDoc = $this->request->getFile('form_k_doc');
                    if(isset($stackFormKDoc)){
                        if($stackFormKDoc->isValid() && !$stackFormKDoc->hasMoved()){
                            if(($stackFormKDoc->getMimeType() === 'application/pdf') || (explode('/', $stackFormKDoc->getMimeType())[0] === 'image')){
                                $newName = $stackData['name'].'_form_k.' . explode('.',$stackFormKDoc->getName())[1];
                                $stackFormKDoc->move(WRITEPATH . 'uploads', $newName);
                                $stackData['form_k_doc'] = $newName;
                            }
                        }
                    }
                    $stackId = $stackInfoModel->insert($stackData, false);
                    if($stackId){
                        $result = ['alert'=>'success', 'message'=>['name'=>'Stack added succesfully']];
                        return $this->response->setJSON($result);
                    }
                    $result = ['alert'=>'error', 'message'=>['name'=>'Something went wrong']];
                    return $this->response->setJSON($result);
                    break;

                case 'PUT':
                    $stackReqData = $this->request->getVar();
                    $stackData = $stackInfoModel->find($stackReqData['id']);
                    unset($stackReqData['_method']);
                    unset($stackReqData['id']);
                    $stackFormKDoc = $this->request->getFile('form_k_doc');
                    if(isset($stackFormKDoc)){
                        if($stackFormKDoc->isValid() && !$stackFormKDoc->hasMoved()){
                            if(($stackFormKDoc->getMimeType() === 'application/pdf') || (explode('/', $stackFormKDoc->getMimeType())[0] === 'image')){
                                $newName = $stackData['name'].'_form_k.' . explode('.',$stackFormKDoc->getName())[1];
                                $stackFormKDoc->move(WRITEPATH . 'uploads', $newName);
                                $stackReqData['form_k_doc'] = $newName;
                            }
                        }
                        if(isset($stackData['form_k_doc'])){
                            $basePath = WRITEPATH . 'uploads/';
                            try{
                                unlink($basePath.$stackData['form_k_doc']);
                            } catch (Exception $e){
                                // Do Nothing
                            }
                        }
                    }
                    $status = $stackInfoModel->update($stackData['id'], $stackReqData);
                    if($status){
                        $result = ['alert'=>'success', 'message'=>['name'=>'Stack edited succesfully']];
                        return $this->response->setJSON($result);
                    }
                    $result = ['alert'=>'error', 'message'=>['name'=>'Something went wrong']];
                    return $this->response->setJSON($result);
                    break;
                
                case 'DELETE':
                    $id = $this->request->getVar('id');
                    $stackData = $stackInfoModel->find($id);

                    $basePath = WRITEPATH . 'uploads/';
                    try{
                        unlink($basePath.$stackData['form_k_doc']);
                    } catch (Exception $e){
                        // Do Nothing
                    } finally {
                        $stackInfoModel->delete($id, true);
                        $result = ['alert'=>'success', 'message'=>['name'=>'Stack deleted succesfully']];
                        return $this->response->setJSON($result);
                    }
                    break;
                
                default:
                    return $this->response->setJSON(['alert'=>'error', 'message'=>['name'=>'Method not allowed!!']]);
                    break;
            }
        } else {return $this->response->redirect("/stack-info");}
    }
}
?>