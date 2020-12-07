<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class Post extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'PostTable';

    protected static $logAttributes = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
    ];

}
