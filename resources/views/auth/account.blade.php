@extends('layouts.studio')

@section('page_title', 'Account Settings')
@section('show_title', true)

@section('content')
    @if (!empty(session('alert-type')))
    <div class="alert alert-dismissible {{ 'alert-'.session('alert-type') ?: '' }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('message') }}
    </div>
    @endif

    <div class="card">
        <form role="form" method="POST" action="{{ route('studio.account') }}">
            @csrf
            <div class="card-body">
                @if (!empty($errors) && $errors->has('name'))
                        <div class="callout small alert text-center" id="nameHelpText">
                            <p>{{ $errors->first('name') }}</p>
                        </div>
                    @endif
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter name" value="{{ $user->name }}">
                </div>
                    @if (!empty($errors) && $errors->has('email'))
                        <div class="callout small alert text-center" id="emailHelpText">
                            <p>{{ $errors->first('email') }}</p>
                        </div>
                    @endif

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Enter email" value="{{ $user->email }}">
                </div>

                    @if (!empty($errors) && $errors->has('password'))
                        <div class="callout small alert text-center" id="password">
                            <p>{{ $errors->first('password') }}</p>
                        </div>
                    @endif
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Password Confirm</label>
                    <input id="password_confirm" name="password_confirm" type="password_confirm" class="form-control" placeholder="Password confirm">
                </div>
                <button type="submit" class="btn btn-primary">Update my account</button>
            </div>
        </form>
    </div>
@endsection
