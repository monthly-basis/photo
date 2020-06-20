<?php
namespace LeoGalleguillos\PhotoTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;

class PhotoTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath;

    /**
     * @var PhotoTable
     */
    protected $photoTable;

    protected function setUp(): void
    {
        $this->photoTable = new PhotoTable\Photo($this->getAdapter());

        $this->setForeignKeyChecks0();
        $this->dropTable('photo');
        $this->createTable('photo');
        $this->setForeignKeyChecks1();
    }

    public function testInsertAndSelectCount()
    {
        $this->assertSame(
            0,
            $this->photoTable->selectCount()
        );

        $this->assertSame(
            1,
            $this->photoTable->insert(123, 'jpg', 'title', 'description')
        );
        $this->assertSame(
            1,
            $this->photoTable->selectCount()
        );

        $this->assertSame(
            2,
            $this->photoTable->insert(123, 'jpg', 't', 'd')
        );
        $this->assertSame(
            2,
            $this->photoTable->selectCount()
        );
    }

    public function testSelectOrderByCreatedDesc()
    {
        $this->photoTable->insert(123, 'jpg', 'title', 'description');
        $this->photoTable->insert(123, 'jpg', 'title', 'description');

        $generator = $this->photoTable->selectOrderByCreatedDescLimit(0, 10);

        $generator->next();

        $arrayObject = new ArrayObject([
            'photo_id'    => '2',
            'extension'   => 'jpg',
            'title'       => 'title',
            'description' => 'description',
            'views'       => '0',
            'created'     => '0000-00-00 00:00:00',
        ]);

        $this->assertNull(
            $generator->current()['extension']
        );
        $this->assertNull(
            $generator->current()['title']
        );
    }

    public function testSelectWherePhotoId()
    {
        $this->photoTable->insert(123, 'jpg', 'title', 'description');
        $array = $this->photoTable->selectWherePhotoId(1);
        $this->assertSame(
            'jpg',
            $array['extension']
        );
        $this->assertSame(
            'title',
            $array['title']
        );
    }

    public function testSelectWhereUserId()
    {
        $this->photoTable->insert(123, 'jpg', 'title', 'description');
        $this->photoTable->insert(123, 'png', 'title2', 'description2');
        $generator = $this->photoTable->selectWhereUserId(123);

        $this->assertSame(
            $generator->current()['title'],
            'title'
        );
        $generator->next();
        $this->assertSame(
            $generator->current()['title'],
            'title2'
        );
    }
}
