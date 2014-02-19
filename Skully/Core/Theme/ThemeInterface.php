<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/30/13
 * Time: 1:14 PM
 */

namespace Skully\Core\Theme;


use Skully\Exceptions\ThemeFileNotFoundException;

/**
 * Interface ThemeInterface
 * @package Skully\Core\Theme
 * Theme object manages all theme-related functions within Skully framework.
 * For example, given a relative path to a file, can this Theme object get the absolute path / url
 * into it?
 */
interface ThemeInterface {
    /**
     * @param string $basePath Base path of the main app.
     * @param string $baseUrl path to base url of the main app.
     * @param string $publicDirectory name of public directory.
     * @param string $themeName Selected theme name.
     * @param string $appName App's name, used as directory name storing languages and views.
     * @param boolean $virtual Set to true for applications with virtual server setting. When true, use baseURl without publicDirectory for public Url.
     */
    public function __construct($basePath, $baseUrl, $publicDirectory, $themeName, $appName, $virtual = false);

    /**
     * @param $path
     * @param boolean $hideErrors True to hide errors from file not found.
     * @return string
     * @throws ThemeFileNotFoundException
     * Get absolute path of file inside theme directory.
     * Throw ThemeFileNotFoundException Exception when not found
     */
    public function getPath($path = '', $hideErrors = false);

    public function getAppPath($path = '', $hideErrors = false);

    /**
     * @param string $path
     * @param array $params
     * @param boolean $hideErrors True to hide errors from file not found.
     * @return string
     */
    public function getUrl($path = '', $params = array(), $hideErrors = false);

    /**
     * Get path to public directory e.g. /appname/public/
     * @return string
     */
    public function getBasePath();

    /**
     * Convenience method, alias for getBasePath
     * @return string
     */
    public function getPublicBasePath();

    /**
     * @return string
     */
    public function getPublicBaseUrl();

    /**
     * @return string
     */
    public function getSkullyBasePath();

    /**
     * @return string
     */
    public function getSkullyPublicBaseUrl();

    /**
     * @return string
     */
    public function getThemeName();
} 