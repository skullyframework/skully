<?php
namespace Skully\App\Helpers;

use Exception;
use Skully\Core\ApplicationAwareHelper;

class Csrf extends ApplicationAwareHelper {
    public static function get_token_id() {
        /*if (isset($_SESSION['token_id'])) {
            return $_SESSION['token_id'];
        }
        else {
            $_SESSION['token_id']   = self::random(25);
            return $_SESSION['token_id'];
        }*/

        return '__token';
    }

    public static function get_token() {
        if (isset($_SESSION['token_value'])) {
            return $_SESSION['token_value'];
        }
        else {
            $_SESSION['token_value']   = self::random(25);
            return $_SESSION['token_value'];
        }

    }

    public static function check_valid($flag) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $flag) {
            if (!isset($_POST[self::get_token_id()]) || $_POST[self::get_token_id()] != self::get_token()) {
                throw new Exception('Invalid CSRF!');
            }

            unset($_SESSION['token_id']);
            unset($_SESSION['token_value']);
        }
    }

    private static function random($len) {
        $return = '';
        for ($i = 0; $i < $len; ++$i) {
            if (!isset($urandom)) {
                if ($i % 2 == 0) {
                    mt_srand(time() % 2147 * 1000000 + (double)microtime() * 1000000);
                }
                $rand = 48 + mt_rand() % 64;
            }
            else {
                $rand = 48 + ord($urandom[$i]) % 64;
            }

            if ($rand > 57) $rand += 7;
            if ($rand > 90) $rand += 6;

            if ($rand == 123) $rand = 52;
            if ($rand == 124) $rand = 53;

            $rand += 3333;
            $return .= chr($rand);
        }
        return $return;
    }
}