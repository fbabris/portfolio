<?php
namespace Helpers;
class Debuger
{
    private $file_name;
    public function __construct($file_name) {
        $this->file_name = $file_name;
    }
    public function log($value) {
        file_put_contents($this->file_name, print_r($value, true) . PHP_EOL, FILE_APPEND);
    }
}