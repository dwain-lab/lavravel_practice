<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;

class Phone extends Model
{
    use HasFactory, Sortable, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
    ];

    protected static $logName = 'PhoneTable';

    protected static $logAttributes = ['number'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public $sortable = [
        'number',
        'updated_at'
    ];


    public function services()
    {
        return $this->belongsToMany(\App\Models\Service::class)
            ->withTimestamps();
    }
}
