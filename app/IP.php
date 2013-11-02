<?php
/**
 * Return an array of whitelisted ip allowed to access the application
 *
 * @return array
 */
function getAllowedIP() {
    return array(
        '127.0.0.1',
        'fe80::1',
        '::1',
    );
}