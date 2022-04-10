<?php

namespace App\Utils\File;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageResizer
{
    /**
     * @var Imagine
     */
    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    /**
     * @param string $originalFileFolder
     * @param string $originalFilename
     * @param array $targetParams
     * @return string
     */
    public function resizeImageAndSave(string $originalFileFolder, string $originalFilename, array $targetParams): string
    {
        $originalFilepath = $originalFileFolder . '/' . $originalFilename;

        list($imagaWidth, $imageHeight) = getimagesize($originalFilepath);

        $ratio = $imagaWidth / $imageHeight;
        $targetWidth = $targetParams['width'];
        $targetHeight = $targetParams['height'];

        if ($targetHeight) {
            if ($targetWidth / $targetHeight > $ratio) {
                $targetWidth = $targetHeight * $ratio;
            } else {
                $targetHeight = $targetWidth / $ratio;
            }
        } else {
            $targetHeight = $targetWidth / $ratio;
        }

        $targetFolder = $targetParams['newFolder'];
        $targetFilename = $targetParams['newFilename'];

        $targetFilePath = sprintf('%s/%s', $targetFolder, $targetFilename);

        $imaginefile = $this->imagine->open($originalFilepath);
        $imaginefile->resize(
            new Box($targetWidth, $targetHeight)
        )
            ->save($targetFilePath);

        return $targetFilename;
    }
}