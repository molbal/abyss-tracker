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
 * @property int $id
 * @property string $uuid
 * @property int $run_id
 * @property array $raw_import
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereRawImport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telemetry whereUuid($value)
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

    /**
     * Gets if Telemetry data is assigned to a run
     * @param int $run_id
     * @return bool
     */
    public static function existsForRun(int $run_id): bool
    {
        return self::where('run_id', $run_id)->exists();
    }


    /**
     * Gets assigned telemetry to a run
     * @param int $run_id
     * @return Telemetry
     */
    public static function getForRun(int $run_id):array
    {
        return self::where('run_id', $run_id)->firstOrFail()->raw_import;
    }

}
