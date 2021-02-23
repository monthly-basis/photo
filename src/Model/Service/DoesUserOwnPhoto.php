<?php
namespace MonthlyBasis\Photo\Model\Service;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;

class DoesUserOwnPhoto
{
    public function doesUserOwnPhoto(
        UserEntity\User $userEntity,
        PhotoEntity\Photo $photoEntity
    ): bool {
        return ($userEntity->getUserId() == $photoEntity->getUserId());
    }
}
