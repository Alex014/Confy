<?php
namespace Confy;

class Confy 
{
    private static $config;
    
    public static function getAll() {
        return self::$config;
    }
    
    /**
     * Load configuration from file
     * Multiple configurations can be loaded
     * @param string $filename
     * @throws \Exception
     */
    public static function load(string $filename) 
    {
        $fileparts = explode('.', $filename);
        $ext = $fileparts[count($fileparts) - 1];
        $ext = ucfirst($ext);
        
        $classname = '\\Confy\\Parser\\'.$ext;
        
        if(class_exists($classname)) {
            $classParser = new $classname();
            
            if(!isset(self::$config)) {
                self::$config = [];
            }
                
            self::$config = array_merge(self::$config, $classParser->parseFile($filename));
        } else {
            throw new \Exception("Unable to load class for extension $ext !");
        }
    }

    /**
     * Check configuration key existance
     * @param string $name
     * @return boolean
     */
    public static function has(string $name) 
    {
        $aname = explode('.', $name);
        $config = self::$config;
        
        foreach ($aname as $value) {
            if(!isset($config[$value])) {
                return false;
            } else {
                $config = $config[$value];
            }
        }
        
        return true;
    }
    
    /**
     * Get configuration value
     * @param string $name
     * @return type
     * @throws \Exception
     */
    public static function get(string $name) 
    {
        $key_list = explode('.', $name);
        $config = self::$config;
        
        foreach ($key_list as $key) {
            if(isset($config[$key])) {
                $config = $config[$key];
            } else {
                throw new \Exception("Param '$name' not found in config");
            }
        }
        
        return $config;
    }
    
    private static function _set(&$config_part, $key_list, $value) 
    {
        if(count($key_list) == 1) {
            if(empty($config_part) || !is_array($config_part)) {
                $config_part = [];
            }
            $config_part[$key_list[0]] = $value;
        } else {
            if(empty($config_part[$key_list[0]]) || !is_array($config_part[$key_list[0]])) {
                $config_part[$key_list[0]] = [];
            }
            self::_set($config_part[$key_list[0]], 
                    array_slice($key_list, 1, count($key_list) - 1), 
                    $value);
        }
    }
    
    /**
     * Set configuration value
     * @param string $name
     * @param type $value
     */
    public static function set(string $name, $value) 
    {
        $key_list = explode('.', $name);
        
        self::_set(self::$config, $key_list, $value);
    }
    
    private static function _unset(&$config_part, $key_list) 
    {
        if(count($key_list) == 1) {
            unset($config_part[$key_list[0]]);
        } else {
            self::_unset($config_part[$key_list[0]], 
                    array_slice($key_list, 1, count($key_list) - 1));
        }
    }
    
    /**
     * Delete configuration value
     * @param string $name
     */
    public static function unset(string $name) 
    {
        $key_list = explode('.', $name);
        
        self::_unset(self::$config, $key_list);
    }
}
