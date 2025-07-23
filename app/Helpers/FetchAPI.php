<?php

if (! function_exists('FetchAPIMethod')) {
    function FetchAPI($url)
    {
        return FetchAPIMethod($url, 'GET');
    }

    function FetchAPIPost($url, $data)
    {
        return FetchAPIMethod($url, 'POST', $data);
    }

    function FetchAPIMethod($url, $method, $data = [])
    {
        $headers = [
            "Authorization: Bearer " . env('SANCTUM_TOKEN_PREFIX'),
            "Content-Type: application/json"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }
}

// Products
if (!function_exists('getAllProducts')) {
    function getAllProducts()
    {
        $response = FetchAPI(env('URL_API') . '/api/v1/products');
        $response = filterByOwner($response, 'owner', GetUser());

        return $response;
    }
}

if (!function_exists('getProductById')) {
    function getProductById($id)
    {
        return FetchAPI(env('URL_API') . '/api/v1/products/' . $id);
    }
}

if (!function_exists('updateProductById')) {
    function updateProductById($id, $data)
    {
        return FetchAPIPost(env('URL_API') . '/api/v1/products/' . $id, $data);
    }
}

// Availability
if (!function_exists('getAvailability')) {
    function getAvailability($produk_id)
    {
        $response = FetchAPI(env('URL_API') . '/api/v1/availability/' . $produk_id);
        $response = filterByOwner($response, 'product_owner', GetUser());

        return $response;
    }
}

if (!function_exists('createAvailability')) {
    function createAvailability($produk_id, $data)
    {
        return FetchAPIPost(env('URL_API') . '/api/v1/availability/' . $produk_id, $data);
    }
}

if (!function_exists('updateAvailability')) {
    function updateAvailability($produk_id, $id, $data)
    {
        return FetchAPIMethod(env('URL_API') . '/api/v1/availability/' . $produk_id . '/' . $id, 'PUT', $data);
    }
}

if (!function_exists('deleteAvailability')) {
    function deleteAvailability($produk_id, $id)
    {
        return FetchAPIMethod(env('URL_API') . '/api/v1/availability/' . $produk_id . '/' . $id, 'DELETE');
    }
}

// Reservations
if (!function_exists('getAllReservations')) {
    function getAllReservations()
    {
        $response = FetchAPI(env('URL_API') . '/api/v1/reservations');
        $response = filterByOwner($response, 'produk_owner', GetUser());

        return $response;
    }
}

if (!function_exists('getReservationById')) {
    function getReservationById($id)
    {
        return FetchAPI(env('URL_API') . '/api/v1/reservations/' . $id);
    }
}

if (!function_exists('getReservationsByDate')) {
    function getReservationsByDate($date)
    {
        return FetchAPI(env('URL_API') . '/api/v1/reservations/by-date/' . $date);
    }
}

if (!function_exists('acceptAllReservations')) {
    function acceptAllReservations($transaksi_id, $data = [])
    {
        return FetchAPIPost(env('URL_API') . '/api/v1/reservations/' . $transaksi_id . '/acceptAll', $data);
    }
}

if (!function_exists('acceptReservation')) {
    function acceptReservation($id, $data = [])
    {
        return FetchAPIPost(env('URL_API') . '/api/v1/reservations/' . $id . '/accept', $data);
    }
}

if (!function_exists('rejectReservation')) {
    function rejectReservation($id, $data = [])
    {
        return FetchAPIPost(env('URL_API') . '/api/v1/reservations/' . $id . '/reject', $data);
    }
}