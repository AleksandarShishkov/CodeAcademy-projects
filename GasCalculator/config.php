<?php

// the autoloader function
function custom_autoloader($className, $dirs) {
    
    // the possible directories can be added to an array and loopedtrough
    
    $classParts = explode('\\', $className);
    $fileName = end($classParts) . '.php';
    array_pop($classParts);
    $dirPath = implode('/', $classParts);

    foreach($dirs as $dir) {
        $classFilePath = $dir . '/' . $dirPath . $fileName;
        if(file_exists($classFilePath)) {
            require_once $classFilePath;
            return;
        }
    }
    
    //if no such file is located 
    throw new Exception('Not initialized: ' . $className . " or invalid dir path: " . $classFilePath . "\n");
}

$dirs = array(
    'html_class',
    'html_files',
    'models',
    'views',
    'controller'
);

// registering the autoloader
spl_autoload_register(function($className) use($dirs) {
    custom_autoloader($className, $dirs);
});