@extends('layouts.registration_form.default')

<!-- TODO: Match Validation -->
@section('content')
    <div id="typed-strings" style="display: none;">
        <p>Games^1000</p>
        <p>Plugins^1000</p>
        <p>Awesomeness</p>
    </div>
    <div class="form-left">
        <img src="{{ url('registration_form/images/form-v2.jpg') }}" alt="form">
        <div class="text-1">
            <p>Start building your world<span>try it for free!</span></p>
        </div>
        <div class="text-2">
            <p><span style="font-size:15px;"><del>$9.99</del></span> <span>$0</span>/ Month</p>
        </div>
    </div>
    <form id="form" class="form-detail" method="POST" action="{{ route('register') }}">
        @csrf

        <h2>Start creating <span id="typed"></span></h2>

        <!-- Full Name -->
        <div class="form-row">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-text" placeholder="Cave Johnson" aria-describedby="nameHelpText" required autofocus>
            @if (!empty($errors) && $errors->has('name'))
                <label id="'name-error" for="name" class="error">{{ $errors->first('name') }}</label>
            @endif
        </div>

        <!-- Email Address -->
        <div class="form-row">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="input-text" placeholder="lemon.crushing@service.com" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" aria-describedby="emailHelpText" required>
            @if (!empty($errors) && $errors->has('email'))
                <label id="'email-error" for="email" class="error">{{ $errors->first('email') }}</label>
            @endif
        </div>

        <!-- Password -->
        <div class="form-row">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input-text" aria-describedby="passwordHelpText" required minlength="8">
        </div>

        <!-- Password Confirm -->
        <div class="form-row">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="input-text" required minlength="8">
            @if (!empty($errors) && $errors->has('password'))
                <label id="'password_confirmation-error" for="password_confirmation" class="error">{{ $errors->first('password') }}</label>
            @endif
        </div>


        <!-- Terms of Service -->
        <div class="form-checkbox">
            <label class="container"><p>By signing up, you agree to the <a href="#" class="text">Play Term of Service</a></p>
                <input type="checkbox" name="agree" id="agree">
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="form-row-last">
            <input type="submit" name="register" class="register" value="Register">
            <label>Already registered? <a href="{{ route('login') }}">Login</a> instead.</label>
        </div>
    </form>
    @push('scripts')
        <script>
            $( "#form" ).validate({
                highlight: function(element, errorClass, validClass) {
                    let $lbl = $("#"+element.id+"-error");
                    if($lbl == undefined)
                        $lbl = $('<label id="'+element.id+'-error" for="'+element.id+'"></label>').insertAfter("#"+element.id);
                    $lbl.addClass(errorClass).removeClass(validClass).attr('style', '');;
                },
                unhighlight: function(element, errorClass, validClass) {
                    let $lbl = $("#"+element.id+"-error");
                    if($lbl.length == 0)
                        $lbl = $('<label id="'+element.id+'-error" for="'+element.id+'"></label>').insertAfter("#"+element.id);
                    $lbl.removeClass(errorClass).addClass(validClass).attr('style', '');
                },
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true,
                    },
                    password: "required",
                    password_confirmation: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please provide you full name"
                    },
                    email: {
                        required: "Please provide your email address"
                    },
                    password: {
                        required: "Please provide a password"
                    },
                    password_confirmation: {
                        required: "Please provide a password",
                        equalTo: "Wrong Password"
                    }
                }
            });
        </script>
        <script>
            var typed = new Typed('#typed', {
                stringsElement: '#typed-strings',
                typeSpeed: 50,
            });
        </script>
    @endpush
@endsection
