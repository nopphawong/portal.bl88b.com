<?

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PageAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get("logged_in")) return redirect()->to(site_url("login"));
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
