<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $fillable = [
      'location', 'id_product'
  ];

  protected $table = 'file';
  protected $primaryKey = 'id_file';
  public $timestamps = false;

}
