<?php
namespace src;
use src\Core\DirectoryScanner;
use src\Core\FileHasher;
use src\servises\DeduplicationService;
use src\logger\Logger;

class App {
    private $deduplicationService; 
    public function __construct($path){
        $scanner = new DirectoryScanner($path);
        $hasher = new FileHasher();
        $logger = new Logger();
        $this->deduplicationService = new DeduplicationService($scanner, $hasher, $logger, $path);
    }
    public function start(){
        $this->deduplicationService->generateFileHashs()->removeDuplicates();
    }
}