<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;
use mysqli;

class Helper
{
    public static function instance()
    {
        return new Helper();
    }
    public function checkDBConnection()
    {
        try {
            $conn = new mysqli('127.0.0.1', 'root', '');
            // DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
