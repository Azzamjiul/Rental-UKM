<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
      'name'
  ];

  protected $table = 'category';
  protected $primaryKey = 'id_category';
  public $timestamps = false;
}
