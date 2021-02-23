<?php
namespace MonthlyBasis\Photo\View\Helper;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\User\Model\Entity as UserEntity;
use Laminas\View\Helper\AbstractHelper;

class DoesUserOwnPhoto extends AbstractHelper
{
    public function __construct(
        PhotoService\DoesUserOwnPhoto $doesUserOwnPhotoService
    ) {
        $this->doesUserOwnPhotoService = $doesUserOwnPhotoService;
    }

    /**
     * Get root relative URL.
     *
     * @param PhotoEntity\Photo $photoEntity
     * @return string
     */
    public function __invoke(
        UserEntity\User $userEntity,
        PhotoEntity\Photo $photoEntity
    ): bool {
        return $this->doesUserOwnPhotoService->doesUserOwnPhoto(
            $userEntity,
            $photoEntity
        );
    }
}
