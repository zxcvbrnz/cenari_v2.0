<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PesertaExport implements FromView, WithEvents
{
    use Exportable;

    private $exportData;

    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('excel', [
            'exportData' => $this->exportData,
        ]);
    }

    public function registerEvents(): array
    {
        $columns = [];

        // Generate column IDs from 'AA' to 'AJ'
        for ($i = ord('A'); $i <= ord('A'); $i++) {
            for ($j = ord('A'); $j <= ord('J'); $j++) {
                $columns[] = 'A' . chr($j);
            }
        }
        return [
            AfterSheet::class => function (AfterSheet $event)  use ($columns) {
                foreach (range('A', 'Z') as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize(true);
                }
                foreach ($columns as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}
