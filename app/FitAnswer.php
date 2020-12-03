<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FitAnswer
 *
 * @property int $id
 * @property int $char_id
 * @property int $question_id
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\FitQuestion|null $question
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereCharId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitAnswer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FitAnswer extends Model
{
    public function char() {
        return $this->hasOne('App\Char', 'CHAR_ID', 'char_id');
    }
}
