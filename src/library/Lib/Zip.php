<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Lib;

use ZipArchive;

class Zip extends ZipArchive
{
    public function addDirectory(string $dir, string $base): self
    {
        $newFolder = str_replace($base, '', $dir);
        $this->addEmptyDir($newFolder);
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                $this->addDirectory($file, $base);
            } else {
                $newFile = str_replace($base, '', $file);
                $this->addFile($file, $newFile);
            }
        }
        return $this;
    }
}
