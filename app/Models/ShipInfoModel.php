<?php
namespace App\Models;
use CodeIgniter\Model;

class ShipInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ShipInfo';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields = ['client_id','name','address','pincode'];

    public function shipList($clientId){
        $builder = $this->builder();
        $builder->select('id,name,address,pincode');
        $builder->where('client_id', $clientId);
        $query = $builder->get();
        return $query->getResult();
    }

    public function shipBasicInfo($clientId){
        $builder = $this->builder();
        $builder->select('id,name');
        $builder->where('client_id', $clientId);
        $query = $builder->get();
        return $query->getResult();
    }
}
?>