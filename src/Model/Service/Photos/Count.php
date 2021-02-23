<?php
namespace MonthlyBasis\Photo\Model\Service\Photos;

use MonthlyBasis\Photo\Model\Table as PhotoTable;

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
