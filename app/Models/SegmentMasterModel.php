<?php

namespace App\Models;

use CodeIgniter\Model;

class SegmentMasterModel extends Model
{
    protected $table = 'tb_segment_master';
    protected $allowedFields = ['agent', 'wheel', 'index', 'title', 'type', 'value', 'rate', 'hex', 'image', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
