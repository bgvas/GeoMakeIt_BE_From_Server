@extends('layouts.registration_form.default')

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
    <form id="form" class="form-detail" method="POST" action="{{ route('login') }}">
        @csrf

        <h2>Get back to <span id="typed"></span></h2>

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
            @if (!empty($errors) && $errors->has('password'))
                <label id="'password_confirmation-error" for="password_confirmation" class="error">{{ $errors->first('password') }}</label>
            @endif
        </div>

        <!-- Remember Me? -->
        <div class="form-checkbox">
            <label class="container"><p>Remember me?</p>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark" style="top:5px;"></span>
            </label>
        </div>
        <div class="form-row-last">
            <input type="submit" name="login" class="register" value="Login">
            <label><a href="{{ route('password.request') }}">Forgot Your Password?</a></label>
            <label>New here? Start by <a href="{{ route('register') }}">creating an account</a>.</label>
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
                    email: {
                        required: true,
                        email: true,
                    },
                    password: "required",
                },
                messages: {
                    email: {
                        required: "Please provide your email address"
                    },
                    password: {
                        required: "Please provide a password"
                    },
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
