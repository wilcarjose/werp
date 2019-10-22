<?php

namespace Werp\Modules\JMJ\POS\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\JMJ\POS\Services\POSService;

class POSController extends Controller
{
    protected $posService;

    public function __construct(POSService $posService)
    {
        $this->posService = $posService;
    }

    public function pos(Request $request)
    {
        return view('admin.core.pos.pos');
    }
}
