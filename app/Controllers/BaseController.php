<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $viewData = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->viewData['includes_js'][] = site_url("js/utils.js?v=0.01a");
        $this->viewData['includes_css'][] = site_url("css/main.css");

        $this->viewData['title'] = 'UFA PORTAL';
        $this->viewData['path'] = implode("/", $request->uri->getSegments());
    }

    public function use_datatable()
    {
        $this->viewData["lib_datatable"] = (object) array(
            "css" => [
                site_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"),
            ],
            "js" => [
                site_url("assets/plugins/datatables/jquery.dataTables.min.js"),
                site_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"),
            ],
        );
    }
}
