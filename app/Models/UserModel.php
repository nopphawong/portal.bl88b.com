<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['role', 'username', 'password', 'name', 'tel', 'agent', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
