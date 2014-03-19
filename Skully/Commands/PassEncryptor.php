<?php
namespace Skully\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use \Skully\Library\EncryptionClass\EncryptionClass;

class PassEncryptorCommand extends Command {
    protected function configure()
    {
        $crypt = new EncryptionClass();

        $crypt->setAdjustment(2.21); // 1st adjustment value (optional)
        $crypt->setModulus(4); // 2nd adjustment value (optional)

        if (!empty($argv) && !empty($argv[1])) {
            if ($argv[1] == '-h' || $argv[1] == '--help') {
                echo "Usage: ./encrypt.php [string_to_encrypt]\n";
            }
            else {
                echo $crypt->encrypt($this->app->getConfig('salt'), $argv[1])."\n";
            }
        }

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }

} 