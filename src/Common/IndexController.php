<?php

namespace Common;

use Symfony\Component\HttpFoundation\Response;

class IndexController
{

    private const TEMPLATE_PATH = 'templates';

    private function getTemplateFilePath(string $template_name): string
    {
        return PROJECT_ROOT.'/'.self::TEMPLATE_PATH.'/'.$template_name;
    }

    private function render($template_name, $vars = null)
    {
        if ($vars && is_array($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }
        ob_start();
        $tpl_path = $this->getTemplateFilePath($template_name);
        include($tpl_path);
        return ob_get_clean();
    }

    public function indexAction(): Response
    {
        $content = $this->render('Common/index.phtml');
        return new Response($content);
    }

}