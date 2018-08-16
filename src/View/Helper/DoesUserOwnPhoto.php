<?php
namespace LeoGalleguillos\Photo\View\Helper;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use Zend\View\Helper\AbstractHelper;

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
