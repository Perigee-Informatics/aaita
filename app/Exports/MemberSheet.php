<?php

namespace App\Exports;

use App\Http\Controllers\Admin\MemberCrudController;
use Maatwebsite\Excel\Sheet;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class MemberSheet extends DefaultValueBinder implements FromView, WithHeadingRow, ShouldAutoSize, WithCustomValueBinder,WithTitle
{
    private $viewName, $data;
    /**
     * @return \Illuminate\Support\Collection
     */
    function __construct($viewName, $member)
    {
        $this->viewName = $viewName;
        $this->member_name = $member->full_name;
        $this->member_id = $member->id;
    }

    public function view(): View
    {
        $this->data = (new MemberCrudController)->getMemberData($this->member_id);
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

    public function title(): string
    {
        return $this->member_name;
    }
    
}

