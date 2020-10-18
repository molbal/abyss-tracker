<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * App\Http\Controllers\Models\FitHistoryItem
 *
 * @property int $id
 * @property int $fit_root_id
 * @property int $fit_it
 * @property string $event
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem whereFitIt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem whereFitRootId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitHistoryItem whereId($value)
 * @mixin \Eloquent
 */
class FitHistoryItem extends Model
{


    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fit_logs';


    /** ID of the history item
     *
     * @var int
     */
    public $id;

    /** ID of the fit root id
     *
     * @var int
     */
    public $fit_root_id;

    /** ID of the fit ID
     *
     * @var int
     */
    public $fit_it;

    /** Event text (max 255 char)
     *
     * @var string
     */
    public $event;

    /**
     * Timestamp
     *
     * @var Carbon
     */
    public $created_at;
}
