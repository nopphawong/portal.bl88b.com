<?php

namespace App\Models;

use CodeIgniter\Model;

class WheelModel extends Model {
    protected $table = 'tb_wheel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['agent', 'title', 'detail', 'deposit_rule', 'background_image', 'arrow_image', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
