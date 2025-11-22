<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Fonte
{
    public static function send($number, $message)
    {
        return Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->asForm()->post(env('FONNTE_URL'), [
            'target' => $number,
            'message' => $message,
        ]);
    }
}
