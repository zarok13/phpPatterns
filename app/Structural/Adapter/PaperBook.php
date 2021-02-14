<?php

namespace App\Structural\Adapter;

class PaperBook implements IBook
{
    private $page;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function open()
    {
        $this->page = 1;
    }

    public function turnPage()
    {
        $this->page++;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}