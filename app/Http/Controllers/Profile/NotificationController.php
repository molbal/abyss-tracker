<?php

namespace App\Http\Controllers\Profile;

use App\Char;
use App\Connector\EveAPI\Mail\MailService;
use App\Fit;
use App\FitAnswer;
use App\FitQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /** @var MailService */
    private $mailService;

    /**
     * FitQuestionsController constructor.
     *
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService) {
        $this->mailService = $mailService;
    }

    public function sendNewFitQuestionNotification(Fit $fit, FitQuestion $fitQuestion, Char $sender) {
        $text = __('mail-notifications.new-question', [
            'name' => $fit->char->NAME,
            'askercharid' => $sender->CHAR_ID,
            'askercharname' => $sender->NAME,
            'shipid' => $fit->ship->ID,
            'shipname' => $fit->ship->NAME,
            'fit' => trim($fit->NAME),
            'url' => route('fit_single', ['id' => $fit->ID])
        ]);

        $this->mailService->sendMaiItoCharacter(config('tracker.accountant.char-id'), $fit->char->CHAR_ID, 'New question on your fit '.trim($fit->NAME), $text);

    }

    public function sendNewFitAnswerNotification(Fit $fit, FitQuestion $question, FitAnswer $fitAnswer, Char $sender) {

        $text = __('mail-notifications.new-answer', [
            'name' => $question->char->NAME,
            'answercharid' => $sender->CHAR_ID,
            'answercharname' => $sender->NAME,
            'shipid' => $fit->ship->ID,
            'shipname' => $fit->ship->NAME,
            'fit' => trim($fit->NAME),
            'url' => route('fit_single', ['id' => $fit->ID])
        ]);

        $this->mailService->sendMaiItoCharacter(config('tracker.accountant.char-id'), $fit->char->CHAR_ID, 'New answer on your question on the fit '.trim($fit->NAME), $text);

    }
}
