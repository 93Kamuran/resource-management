<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PdfResource extends Model
{
    use HasFactory;

    protected $table = 'pdf_resources';
    protected $guarded = [];
}
