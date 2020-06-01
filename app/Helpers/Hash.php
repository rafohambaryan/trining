<?php


namespace App\Helpers;

use Illuminate\Support\Str;

class Hash extends Str
{
    private static $hash;

    public static function unique($model, $column, $length = 32)
    {
        do {
            $url = self::random($length);
            self::$hash = $url;
        } while ($model::where($column, $url)->first() instanceof $model);
        return self::$hash;
    }

}
