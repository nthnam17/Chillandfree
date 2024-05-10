<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class Thumbnail
{
    public static function thumbnailImg($sourceFile, $width, $height) {
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $sourceFile) || is_null($sourceFile)) return null;

        $lastIndex = strripos($sourceFile, '/');
        $arrSource = explode("/", $sourceFile);

        //example image.png
        $img_name = end($arrSource);
        //example name
        $file_name = explode(".", $img_name);
        //folder image
        $folder = substr($sourceFile, 0, $lastIndex);
        //folder image root
        $folder_absolute = $_SERVER['DOCUMENT_ROOT'] . '/thumbnail' . '/' . $width . 'x' . $height;
        $file = $folder_absolute . '/' . $file_name[0] . '.png';
        if (!file_exists($file)) {
            if(!file_exists($folder_absolute)) {
                mkdir($folder_absolute, 0777, true);
            }
            Image::make($_SERVER['DOCUMENT_ROOT'] . '/' .$sourceFile)->encode('png', 90)->resize($width, $height)->save($folder_absolute . '/' . $file_name[0] . '.png');
        }

        $folder_resize = '/thumbnail/' . $width . 'x' . $height . '/' . $file_name[0] .'.png';

        return $folder_resize;
    }

    public static function thumbnailImage($filename, $width, $height){
        $arrayName=explode("/",$filename);
        $image= end($arrayName);
        $file = 'thumbnail/'.$width.'x'.$height;

        if (file_exists($file)) {

            $file1 = 'thumbnail/'.$width.'x'.$height.'/'.$image;
            if (!file_exists($file1)) {
                //image
                $image1 = $_SERVER['DOCUMENT_ROOT'].$filename;

                if(!file_exists($image1)) return $filename;
                self::resizeImage($filename,$file1, $width, $height);
            }

        }
        else{
            $File='thumbnail/'.$width.'x'.$height;

            self::SetFile($File);

            $file1 = 'thumbnail/'.$width.'x'.$height.'/'.$image;
            if(!file_exists($file1)) return null;
            self::resizeImage($filename,$file1, $width, $height);
        }
        return  '/thumbnail/'.$width.'x'.$height.'/'.$image;
    }
    public static function SetFile($file)
    {
        if ((is_dir($file) != 1)) {
            if (mkdir('./' . $file, 0777, true)) {
                return true;
            }
        }
        return false; //có cái nào load lên được k
    }
    public static function resizeImage($sourceFile,$destFile, $width, $height)
    {
//        copy($_SERVER['HTTP_HOST'].$sourceFile, $destFile);
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$sourceFile)) return null;
        copy($_SERVER['DOCUMENT_ROOT'].$sourceFile, $destFile);

        $file = $destFile;

        if ($height <= 0 && $width <= 0)
            return false;
        # get image size
        $info = getimagesize($file);
        $image = '';
        list($width_old, $height_old) = $info;
        $final_width = 0;
        $final_height = 0;
        $dims = self::resizeBoundary($width_old, $height_old, $width, $height);

        $final_height = intval($dims['height']);
        $final_width = intval($dims['width']);
        switch ($info[2])
        {
            case IMAGETYPE_GIF: $image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG: $image = imagecreatefrompng($file);
                break;
            default: return false;
        }

        $image_resized = imagecreatetruecolor(intval($final_width), intval($final_height));
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG))
        {
            $transparency = imagecolortransparent($image);
            if ($transparency >= 0)
            {
                $transparent_color = imagecolorsforindex($image, $trnprt_indx);
                $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG)
            {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
        $output = $file;
        switch ($info[2])
        {
            case IMAGETYPE_GIF: imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG: imagejpeg($image_resized, $output);
                break;
            case IMAGETYPE_PNG: imagepng($image_resized, $output);
                break;
            default: return false;
        }
        return true;
    }

    public static function resizeBoundary($oldW, $oldH, $newW = '', $newH = '')
    {
        $oldW = intval($oldW);
        $oldH = intval($oldH);
        $newW = intval($newW);
        $newH = intval($newH);

        if (!($oldW > 0 && $oldH > 0))
            return;
        $tempW = ( $oldW * $newH ) / ( $oldH );
        $tempH = ( $oldH * $newW ) / ( $oldW );
        if ($newW == "" && $newH != "")
        {
            if ($newH > $oldH)
            {
                $dims = self::resizeBoundary($oldW, $oldH, '', $oldH);
                $finalH = $dims['height'];
                $finalW = $dims['width'];
            } else
            {
                $finalH = $tempH;
                $finalW = $newW;
            }
        } else if ($newW != "" && $newH == "")
        {
            if ($newW > $oldW)
            {
                $dims = self::resizeBoundary($oldW, $oldH, $oldW, '');
                $finalH = $dims['height'];
                $finalW = $dims['width'];
            } else
            {
                $finalH = $tempH;
                $finalW = $newW;
            }
        } else if ($newW != "" && $newH != "")
        {
            if ($tempW > $newW)
            {
                if ($newW > $oldW)
                {
                    $dims = self::resizeBoundary($oldW, $oldH, $oldW, '');
                    $finalH = $dims['height'];
                    $finalW = $dims['width'];
                } else
                {
                    $finalH = $tempH;
                    $finalW = $newW;
                }
            } else
            {
                if ($newH > $oldH)
                {
                    $dims = self::resizeBoundary($oldW, $oldH, '', $oldH);
                    $finalH = $dims['height'];
                    $finalW = $dims['width'];
                } else
                {
                    $finalH = $tempH;
                    $finalW = $newW;
                }
            }
        }
        $dims['height'] = $finalH;
        $dims['width'] = $finalW;
        return $dims;
    }
}
