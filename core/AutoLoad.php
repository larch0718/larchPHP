<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $path = './' . $class . '.php';
    if (file_exists($path)) {
        require_once './' . $class . '.php';
    }
}, true, true);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error) {
        die(json_encode($error));
    }
});