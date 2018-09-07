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

  public function product(){
    return $this->belongsTo('App\Product', 'id_product', 'id_product');

  }

  public function invoice(){
    return $this->belongsTo('App\Invoice', 'id_invoice', 'id_invoice');
  }

}
