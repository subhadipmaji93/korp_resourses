<?php
    namespace App\Models;
    use CodeIgniter\Model;

class ReturnDataModel extends Model
    {
        protected $DBGroup          = 'default';
        protected $table            = 'ReturnData';
        protected $primaryKey       = 'id';
        protected $returnType       = 'array';
        protected $allowedFields    = ['id', 'return_id', 'name', 'alert_date', 'submit_date', 'file_list','is_active'];

        // Dates
	    protected $useTimestamps        = false;
	    protected $dateFormat           = 'datetime';
	    protected $updatedField         = 'updated_at';
	    
        public function fetchAlert($date){
            $builder = $this->builder();
            $builder->select('id, return_id,  name, submit_date');
            $builder->where('is_active', true)
            ->where('submit_date >=', $date)
            ->where('alert_date <=', $date);

            $query = $builder->get();
            return $query->getResult();
        }

        public function fetchReturn($date){
            $builder = $this->builder();
            $builder->select('id, name, submit_date, updated_at, file_list');
            $builder->where('submit_date', $date);
            $query = $builder->get();
            return $query->getResult();
        }
    }
?>