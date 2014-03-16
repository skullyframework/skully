<?php
/**
 * Created by Trio Design Team P (jay@tgitriodesign.com).
 * Date: 3/16/14
 * Time: 8:29 PM
 */

namespace Skully\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

define("BASE_PATH", realpath(dirname(__FILE__)) . '/../../');
$serverName = 'localhost';
include(BASE_PATH . 'config/config/config.php');
include(BASE_PATH . 'config/config/commonConfig.php');
include(BASE_PATH . 'library/encryptionClass/EncryptionClass.php');

$crypt = new \Skully\Library\EncryptionClass\EncryptionClass();

$crypt->setAdjustment(2.21); // 1st adjustment value (optional)
$crypt->setModulus(4); // 2nd adjustment value (optional)

if (!empty($argv) && !empty($argv[1])) {
    if ($argv[1] == '-h' || $argv[1] == '--help') {
        echo "Usage: ./encrypt.php [string_to_encrypt]\n";
    }
    else {
        echo $crypt->encrypt($config['salt'], $argv[1])."\n";
    }
}

class PassEncryptor extends Command {
    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }

} 