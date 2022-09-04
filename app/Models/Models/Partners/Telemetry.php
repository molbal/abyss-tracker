<?php

namespace App\Models\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Models\Partners\Telemetry
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry query()
 * @mixin \Eloquent
 */
class Telemetry extends Model
{
    public static function make(array $payload, int $run_id) {
        $model = new self();
        $model->uuid = $payload['recordUUID'];
        $model->run_id = $run_id;
        $model->raw_import = $payload;
        $model->saveOrFail();
    }

    protected $casts = [
      'raw_import' => 'array',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];
    protected $table = 'telemetry';
    use HasFactory;
}
