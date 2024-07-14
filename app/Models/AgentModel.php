<?php

namespace App\Models;

use CodeIgniter\Model;

class AgentModel extends Model {
    protected $table = 'tb_agent';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['code', 'key', 'web', 'secret', 'name', 'url', 'description', 'logo', 'line_id', 'line_link', 'meta_tag', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
