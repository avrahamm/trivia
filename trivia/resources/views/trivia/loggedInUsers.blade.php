@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Logged in users') }}</div>

                <ul class="list-group">
                    @foreach ($users as $user)
                        <li class="list-group-item">
                            <p>{{ $user->name }}</p>
                        </li>
                    @endforeach
                </ul>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

