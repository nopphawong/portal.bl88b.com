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
abstract class BaseController extends Controller {
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
    protected $viewData = [
        "includes_js" => [],
        "includes_css" => [],
        "includes_vuejs" => [],
    ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->addJs(base_url("js/utils.js?v=0.01aa"));
        $this->addCss(base_url("css/main.css?v=0.01"));

        $this->viewData['title'] = 'UFA PORTAL';
        $this->viewData['path'] = implode("/", $request->uri->getSegments());
    }
    public function addJs($js, $key = "includes_js") {
        if (is_array($js)) $this->viewData[$key] = array_merge($this->viewData[$key], $js);
        else if (is_string($js)) $this->viewData[$key][] = $js;
    }
    public function addCss($css, $key = "includes_css") {
        if (is_array($css)) $this->viewData[$key] = array_merge($this->viewData[$key], $css);
        else if (is_string($css)) $this->viewData[$key][] = $css;
    }
    public function addVueJs($js) {
        $this->addJs($js, "includes_vuejs");
    }
    public function usePrimevue() {
        // $this->addCss("https://unpkg.com/primevue/resources/themes/lara-light-green/theme.css");
        $this->addVueJs("https://unpkg.com/primevue@4.0.0/umd/primevue.min.js");
        $this->addVueJs("https://unpkg.com/@primevue/themes@4.0.0/umd/aura.min.js");
    }
    public function usePrimevueLib($name) {
        $this->addVueJs("https://unpkg.com/primevue/{$name}/{$name}.min.js");
    }
    public function renderView($path) {
        return view($path, $this->viewData);
    }
}
