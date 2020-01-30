<?php


    namespace App\Http\Controllers;


    class ItemController extends Controller {

        public function get_single(int $item_id) {
            return view('error', [
                "error" => "This page will contain the details, prices, and drop rates of this item. It is not ready yet."
            ]);
        }
    }
