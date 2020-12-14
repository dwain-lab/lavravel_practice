<?php

namespace App\Imports;
use App\Models\Phone;
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

class PhonesImport implements
    // ToCollection,
    WithHeadingRow,
    SkipsOnError,
    ToModel,
    SkipsOnFailure,
    WithValidation,
    WithBatchInserts,
    WithEvents
    // WithEvents
    // WithChunkReading,
    // ShouldQueue
{
    use Importable;
    use SkipsErrors;
    use SkipsFailures;
    use RegistersEventListeners;

    // use RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $row) {
    //         $user = Phone::create([
    //             'number' => $row['number']
    //         ]);
    //     }
    // }

    public function model(array $row)
    {
            return new Phone([
                'number' => $row['number'],
            ]);
    }

    public function rules(): array
    {
        return [
            '*.number' => ['unique:phones,number','digits:7']
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }





    // public function chunkSize(): int
    // {
    //     return 1000;
    // }

    // public static function afterImport(AfterImport $event)
    // {

    // }

    // public function onFailure(Failure ...$failure)
    // {

    // }
}
