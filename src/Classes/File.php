<?php

namespace Retamayo\Vector\Classes;

class File
{
    public static function createPath($path): void
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public static function createFile($path): void
    {
        if (!file_exists($path)) {
            touch($path);
        }
    }

    public static function deleteFile($path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public static function writeFile($path, $content): void
    {
        if (file_exists($path)) {
            file_put_contents($path, $content);
        }
    }
}
