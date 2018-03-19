<?php
namespace LeoGalleguillos\PhotoTest\View\Helper;

use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use LeoGalleguillos\Photo\Model\Service as PhotoService;
use LeoGalleguillos\Photo\View\Helper as PhotoHelper;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp()
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
