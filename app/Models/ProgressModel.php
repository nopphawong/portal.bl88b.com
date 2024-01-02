<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table = 'tb_progress';
    protected $allowedFields = ['agent', 'checkin', 'index', 'title', 'type', 'value', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
