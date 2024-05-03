<?php

namespace App\Models;

use CodeIgniter\Model;

class ChannelModel extends Model {
    protected $table = 'tb_channel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id',
        'ref',
        'name',
        'description',
        'agent',
        'status',
        'add_date',
        'add_by',
        'edit_date',
        'edit_by',
    ];
    protected $returnType = 'object';
}
