<?php
namespace LeoGalleguillos\PhotoTest\Model\Factory;

use ArrayObject;
use DateTime;
use LeoGalleguillos\Flash\Model\Service as FlashService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Image\Model\Service as ImageService;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Factory as PhotoFactory;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class PhotoTest extends TestCase
{
    protected function setUp(): void
    {
        $this->createThumbnailServiceMock = $this->createMock(
            ImageService\Thumbnail\Create::class
        );
        $this->photoTableMock = $this->createMock(
            PhotoTable\Photo::class
        );
        $this->photoFactory = new PhotoFactory\Photo(
            $this->createThumbnailServiceMock,
            $this->photoTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoFactory\Photo::class,
            $this->photoFactory
        );
    }

    public function testBuildFromArrayObject()
    {
        $_SERVER['DOCUMENT_ROOT'] = $_SERVER['PWD'];
        $array = [
            'photo_id'    => '2',
            'extension'   => 'jpg',
            'title'       => 'title',
            'description' => 'description',
            'views'       => '5',
            'created'     => '0000-00-00 00:00:00',
            'user_id'     => '123',
        ];
        $original = new ImageEntity\Image();
        $original->setRootRelativeUrl('/uploads/photos/2/original.jpg')
                 ->setRootUrl($_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/2/original.jpg');

        $photoEntity = new PhotoEntity\Photo();
        $photoEntity->setCreated(new DateTime('0000-00-00 00:00:00'))
                    ->setDescription('description')
                    ->setExtension('jpg')
                    ->setOriginal($original)
                    ->setPhotoId(2)
                    ->setTitle('title')
                    ->setUserId(123)
                    ->setViews(5);

        $imageEntity = new ImageEntity\Image();
        $this->createThumbnailServiceMock->method('create')->willReturn($imageEntity);
        $thumbnails = [
            '400' => $imageEntity,
        ];
        $photoEntity->setThumbnails($thumbnails);

        $this->assertEquals(
            $photoEntity,
            $this->photoFactory->buildFromArray($array)
        );
    }

    public function testBuildFromPhotoId()
    {
        $array = [
            'photo_id'    => '2',
            'extension'   => 'jpg',
            'title'       => 'title',
            'description' => 'description',
            'views'       => '0',
            'created'     => '0000-00-00 00:00:00',
            'user_id'     => '123',
        ];
        $this->photoTableMock->method('selectWherePhotoId')->willReturn(
            $array
        );

        $this->assertInstanceOf(
            PhotoEntity\Photo::class,
            $this->photoFactory->buildFromPhotoId(2)
        );
    }
}
