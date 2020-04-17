<?php

namespace controllers;

use core\BaseController;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        $type = $this->request->get('type', 'html');
        if ($type === 'json') {
            return $this->sendJson(['red' => '红色']);
        }
        return $this->render('site/index', ['name' => '张三']);
    }
}   