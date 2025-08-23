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


if (! function_exists('getPermissionProducts')) {
    function getPermissionProducts($user)
    {
        if ($user === null) {
            return [];
        }
        
        // dd(App\Models\CollabPermission::where('user_id', $user->id)->pluck('product_id')->toArray());
        return App\Models\CollabPermission::where('user_id', $user->id)->pluck('product_id')->toArray();
    }
}

if (! function_exists('filterCollabPermission')) {

    function filterCollabPermission($datas, $atribute = 'produk_id', $permission = [])
    {
        if (auth()->user() === null) {
            throw new \Exception('User is not logged in');
        }

        if (!auth()->user()->isCollab()) { // Check if the user is a Collab
            return $datas;
        }
        
        if (!is_array($datas)) {
            return [];
        }
        
        return array_filter($datas, function ($data) use ($atribute, $permission) {
            return isset($data[$atribute]) && isset($permission) && is_array($permission) && in_array( $data[$atribute], $permission);
        });
    }
}