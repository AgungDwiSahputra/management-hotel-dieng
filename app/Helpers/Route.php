<?php

if (! function_exists('thisRoute')) {
    function isCurrentRoute($routeName = 'dashboard') {
        return Str::startsWith(request()->route()->getName(), $routeName);
    }
}