<?php
namespace LeoGalleguillos\Photo\Model\Service;

use Imagick;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;

class Upload
{
    /**
     * Construct.
     *
     * @param PhotoTable\Photo $photoTable
     */
    public function __construct(
        PhotoTable\Photo $photoTable
    ) {
        $this->photoTable = $photoTable;
    }

    /**
     * Upload
     *
     * @param PhotoEntity\Photo $userEntity
     * @param string $fileName
     * @param string $fileTmpName
     * @param string $title
     * @param string $description
     */
    public function upload(
        PhotoEntity\Photo $userEntity,
        string $fileName,
        string $fileTmpName,
        string $title,
        string $description
    ) {
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileExtension = preg_replace('/\W/', '', $fileExtension);

        $photoId = $this->photoTable->insert(
            $userEntity->getPhotoId(),
            $fileExtension,
            $title,
            $description
        );

        $imagick     = new Imagick($fileTmpName);
        $orientation = $imagick->getImageOrientation();
        switch ($orientation) {
            case Imagick::ORIENTATION_BOTTOMRIGHT:
                $imagick->rotateimage('#000', 180);
            break;

            case Imagick::ORIENTATION_RIGHTTOP:
                $imagick->rotateimage('#000', 90);
            break;

            case Imagick::ORIENTATION_LEFTBOTTOM:
                $imagick->rotateimage('#000', -90);
            break;
        }
        $imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);

        mkdir($_SERVER['DOCUMENT_ROOT'] . "/uploads/photos/$photoId");

        $uploadPath = $_SERVER['DOCUMENT_ROOT']
                    . "/uploads/photos/$photoId/original.$fileExtension";

        $imagick->writeImage($uploadPath);
    }
}
