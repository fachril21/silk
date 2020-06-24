<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function instance()
    {
        return new Helper();
    }
    public function checkDBConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            die("Could not open connection to database server.  Please check your configuration.");
        }
    }
}
