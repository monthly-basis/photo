<?php
namespace LeoGalleguillos\Photo\Model\Table\Photo;

use Zend\Db\Adapter\Adapter;

class Title
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return bool
     */
    public function updateWherePhotoId(
        string $title,
        int $photoId
    ) {
        $sql = '
            UPDATE `photo`
               SET `title` = ?
             WHERE `photo_id` = ?
                 ;
        ';
        $parameters = [
            $title,
            $photoId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
