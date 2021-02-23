<?php
namespace MonthlyBasis\Photo\View\Helper;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\Photo\View\Helper as PhotoHelper;
use Laminas\View\Helper\AbstractHelper;

class RootRelativeUrl extends AbstractHelper
{
    public function __construct(
        PhotoService\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    /**
     * Get root relative URL.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return string
     */
    public function __invoke(
        PhotoEntity\Photo $photoEntity
    ) : string {
        return $this->rootRelativeUrlService->getRootRelativeUrl($photoEntity);
    }
}
