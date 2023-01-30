<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ReturnListModel extends Model
    {
        protected $DBGroup          = 'default';
        protected $table            = 'ReturnList';
        protected $primaryKey       = 'id';
        protected $returnType       = 'array';
        protected $allowedFields    = ['name', 'type', 'alert_day', 'submit_day', 'submit_month'];

        // Dates
	    protected $useTimestamps        = false;
	    protected $dateFormat           = 'datetime';
	    protected $createdField         = 'created_at';
        protected $updatedField         = 'updated_at';
    }

?>