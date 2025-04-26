<?php

$targetFolder = __DIR__ . '/app/public';
$linkFolder = __DIR__ . '/../public/storage';

if (file_exists($linkFolder)) {
    unlink($linkFolder);
}

if (!file_exists($targetFolder)) {
    mkdir($targetFolder, 0777, true);
}

symlink($targetFolder, $linkFolder);
