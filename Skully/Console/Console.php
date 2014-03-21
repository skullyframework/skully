<?php


namespace Skully\Console;


use Skully\Application;
use Skully\Core\ApplicationAware;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class Console extends ApplicationAware {
    protected $test = false;
    protected $consoleApp;
    protected $app;
    public function __construct(Application $app, $test = false) {
        $this->app = $app;
        $this->test = $test;
        $this->consoleApp = new ConsoleApplication();
        $classes = array(
            '\Skully\Commands\EncryptCommand',
            '\Skully\Commands\DecryptCommand',
            '\Skully\Commands\SchemaCommand'
        );
        $this->addCommands($classes);
    }
    public function addCommands($commands = null) {

        if (!empty($commands)) {
            foreach($commands as $command) {
                /** @var \Skully\Console\Command $newClass */
                $newCommand = new $command($this->app);
                $this->consoleApp->add($newCommand);
            }
        }
    }
    public function run($inputString = '') {
        $input = null;
        if (!empty($inputString)) {
            $input = new StringInput($inputString);
        }

        $output = null;
        if ($this->test) {
            $this->consoleApp->setAutoExit(!$this->test);
            $output = new BufferedOutput();
        }
        $this->consoleApp->run($input, $output);
        return $output;
    }
} 