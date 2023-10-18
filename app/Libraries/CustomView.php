<?php

namespace App\Libraries;

class CustomView
{
    /**
     * This is fuction custom page view (for logged in).
     * @param string $page is view.
     * @param array $headerInfo for config in head element tag such as title.
     * @param array $viewData data in view page.
     */
    public static function pageView($page, $headerInfo, $viewData = [])
    {
        return view('layouts/header', $headerInfo) .
            view('layouts/sidebar') .
            view($page, $viewData) .
            view('layouts/footer');
    }
}
