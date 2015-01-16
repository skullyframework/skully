<?php


namespace Skully\Console; \Patchwork\Interceptor\applyScheduledPatches();


use Skully\Application;
use Skully\Core\ApplicationAware;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class Console extends ApplicationAware {
    protected $test = false;
    protected $consoleApp;
    protected $app;
    public function __construct(Application $app, $test = false) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->app = $app;
        $this->test = $test;
        $this->consoleApp = new ConsoleApplication();
        $classes = array(
            '\Skully\Commands\EncryptCommand',
            '\Skully\Commands\DecryptCommand',
            '\Skully\Commands\SchemaCommand',
            '\Skully\Commands\PackCommand'
        );
        $this->addCommands($classes);
    }
    public function addCommands($commands = null) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);

        if (!empty($commands)) {
            foreach($commands as $command) {
                /** @var \Skully\Console\Command $newClass */
                $newCommand = new $command($this->app);
                $this->consoleApp->add($newCommand);
            }
        }
    }
    public function run($inputString = '') {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
}\Patchwork\Interceptor\applyScheduledPatches(); 