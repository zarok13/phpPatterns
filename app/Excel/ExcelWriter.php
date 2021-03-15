<?php


namespace App\Excel;

use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class ExcelWriter
{
    public function write()
    {
        $writer = WriterEntityFactory::createXLSXWriter();

        $writer->openToFile('excel.xlsx');

        $style = (new StyleBuilder())
        ->setFontBold()
        ->setFontSize(15)
        ->setFontColor(Color::BLUE)
        ->setShouldWrapText()
        ->setCellAlignment(CellAlignment::RIGHT)
        ->setBackgroundColor(Color::YELLOW)
        ->build();

        /** Shortcut: add a row from an array of values */
        $values = ['Carl', 'is', 'great!'];
        $rowFromValues = WriterEntityFactory::createRowFromArray($values, $style);
        $writer->addRow($rowFromValues);

        $writer->close();
    }
}
