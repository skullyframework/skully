<?php
/**
 * Created by Trio Digital Agency.
 * Date: 3/2/15
 * Time: 3:55 PM
 */

namespace Skully\Tests\Commands;


use Skully\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewCommand extends Command {
    protected function configure()
    {
        $this->setName("testcommand")
            ->setDescription("Test command. See if this is successfully added to Skully's command list.")
            ->setDefinition(array(
                new InputArgument('string', InputArgument::REQUIRED, 'String')
            ))
            ->setHelp(<<<EOT
Test command. See if this is successfully added to Skully's command list.

Usage:

<info>./console testcommand string <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Input was: " . $input->getArgument('string'));
    }
} 