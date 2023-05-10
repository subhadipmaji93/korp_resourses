<?php
namespace App\Models;
use CodeIgniter\Model;

class StackInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'StackInfo';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['name','size', 'grade', 'capacity', 'current','form_k_doc','form_k_grade','applied_for'];

    public function stackList(){
        $builder = $this->builder();
        $builder->select('id, name, size, grade, capacity, current');
        $query = $builder->get();
        return $query->getResult();
    }
}

?>