<?php

namespace GPDSurvey\Controller;

use Exception;
use GPDCore\Library\AbstractAppController;
use GPDSurvey\Services\SurveyUploadFileService;


class SurveyUploadFileController extends AbstractAppController
{



    public function dispatch()
    {


        $dir = $this->context->getConfig()->get('survey_upload_file_dir');
        $uploadDir = $this->context->getConfig()->get("app_upload_dir");
        if (empty($dir) || empty($uploadDir)) {
            throw new Exception("Internal server error", 500);
        }
        SurveyUploadFileService::upload($this->context, $uploadDir, $dir);
    }
}
