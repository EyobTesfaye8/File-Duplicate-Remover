<?php
namespace src\Core;

class FileHasher {
    public function hashFile($filePath){
        return sha1_file($filePath);
    }
}