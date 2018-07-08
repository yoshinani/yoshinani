@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if(session()->has('message'))
                    <div class="alert alert-info mb-3">
                        {{session('message')}}
                    </div>
                @endif
                <div class="panel-heading">Dashboard</div>
                <div class="panel-heading">
                    <a href="{{ route('home.user.withdrawal') }}">
                        Withdrawal
                    </a>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
