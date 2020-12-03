@forelse($questions as $question)
    <div class="d-flex w-100 justify-content-start align-items-top question-container" id="question_{{$question->id}}">
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
                        Private
                    @else
                        <a href="{{route('profile.index', ['id' => $question->char_id])}}">{{$question->NAME}}</a>
                    @endif
                    @if($question->char_id == $fit->CHAR_ID)
                        <span class="badge badge-secondary text-white ml-1 bu-3"><small>Fit uploader</small></span>
                    @endif
                </span>
                <small data-toggle="tooltip" title="{{$question->created_at}}" class="text-uppercase">
                    {{\App\Http\Controllers\TimeHelper::timeElapsedString($question->created_at)}}
                </small>
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
                                    Private
                                @else
                                    <a href="{{route('profile.index', ['id' => $answer->char_id])}}">{{$answer->NAME}}</a>
                                @endif
                                @if($answer->char_id == $fit->CHAR_ID)
                                    <span class="badge badge-secondary text-white ml-1 bu-3"><small>Fit uploader</small></span>
                                @endif</span>
                            <small data-toggle="tooltip" title="{{$answer->created_at}}" class="text-uppercase">
                                {{\App\Http\Controllers\TimeHelper::timeElapsedString($answer->created_at)}}
                            </small>
                        </div>
                        <p class="text-justify">
                            {{$answer->text}}
                        </p>
                    </span>
                </div>
            @empty
                <em class="d-block w-100 pt-2 pb-3 text-center text-muted">No answers yet to this question.</em>
            @endforelse

            @if (session()->has("login_id"))
                <div class="d-flex w-100 justify-content-start align-items-top mb-2">
                    <span class="answer-image">
                        <img src="https://images.evetech.net/characters/{{session('login_id')}}/portrait?size=128" class="shadow rounded-circle compose" alt="Avatar">
                    </span>
                    <span class="answer-content pl-3 w-100">
                        <form action="{{route('fit.questions.answer')}}" method="post">
                            @csrf
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <input type="hidden" name="fit_id" value="{{$fit->ID}}">
                            <label for="text">Answer this question as {{session('login_name')}}</label>
                            <textarea name="text" id="text" class="form-control w-100" rows="1" title="No formatting allowed"></textarea>
                            <input type="submit" value="Submit answer" class="btn btn-sm btn-outline-primary mt-3">
                        </form>
                    </span>
                </div>
            @endif
        </div>
    </div>
@empty
    <em class="d-block w-100 py-5 text-center text-muted">No questions yet - be the first to ask one.</em>
@endforelse
<hr>
<h5 class="font-weight-bold">Ask a new question</h5>
@if (session()->has("login_id"))
    <form action="{{route('fit.questions.new')}}" method="post" class="mb-3">
        @csrf
        <input type="hidden" name="fit_id" value="{{$fit->ID}}">
        <div class="form-group">
            <label for="question" class="w-100 d-flex justify-content-between align-items-center"><span>Type your question below</span><small>The fit uploader will be notified
                    ingame.</small></label>
            <textarea name="question" id="question" class="form-control w-100" rows="3" title="No formatting allowed"></textarea>
        </div>
        <input type="submit" value="Submit question" class="btn btn-outline-primary">
    </form>

    @if (session()->get('login_id') == $fit->CHAR_ID)
        @component('components.info-line')Since this fit's privacy selection is '{{ucwords($fit->PRIVACY)}}' your avatar and name will be
        <strong>{{$fit->PRIVACY == 'public' ? 'displayed' : 'hidden'}}</strong>. @endcomponent
    @endif
@else
    @component('components.info-line') Sign in to add questions or answers. @endcomponent
@endif
