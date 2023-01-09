<?php


    namespace App\Http\Controllers\Misc;


    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Response;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    class QrController extends Controller {



        public function runQr(int $id, string $color='000000') {

            if (!Cache::remember('runs.exists.'.$id, now()->addSeconds(3), function () use ($id) {
                return DB::table('runs')->where('ID','=', $id)->exists();
            })) {
                abort(404);
            }
            [$r, $g, $b] = array_map('hexdec', str_split(ltrim($color, '#'), 2));

            $contents = QrCode::format('svg')
                         ->size(300)
                         ->style('round')
                         ->gradient(26, 3, 3, $r, $g, $b, 'inverse_diagonal')
                         ->generate(\route('view_single', ['id' => $id]));

            $response = Response::make($contents);
            $response->header('Content-Type', 'image/svg+xml');
            return $response;
        }
    }
