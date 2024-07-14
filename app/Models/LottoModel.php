<?php

namespace App\Models;

use CodeIgniter\Model;

class LottoModel extends Model {
    protected $table = 'tb_lotto';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['type', 'period', 'start', 'expire', 'reward', 'price', 'bingo', 'agent', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
