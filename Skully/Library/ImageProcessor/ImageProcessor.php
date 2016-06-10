<?php


namespace Skully\Library\ImageProcessor;
    /**
     * Resize image using ImageMagick's "convert" method.
     * Initial function by Wes Edling .. http://joedesigns.com
     *
     *
     * Changes:
     * 2012/01/30 - David Goodwin - call escapeshellarg on parameters going into the shell
     * 2012/07/12 - Whizzkid - Added support for encoded image urls and images on ssl secured servers [https://]
     * 2014/02/04 - Jay - Added some options.
     * 2014/04/13 - Jay - Major update
     */

/**
 * SECURITY:
 * It's a bad idea to allow user supplied data to become the path for the image you wish to retrieve, as this allows them
 * to download nearly anything to your server. If you must do this, it's strongly advised that you put a .htaccess file
 * in the cache directory containing something like the following :
 * <code>php_flag engine off</code>
 * to at least stop arbitrary code execution. You can deal with any copyright infringement issues yourself :)
 */

class ImageProcessor {
    /**
     * @param string $imagePath - either a local absolute/relative path, or a remote URL (e.g. http://...flickr.com/.../ ). See SECURITY note above.
     * @param array $opts (
     *  curl(boolean) = false,
     *  maxCurlSize(int in Mbytes),
     *  w(pixels),
     *  h(pixels),
     *  crop(boolean) = false,
     *  scale(boolean) = true,
     *  thumbnail(boolean) = false,
     *  maxOnly(boolean) = true, # Resize only when file is larger.
     *  canvasColor(string) = '#FFFFFF',
     *  resultDir = null,
     *  remoteDir = null,
     *  outputFilename(string) = false,
     *  cacheHttpMinutes(int) = 20,
     *  overwrite(boolean) - false,
     *  onlyCreateWhenNew(boolean) - true)
     * @throws \Exception
     * @return bool|mixed|string string new URL for resized image.
     */
    public static function resize($imagePath,$opts=null){
        $imagePath = urldecode($imagePath);
        # start configuration
        $resultDir = null;
        if (!empty($opts['resultDir'])) {
            $resultDir = $opts['resultDir']; # path to your result Dir, must be writeable by web server
            $resultDir = str_replace('/', DIRECTORY_SEPARATOR, $resultDir);
        }
        $remoteDir = null;
        if (!empty($opts['remoteDir'])) {
            $remoteDir = $opts['remoteDir'];
        }
        if (empty($remoteDir)) {
            $remoteDir = $resultDir.'remote/'; # path to the Dir you wish to download remote images into
        }

        $overwrite = false;
        if (isset($opts['overwrite'])) {
            $overwrite = $opts['overwrite'];
        }

        $onlyCreateWhenNew = true;
        if (isset($opts['onlyCreateWhenNew'])) {
            $onlyCreateWhenNew = $opts['onlyCreateWhenNew'];
        }

        $defaults = array('curl' => false, 'crop' => false, 'scale' => true, 'thumbnail' => false, 'maxOnly' => true,
            'canvasColor' => '#FFFFFF', 'outputFilename' => false,
            'resultDir' => $resultDir, 'remoteDir' => $remoteDir, 'quality' => 90, 'cacheHttpMinutes' => 20);

        $opts = array_merge($defaults, $opts);

        $path_to_convert = 'convert'; # this could be something like /usr/bin/convert or /opt/local/share/bin/convert

        ## you shouldn't need to configure anything else beyond this point

        $purl = parse_url($imagePath);
        $finfo = pathinfo($imagePath);
        $ext_r = explode('.', $imagePath);
        $ext = $ext_r[count($ext_r)-1];

        //if not using imagic, run the following code and return the new path immediately
        if(!empty($opts['noImagick']) && $opts['noImagick']){
            if(file_exists($imagePath) == false):
                $imagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
                if(file_exists($imagePath) == false):
                    throw new \Exception("Image not found. (".$imagePath.")");
                endif;
            endif;

            $filename = md5_file($imagePath);

            if(false !== $opts['outputFilename']) :
                $opts['outputFilename'] = str_replace('/', DIRECTORY_SEPARATOR, $opts['outputFilename']);
                $newPath = $resultDir.$opts['outputFilename'];
            else:
                $newPath = $resultDir.$filename.$ext;
            endif;

            if(move_uploaded_file($imagePath, $newPath)){
                return $newPath;
            }
            else{
                $e = new \Exception("Unable to move the uploaded file. Please check your Dir permission.");
                throw $e;
            }
        }

        # check for remote image..
        if(isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')):
            # grab the image, and cache it so we have something to work with..
            list($filename) = explode('?',$finfo['basename']);
            $local_filepath = $remoteDir.$filename;
            $download_image = true;
            if(file_exists($local_filepath)):
                if(filemtime($local_filepath) < strtotime('+'.$opts['cacheHttpMinutes'].' minutes')):
                    $download_image = false;
                endif;
            endif;
            if($download_image == true):

                try {
                    if ($opts['curl'] == true) {
                        if (!empty($opts['maxCurlSize'])) {
                            if (ImageProcessor::grabSize($imagePath) <= ($opts['maxCurlSize']*1024*1024)) {
                                ImageProcessor::grabImage($imagePath, $local_filepath);
                            }
                            else {
                                throw new \Exception("image too large");
                            }
                        }
                        else {
                            ImageProcessor::grabImage($imagePath, $local_filepath);
                        }
                    }
                    $img = @file_get_contents($imagePath);
                    if (empty($img)) {
                        return "invalid image pathname";
                    }
                    else {
                        file_put_contents($local_filepath,$img);
                    }
                } catch (\Exception $e) {
                    throw new \Exception("ERROR: While doing image resize, got this error: ".$e->getMessage());
                }
            endif;
            $imagePath = $local_filepath;
        endif;

        if(file_exists($imagePath) == false):
            $imagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
            if(file_exists($imagePath) == false):
                throw new \Exception('image not found. ('.$imagePath.')');
            endif;
        endif;

        $w = 0;

        if(isset($opts['w'])): $w = $opts['w']; endif;
        if(isset($opts['h'])): $h = $opts['h']; endif;

        $filename = md5_file($imagePath);

        // If the user has requested an explicit outputFilename, do not use the cache directory.
        if(false !== $opts['outputFilename']) :
            $newPath = $resultDir.$opts['outputFilename'];
        else:
            if(!empty($w) and !empty($h)):
                $newPath = $resultDir.$filename.'_w'.$w.'_h'.$h.(isset($opts['crop']) && $opts['crop'] == true ? "_cp" : "").(isset($opts['scale']) && $opts['scale'] == true ? "_sc" : "").'.'.$ext;
            elseif(!empty($w)):
                $newPath = $resultDir.$filename.'_w'.$w.'.'.$ext;
            elseif(!empty($h)):
                $newPath = $resultDir.$filename.'_h'.$h.'.'.$ext;
            else:
                return false;
            endif;
        endif;

        $create = true;

        if ($onlyCreateWhenNew) {
            if(file_exists($newPath) == true):
                $create = false;
                $origFileTime = date("YmdHis",filemtime($imagePath));
                $newFileTime = date("YmdHis",filemtime($newPath));
                if($newFileTime < $origFileTime): # Not using $opts['expire-time'] ??
                    $create = true;
                endif;
            endif;
        }
        else {
            if (!$overwrite) {
                if(file_exists($newPath) == true) {
                    $newExt = substr(strrchr($newPath,'.'),1);
                    $pos = strrpos($newPath, '.'.$newExt);
                    if($pos !== false)
                    {
                        $noExt = substr_replace($newPath, '', $pos, strlen('.'.$newExt));
                        $count = 1;
                        while(file_exists($noExt.'-'.$count.'.'.$newExt)) {
                            $count+=1;
                        }
                        $newPath = $noExt.'-'.$count.'.'.$newExt;
                    }
                    else {
                        $noExt = $newPath;
                        $count = 1;
                        while(file_exists($noExt.'-'.$count)) {
                            $count+=1;
                        }
                        $newPath = $noExt.'-'.$count;
                    }
                }
            }
        }

        if($create == true):
            if(!empty($w) and !empty($h)):

                list($width,$height) = getimagesize($imagePath);

                if($width > $height):
                    $resize = $w;
                    if(true === $opts['crop']):
                        $resize = "x".$h;
                    endif;
                else:
                    $resize = "x".$h;
                    if(true === $opts['crop']):
                        $resize = $w;
                    endif;
                endif;

                if(!empty($opts['imagickProgressive']) && $opts['imagickProgressive']) {
                    $progressiveCommand = "-strip -interlace Plane";
                }
                else{
                    $progressiveCommand = "";
                }

                if(true === $opts['scale']):
                    $resize = $w."x".$h;
                    $cmd = $path_to_convert ." $progressiveCommand ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
                        (true === $opts['crop'] ? "^ -gravity center -extent " . escapeshellarg($resize) : "").
                        " -quality ". escapeshellarg($opts['quality']) . " " . escapeshellarg($newPath);
                else:
                    $cmd = $path_to_convert." $progressiveCommand ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
                        " -size ". escapeshellarg($w ."x". $h) .
                        " xc:". escapeshellarg($opts['canvasColor']) .
                        " +swap -gravity center -composite -quality ". escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
                endif;

            else:
                if (self::isWindows()) {
                    $maxSign = "^>";
                }
                else {
                    $maxSign = "\\>";
                }
                $cmd = $path_to_convert." " . escapeshellarg($imagePath) .
                    " -thumbnail ". (!empty($h) ? 'x':'') . $w ."".
                    (isset($opts['maxOnly']) && $opts['maxOnly'] == true ? $maxSign : "") .
                    " -quality ". escapeshellarg($opts['quality']) ." ". escapeshellarg($newPath);
            endif;
            exec($cmd, $output, $return_code);
            if($return_code == 127) {
                $path_to_convert = '/usr/local/bin/convert'; # this could be something like /usr/bin/convert or /opt/local/share/bin/convert
                $cmd = preg_replace('/convert/', $path_to_convert, $cmd, 1);
                exec($cmd, $output, $return_code);
            }

            if($return_code != 0) {
                throw new \Exception("Tried to execute : $cmd, return code: $return_code, output: " . print_r($output, true));
            }
        endif;

        # return cache file path
        return $newPath;

    }

    public static function grabSize($remoteFile, &$status = 'unknown') {
        $ch = curl_init($remoteFile);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data === false) {
            throw new \Exception('cURL failed');
        }

        $contentLength = 'unknown';
        if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
            $status = (int)$matches[1];
        }
        if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
            $contentLength = (int)$matches[1];
        }
        return $contentLength;
    }

    public static function grabImage($url,$saveto){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($saveto)){
            unlink($saveto);
        }
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }

    public static function isWindows() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        } else {
            return false;
        }
    }
}