<?php

namespace App\Models;

use CodeIgniter\Model;

class WheelModel extends Model
{
    protected $table = 'tb_wheel';
    protected $allowedFields = ['agent', 'title', 'detail', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
