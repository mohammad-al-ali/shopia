<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseTypeService
{
    public function getDatabaseType(): string
    {
        //To get driver name that used in connection.
        $driver = DB::getDriverName();

        //return connection type.
        if ($driver === 'sqlite') {
            return 'SQLite';
        } elseif ($driver === 'mysql') {
            return 'MySQL';
        } else {
            return 'Unknown (' . $driver . ')';
        }
    }
}
