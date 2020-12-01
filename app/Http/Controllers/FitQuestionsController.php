<?php

namespace App\Http\Controllers;

use App\FitAnswer;
use App\FitQuestion;
use App\Http\Requests\PostAnswerRequest;
use App\Http\Requests\PostQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FitQuestionsController extends Controller
{
    /**
     * Gets questions for a fit
     * @param int $fitId
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getFitQuestions(int $fitId): Collection {
        $questions = DB::table('fit_questions')
            ->join('chars', 'fit_questions.char_ID','=','chars.CHAR_ID')
            ->select(['fit_questions.id','fit_questions.char_id', 'fit_questions.created_at', 'fit_questions.question', 'chars.NAME'])
            ->where('fit_questions.fit_id', $fitId)
            ->orderByDesc('fit_questions.created_at')->limit(100)->get();
//        $questions->dd();

        $qIds = $questions->pluck('id');
        $answers = DB::table('fit_answers')
                       ->join('chars', 'fit_answers.char_ID','=','chars.CHAR_ID')
                       ->select(['fit_answers.id','fit_answers.char_id', 'fit_answers.created_at', 'fit_answers.text', 'chars.NAME', 'fit_answers.question_id'])
                       ->whereIn('fit_answers.question_id', $qIds)->get();

        return $questions->map(function ($item, $key) use ($answers) {
            $item->answers = $answers->where('question_id', $item->id)->sortBy('created_at');
            return $item;
        });
    }


    public function postQuestion(PostQuestionRequest $request) {
        $model = new FitQuestion();
        $model->fit_id = $request->get('fit_id');
        $model->char_id = session()->get('login_id');
        $model->question = $request->get('question');
        $model->save();
        // TODO notify fit owner

        // Redirect with message
        return view('autoredirect', [
            'title' => "Success",
            'message' => "New question posted",
            'redirect' => route('fit_single', ['id' => $request->get('fit_id')])
        ]);
    }

    public function postAnswer(PostAnswerRequest $request) {
        $model = new FitAnswer();
        $model->char_id = session()->get('login_id');
        $model->question_id = $request->get('question_id');
        $model->text = $request->get('text');
        $model->save();
        // TODO notify fit owner

        // Redirect with message
        return view('autoredirect', [
            'title' => "Success",
            'message' => "New answer posted",
            'redirect' => route('fit_single', ['id' => $request->get('fit_id')])
        ]);
    }
}
