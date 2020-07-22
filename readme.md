## Confy the configuration utility
### Instalation and usage
`composer require alex014/confy`
```
<?php
use \Confy\Confy;
Confy::load('config/database.ini');
echo Confy::get('login');
print_r(Confy::getAll());
```
### Methods
* `Confy::load(string $filename)` load configuration file (ini, json, php, yaml formats are supported), 
many configuration files can be loaded
* `Confy::get(string $name)` get configuration value
* `Confy::has(string $name)` check configuration key existance
* `Confy::set(string $name, $value)` set configuration value
* `Confy::unset(string $name)` delete configuration value
* `Confy::getAll()` 
### Plugins
* All plugins are located in `/src/Parser` directory.
* All plugins must be named by Capitalized file extension (Ini.php -> .ini).
* All plugin classes must implement `\Confy\Interfaces\Parser` interface
### Run tests
* Install PHPUnit `wget -O phpunit https://phar.phpunit.de/phpunit-9.phar` and `chmod +x phpunit`
* Run tests `./phpunit ConfyTest.php`
### License
MIT license