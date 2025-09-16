<?php
namespace Core;

class Controller {
    protected $template;

    public function __construct() {
        $this->template = new Template();
    }

    protected function render($view, $data = []) {
        foreach ($data as $key => $value) {
            $this->template->set($key, $value);
        }
        
        $this->template->set('content', $this->template->render($view));
        $this->template->display('layouts/main');
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getParam($name, $default = null) {
        return $_POST[$name] ?? $_GET[$name] ?? $default;
    }
}