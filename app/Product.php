<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
      'id_category', 'quantity', 'description',
      'name', 'price'
  ];

  protected $table = 'product';
  protected $primaryKey = 'id_product';
  public $timestamps = false;

}
