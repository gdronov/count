<?php
/**
 * Вариант решения: рекурсивный обход директорий через функцию scandir()
 */

const FILENAME = 'count';

$dirList = [
    __DIR__ . '/scan/001',
    __DIR__ . '/scan/002',
    __DIR__ . '/scan/003',
];

/**
 * Рекурсивный поиск файлов в директории
 * @param string $dir
 * @return array
 */
function getFiles(string $dir): array
{
    $result = [];
    $list = array_diff(scandir($dir), ['.', '..']);
    foreach ($list as $name) {
        $fullName = $dir . '/' . $name;
        if (is_dir($fullName)) {
            $result = array_merge($result, getFiles($fullName));
        } elseif ($name == FILENAME) {
            $result[] = $fullName;
        }
    }

    return $result;
}

$count = 0;

foreach ($dirList as $directory) {
    if (!is_dir($directory)) {
        continue;
    }
    foreach (getFiles($directory) as $file) {
        $content = @file_get_contents($file);
        if ($content !== false) {
            // в задании не указано, какие именно числа записаны в файлах
            // будем считать, что это целое число
            $count += intval($content);
        }
    }
}

// если файлы не будут найдены, то результатом будет 0
echo 'Сумма: ' . $count;
