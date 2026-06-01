<?php
namespace src\servises;
use src\Core\DirectoryScanner;
use src\Core\FileHasher;
use src\logger\Logger;

class DeduplicationService{
    private $parentDir;
    private DirectoryScanner $scanner;
    private FileHasher $hasher;
    private Logger $logger;
    private $fileHashMap = [];

    public function __construct($scanner, $hasher, $logger, $dir){
        $this->scanner = $scanner;
        $this->hasher = $hasher;
        $this->logger = $logger;
        $this->parentDir = $dir;
    }
    public function generateFileHashs(){
        $filePaths = $this->scanner->scan();
        $this->logger->info("Scanned ".$this->parentDir); // log
        foreach($filePaths as $filePath){
            $hashString = $this->hasher->hashFile($filePath);
            $this->logger->info("Hashed: " . $filePath . " -> " . $hashString); // log
            if(array_key_exists($hashString,$this->fileHashMap)){
                $this->fileHashMap[$hashString][] = $filePath;
            }else{
                $this->fileHashMap[$hashString] = [$filePath];
            }
        }
        return $this;
    }
    public function removeDuplicates(){
        if(empty($this->fileHashMap)){
            $this->logger->error("No files registerd on the hashmap.");
            return;
        }
        foreach($this->fileHashMap as $hashKey => $paths){
            if(count($paths) <= 1){
                continue;
            }
            for ($i = count($paths) - 1; $i > 0; $i--){
                if(unlink($paths[$i])){
                    $this->logger->info("Deleted - " . array_pop($paths));
                }
            }
        }
    }

}