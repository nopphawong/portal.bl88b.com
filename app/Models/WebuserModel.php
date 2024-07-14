<?php

namespace App\Models;

use CodeIgniter\Model;

class WebuserModel extends Model {
    protected $table = 'tb_webuser';
    protected $primaryKey = 'web_username';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'web_username',
        'web_password',
        'web_agent',
        'agent',
        'tel',
        'date_use',
        'status',
        'add_date',
        'add_by',
        'edit_date',
        'edit_by'
    ];
    protected $returnType = 'object';
}
