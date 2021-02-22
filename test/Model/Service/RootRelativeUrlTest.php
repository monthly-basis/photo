<?php
namespace LeoGalleguillos\PhotoTest\Model\Service;

use MonthlyBasis\String\Model\Service as StringService;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->slugServiceMock = $this->createMock(
            PhotoService\Slug::class
        );
        $this->rootRelativeUrlService = new PhotoService\RootRelativeUrl(
            $this->slugServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoService\RootRelativeUrl::class,
            $this->rootRelativeUrlService
        );
    }

    public function testGetRootRelativeUrl()
    {
        $photoEntity = new PhotoEntity\Photo();
        $photoEntity->setPhotoId(12345)
                    ->setTitle('The Title');

        $this->slugServiceMock->method('getSlug')->willReturn('the-title');

        $this->assertSame(
            '/photos/12345/the-title',
            $this->rootRelativeUrlService->getRootRelativeUrl($photoEntity)
        );
    }
}
