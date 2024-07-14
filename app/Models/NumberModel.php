<?php

namespace App\Models;

use CodeIgniter\Model;

class NumberModel extends Model {
    protected $table = 'tb_number';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['lotto', 'no', 'sold_date', 'user', 'agent', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
