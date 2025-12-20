<?php

if (! function_exists('filterReservationNotRejected')) {
    function filterReservationNotRejected($response) {
        if (empty($response) || !is_array($response)) {
            return [];
        }

        $response = array_filter($response, fn($reservation) => $reservation['detail_status'] != 'REJECTED');

        return $response;
    }
}