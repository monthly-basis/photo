<?php
namespace MonthlyBasis\PhotoTest\View\Helper;

use MonthlyBasis\Photo\Model\Entity as PhotoEntity;
use MonthlyBasis\Photo\Model\Service as PhotoService;
use MonthlyBasis\Photo\View\Helper as PhotoHelper;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->rootRelativeUrlServiceMock = $this->createMock(
            PhotoService\RootRelativeUrl::class
        );
        $this->rootRelativeUrlHelper = new PhotoHelper\RootRelativeUrl(
            $this->rootRelativeUrlServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoHelper\RootRelativeUrl::class,
            $this->rootRelativeUrlHelper
        );
    }

    public function testInvoke()
    {
        $photoEntity = new PhotoEntity\Photo();

        $this->rootRelativeUrlServiceMock->method('getRootRelativeUrl')->willReturn(
            '/photos/12345/The-title'
        );

        $this->assertSame(
            '/photos/12345/The-title',
            $this->rootRelativeUrlHelper->__invoke($photoEntity)
        );
    }
}
