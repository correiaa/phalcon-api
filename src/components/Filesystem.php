<?php

namespace App\Component;

use App\Exception\IOException;

/**
 * Class Filesystem.
 *
 * @package App\Component
 */
class Filesystem
{
    /**
     * Creates a directory recursively.
     *
     * ```php
     * $dirs = [
     *     0 => 'a/b/c/d/e/f',
     *     ...
     * ];
     * $Filesystem = new Filesystem();
     * $Filesystem->mkdir($dirs);
     * ```
     *
     * @param string|array $file The directory path.
     * @param int          $mode The directory mode.
     *
     * @throws \App\Exception\IOException
     */
    public function mkdir($file, $mode = 0777)
    {
        $dirs = is_array($file) ? (array)$file : [$file];
        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                continue;
            }

            if (true !== @mkdir($dir, $mode, true)) {
                $error = error_get_last();
                if (!is_dir($dir)) {
                    if ($error) {
                        throw new IOException(
                            sprintf('Failed to create "%s": %s.', $dir, $error['message']),
                            0,
                            null,
                            $dir
                        );
                    }
                    throw new IOException(
                        sprintf('Failed to create "%s"', $dir),
                        0,
                        null,
                        $dir
                    );
                }
            }
        }
    }
}
