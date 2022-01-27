<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Keensoen\CPanelApi\CPanel;

class CpanelController extends Controller
{
public function getSubdomains(){
    $cpanel = new CPanel();
    $response = $cpanel->getEmailAccounts();
    return $response;
}
}
