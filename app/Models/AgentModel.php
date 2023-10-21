<?

namespace App\Models;

use CodeIgniter\Model;

class AgentModel extends Model
{
    protected $table = 'tb_agent';
    protected $allowedFields = ['code', 'key', 'secret', 'name', 'url', 'description', 'logo', 'line', 'status', 'add_date', 'add_by', 'edit_date', 'edit_by'];
    protected $returnType = 'object';
}
