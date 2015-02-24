<?php


namespace Skully\Core\Theme;

use Skully\App\Helpers\FileHelper;
use Skully\Exceptions\ThemeFileNotFoundException;

/**
 * Class Theme
 * @package Skully\Core\Theme
 * Theme related functions
 */
class Theme implements ThemeInterface {
    /**
     * @var string
     * BasePath of main app, ended with DIRECTORY_SEPARATOR.
     */
    protected $basePath = DIRECTORY_SEPARATOR;

    /**
     * @var string
     * Theme name. Default theme is 'default'.
     */
    protected $themeName = 'default';

    /**
     * @var string
     * BasePath of skully app, ended with DIRECTORY_SEPARATOR.
     */
    protected $skullyBasePath = '';

    /**
     * @var string
     * Url of public directory of your app, ended with '/'.
     * On app setting with virtual host where public directory is the DocumentRoot,
     * you may want to put your index.php to this page
     * and set $publicBaseUrl to http://yoursite.wow/
     * With virtualhost setting, you cannot use Skully theme directory.
     */
    protected $publicBaseUrl = 'http://yoursite.wow/public/';

    /**
     * @var string
     * Application's name, used in directory name to store languages and views.
     */
    protected $appName = 'App';

    protected $dirs = '';

    /**
     * @param string $basePath Base path of the main app.
     * @param string $baseUrl path to base url of the main app.
     * @param string $publicDirectory name of public directory.
     * @param string $themeName Selected theme name.
     * @param string $appName App's name, used as directory name storing languages and views.
     * @param \Skully\ApplicationInterface $app Optional Skully App
     * todo: param boolean $virtual Set to true for applications with virtual server setting. When true, use baseURl without publicDirectory for public Url.
     */
    public function __construct($basePath, $baseUrl, $publicDirectory, $themeName, $appName, $app = null)
    {
        $basePath = str_replace('/', DIRECTORY_SEPARATOR, $basePath);
        if (substr($basePath, -1, 1) != DIRECTORY_SEPARATOR) {
            $basePath .= DIRECTORY_SEPARATOR;
        }
        // todo: virtual server setup
//        if ($virtual) {
//            $this->publicBaseUrl = $baseUrl;
//        }
//        else {
        $this->publicBaseUrl = $baseUrl . $publicDirectory . '/';
//        }
        $this->basePath = $basePath . $publicDirectory . DIRECTORY_SEPARATOR;
        $this->themeName = $themeName;

        $this->app = $app;
        $this->appName = $appName;
    }

    /**
     * @param $path
     * @param boolean $hideErrors True to hide errors from file not found.
     * @return string
     * @throws ThemeFileNotFoundException
     * Get absolute path of file inside theme directory.
     * Throw ThemeFileNotFoundException Exception when not found
     */
    public function getPath($path = '', $hideErrors = false, $useAppName = false)
    {
        $dirs = $this->getDirs();
        $fullPaths = array();
        $fullPath = '';
        foreach($dirs as $key => $dir) {
            $thePath = $path;
            if ($key == 'main' || $key == 'default') {
                if ($useAppName) {
                    $thePath = $this->appName . DIRECTORY_SEPARATOR . $path;
                }
            }
            $fullPaths[] = $dir . DIRECTORY_SEPARATOR . $thePath;
            if (!file_exists(rtrim($fullPath, DIRECTORY_SEPARATOR))) {
                $fullPath = $dir . DIRECTORY_SEPARATOR . $thePath;
            }
        }
        if (!file_exists(rtrim($fullPath, DIRECTORY_SEPARATOR)) && !$hideErrors) {
            throw new ThemeFileNotFoundException("Theme file '$fullPath' not found after searching at these locations: \n".
                implode("\n", $fullPaths)
            );
        }
        return $fullPath;
    }

    public function setDirs($dirs)
    {
        $this->dirs = $dirs;
    }

    public function setDir($dir, $key)
    {
        $this->dirs[$key] = $dir;
    }

    /**
     * @return Array
     */
    public function getDirs()
    {
        return $this->dirs;
    }

    public function getDir($key)
    {
        return $this->dirs[$key];
    }

    /**
     * @param string $path
     * @param bool $hideErrors
     * @return string
     */
    public function getAppPath($path = '', $hideErrors = false)
    {
        return $this->getPath($path, $hideErrors, true);
    }

    /**
     * @param string $path
     * @param array $params
     * @param boolean $hideErrors True to hide errors from file not found.
     * @param boolean $ssl When true or false force to change security mode (http or https).
     * @throws \Skully\Exceptions\ThemeFileNotFoundException Given a path, must find that path within the themes/ directory
     * @return string
     */
    public function getUrl($path = '', $params = array(), $hideErrors = false, $ssl = null)
    {
        $fullUrl = $path;
        $fullPath = $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path;
        if (!file_exists(FileHelper::replaceSeparators($fullPath))) {
            $fullPath = $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . $path;
            if (!file_exists(FileHelper::replaceSeparators($fullPath))) {
            }
            else {
                $fullUrl = $this->getPublicBaseUrl($ssl) . 'default/' . $path;
            }
        }
        else {
            $fullUrl = $this->getPublicBaseUrl($ssl) . $this->themeName . '/' . $path;
        }

        if (!file_exists(FileHelper::replaceSeparators($fullPath)) && !$hideErrors) {
            throw new ThemeFileNotFoundException("Theme file not found after searching at these locations: \n".
                $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . FileHelper::replaceSeparators($path) . "\n".
                $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . FileHelper::replaceSeparators($path) . "\n"
            );
        }
        if (empty($params)) {
            return $fullUrl;
        }
        else {
            return $fullUrl . '?' . http_build_query($params);
        }
    }

    /**
     * Get path to public directory e.g. /appname/public/
     * @return string
     */
    public function getBasePath()
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $this->basePath);
    }

    /**
     * Convenience method, alias for getBasePath
     * @return string
     */
    public function getPublicBasePath()
    {
        return $this->getBasePath();
    }

    /**
     * @return string
     * @param boolean $ssl When true or false force to change security mode (http or https).
     */
    public function getPublicBaseUrl($ssl = null)
    {
        $url = $this->publicBaseUrl;
        if ($ssl === true) {
            $url = str_replace('http://', 'https://', $url);
        }
        elseif ($ssl === false) {
            $url = str_replace('https://', 'http://', $url);
        }
        return $url;
    }

    /**
     * @return string
     */
    public function getThemeName()
    {
        return $this->themeName;
    }


}