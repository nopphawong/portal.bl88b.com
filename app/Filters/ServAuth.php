<?

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ServAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get("logged_in")) return redirect()->to(site_url("unauthen"));
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
