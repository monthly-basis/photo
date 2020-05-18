<?php
namespace LeoGalleguillos\PhotoTest\Model\Service;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class IncrementViewsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->photoTableMock = $this->createMock(
            PhotoTable\Photo::class
        );
        $this->incrementViewsService = new PhotoService\IncrementViews(
            $this->photoTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoService\IncrementViews::class,
            $this->incrementViewsService
        );
    }

    public function testIncrementViews()
    {
        $photoEntity = new PhotoEntity\Photo();
        $photoEntity->setPhotoId(123);

        $this->photoTableMock->method('updateViewsWherePhotoId')->willReturn(true);

        $this->assertTrue(
            $this->incrementViewsService->incrementViews($photoEntity)
        );
    }
}
