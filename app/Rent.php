<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
  protected $guarded = [''];
  protected $fillable = [
      'id_invoice', 'id_product', 'prod_quantity',
      'sum_price'
  ];

  protected $table = 'rent';
  protected $primaryKey = 'id_rent';
  public $timestamps = false;
}
