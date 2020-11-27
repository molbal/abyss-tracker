<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FitQuestionsController extends Controller
{
    /**
     * Gets questions for a fit
     * @param int $fitId
     */
    public static function getFitQuestions(int $fitId) {
        $questions = DB::table('fit_questions')
            ->join('chars', 'fit_questions.char_ID','=','chars.CHAR_ID')
            ->select(['fit_questions.char_id', 'fit_questions.created_at', 'fit_questions.question', 'chars.NAME'])
            ->where('fit_questions.fit_id', $fitId)
            ->orderByDesc('fit_questions.created_at')->limit(100)->get();
        $questions->dd();
    }
}
