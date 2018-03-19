<?php
namespace LeoGalleguillos\PhotoTest\Model\Entity;

use DateTime;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Photo\Model\Entity as PhotoEntity;
use PHPUnit\Framework\TestCase;

class PhotoTest extends TestCase
{
    protected function setUp()
    {
        $this->photoEntity = new PhotoEntity\Photo();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoEntity\Photo::class,
            $this->photoEntity
        );
    }

    public function testGettersAndSetters()
    {
        $created = new DateTime();
        $this->assertSame(
            $this->photoEntity,
            $this->photoEntity->setCreated($created)
        );
        $this->assertSame(
            $created,
            $this->photoEntity->getCreated()
        );

        $original = new ImageEntity\Image();
        $this->assertSame(
            $this->photoEntity,
            $this->photoEntity->setOriginal($original)
        );
        $this->assertSame(
            $original,
            $this->photoEntity->getOriginal()
        );

        $userId = 123;
        $this->assertSame(
            $this->photoEntity,
            $this->photoEntity->setUserId($userId)
        );
        $this->assertSame(
            $userId,
            $this->photoEntity->getUserId()
        );
    }
}
