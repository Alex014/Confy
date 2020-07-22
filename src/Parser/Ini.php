<?php
namespace Confy\Parser;
use \Confy\Interfaces\Parser;

class Ini implements Parser 
{
    public function parseFile(string $filename): array
    {
        if(file_exists($filename)) {
            return parse_ini_file($filename, true, INI_SCANNER_TYPED);
        } else {
            throw new \Exception("Unable to load config ! File $filename does not exist !");
        }
    }
}
