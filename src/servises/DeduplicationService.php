<?php
namespace src\servises;
use src\Core\DirectoryScanner;
use src\Core\FileHasher;

class DeduplicationService{
    private $parentDir;
    private DirectoryScanner $scanner;
    private FileHasher $hasher;
    private $fileHashMap = [];

    public function __construct($scanner, $hasher, $dir){
        $this->scanner = $scanner;
        $this->hasher = $hasher;
        $this->parentDir = $dir;
    }
    public function generateFileHashes(){
        $filePaths = $this->scanner->scan();
        // die($filePaths[0]);
        foreach($filePaths as $filePath){
            $hashString = $this->hasher->hashFile($filePath);
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
            return;
        }
        foreach($this->fileHashMap as $hashKey => $paths){
            if(count($paths) <= 1){
                continue;
            }
            for ($i = count($paths) - 1; $i > 0; $i--){
                if(unlink($paths[$i])){
                    array_pop($paths);
                }
            }
        }
    }

}