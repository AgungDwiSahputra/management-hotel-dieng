<?php

if (! function_exists('whatsappLink')) {
    function whatsappLink($nomor) {
        return "https://wa.me/62 " . ltrim($nomor, '0');
    }
}