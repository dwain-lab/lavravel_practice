<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;

class Service extends Model
{
    use HasFactory, Sortable, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'keyword',
    ];

    protected static $logName = 'ServiceTable';

    protected static $logAttributes = ['code', 'name', 'description', 'keyword'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public $sortable = [
        'code',
        'name',
        'description',
        'updated_at',
        'keyword',
    ];

    /**
     * @param mixed $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }


    /**
     * @param mixed $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucwords($value);
    }

    /** @return BelongsToMany  */
    public function phones()
    {
        return $this->belongsToMany(\App\Models\Phone::class)
            ->withTimestamps();
    }
}
