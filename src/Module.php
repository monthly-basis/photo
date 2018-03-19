<?php
namespace LeoGalleguillos\Photo;

use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Image\Model\Service as ImageService;
use LeoGalleguillos\String\Model\Service as StringService;
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
                    'photoRootRelativeUrl' => PhotoHelper\RootRelativeUrl::class,
                ],
                'factories' => [
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
                PhotoTable\Photo::class => function ($serviceManager) {
                    return new PhotoTable\Photo(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
