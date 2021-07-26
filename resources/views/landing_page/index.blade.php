<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>GeoMakeIt! - Just Configure</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('landing_page/css/img/core-img/favicon.ico') }}">

    <!-- Core Stylesheet -->
    <link href="{{ url('landing_page/style.css') }}" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{ url('landing_page/css/responsive.css') }}" rel="stylesheet">

</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader">
        <div class="colorlib-load"></div>
    </div>

    <!-- ***** Header Area Start ***** -->
    <header class="header_area animated">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Menu Area Start -->
                <div class="col-12 col-lg-10">
                    <div class="menu_area">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <!-- Logo -->
                            <a class="navbar-brand" href="#"><img src="{{ url('landing_page/img/core-img/logo.png') }}" style="width: 100%;max-width: 227px;height:auto; max-height: 70px;" width="260" height="80"/></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ca-navbar" aria-controls="ca-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                            <!-- Menu Area -->
                            <div class="collapse navbar-collapse" id="ca-navbar">
                                <ul class="navbar-nav ml-auto" id="nav">
                                    <li class="nav-item active"><a class="nav-link" href="#home">Home</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
{{--                                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>--}}
{{--                                    <li class="nav-item"><a class="nav-link" href="#showcase">Showcase</a></li>--}}
{{--                                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>--}}
{{--                                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>--}}
                                </ul>
                                <div class="sing-up-button d-lg-none">
                                    <a href="{{ route('register') }}">Sign Up Free</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Signup btn -->
                <div class="col-12 col-lg-2">
                    <div class="sing-up-button d-none d-lg-block">
                        <a href="{{ route('register') }}">Sign Up Free</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Welcome Area Start ***** -->
    <section class="wellcome_area clearfix" id="home">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 col-md">
                    <div class="wellcome-heading">
                        <h2>GeoMakeIt!</h2>
                        <h3>G</h3>
                        <p>Create. Configure. Publish! Now you can make a game in 30 minutes!</p>
                    </div>
{{--                    <div class="get-start-area">--}}
{{--                        <!-- Form Start -->--}}
{{--                        <form action="#" method="post" class="form-inline">--}}
{{--                            <input type="email" class="form-control email" placeholder="name@company.com">--}}
{{--                            <input type="submit" class="submit" value="Get Started">--}}
{{--                        </form>--}}
{{--                        <!-- Form End -->--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        <!-- Welcome thumb -->
        <div class="welcome-thumb wow fadeInDown" data-wow-delay="0.5s">
            <img src="{{ url('landing_page/img/bg-img/welcome-img.png') }}" alt="">
        </div>
    </section>
    <!-- ***** Wellcome Area End ***** -->

    <!-- ***** Special Area Start ***** -->
    <section class="special-area bg-white section_padding_100" id="about">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading Area -->
                    <div class="section-heading text-center">
                        <h2>Why Is It Special</h2>
                        <div class="line-shape"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.2s">
                        <div class="single-icon">
                            <i class="ti-mobile" aria-hidden="true"></i>
                        </div>
                        <h4>Easy to use</h4>
                        <p>No need for complicated code and programming knowledge. Build your prototype, teach your class, release your game.</p>
                    </div>
                </div>
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.4s">
                        <div class="single-icon">
                            <i class="ti-plug" aria-hidden="true"></i>
                        </div>
                        <h4>Modular Design</h4>
                        <p>Already built plugins are available for you to instantly use. Make quizzes, fight monsters, create quests! Just plug 'n play.</p>
                    </div>
                </div>
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.6s">
                        <div class="single-icon">
                            <i class="ti-settings" aria-hidden="true"></i>
                        </div>
                        <h4>Customizability</h4>
                        <p>Create your own world. Configure plugins to create a unique experience for yourself, your students, your players!</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Special Description Area -->
        <div class="special_description_area mt-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="special_description_img">
                            <img src="{{ url('landing_page/img/bg-img/special.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-5 ml-xl-auto">
                        <div class="special_description_content">
                            <h2>Having doubts? Let's play a game together!</h2>
                            <p><span class="font-weight-bold">GeoQuestionIt!</span> is a single-player quiz game. Take your phone, go for a walk and answer the 10 questions. We made this in under 30 minutes.</p>

                            <div class="app-download-area">
                                <div class="app-download-btn wow fadeInUp" data-wow-delay="0.2s">
                                    <!-- Google Store Btn -->
                                    <a href="#">
                                        <i class="fa fa-android"></i>
                                        <p class="mb-0"><span>available on</span> Google Store</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Special Area End ***** -->

{{--    <!-- ***** Awesome Features Start ***** -->--}}
{{--    <section class="awesome-feature-area bg-white section_padding_0_50 clearfix" id="features">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <!-- Heading Text -->--}}
{{--                    <div class="section-heading text-center">--}}
{{--                        <h2>Awesome Features</h2>--}}
{{--                        <div class="line-shape"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-user" aria-hidden="true"></i>--}}
{{--                        <h5>Awesome Experience</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-pulse" aria-hidden="true"></i>--}}
{{--                        <h5>Fast and Simple</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-dashboard" aria-hidden="true"></i>--}}
{{--                        <h5>Clean Code</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-palette" aria-hidden="true"></i>--}}
{{--                        <h5>Perfect Design</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-crown" aria-hidden="true"></i>--}}
{{--                        <h5>Best Industry Leader</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Feature Start -->--}}
{{--                <div class="col-12 col-sm-6 col-lg-4">--}}
{{--                    <div class="single-feature">--}}
{{--                        <i class="ti-headphone" aria-hidden="true"></i>--}}
{{--                        <h5>24/7 Online Support</h5>--}}
{{--                        <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** Awesome Features End ***** -->--}}

{{--    <!-- ***** Video Area Start ***** -->--}}
{{--    <div class="video-section">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <!-- Video Area Start -->--}}
{{--                    <div class="video-area" style="background-image: url({{ url('landing_page/img/bg-img/video.jpg') }});">--}}
{{--                        <div class="video-play-btn">--}}
{{--                            <a href="https://www.youtube.com/watch?v=f5BBJ4ySgpo" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- ***** Video Area End ***** -->--}}

{{--    <!-- ***** Cool Facts Area Start ***** -->--}}
{{--    <section class="cool_facts_area clearfix">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <!-- Single Cool Fact-->--}}
{{--                <div class="col-12 col-md-3 col-lg-3">--}}
{{--                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.2s">--}}
{{--                        <div class="counter-area">--}}
{{--                            <h3><span class="counter">90</span></h3>--}}
{{--                        </div>--}}
{{--                        <div class="cool-facts-content">--}}
{{--                            <i class="ion-arrow-down-a"></i>--}}
{{--                            <p>APP <br> DOWNLOADS</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Cool Fact-->--}}
{{--                <div class="col-12 col-md-3 col-lg-3">--}}
{{--                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.4s">--}}
{{--                        <div class="counter-area">--}}
{{--                            <h3><span class="counter">120</span></h3>--}}
{{--                        </div>--}}
{{--                        <div class="cool-facts-content">--}}
{{--                            <i class="ion-happy-outline"></i>--}}
{{--                            <p>Happy <br> Clients</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Cool Fact-->--}}
{{--                <div class="col-12 col-md-3 col-lg-3">--}}
{{--                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.6s">--}}
{{--                        <div class="counter-area">--}}
{{--                            <h3><span class="counter">40</span></h3>--}}
{{--                        </div>--}}
{{--                        <div class="cool-facts-content">--}}
{{--                            <i class="ion-person"></i>--}}
{{--                            <p>ACTIVE <br>ACCOUNTS</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Single Cool Fact-->--}}
{{--                <div class="col-12 col-md-3 col-lg-3">--}}
{{--                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.8s">--}}
{{--                        <div class="counter-area">--}}
{{--                            <h3><span class="counter">10</span></h3>--}}
{{--                        </div>--}}
{{--                        <div class="cool-facts-content">--}}
{{--                            <i class="ion-ios-star-outline"></i>--}}
{{--                            <p>TOTAL <br>APP RATES</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** Cool Facts Area End ***** -->--}}

{{--    <!-- ***** App Screenshots Area Start ***** -->--}}
{{--    <section class="app-screenshots-area bg-white section_padding_0_100 clearfix" id="screenshot">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12 text-center">--}}
{{--                    <!-- Heading Text  -->--}}
{{--                    <div class="section-heading">--}}
{{--                        <h2>App Screenshots</h2>--}}
{{--                        <div class="line-shape"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <!-- App Screenshots Slides  -->--}}
{{--                    <div class="app_screenshots_slides owl-carousel">--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-1.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-2.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-3.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-4.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-5.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="single-shot">--}}
{{--                            <img src="{{ url('landing_page/img/scr-img/app-3.jpg') }}" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** App Screenshots Area End *****====== -->--}}

{{--    <!-- ***** Pricing Plane Area Start *****==== -->--}}
{{--    <section class="pricing-plane-area section_padding_100_70 clearfix" id="pricing">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <!-- Heading Text  -->--}}
{{--                    <div class="section-heading text-center">--}}
{{--                        <h2>Pricing Plan</h2>--}}
{{--                        <div class="line-shape"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row no-gutters">--}}
{{--                <div class="col-12 col-md-6 col-lg-3">--}}
{{--                    <!-- Package Price  -->--}}
{{--                    <div class="single-price-plan text-center">--}}
{{--                        <!-- Package Text  -->--}}
{{--                        <div class="package-plan">--}}
{{--                            <h5>Starter Plan</h5>--}}
{{--                            <div class="ca-price d-flex justify-content-center">--}}
{{--                                <span>$</span>--}}
{{--                                <h4>29</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="package-description">--}}
{{--                            <p>Up to 10 users monthly</p>--}}
{{--                            <p>Unlimited updates</p>--}}
{{--                            <p>Free host &amp; domain</p>--}}
{{--                            <p>24/7 Support</p>--}}
{{--                            <p>10 Unique Users</p>--}}
{{--                        </div>--}}
{{--                        <!-- Plan Button  -->--}}
{{--                        <div class="plan-button">--}}
{{--                            <a href="#">Select Plan</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6 col-lg-3">--}}
{{--                    <!-- Package Price  -->--}}
{{--                    <div class="single-price-plan text-center">--}}
{{--                        <!-- Package Text  -->--}}
{{--                        <div class="package-plan">--}}
{{--                            <h5>Basic Plan</h5>--}}
{{--                            <div class="ca-price d-flex justify-content-center">--}}
{{--                                <span>$</span>--}}
{{--                                <h4>49</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="package-description">--}}
{{--                            <p>Up to 10 users monthly</p>--}}
{{--                            <p>Unlimited updates</p>--}}
{{--                            <p>Free host &amp; domain</p>--}}
{{--                            <p>24/7 Support</p>--}}
{{--                            <p>10 Unique Users</p>--}}
{{--                        </div>--}}
{{--                        <!-- Plan Button  -->--}}
{{--                        <div class="plan-button">--}}
{{--                            <a href="#">Select Plan</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6 col-lg-3">--}}
{{--                    <!-- Package Price  -->--}}
{{--                    <div class="single-price-plan active text-center">--}}
{{--                        <!-- Package Text  -->--}}
{{--                        <div class="package-plan">--}}
{{--                            <h5>Advenced Plan</h5>--}}
{{--                            <div class="ca-price d-flex justify-content-center">--}}
{{--                                <span>$</span>--}}
{{--                                <h4>69</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="package-description">--}}
{{--                            <p>Up to 10 users monthly</p>--}}
{{--                            <p>Unlimited updates</p>--}}
{{--                            <p>Free host &amp; domain</p>--}}
{{--                            <p>24/7 Support</p>--}}
{{--                            <p>10 Unique Users</p>--}}
{{--                        </div>--}}
{{--                        <!-- Plan Button  -->--}}
{{--                        <div class="plan-button">--}}
{{--                            <a href="#">Select Plan</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6 col-lg-3">--}}
{{--                    <!-- Package Price  -->--}}
{{--                    <div class="single-price-plan text-center">--}}
{{--                        <!-- Package Text  -->--}}
{{--                        <div class="package-plan">--}}
{{--                            <h5>Community Plan</h5>--}}
{{--                            <div class="ca-price d-flex justify-content-center">--}}
{{--                                <span>$</span>--}}
{{--                                <h4>99</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="package-description">--}}
{{--                            <p>Up to 10 users monthly</p>--}}
{{--                            <p>Unlimited updates</p>--}}
{{--                            <p>Free host &amp; domain</p>--}}
{{--                            <p>24/7 Support</p>--}}
{{--                            <p>10 Unique Users</p>--}}
{{--                        </div>--}}
{{--                        <!-- Plan Button  -->--}}
{{--                        <div class="plan-button">--}}
{{--                            <a href="#">Select Plan</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** Pricing Plane Area End ***** -->--}}

{{--    <!-- ***** CTA Area Start ***** -->--}}
{{--    <section class="our-monthly-membership section_padding_50 clearfix">--}}
{{--        <div class="container">--}}
{{--            <div class="row align-items-center">--}}
{{--                <div class="col-md-8">--}}
{{--                    <div class="membership-description">--}}
{{--                        <h2>Join our Monthly Membership</h2>--}}
{{--                        <p>Find the perfect plan for you — 100% satisfaction guaranteed.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="get-started-button wow bounceInDown" data-wow-delay="0.5s">--}}
{{--                        <a href="#">Get Started</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** CTA Area End ***** -->--}}

{{--    <!-- ***** Contact Us Area Start ***** -->--}}
{{--    <section class="footer-contact-area section_padding_100 clearfix" id="contact">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <!-- Heading Text  -->--}}
{{--                    <div class="section-heading">--}}
{{--                        <h2>Get in touch with us!</h2>--}}
{{--                        <div class="line-shape"></div>--}}
{{--                    </div>--}}
{{--                    <div class="footer-text">--}}
{{--                        <p>We'll send you epic weekly blogs, whitepapers and things to make your app startup thrive, all FREE!</p>--}}
{{--                    </div>--}}
{{--                    <div class="address-text">--}}
{{--                        <p><span>Address:</span> 40 Baria Sreet 133/2 NewYork City, US</p>--}}
{{--                    </div>--}}
{{--                    <div class="phone-text">--}}
{{--                        <p><span>Phone:</span> +11-225-888-888-66</p>--}}
{{--                    </div>--}}
{{--                    <div class="email-text">--}}
{{--                        <p><span>Email:</span> info.deercreative@gmail.com</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <!-- Form Start-->--}}
{{--                    <div class="contact_from">--}}
{{--                        <form action="#" method="post">--}}
{{--                            <!-- Message Input Area Start -->--}}
{{--                            <div class="contact_input_area">--}}
{{--                                <div class="row">--}}
{{--                                    <!-- Single Input Area Start -->--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Single Input Area Start -->--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="email" class="form-control" name="email" id="email" placeholder="Your E-mail" required>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Single Input Area Start -->--}}
{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Your Message *" required></textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Single Input Area Start -->--}}
{{--                                    <div class="col-12">--}}
{{--                                        <button type="submit" class="btn submit-btn">Send Now</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- Message Input Area End -->--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- ***** Contact Us Area End ***** -->--}}

    <!-- ***** Footer Area Start ***** -->
    <footer class="footer-social-icon text-center section_padding_70 clearfix">
        <!-- footer logo -->
        <div class="footer-text">
            <h2>GeoMakeIt!</h2>
        </div>
        <!-- social icon-->
        <div class="footer-social-icon">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"> <i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
        </div>
        <div class="footer-menu">
            <nav>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Terms &amp; Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        <!-- Foooter Text-->
        <div class="copyright-text">
            <!-- ***** Removing this text is now allowed! This template is licensed under CC BY 3.0 ***** -->
            <p>Copyright ©2017 Ca. Designed by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
        </div>
    </footer>
    <!-- ***** Footer Area Start ***** -->

    <!-- Jquery-2.2.4 JS -->
    <script src="{{ url('landing_page/js/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ url('landing_page/js/popper.min.js') }}"></script>
    <!-- Bootstrap-4 Beta JS -->
    <script src="{{ url('landing_page/js/bootstrap.min.js') }}"></script>
    <!-- All Plugins JS -->
    <script src="{{ url('landing_page/js/plugins.js') }}"></script>
    <!-- Slick Slider Js-->
    <script src="{{ url('landing_page/js/slick.min.js') }}"></script>
    <!-- Footer Reveal JS -->
    <script src="{{ url('landing_page/js/footer-reveal.min.js') }}"></script>
    <!-- Active JS -->
    <script src="{{ url('landing_page/js/active.js') }}"></script>
</body>

</html>
