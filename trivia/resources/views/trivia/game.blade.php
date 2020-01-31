@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Game form') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('game.checkAnswer') }}">
                        @csrf
                        <input type="hidden" id="questionId" name="questionId" value="{{ $question->id }}">
                        <div class="form-group row">
                            <label for="question" class="col-md-2 col-form-label text-md-right">{{ __('Question') }}</label>

                            <div class="col-md-10">
                                <textarea id="question" class="form-control" style="resize:none;" rows="4"
                                          readonly>{{ $question->question }}</textarea>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="answer" class="col-md-2 col-form-label text-md-right">{{ __('Answer') }}</label>

                            <div class="col-md-10">
                                <textarea id="answer" class="form-control @error('answer')
                                    is-invalid @enderror" name="answer" required  autofocus
                                >{{ old('answer') }}</textarea>

                                @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gameMessage" class="col-md-2 col-form-label text-md-right">{{ __('Game Message') }}</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control"
                                       value="{{$gameMessage}}" placeholder="Message about answer" id="gameMessage"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
