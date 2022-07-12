<?php

namespace GPDSurvey\Controller;

use GPDCore\Library\AbstractAppController;
use GPDSurvey\Services\SurveyReadFileService;


class SurveyReadFileController extends AbstractAppController
{



    public function dispatch()
    {
        $filename = $this->request->getParam('file', '');
        $uploadDir = $this->context->getConfig()->get("app_upload_dir");
        SurveyReadFileService::read($uploadDir, $filename);
    }
}
