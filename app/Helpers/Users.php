<?php

if (! function_exists('GetUser')) {
    function GetUser() {
        if (auth()->user() === null) {
            throw new \Exception('User is not logged in');
        }

        return auth()->user();
    }
}

if (! function_exists('filterByOwner')) {
    function filterByOwner($datas, $atribute = 'produk_owner', $owner = null)
    {
        if ($owner === null || !$owner->isPartner()) { // Check if the user is a partner
            return $datas;
        }
        
        if (!is_array($datas)) {
            return [];
        }

        return array_filter($datas, function ($data) use ($atribute, $owner) {
            return isset($data[$atribute]) && strtolower($data[$atribute]) === strtolower($owner->email);
        });
    }
}