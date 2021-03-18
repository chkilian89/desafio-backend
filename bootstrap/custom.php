<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

function debug($arg)
{
    $str = is_string($arg) ? $arg : var_export($arg, true);
    Log::debug($str);
}

function get_assets_version()
{
    return Cache::rememberForever("assets_version", function () {
        return time();
    });
}

/**
 * [asset 'Funcao sobreescrita para colocar uma funcionalidade de limpar o cache do JS e CSS do sistema']
 * @param  [string] $path
 * @param  [bool] $secure
 * @return [string]
 */
function asset($path, $secure = null)
{
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    if (Config::get('app.env') !== 'local') {
        // Set default https route
        $url = app('url')->asset($path, true);
    } else {
        $url = app('url')->asset($path, $secure);
    }

    if (in_array(strtolower($ext), ['js', 'css'])) {
        return $url . "?v=" . get_assets_version();
    }

    return $url;
}
