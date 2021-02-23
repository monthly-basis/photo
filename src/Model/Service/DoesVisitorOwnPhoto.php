<?php
namespace MonthlyBasis\Photo\Model\Service;

use Exception;
use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\User\Model\Service as UserService;

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
