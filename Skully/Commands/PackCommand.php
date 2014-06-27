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
        $readme = file_get_contents(__DIR__.'/../Library/pack/README');
        $this->setName("skully:pack")

  ->setDescription("Pack javascript file (or css, but we'd prefer compass for that)")
            ->setDefinition(array(
                new InputArgument('input', InputArgument::REQUIRED, 'Input to run with pack tool.')
            ))
            ->setHelp(<<<EOT
Pack javascript file (or css, but we'd prefer compass for that).

Usage:
<info>./console skully:pack PATH_TO_PACKER_CONFIG</info>
You may specify multiple files.

Information from Pack's README:
$readme
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argv = $input->getArguments();
        unset($argv['command']);
        $argv = array_values($argv);
        if (!empty($argv)) {
            foreach ($argv as $i => $arg) {
                $argv[$i] = getcwd().DIRECTORY_SEPARATOR.$arg;
            }
        }
        print_r($argv);

        $_SERVER["argv"] = $argv;

        $output = array();

        $packPath = realpath(__DIR__.'/../Library/pack/pack');
        $runme = 'ruby ' . $packPath. ' '.implode(' ', $argv);
        echo "running pack ($runme)...\n";
        exec($runme, $output);
        echo implode("\n",$output)."\n";
    }

} 
