<?php

namespace App\Models;

use CodeIgniter\Model;

class LottoTypeModel extends Model {
    protected $table = 'tb_lotto_type';
    protected $primaryKey = 'code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['code', 'name', 'length', 'min', 'max', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
