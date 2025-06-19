<?php

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/'; // Esto es app/

    // Asumimos que todas las clases están bajo el namespace "App"
    $prefix = 'App\\';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

