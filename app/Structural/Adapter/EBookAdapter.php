<?php

namespace App\Structural\Adapter;

class EBookAdapter implements IBook
{
    protected IEBook $eBook;

    public function __construct(IEBook $eBook)
    {
        $this->eBook = $eBook;
    }

    public function open()
    {
        $this->eBook->unlock();
    }

    public function turnPage()
    {
        $this->eBook->pressNext();
    }

    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}