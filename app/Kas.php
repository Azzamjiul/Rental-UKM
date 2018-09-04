<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
  protected $fillable = [
    'date', 'type', 'price', 'description'
  ];

  protected $table = 'kas';
  protected $primaryKey = 'id_kas';
  public $timestamps = false;

}
