<?php
class Partial {
    private string $filepath;

    public function __construct(string $filepath) 
    {
        if (!file_exists($filepath)) {
            throw new Exception('Error: file ' . $filepath . ' does not exist.');
        }

        $this->filepath = $filepath;
    }

    public function render(array $args = [])
    {
        if ($args) {
            extract($args);
        }

        ob_start();
        include $this->filepath;
        echo ob_get_clean();
    }
}