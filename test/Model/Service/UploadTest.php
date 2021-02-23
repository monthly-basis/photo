<?php
namespace MonthlyBasis\PhotoTest\Model\Service;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    protected function setUp(): void
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
