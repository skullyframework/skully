<?php
namespace Skully\Commands;

use Skully\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
class SchemaCommand extends Command {

    protected function configure()
    {
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
    {
        $argv = $input->getArguments();
        unset($argv['command']);
        $argv = array_values($argv);
        array_unshift($argv, './ruckus.php');
        $_SERVER["argv"] = $argv;

        $dbConfig = $this->app->config('dbConfig');
        $ruckusingConfig = array_merge(array(
            'db' => array(
                'development' => array(
                    'type' => $dbConfig['type'],
                    'database' => $dbConfig['dbname'],
                    'host' => $dbConfig['host'],
                    'port' => $dbConfig['port'],
                    'user' => $dbConfig['user'],
                    'password' => $dbConfig['password']
                )
            )
        ), $this->app->config('ruckusingConfig'));
        $main = new \Ruckusing_FrameworkRunner($ruckusingConfig, $argv);
        echo $main->execute();
    }

} 