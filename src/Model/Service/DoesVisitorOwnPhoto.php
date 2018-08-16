<?php
namespace LeoGalleguillos\Photo\Model\Service;

use Exception;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\User\Model\Service as UserService;

class DoesVisitorOwnPhoto
{
    public function __construct(
        PhotoService\DoesUserOwnPhoto $doesUserOwnPhotoService,
        UserService\LoggedInUser $loggedInUserService
    ) {
        $this->doesUserOwnPhotoService = $doesUserOwnPhotoService;
        $this->loggedInUserService     = $loggedInUserService;
    }

    public function doesVisitorOwnPhoto(
        PhotoEntity\Photo $photoEntity
    ): bool {
        try {
            $userEntity = $this->loggedInUserService->getLoggedInUser();
        } catch (Exception $exception) {
            return false;
        }

        return $this->doesUserOwnPhotoService->doesUserOwnPhoto(
            $userEntity,
            $photoEntity
        );
    }
}
