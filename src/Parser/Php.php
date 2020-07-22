<?php
namespace Confy\Parser;
use \Confy\Interfaces\Parser;

class Php implements Parser 
{
    public function parseFile(string $filename): array
    {
        if(file_exists($filename)) {
            return include $filename;
        } else {
            throw new \Exception("Unable to load config ! File $filename does not exist !");
        }
    }
}
