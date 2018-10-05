<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueUpdateStock extends Model
{
  protected $fillable = [
      'id_product', 'quantity',
      'rent_date', 'status',
  ];

  protected $table = 'queue_update_stock';
  protected $primaryKey = 'id_queue';
  public $timestamps = false;
}
