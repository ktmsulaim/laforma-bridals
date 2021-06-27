<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;

class Job extends Model
{
    use HasFactory, ImagesTrait;

    protected $table = 'jobs_model';

    protected $guarded = [];
}
