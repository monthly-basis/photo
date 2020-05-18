<?php
namespace LeoGalleguillos\PhotoTest\Model\Table;

use ArrayObject;
use Generator;
use LeoGalleguillos\Photo\Model\Table as PhotoTable;
use LeoGalleguillos\PhotoTest\TableTestCase;
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
        $this->sqlPath    = $_SERVER['PWD'] . '/sql/leogalle_test/photo';

        $configArray      = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $configArray      = $configArray['db']['adapters']['test'];
        $this->adapter    = new Adapter($configArray);
        $this->photoTable = new PhotoTable\Photo($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents($this->sqlPath . '/drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents($this->sqlPath . '/create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PhotoTable\Photo::class,
            $this->photoTable
        );
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

        $this->assertInstanceOf(
            Generator::class,
            $generator
        );

        $generator->next();

        $arrayObject = new ArrayObject([
            'photo_id'    => '2',
            'extension'   => 'jpg',
            'title'       => 'title',
            'description' => 'description',
            'views'       => '0',
            'created'     => '0000-00-00 00:00:00',
        ]);

        $this->assertSame(
            $arrayObject['extension'],
            $generator->current()['extension']
        );
        $this->assertSame(
            $arrayObject['title'],
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
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );

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
