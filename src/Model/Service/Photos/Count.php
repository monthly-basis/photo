<?php
namespace LeoGalleguillos\Photo\Model\Service\Photos;

use LeoGalleguillos\Photo\Model\Table as PhotoTable;

class Count
{
    /**
     * Construct.
     *
     * @param PhotoTable\Photo $photoTable
     */
    public function __construct(
        PhotoTable\Photo $photoTable
    ) {
        $this->photoTable   = $photoTable;
    }

    /**
     * Get count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->photoTable->selectCount();
    }
}
