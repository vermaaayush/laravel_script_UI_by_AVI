<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{--{{ $bankName }}--}}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="css/keyboard.css" rel="stylesheet">
    <style type="text/css">
        .ui-widget-content {
            border: 1px solid var(--iq-border-light);
            background: #fff !important;
            color: #1e3d73;
        }
        .online-support{margin-top: 10px;}
        .online-support h3{background: #fe517e;color: #fff; padding-left: 15px;margin-bottom: 10px;border:1px solid transparent;box-shadow: 0px 2px 5px 2px rgba(0,0,0,0.1)}
        .online-support .btn-link{color:#fff;border-bottom: 1px solid #fff;border-radius: 0px;}
        .input-group-text{font-size: 20px; }
    </style>
</head>
<body>
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Sign in Start -->
<section class="sign-in-page">
    <div class="container p-0">
        <div class="row no-gutters height-self-center">
            <div class="col-sm-12 align-self-center rounded">
                <div class="row m-0">
                    <div class="col-md-12 bg-white sign-in-page-data">
                        <div class="sign-in-from">
                            <h3 class="mb-0 text-center">Bank Account</h3>
                            <p class="text-center text-dark">{{--{{ $bankName }}--}} Bank Account Registration
                                <br>
                                {{ $echo2 ?? '' }}</p>


                            <div class="flex flex-wrap -mx-3">
                                <div class="col-12 text-dark">
                                    @include('flash::message')
                                    <form id="form-wizard1" class="text-center mt-6" role="form" method="POST" action="verifyunregisteraccount">
                                    @csrf
                                    <!-- fieldsets -->
{{--                                        @if($otp == 'show' or $otp == 'show2')--}}
                                            <fieldset class="text-center">
                                                <div class="form-card text-left">
                                                    <div class="flex flex-wrap -mx-3">
                                                        <div class="col-12">
                                                            <h3 class="text-center">Enter Email OTP</h3>
                                                            <p class="text-center">We have sent you Token OTP via Email ! Please write OTP to proceed!</p>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="w-full md:w-1/2 px-3">
                                                            <div class="mb-6">
                                                                <!-- <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name: *</label> -->
                                                                <input type="text" required class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="otpcode" name="mailotp" placeholder="Enter OTP here" value="{{--@if($otp == 'show2')
                                                                {{ $otprequired ?? '' }}
                                                                @endif--}}">
                                                                 <input type="hidden" name="user_id" value="{{$user_id}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           <!--     <div class="form-card text-left">
                                                    <div class="flex flex-wrap -mx-3">
                                                        <div class="col-12">
                                                            <h3 class="text-center">Enter Mobile OTP</h3>
                                                            <p class="text-center">We have sent you Token OTP via Email ! Please write OTP to proceed!</p>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="w-full md:w-1/2 px-3">
                                                            <div class="mb-6">
                                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name: *</label> 
                                                                <input type="text" required class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="otpcode" name="phoneotp" placeholder="Enter OTP here" value="{{--@if($otp == 'show2')
                                                                {{ $otprequired ?? '' }}
                                                                @endif--}}">
                                                                <input type="hidden" name="user_id" value="{{$user_id}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <button type="submit" name="submit" id="otpsequal" class="btn btn-primary next action-button " value="submitotp">Submit</button>
{{--                                                <button type="button" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2" data-toggle="modal" data-target="#exampleModalCenter">--}}
{{--                                                    Launch demo modal--}}
{{--                                                </button>--}}
                                                <a href="{{  url('change')  }}" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">Change your   email/Phone</a>
                                                <div class="clearfix"></div>
                                                <p class="text-center">Entering the wrong OTP more than 3 times will lead to suspension of the account. You have <span id='attempts'>3</span> attempts left. <br> If you have any problems with acquiring the OTP, Please contact your account Officer, <br>or visit our nearest Branch</p>


                                            </fieldset>
{{--                                        @endif--}}


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-[#b34020] text-white">
                    <h5 class="modal-title text-white" id="exampleModalCenterTitle">Bank Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="change" method="post">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                            <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                   name="firstappemail"
                                   value="{{$recover->firstappemail ?? '' }}">
                           <input type="hidden" name="user_id" value="{{$user_id}}" >
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Country code *</label>
                            <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="countrycode" required>
                                <option value="">Code</option>
                                <option
                                    value="+93" <?php if (isset($recover) and ($recover->countrycode == '+93')) {
                                    echo ' selected ';
                                } ?> >+93 (Afghanistan)
                                </option>
                                <option
                                    value="+355" <?php if (isset($recover) and ($recover->countrycode == '+355')) {
                                    echo ' selected ';
                                } ?> >+355 (Albania)
                                </option>
                                <option
                                    value="+213" <?php if (isset($recover) and ($recover->countrycode == '+213')) {
                                    echo ' selected ';
                                } ?> >+213 (Algeria)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (American Samoa)
                                </option>
                                <option
                                    value="+376" <?php if (isset($recover) and ($recover->countrycode == '+376')) {
                                    echo ' selected ';
                                } ?> >+376 (Andorra)
                                </option>
                                <option
                                    value="+244" <?php if (isset($recover) and ($recover->countrycode == '+244')) {
                                    echo ' selected ';
                                } ?> >+244 (Angola)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Anguilla)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Antigua and Barbuda)
                                </option>
                                <option
                                    value="+54" <?php if (isset($recover) and ($recover->countrycode == '+54')) {
                                    echo ' selected ';
                                } ?> >+54 (Argentina)
                                </option>
                                <option
                                    value="+374" <?php if (isset($recover) and ($recover->countrycode == '+374')) {
                                    echo ' selected ';
                                } ?> >+374 (Armenia)
                                </option>
                                <option
                                    value="+297" <?php if (isset($recover) and ($recover->countrycode == '+297')) {
                                    echo ' selected ';
                                } ?> >+297 (Aruba)
                                </option>
                                <option
                                    value="+247" <?php if (isset($recover) and ($recover->countrycode == '+247')) {
                                    echo ' selected ';
                                } ?> >+247 (Ascension)
                                </option>
                                <option
                                    value="+61" <?php if (isset($recover) and ($recover->countrycode == '+61')) {
                                    echo ' selected ';
                                } ?> >+61 (Australia)
                                </option>
                                <option
                                    value="+672" <?php if (isset($recover) and ($recover->countrycode == '+672')) {
                                    echo ' selected ';
                                } ?> >+672 (Australian External Territories)
                                </option>
                                <option
                                    value="+43" <?php if (isset($recover) and ($recover->countrycode == '+43')) {
                                    echo ' selected ';
                                } ?> >+43 (Austria)
                                </option>
                                <option
                                    value="+994" <?php if (isset($recover) and ($recover->countrycode == '+994')) {
                                    echo ' selected ';
                                } ?> >+994 (Azerbaijan)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Bahamas)
                                </option>
                                <option
                                    value="+973" <?php if (isset($recover) and ($recover->countrycode == '+973')) {
                                    echo ' selected ';
                                } ?> >+973 (Bahrain)
                                </option>
                                <option
                                    value="+880" <?php if (isset($recover) and ($recover->countrycode == '+880')) {
                                    echo ' selected ';
                                } ?> >+880 (Bangladesh)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Barbados)
                                </option>
                                <option
                                    value="+375" <?php if (isset($recover) and ($recover->countrycode == '+375')) {
                                    echo ' selected ';
                                } ?> >+375 (Belarus)
                                </option>
                                <option
                                    value="+32" <?php if (isset($recover) and ($recover->countrycode == '+32')) {
                                    echo ' selected ';
                                } ?> >+32 (Belgium)
                                </option>
                                <option
                                    value="+501" <?php if (isset($recover) and ($recover->countrycode == '+501')) {
                                    echo ' selected ';
                                } ?> >+501 (Belize)
                                </option>
                                <option
                                    value="+229" <?php if (isset($recover) and ($recover->countrycode == '+229')) {
                                    echo ' selected ';
                                } ?> >+229 (Benin)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Bermuda)
                                </option>
                                <option
                                    value="+975" <?php if (isset($recover) and ($recover->countrycode == '+975')) {
                                    echo ' selected ';
                                } ?> >+975 (Bhutan)
                                </option>
                                <option
                                    value="+591" <?php if (isset($recover) and ($recover->countrycode == '+591')) {
                                    echo ' selected ';
                                } ?> >+591 (Bolivia)
                                </option>
                                <option
                                    value="+387" <?php if (isset($recover) and ($recover->countrycode == '+387')) {
                                    echo ' selected ';
                                } ?> >+387 (Bosnia and Herzegovina)
                                </option>
                                <option
                                    value="+267" <?php if (isset($recover) and ($recover->countrycode == '+267')) {
                                    echo ' selected ';
                                } ?> >+267 (Botswana)
                                </option>
                                <option
                                    value="+55" <?php if (isset($recover) and ($recover->countrycode == '+55')) {
                                    echo ' selected ';
                                } ?> >+55 (Brazil)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (British Virgin Islands)
                                </option>
                                <option
                                    value="+673" <?php if (isset($recover) and ($recover->countrycode == '+673')) {
                                    echo ' selected ';
                                } ?> >+673 (Brunei Darussalam)
                                </option>
                                <option
                                    value="+359" <?php if (isset($recover) and ($recover->countrycode == '+359')) {
                                    echo ' selected ';
                                } ?> >+359 (Bulgaria)
                                </option>
                                <option
                                    value="+226" <?php if (isset($recover) and ($recover->countrycode == '+226')) {
                                    echo ' selected ';
                                } ?> >+226 (Burkina Faso)
                                </option>
                                <option
                                    value="+257" <?php if (isset($recover) and ($recover->countrycode == '+257')) {
                                    echo ' selected ';
                                } ?> >+257 (Burundi)
                                </option>
                                <option
                                    value="+855" <?php if (isset($recover) and ($recover->countrycode == '+855')) {
                                    echo ' selected ';
                                } ?> >+855 (Cambodia)
                                </option>
                                <option
                                    value="+237" <?php if (isset($recover) and ($recover->countrycode == '+237')) {
                                    echo ' selected ';
                                } ?> >+237 (Cameroon)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Canada)
                                </option>
                                <option
                                    value="+238" <?php if (isset($recover) and ($recover->countrycode == '+238')) {
                                    echo ' selected ';
                                } ?> >+238 (Cape Verde)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Cayman Islands)
                                </option>
                                <option
                                    value="+236" <?php if (isset($recover) and ($recover->countrycode == '+236')) {
                                    echo ' selected ';
                                } ?> >+236 (Central African Republic)
                                </option>
                                <option
                                    value="+235" <?php if (isset($recover) and ($recover->countrycode == '+235')) {
                                    echo ' selected ';
                                } ?> >+235 (Chad)
                                </option>
                                <option
                                    value="+56" <?php if (isset($recover) and ($recover->countrycode == '+56')) {
                                    echo ' selected ';
                                } ?> >+56 (Chile)
                                </option>
                                <option
                                    value="+86" <?php if (isset($recover) and ($recover->countrycode == '+86')) {
                                    echo ' selected ';
                                } ?> >+86 (China)
                                </option>
                                <option
                                    value="+57" <?php if (isset($recover) and ($recover->countrycode == '+57')) {
                                    echo ' selected ';
                                } ?> >+57 (Colombia)
                                </option>
                                <option
                                    value="+269" <?php if (isset($recover) and ($recover->countrycode == '+269')) {
                                    echo ' selected ';
                                } ?> >+269 (Comoros)
                                </option>
                                <option
                                    value="+242" <?php if (isset($recover) and ($recover->countrycode == '+242')) {
                                    echo ' selected ';
                                } ?> >+242 (Congo)
                                </option>
                                <option
                                    value="+682" <?php if (isset($recover) and ($recover->countrycode == '+682')) {
                                    echo ' selected ';
                                } ?> >+682 (Cook Islands)
                                </option>
                                <option
                                    value="+506" <?php if (isset($recover) and ($recover->countrycode == '+506')) {
                                    echo ' selected ';
                                } ?> >+506 (Costa Rica)
                                </option>
                                <option
                                    value="+225" <?php if (isset($recover) and ($recover->countrycode == '+225')) {
                                    echo ' selected ';
                                } ?> >+225 (Cote d'Ivoire)
                                </option>
                                <option
                                    value="+385" <?php if (isset($recover) and ($recover->countrycode == '+385')) {
                                    echo ' selected ';
                                } ?> >+385 (Croatia)
                                </option>
                                <option
                                    value="+53" <?php if (isset($recover) and ($recover->countrycode == '+53')) {
                                    echo ' selected ';
                                } ?> >+53 (Cuba)
                                </option>
                                <option
                                    value="+599" <?php if (isset($recover) and ($recover->countrycode == '+599')) {
                                    echo ' selected ';
                                } ?> >+599 (Curacao)
                                </option>
                                <option
                                    value="+357" <?php if (isset($recover) and ($recover->countrycode == '+357')) {
                                    echo ' selected ';
                                } ?> >+357 (Cyprus)
                                </option>
                                <option
                                    value="+420" <?php if (isset($recover) and ($recover->countrycode == '+420')) {
                                    echo ' selected ';
                                } ?> >+420 (Czech Republic)
                                </option>
                                <option
                                    value="+243" <?php if (isset($recover) and ($recover->countrycode == '+243')) {
                                    echo ' selected ';
                                } ?> >+243 (Democratic Republic of the Congo)
                                </option>
                                <option
                                    value="+45" <?php if (isset($recover) and ($recover->countrycode == '+45')) {
                                    echo ' selected ';
                                } ?> >+45 (Denmark)
                                </option>
                                <option
                                    value="+246" <?php if (isset($recover) and ($recover->countrycode == '+246')) {
                                    echo ' selected ';
                                } ?> >+246 (Diego Garcia)
                                </option>
                                <option
                                    value="+253" <?php if (isset($recover) and ($recover->countrycode == '+253')) {
                                    echo ' selected ';
                                } ?> >+253 (Djibouti)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Dominica)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Dominican Republic)
                                </option>
                                <option
                                    value="+670" <?php if (isset($recover) and ($recover->countrycode == '+670')) {
                                    echo ' selected ';
                                } ?> >+670 (East Timor)
                                </option>
                                <option
                                    value="+593" <?php if (isset($recover) and ($recover->countrycode == '+593')) {
                                    echo ' selected ';
                                } ?> >+593 (Ecuador)
                                </option>
                                <option
                                    value="+20" <?php if (isset($recover) and ($recover->countrycode == '+20')) {
                                    echo ' selected ';
                                } ?> >+20 (Egypt)
                                </option>
                                <option
                                    value="+503" <?php if (isset($recover) and ($recover->countrycode == '+503')) {
                                    echo ' selected ';
                                } ?> >+503 (El Salvador)
                                </option>
                                <option
                                    value="+240" <?php if (isset($recover) and ($recover->countrycode == '+240')) {
                                    echo ' selected ';
                                } ?> >+240 (Equatorial Guinea)
                                </option>
                                <option
                                    value="+291" <?php if (isset($recover) and ($recover->countrycode == '+291')) {
                                    echo ' selected ';
                                } ?> >+291 (Eritrea)
                                </option>
                                <option
                                    value="+372" <?php if (isset($recover) and ($recover->countrycode == '+372')) {
                                    echo ' selected ';
                                } ?> >+372 (Estonia)
                                </option>
                                <option
                                    value="+251" <?php if (isset($recover) and ($recover->countrycode == '+251')) {
                                    echo ' selected ';
                                } ?> >+251 (Ethiopia)
                                </option>
                                <option
                                    value="+500" <?php if (isset($recover) and ($recover->countrycode == '+500')) {
                                    echo ' selected ';
                                } ?> >+500 (Falkland Islands)
                                </option>
                                <option
                                    value="+298" <?php if (isset($recover) and ($recover->countrycode == '+298')) {
                                    echo ' selected ';
                                } ?> >+298 (Faroe Islands)
                                </option>
                                <option
                                    value="+679" <?php if (isset($recover) and ($recover->countrycode == '+679')) {
                                    echo ' selected ';
                                } ?> >+679 (Fiji)
                                </option>
                                <option
                                    value="+358" <?php if (isset($recover) and ($recover->countrycode == '+358')) {
                                    echo ' selected ';
                                } ?> >+358 (Finland)
                                </option>
                                <option
                                    value="+33" <?php if (isset($recover) and ($recover->countrycode == '+33')) {
                                    echo ' selected ';
                                } ?> >+33 (France)
                                </option>
                                <option
                                    value="+594" <?php if (isset($recover) and ($recover->countrycode == '+594')) {
                                    echo ' selected ';
                                } ?> >+594 (French Guiana)
                                </option>
                                <option
                                    value="+689" <?php if (isset($recover) and ($recover->countrycode == '+689')) {
                                    echo ' selected ';
                                } ?> >+689 (French Polynesia)
                                </option>
                                <option
                                    value="+241" <?php if (isset($recover) and ($recover->countrycode == '+241')) {
                                    echo ' selected ';
                                } ?> >+241 (Gabon)
                                </option>
                                <option
                                    value="+220" <?php if (isset($recover) and ($recover->countrycode == '+220')) {
                                    echo ' selected ';
                                } ?> >+220 (Gambia)
                                </option>
                                <option
                                    value="+995" <?php if (isset($recover) and ($recover->countrycode == '+995')) {
                                    echo ' selected ';
                                } ?> >+995 (Georgia)
                                </option>
                                <option
                                    value="+49" <?php if (isset($recover) and ($recover->countrycode == '+49')) {
                                    echo ' selected ';
                                } ?> >+49 (Germany)
                                </option>
                                <option
                                    value="+233" <?php if (isset($recover) and ($recover->countrycode == '+233')) {
                                    echo ' selected ';
                                } ?> >+233 (Ghana)
                                </option>
                                <option
                                    value="+350" <?php if (isset($recover) and ($recover->countrycode == '+350')) {
                                    echo ' selected ';
                                } ?> >+350 (Gibraltar)
                                </option>
                                <option
                                    value="+30" <?php if (isset($recover) and ($recover->countrycode == '+30')) {
                                    echo ' selected ';
                                } ?> >+30 (Greece)
                                </option>
                                <option
                                    value="+299" <?php if (isset($recover) and ($recover->countrycode == '+299')) {
                                    echo ' selected ';
                                } ?> >+299 (Greenland)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Grenada)
                                </option>
                                <option
                                    value="+590" <?php if (isset($recover) and ($recover->countrycode == '+590')) {
                                    echo ' selected ';
                                } ?> >+590 (Guadeloupe)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Guam)
                                </option>
                                <option
                                    value="+502" <?php if (isset($recover) and ($recover->countrycode == '+502')) {
                                    echo ' selected ';
                                } ?> >+502 (Guatemala)
                                </option>
                                <option
                                    value="+224" <?php if (isset($recover) and ($recover->countrycode == '+224')) {
                                    echo ' selected ';
                                } ?> >+224 (Guinea)
                                </option>
                                <option
                                    value="+245" <?php if (isset($recover) and ($recover->countrycode == '+245')) {
                                    echo ' selected ';
                                } ?> >+245 (Guinea-Bissau)
                                </option>
                                <option
                                    value="+592" <?php if (isset($recover) and ($recover->countrycode == '+592')) {
                                    echo ' selected ';
                                } ?> >+592 (Guyana)
                                </option>
                                <option
                                    value="+509" <?php if (isset($recover) and ($recover->countrycode == '+509')) {
                                    echo ' selected ';
                                } ?> >+509 (Haiti)
                                </option>
                                <option
                                    value="+504" <?php if (isset($recover) and ($recover->countrycode == '+504')) {
                                    echo ' selected ';
                                } ?> >+504 (Honduras)
                                </option>
                                <option
                                    value="+852" <?php if (isset($recover) and ($recover->countrycode == '+852')) {
                                    echo ' selected ';
                                } ?> >+852 (Hong Kong)
                                </option>
                                <option
                                    value="+36" <?php if (isset($recover) and ($recover->countrycode == '+36')) {
                                    echo ' selected ';
                                } ?> >+36 (Hungary)
                                </option>
                                <option
                                    value="+354" <?php if (isset($recover) and ($recover->countrycode == '+354')) {
                                    echo ' selected ';
                                } ?> >+354 (Iceland)
                                </option>
                                <option
                                    value="+91" <?php if (isset($recover) and ($recover->countrycode == '+91')) {
                                    echo ' selected ';
                                } ?> >+91 (India)
                                </option>
                                <option
                                    value="+62" <?php if (isset($recover) and ($recover->countrycode == '+62')) {
                                    echo ' selected ';
                                } ?> >+62 (Indonesia)
                                </option>
                                <option
                                    value="+98" <?php if (isset($recover) and ($recover->countrycode == '+98')) {
                                    echo ' selected ';
                                } ?> >+98 (Iran)
                                </option>
                                <option
                                    value="+964" <?php if (isset($recover) and ($recover->countrycode == '+964')) {
                                    echo ' selected ';
                                } ?> >+964 (Iraq)
                                </option>
                                <option
                                    value="+353" <?php if (isset($recover) and ($recover->countrycode == '+353')) {
                                    echo ' selected ';
                                } ?> >+353 (Ireland)
                                </option>
                                <option
                                    value="+972" <?php if (isset($recover) and ($recover->countrycode == '+972')) {
                                    echo ' selected ';
                                } ?> >+972 (Israel)
                                </option>
                                <option
                                    value="+39" <?php if (isset($recover) and ($recover->countrycode == '+39')) {
                                    echo ' selected ';
                                } ?> >+39 (Italy)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Jamaica)
                                </option>
                                <option
                                    value="+81" <?php if (isset($recover) and ($recover->countrycode == '+81')) {
                                    echo ' selected ';
                                } ?> >+81 (Japan)
                                </option>
                                <option
                                    value="+962" <?php if (isset($recover) and ($recover->countrycode == '+962')) {
                                    echo ' selected ';
                                } ?> >+962 (Jordan)
                                </option>
                                <option
                                    value="+7" <?php if (isset($recover) and ($recover->countrycode == '+7')) {
                                    echo ' selected ';
                                } ?> >+7 (Kazakhstan)
                                </option>
                                <option
                                    value="+254" <?php if (isset($recover) and ($recover->countrycode == '+254')) {
                                    echo ' selected ';
                                } ?> >+254 (Kenya)
                                </option>
                                <option
                                    value="+686" <?php if (isset($recover) and ($recover->countrycode == '+686')) {
                                    echo ' selected ';
                                } ?> >+686 (Kiribati)
                                </option>
                                <option
                                    value="+965" <?php if (isset($recover) and ($recover->countrycode == '+965')) {
                                    echo ' selected ';
                                } ?> >+965 (Kuwait)
                                </option>
                                <option
                                    value="+996" <?php if (isset($recover) and ($recover->countrycode == '+996')) {
                                    echo ' selected ';
                                } ?> >+996 (Kyrgyzstan)
                                </option>
                                <option
                                    value="+856" <?php if (isset($recover) and ($recover->countrycode == '+856')) {
                                    echo ' selected ';
                                } ?> >+856 (Laos)
                                </option>
                                <option
                                    value="+371" <?php if (isset($recover) and ($recover->countrycode == '+371')) {
                                    echo ' selected ';
                                } ?> >+371 (Latvia)
                                </option>
                                <option
                                    value="+961" <?php if (isset($recover) and ($recover->countrycode == '+961')) {
                                    echo ' selected ';
                                } ?> >+961 (Lebanon)
                                </option>
                                <option
                                    value="+266" <?php if (isset($recover) and ($recover->countrycode == '+266')) {
                                    echo ' selected ';
                                } ?> >+266 (Lesotho)
                                </option>
                                <option
                                    value="+231" <?php if (isset($recover) and ($recover->countrycode == '+231')) {
                                    echo ' selected ';
                                } ?> >+231 (Liberia)
                                </option>
                                <option
                                    value="+218" <?php if (isset($recover) and ($recover->countrycode == '+218')) {
                                    echo ' selected ';
                                } ?> >+218 (Libya)
                                </option>
                                <option
                                    value="+423" <?php if (isset($recover) and ($recover->countrycode == '+423')) {
                                    echo ' selected ';
                                } ?> >+423 (Liechtenstein)
                                </option>
                                <option
                                    value="+370" <?php if (isset($recover) and ($recover->countrycode == '+370')) {
                                    echo ' selected ';
                                } ?> >+370 (Lithuania)
                                </option>
                                <option
                                    value="+352" <?php if (isset($recover) and ($recover->countrycode == '+352')) {
                                    echo ' selected ';
                                } ?> >+352 (Luxembourg)
                                </option>
                                <option
                                    value="+853" <?php if (isset($recover) and ($recover->countrycode == '+853')) {
                                    echo ' selected ';
                                } ?> >+853 (Macao)
                                </option>
                                <option
                                    value="+389" <?php if (isset($recover) and ($recover->countrycode == '+389')) {
                                    echo ' selected ';
                                } ?> >+389 (Macedonia)
                                </option>
                                <option
                                    value="+261" <?php if (isset($recover) and ($recover->countrycode == '+261')) {
                                    echo ' selected ';
                                } ?> >+261 (Madagascar)
                                </option>
                                <option
                                    value="+265" <?php if (isset($recover) and ($recover->countrycode == '+265')) {
                                    echo ' selected ';
                                } ?> >+265 (Malawi)
                                </option>
                                <option
                                    value="+60" <?php if (isset($recover) and ($recover->countrycode == '+60')) {
                                    echo ' selected ';
                                } ?> >+60 (Malaysia)
                                </option>
                                <option
                                    value="+960" <?php if (isset($recover) and ($recover->countrycode == '+960')) {
                                    echo ' selected ';
                                } ?> >+960 (Maldives)
                                </option>
                                <option
                                    value="+223" <?php if (isset($recover) and ($recover->countrycode == '+223')) {
                                    echo ' selected ';
                                } ?> >+223 (Mali)
                                </option>
                                <option
                                    value="+356" <?php if (isset($recover) and ($recover->countrycode == '+356')) {
                                    echo ' selected ';
                                } ?> >+356 (Malta)
                                </option>
                                <option
                                    value="+692" <?php if (isset($recover) and ($recover->countrycode == '+692')) {
                                    echo ' selected ';
                                } ?> >+692 (Marshall Islands)
                                </option>
                                <option
                                    value="+596" <?php if (isset($recover) and ($recover->countrycode == '+596')) {
                                    echo ' selected ';
                                } ?> >+596 (Martinique)
                                </option>
                                <option
                                    value="+222" <?php if (isset($recover) and ($recover->countrycode == '+222')) {
                                    echo ' selected ';
                                } ?> >+222 (Mauritania)
                                </option>
                                <option
                                    value="+230" <?php if (isset($recover) and ($recover->countrycode == '+230')) {
                                    echo ' selected ';
                                } ?> >+230 (Mauritius)
                                </option>
                                <option
                                    value="+52" <?php if (isset($recover) and ($recover->countrycode == '+52')) {
                                    echo ' selected ';
                                } ?> >+52 (Mexico)
                                </option>
                                <option
                                    value="+691" <?php if (isset($recover) and ($recover->countrycode == '+691')) {
                                    echo ' selected ';
                                } ?> >+691 (Micronesia)
                                </option>
                                <option
                                    value="+373" <?php if (isset($recover) and ($recover->countrycode == '+373')) {
                                    echo ' selected ';
                                } ?> >+373 (Moldova)
                                </option>
                                <option
                                    value="+377" <?php if (isset($recover) and ($recover->countrycode == '+377')) {
                                    echo ' selected ';
                                } ?> >+377 (Monaco)
                                </option>
                                <option
                                    value="+976" <?php if (isset($recover) and ($recover->countrycode == '+976')) {
                                    echo ' selected ';
                                } ?> >+976 (Mongolia)
                                </option>
                                <option
                                    value="+382" <?php if (isset($recover) and ($recover->countrycode == '+382')) {
                                    echo ' selected ';
                                } ?> >+382 (Montenegro)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Montserrat)
                                </option>
                                <option
                                    value="+212" <?php if (isset($recover) and ($recover->countrycode == '+212')) {
                                    echo ' selected ';
                                } ?> >+212 (Morocco)
                                </option>
                                <option
                                    value="+258" <?php if (isset($recover) and ($recover->countrycode == '+258')) {
                                    echo ' selected ';
                                } ?> >+258 (Mozambique)
                                </option>
                                <option
                                    value="+95" <?php if (isset($recover) and ($recover->countrycode == '+95')) {
                                    echo ' selected ';
                                } ?> >+95 (Myanmar)
                                </option>
                                <option
                                    value="+264" <?php if (isset($recover) and ($recover->countrycode == '+264')) {
                                    echo ' selected ';
                                } ?> >+264 (Namibia)
                                </option>
                                <option
                                    value="+674" <?php if (isset($recover) and ($recover->countrycode == '+674')) {
                                    echo ' selected ';
                                } ?> >+674 (Nauru)
                                </option>
                                <option
                                    value="+977" <?php if (isset($recover) and ($recover->countrycode == '+977')) {
                                    echo ' selected ';
                                } ?> >+977 (Nepal)
                                </option>
                                <option
                                    value="+31" <?php if (isset($recover) and ($recover->countrycode == '+31')) {
                                    echo ' selected ';
                                } ?> >+31 (Netherlands)
                                </option>
                                <option
                                    value="+599" <?php if (isset($recover) and ($recover->countrycode == '+599')) {
                                    echo ' selected ';
                                } ?> >+599 (Netherlands Antilles)
                                </option>
                                <option
                                    value="+687" <?php if (isset($recover) and ($recover->countrycode == '+687')) {
                                    echo ' selected ';
                                } ?> >+687 (New Caledonia)
                                </option>
                                <option
                                    value="+64" <?php if (isset($recover) and ($recover->countrycode == '+64')) {
                                    echo ' selected ';
                                } ?> >+64 (New Zealand)
                                </option>
                                <option
                                    value="+505" <?php if (isset($recover) and ($recover->countrycode == '+505')) {
                                    echo ' selected ';
                                } ?> >+505 (Nicaragua)
                                </option>
                                <option
                                    value="+227" <?php if (isset($recover) and ($recover->countrycode == '+227')) {
                                    echo ' selected ';
                                } ?> >+227 (Niger)
                                </option>
                                <option
                                    value="+234" <?php if (isset($recover) and ($recover->countrycode == '+234')) {
                                    echo ' selected ';
                                } ?> >+234 (Nigeria)
                                </option>
                                <option
                                    value="+683" <?php if (isset($recover) and ($recover->countrycode == '+683')) {
                                    echo ' selected ';
                                } ?> >+683 (Niue)
                                </option>
                                <option
                                    value="+850" <?php if (isset($recover) and ($recover->countrycode == '+850')) {
                                    echo ' selected ';
                                } ?> >+850 (North Korea)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Northern Mariana Islands)
                                </option>
                                <option
                                    value="+47" <?php if (isset($recover) and ($recover->countrycode == '+47')) {
                                    echo ' selected ';
                                } ?> >+47 (Norway)
                                </option>
                                <option
                                    value="+968" <?php if (isset($recover) and ($recover->countrycode == '+968')) {
                                    echo ' selected ';
                                } ?> >+968 (Oman)
                                </option>
                                <option
                                    value="+92" <?php if (isset($recover) and ($recover->countrycode == '+92')) {
                                    echo ' selected ';
                                } ?> >+92 (Pakistan)
                                </option>
                                <option
                                    value="+680" <?php if (isset($recover) and ($recover->countrycode == '+680')) {
                                    echo ' selected ';
                                } ?> >+680 (Palau)
                                </option>
                                <option
                                    value="+970" <?php if (isset($recover) and ($recover->countrycode == '+970')) {
                                    echo ' selected ';
                                } ?> >+970 (Palestine)
                                </option>
                                <option
                                    value="+507" <?php if (isset($recover) and ($recover->countrycode == '+507')) {
                                    echo ' selected ';
                                } ?> >+507 (Panama)
                                </option>
                                <option
                                    value="+675" <?php if (isset($recover) and ($recover->countrycode == '+675')) {
                                    echo ' selected ';
                                } ?> >+675 (Papua New Guinea)
                                </option>
                                <option
                                    value="+595" <?php if (isset($recover) and ($recover->countrycode == '+595')) {
                                    echo ' selected ';
                                } ?> >+595 (Paraguay)
                                </option>
                                <option
                                    value="+51" <?php if (isset($recover) and ($recover->countrycode == '+51')) {
                                    echo ' selected ';
                                } ?> >+51 (Peru)
                                </option>
                                <option
                                    value="+63" <?php if (isset($recover) and ($recover->countrycode == '+63')) {
                                    echo ' selected ';
                                } ?> >+63 (Philippines)
                                </option>
                                <option
                                    value="+48" <?php if (isset($recover) and ($recover->countrycode == '+48')) {
                                    echo ' selected ';
                                } ?> >+48 (Poland)
                                </option>
                                <option
                                    value="+351" <?php if (isset($recover) and ($recover->countrycode == '+351')) {
                                    echo ' selected ';
                                } ?> >+351 (Portugal)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Puerto Rico)
                                </option>
                                <option
                                    value="+974" <?php if (isset($recover) and ($recover->countrycode == '+974')) {
                                    echo ' selected ';
                                } ?> >+974 (Qatar)
                                </option>
                                <option
                                    value="+262" <?php if (isset($recover) and ($recover->countrycode == '+262')) {
                                    echo ' selected ';
                                } ?> >+262 (Reunion)
                                </option>
                                <option
                                    value="+40" <?php if (isset($recover) and ($recover->countrycode == '+40')) {
                                    echo ' selected ';
                                } ?> >+40 (Romania)
                                </option>
                                <option
                                    value="+7" <?php if (isset($recover) and ($recover->countrycode == '+7')) {
                                    echo ' selected ';
                                } ?> >+7 (Russia)
                                </option>
                                <option
                                    value="+250" <?php if (isset($recover) and ($recover->countrycode == '+250')) {
                                    echo ' selected ';
                                } ?> >+250 (Rwanda)
                                </option>
                                <option
                                    value="+290" <?php if (isset($recover) and ($recover->countrycode == '+290')) {
                                    echo ' selected ';
                                } ?> >+290 (Saint Helena)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Saint Kitts and Nevis)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Saint Lucia)
                                </option>
                                <option
                                    value="+508" <?php if (isset($recover) and ($recover->countrycode == '+508')) {
                                    echo ' selected ';
                                } ?> >+508 (Saint Pierre and Miquelon)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Saint Vincent and Grenadines)
                                </option>
                                <option
                                    value="+685" <?php if (isset($recover) and ($recover->countrycode == '+685')) {
                                    echo ' selected ';
                                } ?> >+685 (Samoa)
                                </option>
                                <option
                                    value="+378" <?php if (isset($recover) and ($recover->countrycode == '+378')) {
                                    echo ' selected ';
                                } ?> >+378 (San Marino)
                                </option>
                                <option
                                    value="+239" <?php if (isset($recover) and ($recover->countrycode == '+239')) {
                                    echo ' selected ';
                                } ?> >+239 (Sao Tome and Principe)
                                </option>
                                <option
                                    value="+966" <?php if (isset($recover) and ($recover->countrycode == '+966')) {
                                    echo ' selected ';
                                } ?> >+966 (Saudi Arabia)
                                </option>
                                <option
                                    value="+221" <?php if (isset($recover) and ($recover->countrycode == '+221')) {
                                    echo ' selected ';
                                } ?> >+221 (Senegal)
                                </option>
                                <option
                                    value="+381" <?php if (isset($recover) and ($recover->countrycode == '+381')) {
                                    echo ' selected ';
                                } ?> >+381 (Serbia)
                                </option>
                                <option
                                    value="+248" <?php if (isset($recover) and ($recover->countrycode == '+248')) {
                                    echo ' selected ';
                                } ?> >+248 (Seychelles)
                                </option>
                                <option
                                    value="+232" <?php if (isset($recover) and ($recover->countrycode == '+232')) {
                                    echo ' selected ';
                                } ?> >+232 (Sierra Leone)
                                </option>
                                <option
                                    value="+65" <?php if (isset($recover) and ($recover->countrycode == '+65')) {
                                    echo ' selected ';
                                } ?> >+65 (Singapore)
                                </option>
                                <option
                                    value="+421" <?php if (isset($recover) and ($recover->countrycode == '+421')) {
                                    echo ' selected ';
                                } ?> >+421 (Slovakia)
                                </option>
                                <option
                                    value="+386" <?php if (isset($recover) and ($recover->countrycode == '+386')) {
                                    echo ' selected ';
                                } ?> >+386 (Slovenia)
                                </option>
                                <option
                                    value="+677" <?php if (isset($recover) and ($recover->countrycode == '+677')) {
                                    echo ' selected ';
                                } ?> >+677 (Solomon Islands)
                                </option>
                                <option
                                    value="+252" <?php if (isset($recover) and ($recover->countrycode == '+252')) {
                                    echo ' selected ';
                                } ?> >+252 (Somalia)
                                </option>
                                <option
                                    value="+27" <?php if (isset($recover) and ($recover->countrycode == '+27')) {
                                    echo ' selected ';
                                } ?> >+27 (South Africa)
                                </option>
                                <option
                                    value="+82" <?php if (isset($recover) and ($recover->countrycode == '+82')) {
                                    echo ' selected ';
                                } ?> >+82 (South Korea)
                                </option>
                                <option
                                    value="+211" <?php if (isset($recover) and ($recover->countrycode == '+211')) {
                                    echo ' selected ';
                                } ?> >+211 (South Sudan)
                                </option>
                                <option
                                    value="+34" <?php if (isset($recover) and ($recover->countrycode == '+34')) {
                                    echo ' selected ';
                                } ?> >+34 (Spain)
                                </option>
                                <option
                                    value="+94" <?php if (isset($recover) and ($recover->countrycode == '+94')) {
                                    echo ' selected ';
                                } ?> >+94 (Sri Lanka)
                                </option>
                                <option
                                    value="+249" <?php if (isset($recover) and ($recover->countrycode == '+249')) {
                                    echo ' selected ';
                                } ?> >+249 (Sudan)
                                </option>
                                <option
                                    value="+597" <?php if (isset($recover) and ($recover->countrycode == '+597')) {
                                    echo ' selected ';
                                } ?> >+597 (Suriname)
                                </option>
                                <option
                                    value="+268" <?php if (isset($recover) and ($recover->countrycode == '+268')) {
                                    echo ' selected ';
                                } ?> >+268 (Swaziland)
                                </option>
                                <option
                                    value="+46" <?php if (isset($recover) and ($recover->countrycode == '+46')) {
                                    echo ' selected ';
                                } ?> >+46 (Sweden)
                                </option>
                                <option
                                    value="+41" <?php if (isset($recover) and ($recover->countrycode == '+41')) {
                                    echo ' selected ';
                                } ?> >+41 (Switzerland)
                                </option>
                                <option
                                    value="+963" <?php if (isset($recover) and ($recover->countrycode == '+963')) {
                                    echo ' selected ';
                                } ?> >+963 (Syria)
                                </option>
                                <option
                                    value="+886" <?php if (isset($recover) and ($recover->countrycode == '+886')) {
                                    echo ' selected ';
                                } ?> >+886 (Taiwan)
                                </option>
                                <option
                                    value="+992" <?php if (isset($recover) and ($recover->countrycode == '+992')) {
                                    echo ' selected ';
                                } ?> >+992 (Tajikistan)
                                </option>
                                <option
                                    value="+255" <?php if (isset($recover) and ($recover->countrycode == '+255')) {
                                    echo ' selected ';
                                } ?> >+255 (Tanzania)
                                </option>
                                <option
                                    value="+66" <?php if (isset($recover) and ($recover->countrycode == '+66')) {
                                    echo ' selected ';
                                } ?> >+66 (Thailand)
                                </option>
                                <option
                                    value="+228" <?php if (isset($recover) and ($recover->countrycode == '+228')) {
                                    echo ' selected ';
                                } ?> >+228 (Togo)
                                </option>
                                <option
                                    value="+690" <?php if (isset($recover) and ($recover->countrycode == '+690')) {
                                    echo ' selected ';
                                } ?> >+690 (Tokelau)
                                </option>
                                <option
                                    value="+676" <?php if (isset($recover) and ($recover->countrycode == '+676')) {
                                    echo ' selected ';
                                } ?> >+676 (Tonga)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Trinidad and Tobago)
                                </option>
                                <option
                                    value="+216" <?php if (isset($recover) and ($recover->countrycode == '+216')) {
                                    echo ' selected ';
                                } ?> >+216 (Tunisia)
                                </option>
                                <option
                                    value="+90" <?php if (isset($recover) and ($recover->countrycode == '+90')) {
                                    echo ' selected ';
                                } ?> >+90 (Turkey)
                                </option>
                                <option
                                    value="+993" <?php if (isset($recover) and ($recover->countrycode == '+993')) {
                                    echo ' selected ';
                                } ?> >+993 (Turkmenistan)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (Turks and Caicos Islands)
                                </option>
                                <option
                                    value="+688" <?php if (isset($recover) and ($recover->countrycode == '+688')) {
                                    echo ' selected ';
                                } ?> >+688 (Tuvalu)
                                </option>
                                <option
                                    value="+256" <?php if (isset($recover) and ($recover->countrycode == '+256')) {
                                    echo ' selected ';
                                } ?> >+256 (Uganda)
                                </option>
                                <option
                                    value="+380" <?php if (isset($recover) and ($recover->countrycode == '+380')) {
                                    echo ' selected ';
                                } ?> >+380 (Ukraine)
                                </option>
                                <option
                                    value="+971" <?php if (isset($recover) and ($recover->countrycode == '+971')) {
                                    echo ' selected ';
                                } ?> >+971 (United Arab Emirates)
                                </option>
                                <option
                                    value="+44" <?php if (isset($recover) and ($recover->countrycode == '+44')) {
                                    echo ' selected ';
                                } ?> >+44 (United Kingdom)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (United States)
                                </option>
                                <option
                                    value="+598" <?php if (isset($recover) and ($recover->countrycode == '+598')) {
                                    echo ' selected ';
                                } ?> >+598 (Uruguay)
                                </option>
                                <option
                                    value="+1" <?php if (isset($recover) and ($recover->countrycode == '+1')) {
                                    echo ' selected ';
                                } ?> >+1 (US Virgin Islands)
                                </option>
                                <option
                                    value="+998" <?php if (isset($recover) and ($recover->countrycode == '+998')) {
                                    echo ' selected ';
                                } ?> >+998 (Uzbekistan)
                                </option>
                                <option
                                    value="+678" <?php if (isset($recover) and ($recover->countrycode == '+678')) {
                                    echo ' selected ';
                                } ?> >+678 (Vanuatu)
                                </option>
                                <option
                                    value="+379" <?php if (isset($recover) and ($recover->countrycode == '+379')) {
                                    echo ' selected ';
                                } ?> >+379 (Vatican City)
                                </option>
                                <option
                                    value="+58" <?php if (isset($recover) and ($recover->countrycode == '+58')) {
                                    echo ' selected ';
                                } ?> >+58 (Venezuela)
                                </option>
                                <option
                                    value="+84" <?php if (isset($recover) and ($recover->countrycode == '+84')) {
                                    echo ' selected ';
                                } ?> >+84 (Vietnam)
                                </option>
                                <option
                                    value="+681" <?php if (isset($recover) and ($recover->countrycode == '+681')) {
                                    echo ' selected ';
                                } ?> >+681 (Wallis and Futuna)
                                </option>
                                <option
                                    value="+967" <?php if (isset($recover) and ($recover->countrycode == '+967')) {
                                    echo ' selected ';
                                } ?> >+967 (Yemen)
                                </option>
                                <option
                                    value="+260" <?php if (isset($recover) and ($recover->countrycode == '+260')) {
                                    echo ' selected ';
                                } ?> >+260 (Zambia)
                                </option>
                                <option
                                    value="+263" <?php if (isset($recover) and ($recover->countrycode == '+263')) {
                                    echo ' selected ';
                                } ?> >+263 (Zimbabwe)
                                </option>

                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel *</label>
                            <input required type="number" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="tel"
                                   required="required"
                                   value="{{$recover->tel ?? '' }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->

<!-- Optional JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Counterup JavaScript -->
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<!-- Slick JavaScript -->
<script src="js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="js/select2.min.js"></script>
<!-- Wow JavaScript -->
<script src="js/wow.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.keyboard.js"></script>
<script src="js/jquery.mousewheel.js"></script>
<!-- <script src="js/jquery.keyboard.extension-caret.js"></script>
<script src="js/jquery.keyboard.extension-typing.js"></script> -->
<script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<!--  <script type="text/javascript">
  $('#username,#password').keyboard({openOn : null });

  $('.username').click(function(){
    var kb = $('#username').getkeyboard();
    kb.reveal()
  })
  $('.password').click(function(){
    var kb = $('#password').getkeyboard();
    kb.reveal()
  })
</script>-->
<script>

</script>
<script src="js/custom.js"></script>
<script type="text/javascript">
    jQuery("#load").fadeOut();
    jQuery("#loading").delay().fadeOut("");
</script>
</body>
</html>
