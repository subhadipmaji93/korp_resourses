<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = '';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'date', 'time','contractor', 'vehicle', 'gross_weight', 'tare_weight', 'mineral_weight', 'type', 'to','purpose'];
    
    public function access_table($tableName){
        $this->table = $tableName;
    }

    public function fetch($date, $nxtDate, $type, $cname){
        $builder = $this->builder();
        $builder->select('time, vehicle, gross_weight, tare_weight, mineral_weight, to, purpose');
        $builder->where('date', $date)->where('date <', $nxtDate)->where('type', $type)->where('contractor', $cname);
        $query = $builder->get();
        return $query->getResult();
    }

    public function currentMWeight($date, $nxtDate, $type){
        $builder = $this->builder();
        $builder->select('mineral_weight');
        $builder->where('date', $date)->where('date <', $nxtDate)->where('type', $type);
        $query = $builder->get();
        return $query->getResult();
    }
}
