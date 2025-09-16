<?php
namespace Core;

class Template {
    private $templateDir;
    private $data = [];

    public function __construct($templateDir = null) {
        $this->templateDir = $templateDir ?: __DIR__ . '/../Views';
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    public function render($template) {
        $templatePath = $this->templateDir . '/' . $template . '.tpl';
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: " . $templatePath);
        }

        extract($this->data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function display($template) {
        echo $this->render($template);
    }
}