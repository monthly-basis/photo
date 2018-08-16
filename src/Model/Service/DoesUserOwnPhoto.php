<?php
namespace LeoGalleguillos\Photo\Model\Service;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;

class DoesUserOwnPhoto
{
    public function doesUserOwnPhoto(
        UserEntity\User $userEntity,
        PhotoEntity\Photo $photoEntity
    ): bool {
        return ($userEntity->getUserId() == $photoEntity->getUserId());
    }
}
