<?php
namespace LeoGalleguillos\Photo\Model\Table\Photo;

use Laminas\Db\Adapter\Adapter;

class Description
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
        string $description,
        int $photoId
    ) {
        $sql = '
            UPDATE `photo`
               SET `description` = ?
             WHERE `photo_id` = ?
                 ;
        ';
        $parameters = [
            $description,
            $photoId,
        ];
        return (bool) $this->adapter
                           ->query($sql)
                           ->execute($parameters)
                           ->getAffectedRows();
    }
}
