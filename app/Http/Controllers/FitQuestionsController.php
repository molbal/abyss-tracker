<?php

namespace App\Http\Controllers;

use App\Char;
use App\Connector\EveAPI\Mail\MailService;
use App\Fit;
use App\FitAnswer;
use App\FitQuestion;
use App\Http\Controllers\Profile\NotificationController;
use App\Http\Requests\PostAnswerRequest;
use App\Http\Requests\PostQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FitQuestionsController extends Controller
{

    /** @var NotificationController */
    public $notificationController;

    /**
     * FitQuestionsController constructor.
     *
     * @param NotificationController $notificationController
     */
    public function __construct(NotificationController $notificationController) {
        $this->notificationController = $notificationController;
    }


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


    /**
     * @param PostQuestionRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postQuestion(PostQuestionRequest $request) {
        $fit = Fit::where('ID',$request->get('fit_id'))->first();
        $char = Char::where('CHAR_ID',session()->get('login_id'))->first();
        $fitQuestion = new FitQuestion();
        $fitQuestion->fit_id = $fit->ID;
        $fitQuestion->char_id = $char->CHAR_ID;
        $fitQuestion->question = $request->get('question');
        $fitQuestion->save();

        $this->notificationController->sendNewFitQuestionNotification($fit, $fitQuestion, $char);

        // Redirect with message
        return view('autoredirect', [
            'title' => "Success",
            'message' => "New question posted - thank you for your contribution",
            'redirect' => route('fit_single', ['id' => $fit->ID])
        ]);
    }

    public function postAnswer(PostAnswerRequest $request) {
        $fit = Fit::where('ID',$request->get('fit_id'))->first();
        $char = Char::where('CHAR_ID',session()->get('login_id'))->first();
        $question = FitQuestion::where('id', $request->get('question_id'))->first();
        $fitAnswer = new FitAnswer();
        $fitAnswer->char_id = $char->CHAR_ID;
        $fitAnswer->question_id = $question->id;
        $fitAnswer->text = $request->get('text');
        $fitAnswer->save();

        $this->notificationController->sendNewFitAnswerNotification($fit, $question, $fitAnswer, $char);


        // Redirect with message
        return view('autoredirect', [
            'title' => "Success",
            'message' => "New answer saved - thank you for your contribution",
            'redirect' => route('fit_single', ['id' => $request->get('fit_id')])
        ]);
    }
}
