<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlSnippet extends Model
{
    use HasFactory;


    protected $table = 'html_snippets';
    protected $guarded = [];
}
