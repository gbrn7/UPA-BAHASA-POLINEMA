<?php

namespace App\Exports;

use App\Models\ToeicTestRegistrationsModel;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ToiecDataExport implements FromView
{

    public $eventId;

    public function __construct(string $eventId) {
        $this->eventId = $eventId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view():View
    {
        $detailRegisters = ToeicTestRegistrationsModel::
        where('event_id', $this->eventId)
        ->get();

        return view('export_table.toeicRegister', [
            'detailRegisters' => $detailRegisters
        ]);
    }
}
