<?php
namespace Confy\Parser;
use \Confy\Interfaces\Parser;

class Json implements Parser 
{
    public function parseFile(string $filename): array
    {
        if(file_exists($filename)) {
            return json_decode(file_get_contents($filename), true);
        } else {
            throw new \Exception("Unable to load config ! File $filename does not exist !");
        }
    }
}
