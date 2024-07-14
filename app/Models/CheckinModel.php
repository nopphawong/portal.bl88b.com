<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinModel extends Model {
    protected $table = 'tb_checkin';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['agent', 'title', 'detail', 'deposit_rule', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
