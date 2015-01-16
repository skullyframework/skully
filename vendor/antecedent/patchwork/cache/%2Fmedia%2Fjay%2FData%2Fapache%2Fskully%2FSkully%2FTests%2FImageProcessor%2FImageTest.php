<?php


namespace Tests\Features; \Patchwork\Interceptor\applyScheduledPatches();

require_once(dirname(__FILE__) . '/../DatabaseTestCase.php');
use Skully\App\Helpers\FileHelper;
use Skully\Library\ImageProcessor\ImageProcessor;

class ImageTest extends \PHPUnit_Framework_TestCase {
    public function testResizeWithMaxOnly()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $originalPath = dirname(__FILE__).'/original.jpg';
        $this->assertTrue(file_exists($originalPath));
        $path = ImageProcessor::resize($originalPath, array(
            'maxOnly' => true,
            'w' => 300,
            'resultDir' => dirname(__FILE__).'/',
            'outputFilename' => 'resizeSmall.jpg'
        ));
        $imagesize = getimagesize($path);
        $this->assertEquals(300,$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).'/resizeSmall.jpg'), $path);

        $path = ImageProcessor::resize($originalPath, array(
            'maxOnly' => true,
            'w' => 1500,
            'resultDir' => dirname(__FILE__).'/',
            'outputFilename' => 'resizedOriginal.jpg'
        ));
        $imagesize = getimagesize($path);
        $originalImagesize = getimagesize($originalPath);
        $this->assertEquals($originalImagesize[0],$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).'/resizedOriginal.jpg'), $path);
    }
    public function testResizedWithoutMaxOnly()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $originalPath = dirname(__FILE__).'/original.jpg';
        $path = ImageProcessor::resize($originalPath, array(
            'w' => 1500,
            'resultDir' => dirname(__FILE__).'/',
            'outputFilename' => 'stretched.jpg'
        ));
        $imagesize = getimagesize($path);
        $this->assertEquals(1500,$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).'/stretched.jpg'), $path);
    }
}\Patchwork\Interceptor\applyScheduledPatches();