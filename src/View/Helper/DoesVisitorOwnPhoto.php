<?php
namespace MonthlyBasis\Photo\View\Helper;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use Laminas\View\Helper\AbstractHelper;

class DoesVisitorOwnPhoto extends AbstractHelper
{
    public function __construct(
        PhotoService\DoesVisitorOwnPhoto $doesVisitorOwnPhotoService
    ) {
        $this->doesVisitorOwnPhotoService = $doesVisitorOwnPhotoService;
    }

    public function __invoke(
        PhotoEntity\Photo $photoEntity
    ): bool {
        return $this->doesVisitorOwnPhotoService->doesVisitorOwnPhoto(
            $photoEntity
        );
    }
}
