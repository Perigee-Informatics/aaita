<?php

namespace App\Exports;

use App\Models\Member;
use App\Exports\MemberSheet;
use Maatwebsite\Excel\Sheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromView;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ReportExport extends DefaultValueBinder implements WithMultipleSheets
{
    use Exportable;
    private $viewName, $data;
    /**
     * @return \Illuminate\Support\Collection
     */
    function __construct($viewName)
    {
        $this->viewName = $viewName;
    }

    public function sheets(): array
    {
        $sheets = [];

        $members = Member::all();

        foreach($members as $member){
            $sheets[] = new MemberSheet($this->viewName, $member);
        }

        return $sheets;
    }
    
}

