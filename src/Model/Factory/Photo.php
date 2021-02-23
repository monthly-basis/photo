<?php
namespace LeoGalleguillos\Photo\Model\Factory;

use DateTime;
use MonthlyBasis\Image\Model\Entity as ImageEntity;
use MonthlyBasis\Image\Model\Service as ImageService;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use MonthlyBasis\User\Model\Entity as UserEntity;

class Photo
{
    /**
     * Construct.
     *
     * @param UserTable\Photo $photoTable
     */
    public function __construct(
        ImageService\Thumbnail\Create $createThumbnailService,
        PhotoTable\Photo $photoTable
    ) {
        $this->createThumbnailService = $createThumbnailService;
        $this->photoTable             = $photoTable;
    }

    /**
     * Build from array object.
     *
     * @param array $array
     * @return UserEntity\Photo
     */
    public function buildFromArray(
        array $array
    ) : PhotoEntity\Photo {
        $photo = new PhotoEntity\Photo();

        $photo->setPhotoId($array['photo_id'])
              ->setTitle($array['title'])
              ->setUserId($array['user_id'])
              ->setDescription($array['description'])
              ->setExtension($array['extension'])
              ->setCreated(new DateTime($array['created']))
              ->setViews((int) $array['views']);

        $original = new ImageEntity\Image();
        $original->setRootRelativeUrl(
            '/uploads/photos/'
            . $array['photo_id']
            . '/original.'
            . $array['extension']
        );
        $original->setRootUrl(
            $_SERVER['DOCUMENT_ROOT']
            . '/uploads/photos/'
            . $array['photo_id']
            . '/original.'
            . $array['extension']
        );
        $photo->setOriginal($original);

        $thumbnails = [];
        $thumbnail400RootPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $photo->getPhotoId() . '/400.' . $photo->getExtension();

        if (!file_exists($thumbnail400RootPath)) {
            $thumbnail = $this->createThumbnailService->create(
                $original,
                400,
                $thumbnail400RootPath
            );
        } else {
            $thumbnail = new ImageEntity\Image();
        }
        $thumbnail->setRootRelativeUrl(
            '/uploads/photos/' . $photo->getPhotoId() . '/400.' . $photo->getExtension()
        );
        $thumbnails['400'] = $thumbnail;
        $photo->setThumbnails($thumbnails);

        return $photo;
    }

    /**
     * Build from photo ID.
     *
     * @param int $photoId
     * @return PhotoEntity\Photo
     */
    public function buildFromPhotoId(
        int $photoId
    ) : PhotoEntity\Photo {
        $array = $this->photoTable->selectWherePhotoId($photoId);
        return $this->buildFromArray($array);
    }
}
