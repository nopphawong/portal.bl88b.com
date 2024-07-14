<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressMasterModel extends Model {
    protected $table = 'tb_progress_master';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['agent', 'checkin', 'index', 'title', 'type', 'value', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
