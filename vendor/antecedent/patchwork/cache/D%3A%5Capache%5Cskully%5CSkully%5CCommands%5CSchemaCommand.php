<?php
namespace Skully\Commands; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
class SchemaCommand extends Command {

    protected function configure()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->setName("skully:schema")
            ->setDescription("Run schema-related commands (with Ruckusing module)")
            ->setDefinition(array(
                new InputArgument('input', InputArgument::REQUIRED, 'Input to run at Ruckusing module'),
                new InputArgument('input1', InputArgument::OPTIONAL, 'Additional input to run at Ruckusing module'),
                new InputArgument('input2', InputArgument::OPTIONAL, 'Additional input to run at Ruckusing module')
            ))
            ->setHelp(<<<EOT
Run schema-related commands

Usage:

<info>./console skully:schema db:migrate <env></info>
<info>./console skully:schema db:generate model <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $argv = $input->getArguments();
        unset($argv['command']);
        $argv = array_values($argv);
        array_unshift($argv, './ruckus.php');
        $_SERVER["argv"] = $argv;

        $dbConfig = $this->app->config('dbConfig');
        $developmentConfig = array(
            'type' => $dbConfig['type'],
            'database' => $dbConfig['dbname'],
            'host' => $dbConfig['host'],
            'port' => $dbConfig['port'],
            'user' => $dbConfig['user'],
            'password' => $dbConfig['password'],
            'charset' => $dbConfig['charset']
        );
        if (!empty($dbConfig['directory'])) {
            $developmentConfig['directory'] = $dbConfig['directory'];
        }
        $ruckusingConfig = array_merge(array(
            'db' => array(
                'development' => $developmentConfig
            )
        ), $this->app->config('ruckusingConfig'));
        $main = new \Ruckusing_FrameworkRunner($ruckusingConfig, $argv);
        echo $main->execute();
    }

}\Patchwork\Interceptor\applyScheduledPatches(); 