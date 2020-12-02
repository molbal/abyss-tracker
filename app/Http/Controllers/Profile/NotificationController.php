<?php

namespace App\Http\Controllers\Profile;

use App\Char;
use App\Connector\EveAPI\Mail\MailService;
use App\Fit;
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

//        dd($fit->char);

        $text = __('mail-notifications.new-question', [
            'name' => $fit->char()->NAME
        ]);
        dd($text);
    }
}
