<?php
namespace App\Models;
use CodeIgniter\Model;

class ClientInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ClientInfo';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['full_name','name','address', 'type', 'gst', 'pan', 'cin','form_d','ibm','pollution','address_proof'];

    // Dates
    protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    public function clientList(){
        $builder = $this->builder();
        $builder->select('id, name, address');
        $query = $builder->get();
        return $query->getResult();
    }
}
?>