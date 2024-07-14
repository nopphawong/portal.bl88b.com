<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPointModel extends Model {
    protected $table = 'tb_user_point';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user', 'point', 'agent', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
