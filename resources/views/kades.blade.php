@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Kades Dashboard') }}</div>

                    <div class="card-body">
                        {{ __('You are logged in as kades!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
