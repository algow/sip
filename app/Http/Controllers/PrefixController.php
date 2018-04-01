<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrefixController extends Controller
{
    protected $prefix;
    
    public function __construct(Request $request)
    {
        $prefix = $request->route()->getPrefix();
        $stripslash = str_replace('/','',$prefix);                  // admin or fo
        
        return $this->prefix = $stripslash;
    }
    
    public function getPrefix()
    {
        return $this->prefix;
    }
}
