<?php


	namespace App\Http\Controllers\Profile;


	use App\Http\Controllers\Controller;

    class ProfileController extends Controller {
        public function index(int $id) {
            return view('profile', [
                'id' => $id
            ]);
        }
	}
