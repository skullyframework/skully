<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/19/14
 * Time: 12:34 AM
 */

namespace Skully\Core;

use Skully\ApplicationInterface;

class RepositoryFactory {
    /**
     * @var array
     */
    private static $config = array('namespace' => 'App');

    /**
     * @param $key
     * @param $value
     */
    public static function setConfig($key, $value) {
        self::$config[$key] = $value;
    }
    /**
     * Given "Model", return App\Models\Repositories\ModelRepository object.
     * @param ApplicationInterface $app
     * @param string $repositoryStr
     * @return RepositoryInterface
     */
    public static function create(ApplicationInterface $app, $repositoryStr = '')
    {
        $str_r = explode('\\', $repositoryStr);
        if (!empty($str_r)) {
            foreach ($str_r as $index=>$str) {
                $str = ucfirst($str);
                $str_r[$index] = $str;
            }
            $repositoryStr = implode('\\', $str_r);
        }
        if ($repositoryStr[0] != '\\') {
            $repositoryStr = ucfirst($repositoryStr);
        }
        else {
            $repositoryStr = ucfirst(substr($repositoryStr,1));
        }
        $repositoryStrComplete = self::$config['namespace'].'\Models\Repositories\\'.$repositoryStr."Repository";

        /* @var $repository RepositoryInterface */
        $repository = new $repositoryStrComplete($app);
        return $repository;
    }
} 