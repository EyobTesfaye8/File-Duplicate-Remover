<?php

spl_autoload_register(function ($classname){
    $relativePath = str_replace('\\', '/', $classname);
    $fullPath = __DIR__ . '/' . $relativePath . '.php';
    if(file_exists($fullPath)){
        require_once $fullPath;
    }
});