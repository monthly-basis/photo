<?php
namespace LeoGalleguillos\PhotoTest\Model\Service;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    protected function setUp()
    {
        $this->photoTableMock = $this->createMock(
            PhotoTable\Photo::class
        );
        $this->uploadService = new PhotoService\Upload(
            $this->photoTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoService\Upload::class,
            $this->uploadService
        );
    }
}
