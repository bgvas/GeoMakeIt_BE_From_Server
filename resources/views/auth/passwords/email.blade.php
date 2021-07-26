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
            <p>Bring Your Music Along<span>try Unlimited</span></p>
        </div>
        <div class="text-2">
            <p><span>$9.99</span>/ Month</p>
        </div>
    </div>
    <form id="form" class="form-detail" method="POST" action="{{ route('password.email') }}">
        @csrf

        <h2>Get back to <span id="typed"></span></h2>

        <div class="status_message">
            @if (session('status'))
                <label>
                    {{ session('status') }}
                </label>
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

        <div class="form-row-last">
            <input type="submit" name="reset" class="register" value="Send Password Reset Link">
            <label>Suddenly remembered? <a href="{{ route('login') }}">Login</a> instead.</label>
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
                },
                messages: {
                    email: {
                        required: "Please provide your email address"
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
