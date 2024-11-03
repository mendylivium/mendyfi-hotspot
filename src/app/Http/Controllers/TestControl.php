<?php

namespace App\Http\Controllers;

use App\Mail\MailTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class TestControl extends Controller
{
    //
    public function index()
    {
       $files = File::glob("/var/www/html/storage/app/backups/central/central_database_backup-*sql");

       $dates = [];

       foreach ($files as $file) {
            if (preg_match('/backup-(\d{4}-\d{2}-\d{2})\.sql/', basename($file), $matches)) {
                $dates[] = $matches[1];
            }
        }   

        dd($dates);
    }
    
}
