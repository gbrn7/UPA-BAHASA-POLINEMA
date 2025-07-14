<?php

namespace App\Exports;

use App\Models\CourseEventRegistrationModel;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class CourseRegisterExportByEventId extends StringValueBinder implements FromView, WithCustomValueBinder
{

    public $courseEventId;

    public function __construct(string $courseEventId)
    {
        $this->courseEventId = $courseEventId;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $detailRegisters = CourseEventRegistrationModel::with('courseEventSchedules.courseType')
            ->whereRelation('courseEventSchedules', 'course_events_id', $this->courseEventId)
            ->get();

        return view('export_table.courseRegister', [
            'detailRegisters' => $detailRegisters
        ]);
    }
}
