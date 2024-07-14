<?php

namespace App\Models;

use CodeIgniter\Model;

class WheelDailyModel extends Model {
    protected $table = 'tb_wheel_daily';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['agent', 'user', 'date', 'date_use', 'wheel', 'segment', 'title', 'type', 'value', 'rate', 'rate_min', 'rate_max', 'lucky_number', 'date_claim', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
