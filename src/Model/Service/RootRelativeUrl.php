<?php
namespace LeoGalleguillos\Photo\Model\Service;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;

class RootRelativeUrl
{
    /**
     * Construct.
     *
     * @param PhotoService\Photo\Slug $slugService
     */
    public function __construct(
        PhotoService\Slug $slugService
    ) {
        $this->slugService = $slugService;
    }

    /**
     * Get root relative URL.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return string
     */
    public function getRootRelativeUrl(
        PhotoEntity\Photo $photoEntity
    ) : string {
        return '/photos/'
             . $photoEntity->getPhotoId()
             . '/'
             . $this->slugService->getSlug($photoEntity);
    }
}
