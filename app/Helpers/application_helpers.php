<?php

if (!function_exists('site_name')) {
    function site_name(): string
    {
        return config('app.name', 'Kivor');
    }
}
if (!function_exists('site_logo')) {
    function site_logo(): string
    {
        return env('APP_LOGO', asset('assets/images/logo.png'));
    }
}
