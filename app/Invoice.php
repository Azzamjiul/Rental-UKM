<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $fillable = [
      'rent_date', 'deadline_date', 'cust_name',
      'cust_phone', 'total_price', 'status', 'dp',
      'admin', 'address', 'invoice_date', 'discount'  
  ];

  protected $table = 'invoice';
  protected $primaryKey = 'id_invoice';
  public $timestamps = false;

}
