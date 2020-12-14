<?php

namespace App\Imports;

use App\Services;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;

use Throwable;

class ServicesImport implements
 ToModel,
 // ToCollection,
 WithHeadingRow,
 SkipsOnError,
 SkipsOnFailure,
 WithValidation,
 WithBatchInserts,
 WithEvents
 // WithEvents
{
 use Importable;
 use SkipsErrors;
 use SkipsFailures;
 use RegistersEventListeners;

    public function model(array $row)
    {
            return new Service([
                'code' => $row['code'],
                'name' => $row['name'],
                'description' => $row['description'],
            ]);
    }

    public function rules(): array
    {
        return [
            '*.code' => ['required', 'unique:services,code', 'present', 'filled'],
            '*.name' => ['required','present'],
            '*.description' => ['required','present'],
        ];
    }

    public function validationMessages()
    {
        return [
            'code.*required' => "Code is required",
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /** @return int  */
    public function headingRow(): int {
        return 1;
    }
}
