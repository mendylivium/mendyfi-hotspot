<?php

namespace App\Http\Controllers;

use App\Mail\MailTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestControl extends Controller
{
    //
    public function index()
    {
        Mail::to('rommel.person@gmail.com')
        ->send(new MailTest('Rommel'));
    }
    
}
