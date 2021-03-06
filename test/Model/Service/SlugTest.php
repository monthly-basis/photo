<?php
namespace MonthlyBasis\PhotoTest\Model\Service;

use MonthlyBasis\String\Model\Service as StringService;
use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    protected function setUp(): void
    {
        $this->urlFriendlyServiceMock = $this->createMock(
            StringService\UrlFriendly::class
        );
        $this->slugService = new PhotoService\Slug(
            $this->urlFriendlyServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoService\Slug::class,
            $this->slugService
        );
    }

    public function testGetSlug()
    {
        $photoEntity = new PhotoEntity\Photo();
        $photoEntity->setTitle('The Title');
        $this->urlFriendlyServiceMock->method('getUrlFriendly')->willReturn(
            'the-slug'
        );
        $this->assertSame(
            'the-slug',
            $this->slugService->getSlug($photoEntity)
        );
    }
}
