<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FitQuestion
 *
 * @property int $id
 * @property int $fit_id
 * @property int $char_id
 * @property string $question
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereCharId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereFitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Char|null $char
 */
class FitQuestion extends Model
{

    public function char() {
        return $this->hasOne('App\Char', 'CHAR_ID', 'char_id');
    }
}
