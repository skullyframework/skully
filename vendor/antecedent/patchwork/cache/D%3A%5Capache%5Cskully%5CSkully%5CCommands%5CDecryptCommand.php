<?php
namespace Skully\Commands; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use \Skully\Library\EncryptionClass\EncryptionClass;

class DecryptCommand extends Command {

    protected function configure()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $adjustments = 2.21;
        $modulus = 2.21;

        $this->setName("skully:decrypt")
            ->setDescription("Decrypt a passed string (encryptable with skully:encrypt command).")
            ->setDefinition(array(
                new InputArgument('string', InputArgument::REQUIRED, 'String to decrypt'),
                new InputOption('salt', 's', InputOption::VALUE_OPTIONAL, 'Password salt. Set in application config (\'globalSalt\') or override here.', $this->app->config('globalSalt')),
                new InputOption('adjust', 'a', InputOption::VALUE_OPTIONAL, 'Set adjustments value to obfuscate the password with. Defaults to ' . $adjustments, $adjustments),
                new InputOption('modulus', 'm', InputOption::VALUE_OPTIONAL, 'Set modulus value to further obfuscate the password. Defaults to ' . $modulus, $modulus)
            ))
            ->setHelp(<<<EOT
Encrypt a passed string

Usage:

<info>./console skully:decrypt string <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $salt = $input->getOption('salt');
        $adjustments = $input->getOption('adjust');
        $modulus = $input->getOption('modulus');

        $crypt = new EncryptionClass();

        $crypt->setAdjustment($adjustments); // 1st adjustment value (optional)
        $crypt->setModulus($modulus); // 2nd adjustment value (optional)

        $output->writeln($crypt->decrypt($salt, $input->getArgument('string')));


    }

}\Patchwork\Interceptor\applyScheduledPatches(); 