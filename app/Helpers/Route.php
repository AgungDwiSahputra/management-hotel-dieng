<?php

if (! function_exists('isCurrentRoute')) {
    function isCurrentRoute($routeName = 'dashboard') {
        return Str::startsWith(request()->route()->getName(), $routeName);
    }
}