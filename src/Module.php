<?php
namespace LeoGalleguillos\Photo;

use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Image\Model\Service as ImageService;
use LeoGalleguillos\String\Model\Service as StringService;
use LeoGalleguillos\User\Model\Service as UserService;
use LeoGalleguillos\Photo\Model\Factory as PhotoFactory;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use LeoGalleguillos\Photo\View\Helper as PhotoHelper;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                    'doesUserOwnPhoto'     => PhotoHelper\DoesUserOwnPhoto::class,
                    'doesVisitorOwnPhoto'  => PhotoHelper\DoesVisitorOwnPhoto::class,
                    'photoRootRelativeUrl' => PhotoHelper\RootRelativeUrl::class,
                ],
                'factories' => [
                    PhotoHelper\DoesUserOwnPhoto::class => function ($serviceManager) {
                        return new PhotoHelper\DoesUserOwnPhoto(
                            $serviceManager->get(PhotoService\DoesUserOwnPhoto::class)
                        );
                    },
                    PhotoHelper\DoesVisitorOwnPhoto::class => function ($serviceManager) {
                        return new PhotoHelper\DoesVisitorOwnPhoto(
                            $serviceManager->get(PhotoService\DoesVisitorOwnPhoto::class)
                        );
                    },
                    PhotoHelper\RootRelativeUrl::class => function ($serviceManager) {
                        return new PhotoHelper\RootRelativeUrl(
                            $serviceManager->get(PhotoService\RootRelativeUrl::class)
                        );
                    },
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                PhotoFactory\Photo::class => function ($serviceManager) {
                    return new PhotoFactory\Photo(
                        $serviceManager->get(ImageService\Thumbnail\Create::class),
                        $serviceManager->get(PhotoTable\Photo::class)
                    );
                },
                PhotoService\DoesUserOwnPhoto::class => function ($serviceManager) {
                    return new PhotoService\DoesUserOwnPhoto();
                },
                PhotoService\DoesVisitorOwnPhoto::class => function ($serviceManager) {
                    return new PhotoService\DoesVisitorOwnPhoto(
                        $serviceManager->get(PhotoService\DoesUserOwnPhoto::class),
                        $serviceManager->get(UserService\LoggedInUser::class)
                    );
                },
                PhotoService\IncrementViews::class => function ($serviceManager) {
                    return new PhotoService\IncrementViews(
                        $serviceManager->get(PhotoTable\Photo::class)
                    );
                },
                PhotoService\Photos::class => function ($serviceManager) {
                    return new PhotoService\Photos(
                        $serviceManager->get(PhotoFactory\Photo::class),
                        $serviceManager->get(PhotoTable\Photo::class)
                    );
                },
                PhotoService\RootRelativeUrl::class => function ($serviceManager) {
                    return new PhotoService\RootRelativeUrl(
                        $serviceManager->get(PhotoService\Slug::class)
                    );
                },
                PhotoService\Slug::class => function ($serviceManager) {
                    return new PhotoService\Slug(
                        $serviceManager->get(StringService\UrlFriendly::class)
                    );
                },
                PhotoService\Upload::class => function ($serviceManager) {
                    return new PhotoService\Upload(
                        $serviceManager->get(PhotoTable\Photo::class)
                    );
                },
                PhotoService\Url::class => function ($serviceManager) {
                    return new PhotoService\Url(
                        $serviceManager->get(PhotoService\RootRelativeUrl::class)
                    );
                },
                PhotoTable\Photo::class => function ($serviceManager) {
                    return new PhotoTable\Photo(
                        $serviceManager->get('main')
                    );
                },
                PhotoTable\Photo\Description::class => function ($serviceManager) {
                    return new PhotoTable\Photo\Description(
                        $serviceManager->get('main')
                    );
                },
                PhotoTable\Photo\Title::class => function ($serviceManager) {
                    return new PhotoTable\Photo\Title(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
