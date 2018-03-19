<?php
namespace LeoGalleguillos\Photo\Model\Service;

use ArrayObject;
use Generator;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Factory as PhotoFactory;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class Photos
{
    /**
     * Construct.
     *
     * @param PhotoFactory\Photo $photoFactory
     * @param PhotoTable\Photo $photoTable
     */
    public function __construct(
        PhotoFactory\Photo $photoFactory,
        PhotoTable\Photo $photoTable
    ) {
        $this->photoFactory = $photoFactory;
        $this->photoTable   = $photoTable;
    }

    /**
     * Get newest photos.
     *
     * @return Generator
     */
    public function getNewestPhotos() : Generator
    {
        foreach ($this->photoTable->selectOrderByCreatedDesc() as $array) {
            yield $this->photoFactory->buildFromArray($array);
        }
    }

    /**
     * @return int
     */
    public function getNumberOfPhotosForPhoto(PhotoEntity\Photo $userEntity)
    {
        return $this->photoTable->selectCountWherePhotoId($userEntity->getPhotoId());
    }

    public function getPhotosForUser(UserEntity\User $userEntity)
    {
        foreach ($this->photoTable->selectWhereUserId($userEntity->getUserId()) as $array) {
            yield $this->photoFactory->buildFromArray($array);
        }
    }
}
