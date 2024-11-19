<?php
function base_url($path = '') {
    $base_url = 'http://localhost/javascript/php/public';
    return $base_url . $path;
}

function redirect($path) {
    header('Location: ' . base_url($path));
    exit;
}