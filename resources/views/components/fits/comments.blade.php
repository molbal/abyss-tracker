@forelse($questions as $question)
    <div class="d-flex w-100 justify-content-start align-items-top">
                                <span class="comment-image">
                                    @if (strtoupper($fit->PRIVACY) != 'PUBLIC' && $question->char_id == $fit->CHAR_ID)
                                        <img src="https://images.evetech.net/characters/1/portrait?size=128" class="shadow rounded-circle" alt="Avatar">
                                    @else
                                        <img src="https://images.evetech.net/characters/{{$question->char_id}}/portrait?size=128" class="shadow rounded-circle" alt="Avatar">
                                    @endif
                                </span>
        <div class="comment-content pl-3 w-100">
            <div class="w-100 d-inline-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold text-uppercase">
                                            @if (strtoupper($fit->PRIVACY) != 'PUBLIC' && $question->char_id == $fit->CHAR_ID)
                                                <i>Private</i>
                                            @else
                                                <a href="{{route('profile.index', ['id' => $question->char_id])}}">{{$question->NAME}}</a>
                                            @endif
                                            @if($question->char_id == $fit->CHAR_ID) <span class="badge badge-secondary text-white ml-1 bu-3"><small>Fit uploader</small></span> @endif</span>
                <small data-toggle="tooltip" title="{{$question->created_at}}" class="text-uppercase">{{\App\Http\Controllers\TimeHelper::timeElapsedString($question->created_at)}}</small>
            </div>
            <p class="text-justify mb-3">{{$question->question}}</p>
            @forelse($question->answers as $answer)

                <div class="d-flex w-100 justify-content-start align-items-top mb-2">
                                            <span class="answer-image">
                                                @if (strtoupper($fit->PRIVACY) != 'PUBLIC' && $answer->char_id == $fit->CHAR_ID)
                                                    <img src="https://images.evetech.net/characters/1/portrait?size=128" class="shadow rounded-circle" alt="Avatar">
                                                @else
                                                    <img src="https://images.evetech.net/characters/{{$answer->char_id}}/portrait?size=128" class="shadow rounded-circle" alt="Avatar">
                                                @endif
                                            </span>
                    <span class="answer-content pl-3 w-100">
                                                <div class="w-100 d-inline-flex justify-content-between align-items-center">
                                                    <span class="font-weight-bold text-uppercase">
                                                        @if (strtoupper($fit->PRIVACY) != 'PUBLIC' && $answer->char_id == $fit->CHAR_ID)
                                                            <i>Private</i>
                                                        @else
                                                            <a href="{{route('profile.index', ['id' => $answer->char_id])}}">{{$answer->NAME}}</a>
                                                        @endif
                                                        @if($answer->char_id == $fit->CHAR_ID) <span class="badge badge-secondary text-white ml-1 bu-3"><small>Fit uploader</small></span> @endif</span>
                                                    <small data-toggle="tooltip" title="{{$answer->created_at}}" class="text-uppercase">{{\App\Http\Controllers\TimeHelper::timeElapsedString($answer->created_at)}}</small>
                                                </div>
                                                <p class="text-justify">{{$answer->text}}</p>
                                            </span>
                </div>
            @empty
                No Answers.
            @endforelse
        </div>
    </div>
@empty
    <em class="d-block w-100 py-5 text-center text-muted">No questions yet</em>
@endforelse
