<?php

namespace App\Exports;

use App\Models\Phone;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PhonesExport implements Responsable, WithHeadings, WithMapping, FromCollection
{
    use Exportable;

     /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'phones.csv';

    /**
    * Optional Writer Type
    */
    private $writerType = Excel::CSV;

    /**
    * Optional headers
    */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function collection()
    {
        return Phone::all();
    }

    public function map($phone): array
    {
        return [
            $phone->id,
            $phone->number
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Number'
        ];
    }
}
