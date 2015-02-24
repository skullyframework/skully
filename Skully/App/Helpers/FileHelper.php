<?php

namespace Skully\App\Helpers;

use Skully\Core\ApplicationAwareHelper;
use Skully\Library\ImageProcessor\ImageProcessor;

class FileHelper extends ApplicationAwareHelper
{
    // Save image from given image data then return its file url on success.
    // $base64 is image string passed from canvas.toDataURL()
    public static function saveImage($base64, $filePath, $fileNameNoExt){
        $matches = array();
        preg_match('/\/(.*?)\;/s', $base64, $matches);
        if(empty($matches[1])) return false;
        $ext = $matches[1];

        if(empty($ext)) return false;

        if(!is_dir($filePath))
            mkdir($filePath, 0777, true);

        $filePath = $filePath . $fileNameNoExt . "." . $ext;

        $base64 = substr($base64, strpos($base64, ",")+1);

        $res = file_put_contents($filePath, base64_decode($base64));
        if($res === false)return false;
        return $filePath;
    }

    // Validates given image data
    // $base64 is image string passed from canvas.toDataURL()
    public static function validatesImageData($base64) {
        $base64 = substr($base64, strpos($base64, ",")+1);

        $decodedData = base64_decode($base64);
        $im = @imagecreatefromstring($decodedData);
        if ($im === false) {
            return false;
        }
        else {
            return true;
        }
    }

    public static function parseBytes($size_str)
    {
        switch (substr ($size_str, -1))
        {
            case 'M': case 'm': return (int)$size_str * 1048576;
            case 'K': case 'k': return (int)$size_str * 1024;
            case 'G': case 'g': return (int)$size_str * 1073741824;
            default: return $size_str;
        }
    }

    // Save uploaded image to cache
    // can accept $_FILES['image'] as its attribute.
    // This is only used in cases where browser doesn't have File API.
    // $errors = array of errors.
    public static function saveUploadedImageToCache($file, $name, &$errors) {
        $photoData = false;
        if(!empty($file["tmp_name"])){
            if($file["type"] == "image/jpeg" ||
                $file["type"] == "image/png"){
                $filePath = self::$app->config("imagecachesPath") . $name;
                $fileUrl = self::$app->config("imagecachesUrl") . $name;
                move_uploaded_file($file["tmp_name"], $filePath);
                $photoData["path"] = $filePath;
                $photoData["url"] = $fileUrl;

                $imageProcessor = new ImageProcessor();
                $imageProcessor::resize($photoData['path'], array(
                    'curl' => true,
                    'maxCurlSize' => 10,
                    'w' => self::$app->config("resizeLarge")));

            }
            else { //wrong format
                $errors[] = array('attribute' => 'photo', 'message' => self::$app->getTranslator()->translate('modelCampaignPhotoErrorTypeMismatch'));
            }
        }
        else{
            //need to tell user to upload a file
            $errors[] = array('attribute' => 'photo', 'message' => self::$app->getTranslator()->translate('modelCampaignPhotoErrorUploadPhotoRequired'));
        }
        return $photoData;
    }

    // Get image from url, save it to cache, then return photoData.
    public static function saveImageUrlToCache($url) {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $nameParts = explode('.', $url);
        $extension = $nameParts[count($nameParts)-1];
        $fileName = (time() + rand(1, 1000)).'.'.$extension; //add rand() to make duplicate name possibility smaller

        $filePath = self::$app->config("imagecachesPath") . $fileName;
        $fileUrl = self::$app->config("imagecachesUrl") . $fileName;

        $file = fopen($filePath, 'w+');
        fputs($file, $data);
        fclose($file);

        return array('path' => $filePath, 'url' => $fileUrl);
    }

    public static function removeFolder($dir) {
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..') continue;
            if (!self::removeFolder($dir . DIRECTORY_SEPARATOR . $file)) {
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                if (!self::removeFolder($dir . DIRECTORY_SEPARATOR . $file)) return false;
            };
        }
        return rmdir($dir);
    }

    /**
     * @param $text
     * @return string
     * Replace directory separators i.e. '/' and '\' to DIRECTORY_SEPARATOR
     */
    public static function replaceSeparators($text) {
        $text = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $text);
        $text = str_replace(':\\\\', '://', $text);
        return $text;
    }
}
