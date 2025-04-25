<?php
// app/Services/VoucherService.php

namespace App\Services;

use Illuminate\Support\Str;

class VoucherService
{
    public static function generate()
    {
        return
            rand(1, 1000) .
            now()->format('Ymd') .
            Str::upper(Str::random(3));
    }
}
// Example: ABC-20230715-XYZ
