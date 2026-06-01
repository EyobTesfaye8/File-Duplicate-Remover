<?php
namespace src\Core;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
class DirectoryScanner
{
    private string $mainDir;
    public function __construct(string $dir)
    {
        $this->mainDir = $dir;
    }
    public function scan()
    {
        $filePaths = [];
        try {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->mainDir));
        } catch (Exception $e) {

        }
        foreach ($files as $file) {
            if (!is_dir($file)) {
                $filePaths[] = $file->getPathname();
            }
        }
        return $filePaths;

    }
}