<?php
namespace src;
use src\Core\DirectoryScanner;
use src\Core\FileHasher;
use src\servises\DeduplicationService;

class App {
    private $deduplicationService; 
    public function __construct($path){
        $scanner = new DirectoryScanner($path);
        $hasher = new FileHasher();
        $this->deduplicationService = new DeduplicationService($scanner, $hasher, $path);
    }
    public function start(){
        $this->deduplicationService->generateFileHashes()->removeDuplicates();
    }
}