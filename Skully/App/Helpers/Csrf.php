<?php
namespace Skully\App\Helpers;


use Skully\Core\ApplicationAwareHelper;

class Csrf extends ApplicationAwareHelper {
    public static function get_token_id() {
        $token_id = self::$app->getSession()->get('token_id');
        if (isset($token_id)) {
            return $token_id;
        }
        else {
            $token_id = self::random(10);
            self::$app->getSession()->set('token_id', $token_id);
            return $token_id;
        }
    }

    public static function get_token() {
        $token_value = self::$app->getSession()->get('token_value');
        if (isset($token_value)) {
            return $token_value;
        }
        else {
            $token_value = hash('sha256', self::random(500));
            self::$app->getSession()->set('token_value', $token_value);
            return $token_value;
        }

    }

    public static function check_valid($method) {
        if ($method == 'post' || $method == 'get') {
            $post = $_POST;
            $get = $_GET;
            if (isset(${$method}[self::get_token_id()]) && (${$method}[self::get_token_id()] == self::get_token())) {
                self::$app->getSession()->remove('token_id');
                self::$app->getSession()->remove('token_value');
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public static function form_names($names, $regenerate) {
        $values = array();
        foreach ($names as $n) {
            if ($regenerate == true) {
                unset($_SESSION[$n]);
            }
            $s = isset($_SESSION[$n]) ? $_SESSION[$n] : self::random(10);
            $_SESSION[$n] = $s;
            $values[$n] = $s;
        }
        return $values;
    }

    private static function random($len) {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $byteLen = intval(($len / 2) + 1);
            $return = substr(bin2hex(openssl_random_pseudo_bytes($byteLen)), 0, $len);
        }
        else if (@is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $urandom = fread($f, $len);
            fclose($f);
            $return = '';
        }

        if (empty($return)) {
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
        }
        return $return;
    }
}