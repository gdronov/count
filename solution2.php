<?php
/**
 * Вариант решения: через использование класса RecursiveDirectoryIterator
 */
const FILENAME = 'count';

$dirList = [
    __DIR__ . '/scan/001',
    __DIR__ . '/scan/002',
    __DIR__ . '/scan/003',
];

$count = 0;

foreach ($dirList as $directory) {
    if (!is_dir($directory)) {
        continue;
    }

    $rdi = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($rdi);
    foreach ($iterator as $info) {
        if ($info->getFilename() === FILENAME) {
            $content = @file_get_contents($info->getPathname());
            if ($content !== false) {
                $count += intval($content);
            }
        }
    }
    unset($rdi, $iterator);
}

echo 'Сумма: ' . $count;
