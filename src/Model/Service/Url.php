<?php
namespace MonthlyBasis\Photo\Model\Service;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;

class Url
{
    public function __construct(
        PhotoService\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    /**
     * Get URL.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return string
     */
    public function getUrl(
        PhotoEntity\Photo $photoEntity
    ): string {
        return 'https://'
             . $_SERVER['HTTP_HOST']
             . $this->rootRelativeUrlService->getRootRelativeUrl($photoEntity);
    }
}
