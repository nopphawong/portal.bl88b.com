<?php

namespace App\Models;

use CodeIgniter\Model;

class NumberMasterModel extends Model {
    protected $table = 'tb_number_master';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['type', 'no', 'sold_date', 'user', 'agent', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
