<?php

namespace app\controller;

abstract class ControllerComHtml {
    public function renderizaHtml(String $caminhoTemplate, array $dados) : string 
    {
        extract($dados);
        ob_start();
        require __DIR__ . '/../../view/' . $caminhoTemplate;
        $html = ob_get_clean();

        return $html;
    }
}