<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    //
    protected $fillable = ['title','author','publisher','issn','iselectronic'];
}
