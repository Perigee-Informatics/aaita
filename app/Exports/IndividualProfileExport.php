<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class IndividualProfileExport extends DefaultValueBinder implements FromView, WithHeadingRow, ShouldAutoSize, WithCustomValueBinder
{
    private $viewName, $data;
    /**
     * @return \Illuminate\Support\Collection
     */
    function __construct($viewName, $data)
    {
        $this->viewName = $viewName;
        $this->data = $data;
    }

    public function view(): View
    {
        return view($this->viewName, $this->data);
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
    
}
