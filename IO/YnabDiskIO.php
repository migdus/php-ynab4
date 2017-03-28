<?php

namespace Petrica\Ynab;

use Petrica\Ynab\Entity\YnabFile;
use Petrica\Ynab\IO\YnabIOInterface;

/**
 * Class YnabDiskIO
 *
 * Read database from disk
 *
 * @package Petrica\Ynab
 */
class YnabDiskIO implements YnabIOInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($filepath)
    {
        $file = new YnabFile($filepath, file_get_contents($filepath));

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function write($ynabFile)
    {
        return file_put_contents($ynabFile->getPath(), $ynabFile->__toString());
    }

    /**
     * {@inheritdoc}
     */
    public function ls($path)
    {
        $files = scandir($path);
        $full = [];
        if ($files) {
            $files = array_filter($files, function ($file) {
                return !in_array($file, ['.', '..']);
            });
            $full = array_map(function ($file) use ($path) {
                return $path . DIRECTORY_SEPARATOR . $file;
            }, $files);
        }

        return $full;
    }

}