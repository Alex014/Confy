<?php
namespace Confy\Parser;
use \Confy\Interfaces\Parser;

class Yaml implements Parser 
{
    public function parseFile(string $filename): array
    {
        if(file_exists($filename)) {
            return yaml_parse_file($filename);
        } else {
            throw new \Exception("Unable to load config ! File $filename does not exist !");
        }
    }
}
