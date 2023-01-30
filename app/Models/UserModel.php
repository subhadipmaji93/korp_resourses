<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
    {
        protected $DBGroup          = 'default';
        protected $table            = 'users';
        protected $primaryKey       = 'id';
        protected $returnType       = 'array';
        protected $allowedFields    = ['username', 'password', 'role'];

        // Dates
	    protected $useTimestamps        = false;
	    protected $dateFormat           = 'datetime';
	    protected $createdField         = 'created_at';
	    protected $updatedField         = 'updated_at';
    }
