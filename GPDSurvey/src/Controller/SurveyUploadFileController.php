<?php

namespace GPDSurvey\Controller;

use GPDCore\Library\AbstractAppController;
use GPDSurvey\Services\SurveyUploadFileService;


class SurveyUploadFileController extends AbstractAppController
{



    public function dispatch()
    {


        $dir = $this->context->getConfig()->get('survey_upload_file_dir');
        $uploadDir = $this->context->getConfig()->get("app_upload_dir");
        SurveyUploadFileService::upload($this->context, $uploadDir, $dir);
    }
}
