<?php


namespace Tests\Features;

require_once(dirname(__FILE__) . '/../DatabaseTestCase.php');
use Skully\App\Helpers\FileHelper;
use Skully\Library\ImageProcessor\ImageProcessor;

class ImageTest extends \PHPUnit_Framework_TestCase {
    /**
     * maxOnly resizes only when target size is smaller than original size.
     */
    public function testResizeWithMaxOnly()
    {
        unlink(dirname(__FILE__).DIRECTORY_SEPARATOR.'resizedOriginal.jpg');
        unlink(dirname(__FILE__).DIRECTORY_SEPARATOR.'resizeSmall.jpg');
        $originalPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'original.jpg';
        $this->assertTrue(file_exists($originalPath));
        $originalImagesize = getimagesize($originalPath);
        $this->assertEquals(1280, $originalImagesize[0]);

        $path = ImageProcessor::resize($originalPath, array(
            'maxOnly' => true,
            'w' => 300,
            'resultDir' => dirname(__FILE__).DIRECTORY_SEPARATOR,
            'outputFilename' => 'resizeSmall.jpg'
        ));
        $imagesize = getimagesize($path);
        $this->assertEquals(300,$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).DIRECTORY_SEPARATOR.'resizeSmall.jpg'), $path);

        $path = ImageProcessor::resize($originalPath, array(
            'maxOnly' => true,
            'w' => 1500,
            'resultDir' => dirname(__FILE__).'/',
            'outputFilename' => 'resizedOriginal.jpg'
        ));
        $imagesize = getimagesize($path);
        $this->assertEquals($originalImagesize[0] ,$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).DIRECTORY_SEPARATOR.'resizedOriginal.jpg'), $path);
    }
    public function testResizedWithoutMaxOnly()
    {
        unlink(dirname(__FILE__).DIRECTORY_SEPARATOR.'stretched.jpg');
        $originalPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'original.jpg';
        $path = ImageProcessor::resize($originalPath, array(
            'maxOnly' => false,
            'w' => 1500,
            'resultDir' => dirname(__FILE__).DIRECTORY_SEPARATOR,
            'outputFilename' => 'stretched.jpg'
        ));
        $imagesize = getimagesize($path);
        $this->assertEquals(1500,$imagesize[0]);
        $this->assertEquals(FileHelper::replaceSeparators(dirname(__FILE__).DIRECTORY_SEPARATOR.'stretched.jpg'), $path);
    }

    public function testIsWindows()
    {
        $this->assertEquals(true, true);
        echo "If your OS is Windows, the following should return True: \n";
        echo ImageProcessor::isWindows();
    }
}