<?php
namespace Skully\Commands;

use Skully\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use \Skully\Library\EncryptionClass\EncryptionClass;

class EncryptCommand extends Command {

    protected function configure()
    {
        $adjustments = 2.21;
        $modulus = 2.21;

        $this->setName("skully:encrypt")
            ->setDescription("Encrypt a passed string (decryptable with skully:decrypt command).")
            ->setDefinition(array(
                new InputArgument('password', InputArgument::REQUIRED, 'String to encrypt'),
                new InputOption('salt', 's', InputOption::VALUE_OPTIONAL, 'Password salt. Set in application config (\'globalSalt\') or override here.', $this->app->config('globalSalt')),
                new InputOption('adjust', 'a', InputOption::VALUE_OPTIONAL, 'Set adjustments value to obfuscate the password with. Defaults to ' . $adjustments, $adjustments),
                new InputOption('modulus', 'm', InputOption::VALUE_OPTIONAL, 'Set modulus value to further obfuscate the password. Defaults to ' . $modulus, $modulus)
            ))
            ->setHelp(<<<EOT
Encrypt a passed string

Usage:

<info>./console skully:encrypt password <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $salt = $input->getOption('salt');
        $adjustments = $input->getOption('adjust');
        $modulus = $input->getOption('modulus');

        $crypt = new EncryptionClass();

        $crypt->setAdjustment($adjustments); // 1st adjustment value (optional)
        $crypt->setModulus($modulus); // 2nd adjustment value (optional)

        $output->writeln($crypt->encrypt($salt, $input->getArgument('password')));


    }

} 