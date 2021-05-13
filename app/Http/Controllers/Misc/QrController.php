<?php


    namespace App\Http\Controllers\Misc;


    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    class QrController extends Controller {


        /**
         * Returns a QR code for the run, if it exists.
         * @param int $id
         *
         * @return mixed
         */
        public function runQr(int $id) {

            if (!Cache::remember('runs.exists.'.$id, now()->addSeconds(3), function () use ($id) {
                return DB::table('runs')->where('ID','=', $id)->exists();
            })) {
                abort(404);
            }

            return QrCode::format('svg')
                         ->size(300)
                         ->style('round')
                         ->gradient(26, 3, 3, 247, 52, 42, 'inverse_diagonal')
                         ->generate(\route('view_single', ['id' => $id]));
        }
    }
