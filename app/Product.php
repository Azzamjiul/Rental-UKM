<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $guarded = [''];
  protected $fillable = [
      'id_category', 'quantity', 'description',
      'name', 'price', 'category'
  ];

  protected $table = 'product';
  protected $primaryKey = 'id_product';
  public $timestamps = false;

}
