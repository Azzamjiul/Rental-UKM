<?php

namespace App\Console\Commands;

use Log;
use App\Product;
use App\QueueUpdateStock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock of products to rent.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      //get all products today that is about to have its stock updated
      try {
        $products_in_queue = QueueUpdateStock::where('rent_date', date_format(Carbon::now(), 'Y-m-d 00:00:00'))->get()->toArray();
        for ($i=0; $i < count($products_in_queue); $i++) {
          $product = Product::find($products_in_queue[$i]['id_product']);
          $product->on_rent = $product->on_rent + $products_in_queue[$i]['quantity'];
          $product->save();
          QueueUpdateStock::where('id_queue', $products_in_queue[$i]['id_queue'])->update(['status' => 1]);
        }
        Log::info("Stock products succesfuly updated from laravel command on ". Carbon::now());
      } catch (\Exception $e) {
        Log::error("Stock products cannot be updated from laravel command on ". Carbon::now());
        Log::error($e->getMessage());
      }


        // return $products_in_queue;
    }
}
