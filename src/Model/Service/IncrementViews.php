<?php
namespace LeoGalleguillos\Photo\Model\Service;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;

class IncrementViews
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
     * Increment views.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return bool
     */
    public function incrementViews(PhotoEntity\Photo $photoEntity)
    {
        return $this->photoTable->updateViewsWherePhotoId($photoEntity->getPhotoId());
    }
}
