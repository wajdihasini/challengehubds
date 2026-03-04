<?php

spl_autoload_register(function ($class) {
    // Liste des dossiers où chercher les classes
    $dirs = [
        'app/controllers/',
        'app/models/',
        'app/core/',
        'config/'
    ];

    foreach ($dirs as $dir) {
        $file = __DIR__ . '/../../' . $dir . $class . '.class.php';
        // Sur Windows, on normalise les séparateurs si nécessaire, mais PHP gère bien les /
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
