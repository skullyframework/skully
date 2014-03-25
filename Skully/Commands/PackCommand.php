<?php
namespace Skully\Commands;

use Skully\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PackCommand extends Command {

    protected function configure()
    {
        $this->setName("skully:pack")
            ->setDescription("Pack javascript file (or css, but we'd prefer compass for that)")
            ->setDefinition(array(
                new InputArgument('input', InputOption::VALUE_REQUIRED, 'Input to run at Ruckusing module', '')
            ))
            ->setHelp(<<<EOT
Pack javascript file (or css, but we'd prefer compass for that).

Usage:

<info>./console skully:packjs db:migrate <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argv = $input->getArguments();
        unset($argv['command']);
        $argv = array_values($argv);

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