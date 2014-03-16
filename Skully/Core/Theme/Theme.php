<?php


namespace Skully\Core\Theme;

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
    protected $basePath = '/';

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
     * Url of public directory of Skully app, ended with '/'.
     * This should not be needed in any occassion, except for users wishing to
     * see if their quick Skully installation is successful.
     * This obviously won't work with apps with virtual host setting.
     */
    protected $skullyPublicBaseUrl = 'http://yoursite.wow/library/trio/skully/public/';

    /**
     * @var string
     * Application's name, used in directory name to store languages and views.
     */
    protected $appName = 'App';

    /**
     * @param string $basePath Base path of the main app.
     * @param string $baseUrl path to base url of the main app.
     * @param string $publicDirectory name of public directory.
     * @param string $themeName Selected theme name.
     * @param string $appName App's name, used as directory name storing languages and views.
     * @param boolean $virtual Set to true for applications with virtual server setting. When true, use baseURl without publicDirectory for public Url.
     */
    public function __construct($basePath, $baseUrl, $publicDirectory, $themeName, $appName, $virtual = false)
    {
        if (substr($basePath, -1, 1) != DIRECTORY_SEPARATOR) {
            $basePath .= '/';
        }
        if ($virtual) {
            $this->publicBaseUrl = $baseUrl;
        }
        else {
            $this->publicBaseUrl = $baseUrl . $publicDirectory . '/';
        }
        $this->basePath = $basePath . $publicDirectory . DIRECTORY_SEPARATOR;
        $this->themeName = $themeName;
        $this->skullyBasePath = realpath(dirname(__FILE__).'/../../../').DIRECTORY_SEPARATOR . $publicDirectory . DIRECTORY_SEPARATOR;
        $skullyRelativePath = str_replace($basePath, '', $this->getSkullyBasePath());
        $skullyRelativePath = str_replace(DIRECTORY_SEPARATOR, '/', $skullyRelativePath);
        $this->skullyPublicBaseUrl = $baseUrl.$skullyRelativePath;
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
    public function getPath($path = '', $hideErrors = false)
    {
        $fullPath = $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path;
        if (!file_exists($fullPath)) {
            $fullPath = $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . $path;
        }
        if (!file_exists($fullPath)) {
            $fullPath = $this->getSkullyPath($path);
        }
        if (!file_exists($fullPath) && !$hideErrors) {
            throw new ThemeFileNotFoundException("Theme file not found after searching at these four locations: \n".
                $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getSkullyBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getSkullyBasePath() . 'default' . DIRECTORY_SEPARATOR . $path
            );
        }
        return $fullPath;
    }

    /**
     * @param string $path
     * @param bool $hideErrors
     * @return string
     */
    public function getAppPath($path = '', $hideErrors = false)
    {
        return $this->getPath($this->appName . DIRECTORY_SEPARATOR . $path, $hideErrors);
    }

    /**
     * @param $path
     * @return string
     */
    protected function getSkullyPath($path)
    {
        $fullPath = $this->getSkullyBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path;
        if (!file_exists($fullPath)) {
            $fullPath = $this->getSkullyBasePath() . 'default' . DIRECTORY_SEPARATOR . $path;
        }
        return $fullPath;
    }


    /**
     * @param string $path
     * @param array $params
     * @param boolean $hideErrors True to hide errors from file not found.
     * @throws \Skully\Exceptions\ThemeFileNotFoundException Given a path, must find that path within the themes/ directory
     * @return string
     */
    public function getUrl($path = '', $params = array(), $hideErrors = false)
    {
        $fullUrl = $path;
        $fullPath = $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path;
        if (!file_exists($fullPath)) {
            $fullPath = $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . $path;
            if (!file_exists($fullPath)) {

                $fullPath = $this->getSkullyBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path;
                if (!file_exists($fullPath)) {
                    $fullPath = $this->getSkullyBasePath() . 'default' . DIRECTORY_SEPARATOR . $path;
                    if (file_exists($fullPath)) {
                        $fullUrl = $this->getSkullyPublicBaseUrl() . 'default/' . $path;
                    }
                }
                else {
                    $fullUrl = $this->getSkullyPublicBaseUrl() . $this->themeName . '/' . $path;
                }
            }
            else {
                $fullUrl = $this->getPublicBaseUrl() . 'default/' . $path;
            }
        }
        else {
            $fullUrl = $this->getPublicBaseUrl() . $this->themeName . '/' . $path;
        }

        if (!file_exists($fullPath) && !$hideErrors) {
            throw new ThemeFileNotFoundException("Theme file not found after searching at these four locations: \n".
                $this->getBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getBasePath() . 'default' . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getSkullyBasePath() . $this->themeName . DIRECTORY_SEPARATOR . $path . "\n".
                $this->getSkullyBasePath() . 'default' . DIRECTORY_SEPARATOR . $path
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
        return $this->basePath;
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
     */
    public function getSkullyBasePath()
    {
        return $this->skullyBasePath;
    }

    /**
     * @return string
     */
    public function getPublicBaseUrl()
    {
        return $this->publicBaseUrl;
    }
    
    /**
     * @return string
     */
    public function getSkullyPublicBaseUrl()
    {
        return $this->skullyPublicBaseUrl;
    }

    /**
     * @return string
     */
    public function getThemeName()
    {
        return $this->themeName;
    }


} 