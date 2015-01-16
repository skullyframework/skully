<?php
 \Patchwork\Interceptor\applyScheduledPatches();/**
 * @param $path
 * @return mixed
 * Replacement of realpath method to work with vfsStream
 */
use \org\bovigo\vfs\vfsStream;

$__handle = null;

function setRealpath()
{$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
    global $__handle;
    $__handle = Patchwork\replace("Skully\\Application::getRealpath", function($path)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if (substr($path, 0, 3) == 'vfs') {
            return $path;
        }
        else {
            $originalPath = realpath($path);
            $check = realpath(__DIR__.'/../../../');
            $check_r = explode(DIRECTORY_SEPARATOR, $check);
            if ($check_r[count($check_r)-1] == 'vendor') {
                $basePath = realpath(__DIR__.'/../../../../../');
            }
            else {
                $basePath = realpath(__DIR__.'/../../');
            }
            $newPath = str_replace($basePath, vfsStream::url('root'), $originalPath);
            return $newPath;
        }
    });
}

function unsetRealpath()
{$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
    global $__handle;
    if (!is_null($__handle)) {
        Patchwork\undo($__handle);
    }
}

/*
function realpath_custom($path) {
    if (substr($path, 0, 3) == 'vfs') {
        return $path;
    }
    else {
        $originalPath = realpath_original($path);
        $check = realpath_original(__DIR__.'/../../../');
        $check_r = explode(DIRECTORY_SEPARATOR, $check);
        if ($check_r[count($check_r)-1] == 'vendor') {
            $basePath = realpath_original(__DIR__.'/../../../../../');
        }
        else {
            $basePath = realpath_original(__DIR__.'/../../');
        }
        $newPath = str_replace($basePath, vfsStream::url('root'), $originalPath);
        return $newPath;
    }
}

function setRealpath()
{
//    echo "\nis realpath original empty?";
    if (!function_exists('realpath_original')) {
//        echo "\nyes so we rename. Is custom empty?";
        runkit_function_rename('realpath', 'realpath_original');
        if (function_exists('realpath_custom')) {
//            echo "\nyes so we rename custom to realpath";
            runkit_function_rename('realpath_custom', 'realpath');
        }
    }
}

function unsetRealpath()
{
//    echo "\nunsetrealpath, is custom empty?";
//    echo Skully\Logging\Logger::debugBacktrace(true);
    if (!function_exists('realpath_custom')) {
//        echo "\nyes so we move realpath to realpath custom";
        runkit_function_rename('realpath', 'realpath_custom');
    }
    if (!function_exists('realpath')) {
        runkit_function_rename('realpath_original', 'realpath');
    }
}
*/