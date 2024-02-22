<?php
namespace App\Services;

class Files
{
    /**
     * 
     */
    public function __construct()
	{

	}


    /**
     * 
     */
    public static function upload(string $dir, string $key = 'files')
    {
        $files = [];
        $total_count = count($_FILES[$key]['name']);

        $dir = "files/{$dir}/";
        $uploadPath = MODX_BASE_PATH . $dir;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        for ($i=0 ; $i < $total_count ; $i++) {
            $tmpFilePath = $_FILES[$key]['tmp_name'][$i];

            if ($tmpFilePath != "") {
                $hash = md5_file($_FILES[$key]['tmp_name'][$i]);
                $pathinfo = pathinfo($_FILES[$key]['name'][$i]);
                $name = str_replace("-{$hash}", '', $pathinfo['filename']);
                $filename = "{$name}-$hash.{$pathinfo['extension']}";
                $newFilePath = $uploadPath . $filename;

                if (!file_exists($newFilePath)) {
                    move_uploaded_file($tmpFilePath, $newFilePath);
                }

                $files[] = "/{$dir}{$filename}";
            }
        }

        return $files;
    }
}
