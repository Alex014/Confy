<?php declare(strict_types=1);
require '../src/Confy.php';
require '../src/Interfaces/Parser.php';
require '../src/Parser/Php.php';
require '../src/Parser/Ini.php';
require '../src/Parser/Json.php';
require '../src/Parser/Yaml.php';


use \Confy\Confy;
use PHPUnit\Framework\TestCase;

final class ConfyTest extends TestCase
{
    public function testLoadIniFile(): void
    {
        Confy::load('files/test.ini');
        $this->assertTrue(true);
    }
    
    public function testLoadJsonFile(): void
    {
        Confy::load('files/test.json');
        $this->assertTrue(true);
    }
    
    public function testLoadPhpFile(): void
    {
        Confy::load('files/test.php');
        $this->assertTrue(true);
    }
    
    public function testLoadYamlFile(): void
    {
        Confy::load('files/test.yaml');
        $this->assertTrue(true);
    }
    
    public function testloadConfig(): void
    {
        Confy::load('files/test.ini');
        Confy::load('files/test.json');
        Confy::load('files/test.php');
        Confy::load('files/test.yaml');
        
        $this->assertTrue(Confy::has('ttt'));
        $this->assertTrue(Confy::has('ttt.xxx'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy.zzz'));
    }
    
    public function testloadGetSetValue(): void
    {
        Confy::load('files/test.ini');
        Confy::load('files/test.json');
        Confy::load('files/test.php');
        Confy::load('files/test.yaml');
        
        Confy::set('ttt.xxx.yyy.zzz.Z', 111);
        Confy::set('ttt.xxx.yyy.zzz.ZZ', 222);
        Confy::set('ttt.xxx.yyy.zzz.ZZZ', 333);
        Confy::set('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y', 123456789);
        
        $this->assertTrue(Confy::has('ttt'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy.zzz.Z'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy.zzz.ZZ'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy.zzz.ZZZ'));
        $this->assertTrue(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y'));
        
        $this->assertEquals(Confy::get('ttt.xxx.yyy.zzz.Z'), 111);
        $this->assertEquals(Confy::get('ttt.xxx.yyy.zzz.ZZ'), 222);
        $this->assertEquals(Confy::get('ttt.xxx.yyy.zzz.ZZZ'), 333);
        $this->assertEquals(Confy::get('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y'), 123456789);
        
        $data = Confy::get('ttt.xxx.yyy.zzz.ZZZZ');
        $this->assertEquals($data['q']['w']['e']['r']['t']['y'], 123456789);
    }
    
    public function testloadUnsetValue(): void
    {
        Confy::load('files/test.ini');
        Confy::load('files/test.json');
        Confy::load('files/test.php');
        Confy::load('files/test.yaml');
        
        Confy::set('ttt.xxx.yyy.zzz.Z', 111);
        Confy::set('ttt.xxx.yyy.zzz.ZZ', 222);
        Confy::set('ttt.xxx.yyy.zzz.ZZZ', 333);
        Confy::set('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y', 123456789);
        
        Confy::unset('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y');
        
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y'));
        
        Confy::unset('ttt.xxx.yyy.zzz.ZZZZ.q');
        
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t.y'));
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w.e.r.t'));
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w.r'));
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q.w'));
        $this->assertFalse(Confy::has('ttt.xxx.yyy.zzz.ZZZZ.q'));
        
        $data = Confy::get('ttt.xxx.yyy.zzz.ZZZZ');
        
        $this->assertIsArray($data);
        $this->assertTrue(empty($data));
    }

}