<?php
namespace Confy\Interfaces;

interface Parser 
{
    public function parseFile(string $filename): array;
}
