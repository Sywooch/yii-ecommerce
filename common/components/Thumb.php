<?php

namespace webdoka\yiiecommerce\common\components;

use yii\imagine\Image;
use Yii;

/**
 * Class Thumb
 * @package frontend\components
 */
class Thumb
{
    const QUALITY = 80;

    /**
     * @param $uploadDir
     * @param $file
     * @param $width
     * @param $height
     * @return string
     */
    public static function getImageAsBase64($uploadDir, $file, $width = '', $height = '')
    {
        $fileParts = explode('.', $file);
        $fileName = $fileParts[0] . '_' . $width . 'x' . $height;
        $fileExtension = '.' . $fileParts[1];

        $sizedFile = $fileName . $fileExtension;
        $runtimeSizedFile = Yii::getAlias('@runtime') . '/' . $sizedFile;

        if (!file_exists($runtimeSizedFile)) {
            if ($width && $height) {
                Image::thumbnail($uploadDir . '/' . $file, $width, $height)
                    ->save($runtimeSizedFile, ['quality' => self::QUALITY]);
            } else {
                Image::getImagine()->open($uploadDir . '/' . $file)->copy()
                    ->save($runtimeSizedFile, ['quality' => self::QUALITY]);
            }
        }

        $imageBase64 =  base64_encode(file_get_contents($runtimeSizedFile));
        unlink($runtimeSizedFile);

        return 'data:image/png;base64,' . $imageBase64;
    }
}
