<?php

namespace App\Exports;

use App\Models\CourseEventRegistrationModel;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class CourseRegisterExport extends StringValueBinder implements FromView, WithCustomValueBinder
{

    public $courseEventScheduleId;

    public function __construct(string $courseEventScheduleId)
    {
        $this->courseEventScheduleId = $courseEventScheduleId;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $detailRegisters = CourseEventRegistrationModel::where('course_event_schedule_id', $this->courseEventScheduleId)
            ->with('courseEventSchedules.courseType')
            ->get();

        return view('export_table.courseRegister', [
            'detailRegisters' => $detailRegisters
        ]);
    }
}
