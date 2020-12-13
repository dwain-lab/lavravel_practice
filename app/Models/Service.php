<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kyslik\ColumnSortable\Sortable;


class Service extends Model
{
    use HasFactory, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

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
        'updated_at'
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
