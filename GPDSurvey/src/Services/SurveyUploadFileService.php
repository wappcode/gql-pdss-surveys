<?php

namespace GPDSurvey\Services;


use Exception;
use GMP;
use GPDCore\Library\UploadedFileModel;
use GPDCore\Services\UploadFileService;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;

use function GPDCore\Functions\getFileExtension;


class SurveyUploadFileService
{



    public static function upload(IContextService $context, string $uploadDir, string $dir)
    {
        $file = UploadFileService::uploadFile($uploadDir);

        if ($file !== null) {
            try {
                static::validateFile($file);
                $status = 200;
                $relativePath = static::getRelativePath($file, $dir);
                UploadFileService::mvFile($uploadDir, $file->getFinalPath(), $relativePath);
                $response = ["filename" => $relativePath];
                header("Content-Type: application/json; charset=UTF-8", true, $status);
                echo json_encode($response);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }
    /**
     * Solo son válidos archivos con extension jpg,jpeg,gif,png
     * Solo son válidos archivos de imagen
     */
    protected static function validateFile(UploadedFileModel $file)
    {

        $validImage = static::validateImage($file);
        $validPDF = static::validatePDF($file);
        $validVideo = static::validateVideo($file);
        $validOffice = static::validateOffice($file);
        $extension = getFileExtension($file->getFinalPath());
        $extension = strtolower($extension);
        $errorMsg = 'Formato de archivo inválido';

        if (!$validImage && !$validPDF && !$validVideo && !$validOffice) {
            throw new GQLException($errorMsg);
        }
    }
    protected static function validatePDF(UploadedFileModel $file): bool
    {
        $valid = true;
        $extension = getFileExtension($file->getFinalPath());
        $extension = strtolower($extension);
        $errorMsg = 'Formato inválido solo se permiten archivos PDF e Imágenes';
        if (!preg_match("/pdf/", $extension)) {
            $valid = false;
        }
        $mimetype = @mime_content_type($file->getFinalPath());

        if (!empty($mimetype) && (!preg_match("/(application\/pdf)/", $mimetype))) {
            $valid = false;
        }
        return $valid;
    }
    protected static function validateImage(UploadedFileModel $file): bool
    {
        $valid = true;
        $extension = getFileExtension($file->getFinalPath());
        $extension = strtolower($extension);
        $errorMsg = 'Formato inválido solo se permiten archivos PDF e Imágenes';
        if (!preg_match("/jpg|jpeg|gif|png/", $extension)) {
            $valid = false;
        }
        $mimetype = @mime_content_type($file->getFinalPath());

        if (!empty($mimetype) && (!preg_match("/(image)/", $mimetype))) {
            $valid = false;
        }
        return $valid;
    }
    protected static function validateVideo(UploadedFileModel $file): bool
    {
        $valid = true;
        $extension = getFileExtension($file->getFinalPath());
        $extension = strtolower($extension);
        if (!preg_match("/mp4|mov|wmv|avi|avchd|mkv|webm|mpeg|mpeg-2/", $extension)) {
            $valid = false;
        }
        $mimetype = @mime_content_type($file->getFinalPath());

        if (!empty($mimetype) && (!preg_match("/(video)/", $mimetype))) {
            $valid = false;
        }
        return $valid;
    }
    protected static function validateOffice(UploadedFileModel $file): bool
    {
        $valid = true;
        $extension = getFileExtension($file->getFinalPath());
        $extension = strtolower($extension);
        if (!preg_match("/doc|docx|xls|xlsx|ppt|pptx|pps|ppsx/", $extension)) {
            $valid = false;
        }
        $mimetype = @mime_content_type($file->getFinalPath());

        if (!empty($mimetype) && (!preg_match("/msword|officedocument|powerpoint|excel/", $mimetype))) {
            $valid = false;
        }
        return $valid;
    }


    protected static function getRelativePath(UploadedFileModel $file, string $dir)
    {
        $finalName = $file->getFileName();
        $name = static::createUniqueName();
        $extension = getFileExtension($finalName);
        $relativePath = $dir . DIRECTORY_SEPARATOR . $name . "." . $extension;
        return $relativePath;
    }

    protected static function createUniqueName(): string
    {
        $prefix = rand() . "__";
        return md5(uniqid($prefix, true));
    }
}
