<?php

namespace App\Exports;

use App\Models\CourseEventRegistrationModel;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseRegisterExportBySchedule implements FromView
{

    public $courseEventId;
    public $courseEventCourseTypeId;

    public function __construct(string $courseEventId, string $courseEventCourseTypeId)
    {
        $this->courseEventId = $courseEventId;
        $this->courseEventCourseTypeId = $courseEventCourseTypeId;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $detailRegisters = CourseEventRegistrationModel::with('courseEventSchedules.courseType')
            ->whereRelation('courseEventSchedules', 'course_events_id', $this->courseEventId)
            ->whereRelation('courseEventSchedules', 'course_type_id', $this->courseEventCourseTypeId)
            ->get();

        return view('export_table.courseRegister', [
            'detailRegisters' => $detailRegisters
        ]);
    }
}
