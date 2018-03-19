<?php
namespace LeoGalleguillos\Photo\View\Helper;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\View\Helper as PhotoHelper;
use Zend\View\Helper\AbstractHelper;

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
