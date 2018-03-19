<?php
namespace LeoGalleguillos\Photo\Model\Service;

use LeoGalleguillos\String\Model\Service as StringService;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;

class Slug
{
    /**
     * Construct.
     *
     * @param StringService\UrlFriendly $urlFriendlyService
     */
    public function __construct(
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->urlFriendlyService = $urlFriendlyService;
    }

    /**
     * Get slug.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return string
     */
    public function getSlug(
        PhotoEntity\Photo $photoEntity
    ) : string {
        return $this->urlFriendlyService->getUrlFriendly(
            $photoEntity->getTitle()
        );
    }
}
