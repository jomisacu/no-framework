<?php

use Jomisacu\NoFramework\Apps\Api\RegisterLocationController;

require __DIR__ . '/bootstrap.php';

$commands = [
    'register_location' => RegisterLocationController::class,
];

function request_filterVar(string $variableName, $default = null) {
    return $_REQUEST[$variableName] ?? $default;
}


// $_REQUEST, $_POST, $_GET, $_FILES