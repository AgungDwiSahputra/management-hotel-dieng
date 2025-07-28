<?php

if (! function_exists('filterReservationNotRejected')) {
    function filterReservationNotRejected($response) {
        $response = array_filter($response, function ($reservation) {
            return $reservation['detail_status'] != 'REJECTED';
        });

        return $response;
    }
}