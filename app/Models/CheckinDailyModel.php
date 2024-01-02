<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinDailyModel extends Model
{
    protected $table = 'tb_checkin_daily';
    protected $allowedFields = ['agent', 'user', 'date', 'date_use', 'checkin', 'progress','title', 'type', 'value', 'date_claim', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
