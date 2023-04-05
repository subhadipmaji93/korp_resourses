<?php

namespace App\Models;

use CodeIgniter\Model;

class InwardDataModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = '';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'date', 'time', 'vehicle', 'gross_weight', 'tare_weight', 'mineral_weight', 'from', 'to', 'purpose'];
    
    public function access_table($tableName){
        $this->table = $tableName;
    }

    public function fetch($date, $nxtDate){
        $builder = $this->builder();
        $builder->select('time, vehicle, gross_weight, tare_weight, mineral_weight, from, to, purpose');
        $builder->where('date', $date)->where('date <', $nxtDate);
        $query = $builder->get();
        return $query->getResult();
    }

    public function currentMWeight($date, $nxtDate){
        $builder = $this->builder();
        $builder->select('mineral_weight');
        $builder->where('date', $date)->where('date <', $nxtDate);
        $query = $builder->get();
        return $query->getResult();
    }
}
