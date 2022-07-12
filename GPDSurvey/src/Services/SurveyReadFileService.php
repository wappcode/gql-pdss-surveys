<?php

namespace GPDSurvey\Services;

use GPDCore\Library\IContextService;
use GPDCore\Services\UploadFileService;

class SurveyReadFileService
{
    public static function read(string $uploadDir, string $path)
    {
        $filePath = urldecode($path);

        UploadFileService::readFile($uploadDir, $filePath);
    }
    public static function download(string $uploadDir, string $path)
    {
        $filePath = urldecode($path);
        UploadFileService::downloadFile($uploadDir, $filePath);
    }
}
