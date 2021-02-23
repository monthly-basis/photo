<?php
namespace LeoGalleguillos\Photo\Model\Service;

use ArrayObject;
use Generator;
use MonthlyBasis\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Factory as PhotoFactory;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use MonthlyBasis\User\Model\Entity as UserEntity;

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
    public function getPhotos(
        int $page
    ): Generator {
        $offset   = ($page - 1) * 10;
        $rowCount = 10;

        $generator = $this->photoTable->selectOrderByCreatedDescLimit(
            $offset,
            $rowCount
        );
        foreach ($generator as $array) {
            yield $this->photoFactory->buildFromArray($array);
        }
    }

    /**
     * @return int
     */
    public function getNumberOfPhotosForUser(UserEntity\User $userEntity)
    {
        return $this->photoTable->selectCountWhereUserId($userEntity->getUserId());
    }

    public function getPhotosForUser(UserEntity\User $userEntity)
    {
        foreach ($this->photoTable->selectWhereUserId($userEntity->getUserId()) as $array) {
            yield $this->photoFactory->buildFromArray($array);
        }
    }
}
