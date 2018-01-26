<?php namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends BaseController {
    /**
     * Upload controller, chunk action
     *
     * @access public
     */
    public function chunk(Request $request)
    {
        $chunk = (int)$request->input('chunk', 0);
        $chunks = (int)$request->input('chunks', 0);
        $isVoice = $request->input('voice');

        if ($isVoice){
            $fileName = $request->input('Filename', '');
            $fileKey = 'recording';
        }else {
            $fileName = $request->input('name', '');
            $fileKey = 'file';
        }

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = 'kacana__product_'.md5($fileName);

        $return = array(
            'ok' => 0,
            'jsonrpc' => '2.0',
            'message' => '',
            'id' => 'id',
            'name' => ''
        );

        try {
                $contentType = $this->getContentType();
                $targetDir = PRODUCT_IMAGE;

                $filePath = $targetDir . $fileName;
                $finalFileName = $fileName.'.'.$ext;
                $partFilePath = $filePath.'.'.'part';
                $finalFilePath = $filePath.'.'.$ext;

                $this->cleanUploadDir($targetDir,$partFilePath);
                $this->setExecutionTime();
                $this->setHeaders();

                // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
                if (strpos($contentType, "multipart") !== false)
                {
                    if (isset($_FILES[$fileKey]['tmp_name']) && is_uploaded_file($_FILES[$fileKey]['tmp_name']))
                    {
                        // Open temp file
                        $out = fopen($partFilePath, $chunk == 0 ? "wb" : "ab");
                        if ($out)
                        {
                            // Read binary input stream and append it to temp file
                            $in = fopen($_FILES[$fileKey]['tmp_name'], "rb");

                            if ($in)
                            {
                                while ($buff = fread($in, 4096))
                                    fwrite($out, $buff);
                            }
                            else
                                throw new Exception('Failed to open input stream');

                            fclose($in);
                            fclose($out);
                            @unlink($_FILES[$fileKey]['tmp_name']);
                        }
                        else
                            throw new Exception('Failed to open output stream');
                    }
                    else
                        throw new Exception('Failed to move uploaded file');
                }
                else
                {
                    // Open temp file
                    $out = fopen($partFilePath, $chunk == 0 ? "wb" : "ab");
                    if ($out)
                    {
                        // Read binary input stream and append it to temp file
                        $in = fopen("php://input", "rb");

                        if ($in)
                        {
                            while ($buff = fread($in, 4096))
                                fwrite($out, $buff);
                        }
                        else
                            throw new Exception('Failed to open input stream');

                        fclose($in);
                        fclose($out);
                    }
                    else
                        throw new Exception('Failed to open output stream');
                }

                if (!$chunks || $chunk == $chunks - 1) {
                    $type = $request->input('type');
                    $isOverlay = false;
                    if ($type == 'overlay') {
                        $isOverlay = true;
                    }
                    // Strip the temp .part suffix off
                    rename($partFilePath, $finalFilePath);
                    $imagePath = '/'.$filePath.'.'.$ext;
                    $this->optimizeImage($imagePath);

                    $return['name'] = $imagePath;
                    $return['ok'] = 1;
                }

        } catch (Exception $e) {
            // @codeCoverageIgnoreStart
            $return['message'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    /**
     * Upload controller, setExecutionTime function
     *
     * Set execution time
     *
     * @access private
     */
    private function setExecutionTime()
    {
        // 5 minutes execution time
        @set_time_limit(5 * 60);
    }

    /**
     * Upload controller, setHeaders function
     *
     * Set header
     *
     * @access private
     */
    private function setHeaders()
    {
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    /**
     * Upload controller, getContentType function
     *
     * Get content type
     *
     * @return string
     * @access private
     */
    private function getContentType()
    {

        $contentType = '';

        /* Look for the content type header */
        if (isset($_SERVER["HTTP_CONTENT_TYPE"])){

            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        }

        if (isset($_SERVER["CONTENT_TYPE"])){

            $contentType = $_SERVER["CONTENT_TYPE"];
        }

        return $contentType;
    }

    /**
     * Upload controller, cleanUploadDir function
     *
     * Remove temp files
     *
     * @param $targetDir
     * @param $partFilePath
     * @throws Exception
     * @access private
     */
    private function cleanUploadDir($targetDir,$partFilePath)
    {
        // Create target dir
        if (!file_exists($targetDir)) {

            @mkdir($targetDir);
        }

        $maxFileAge = 5 * 3600;

        // Remove old temp files
        if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {

            throw new Exception('Failed to open temp directory');
        }

        while (($file = readdir($dir)) !== false) {

            $tempFilePath = $targetDir . '/' . $file;

            // If temp file is current file proceed to the next
            if ($tempFilePath == $partFilePath) {

                continue;
            }
            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.part$/', $file) && (filemtime($tempFilePath) < time() - $maxFileAge)) {

                @unlink($tempFilePath);
            }
        }

        closedir($dir);
    }

    public function optimizeImage($image){

        if(trim($image))
            \Log::info('------- PROCESS COMPRESS IMAGE : '.$image.' -----------');
        else
        {
            \Log::warning('------- IMAGE NULL -----------');
            return false;
        }
        $image = public_path().$image;
        $longitude = HEAD_COMPANY_LOCATION_LONGITUDE;
        $latitude = HEAD_COMPANY_LOCATION_LATITUDE;

        //optimize sie file
        try {

            $tinyKey = $this->getTinyfySecretKey();
            \Tinify\setKey($tinyKey);
            $source = \Tinify\fromFile($image);
            $copyrighted = $source->preserve("copyright", "creation", 'location');
            $copyrighted->toFile($image);

        } catch(\Tinify\AccountException $e) {
            \Log::error("The AccountException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Verify your API key and account limit.
        } catch(\Tinify\ClientException $e) {
            \Log::error("The ClientException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Check your source image and request options.
        } catch(\Tinify\ServerException $e) {
            \Log::error("The ServerException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Temporary issue with the Tinify API.
        } catch(\Tinify\ConnectionException $e) {
            \Log::error("The ConnectionException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // A network connection error occurred.
        } catch(\Exception $e) {
            \Log::error("The Exception error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Something else went wrong, unrelated to the Tinify API.
        }

        $command = base_path()."/Image-ExifTool-10.75/exiftool -GPSLongitudeRef=E -GPSLongitude=$longitude -GPSLatitudeRef=N -GPSLatitude=$latitude $image";
        \Log::info('------- Run command : '.$command.' -----------');
        exec($command);
    }

    public function getTinyfySecretKey(){
        $keys = explode('|', TINYFY_SECRET_KEY);
        $keyAvailable = $keys[0]; // main key if free key is over limit 500
        foreach ($keys  as $key)
        {
            \Tinify\setKey($key);
            \Tinify\validate();
            $compressionsThisMonth = \Tinify\compressionCount();
            if($compressionsThisMonth < 450 )
            {
                $keyAvailable = $key;
                return $keyAvailable;
            }

        }

        return $keyAvailable;
    }
}