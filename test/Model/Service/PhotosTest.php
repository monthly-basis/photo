<?php
namespace LeoGalleguillos\PhotoTest\Model\Service;

use Generator;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Factory as PhotoFactory;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class PhotosTest extends TestCase
{
    protected function setUp()
    {
        $this->photoFactoryMock = $this->createMock(
            PhotoFactory\Photo::class
        );
        $this->photoTableMock = $this->createMock(
            PhotoTable\Photo::class
        );
        $this->photosService = new PhotoService\Photos(
            $this->photoFactoryMock,
            $this->photoTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoService\Photos::class,
            $this->photosService
        );
    }

    public function testGetNewestPhotos()
    {
        $array = [
            $array = [
                'photo_id'    => '2',
                'extension'   => 'jpg',
                'title'       => 'title',
                'description' => 'description',
                'views'       => '0',
                'created'     => '0000-00-00 00:00:00',
            ]
        ];
        $this->photoTableMock->method('selectOrderByCreatedDesc')->willReturn(
            $array
        );
        $this->assertInstanceOf(
            PhotoEntity\Photo::class,
            $this->photosService->getNewestPhotos()->current()
        );
    }

    public function testGetPhotosForUser()
    {
        $userEntity = new UserEntity\User();
        $userEntity->setUserId(123);

        $this->photoTableMock->method('selectWhereUserId')->willReturn(
            $this->yieldArrays()
        );

        $generator = $this->photosService->getPhotosForUser($userEntity);
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );

        $this->assertInstanceOf(
            PhotoEntity\Photo::class,
            $generator->current()
        );
        $generator->next();
        $this->assertInstanceOf(
            PhotoEntity\Photo::class,
            $generator->current()
        );
        $generator->next();
        $this->assertNull($generator->current());
    }

    protected function yieldArrays()
    {
        yield [];
        yield [];
    }
}
