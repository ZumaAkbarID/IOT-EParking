<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestApi extends Model
{
    use HasFactory;
    protected $table = 'test_api';
    protected $guarded = ['id'];
}