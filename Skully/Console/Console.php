<?php


namespace Skully\Console;


use Skully\Application;
use Skully\Core\ApplicationAware;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class Console extends ApplicationAware {
    protected $test = false;
    public function __construct($test = false) {
        $this->test = $test;
    }
    public function run(Application $app, $inputString = '') {
        $input = null;
        if (!empty($inputString)) {
            $input = new StringInput($inputString);
        }
        $this->setApp($app);
        $consoleApp = new ConsoleApplication();
        $classes = array(
            '\Skully\Commands\EncryptCommand'
        );
        if (!empty($classes)) {
            foreach($classes as $class) {
                /** @var \Skully\Console\Command $newClass */
                $newClass = new $class($app);
                $consoleApp->add($newClass);
            }
        }
        $output = null;
        if ($this->test) {
            $consoleApp->setAutoExit($this->autoExit);
            $output = new BufferedOutput();
        }
        $consoleApp->run($input, $output);
        return $output;
    }
} 