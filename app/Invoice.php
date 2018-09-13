<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $fillable = [
      'address', 'admin', 'cust_name',
      'cust_phone', 'deadline_date', 'discount', 'dp',
      'id_invoice', 'invoice_date', 'rent_date', 'status',
      'total_price', 'description', 'id_invoice', 'ref_id',
      'type'
  ];

  protected $table = 'invoice';
  protected $primaryKey = 'id_invoice';
  public $timestamps = false;
  public $incrementing = false;

  public function rents(){
    return $this->belongsTo('App\Rent', 'id_invoice', 'id_invoice');
  }

}
