<?php

namespace App\Controllers\Crm;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        // Această variabilă va fi trimisă către view-ul principal
        $data['page_title'] = 'Dashboard';
        return view('Crm/dashboard/index', $data);
    }
}
