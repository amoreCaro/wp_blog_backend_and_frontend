<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if (!function_exists('dd')) {
    /**
     * Dump any variable inside <pre> tags
     */
    function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}