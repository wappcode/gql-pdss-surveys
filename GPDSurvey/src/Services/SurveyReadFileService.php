<?php

namespace GPDSurvey\Services;

use FlowUtilities\UploadFileManager;

class SurveyReadFileService
{
    public static function read(string $uploadDir, string $path)
    {
        $filePath = urldecode($path);
        $fullPath = $uploadDir.DIRECTORY_SEPARATOR.$filePath;
        UploadFileManager::readFile($fullPath);
    }
    public static function download(string $uploadDir, string $path)
    {
        $filePath = urldecode($path);
        $fullPath = $uploadDir.DIRECTORY_SEPARATOR.$filePath;
        UploadFileManager::downloadFile($fullPath);
    }
}
