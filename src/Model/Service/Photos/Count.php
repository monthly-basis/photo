<?php
namespace LeoGalleguillos\Photo\Model\Service\Photos;

use LeoGalleguillos\Photo\Model\Table as PhotoTable;

class Count
{
    public function __construct(
        PhotoTable\Photo $photoTable
    ) {
        $this->photoTable = $photoTable;
    }

    public function getCount(): int
    {
        return $this->photoTable
            ->selectCountWhereUserDeletedDatetimeIsNull()
            ->current()['COUNT(*)'];
    }
}
