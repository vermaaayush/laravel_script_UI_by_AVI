<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$bankName ?? ''}}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico"/>
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
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#b34020",
                        "surface-container-low": "#fff8f5",
                        "on-surface": "#4a2a22",
                        "on-surface-variant": "#7a5e55"
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    </style>
    <style>
        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>
    <style type="text/css">
        .ui-widget-content {
            border: 1px solid var(--iq-border-light);
            background: #fff !important;
            color: #f46a35;
        }

        .online-support {
            margin-top: 10px;
        }

        .online-support h3 {
            background: #fe517e;
            color: #fff;
            padding-left: 15px;
            margin-bottom: 10px;
            border: 1px solid transparent;
            box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1)
        }

        .online-support .btn-link {
            color: #fff;
            border-bottom: 1px solid #fff;
            border-radius: 0px;
        }

        .input-group-text {
            font-size: 20px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff8f5;
            color: #4a2a22;
        }
        .bg-[#b34020] { background: #b34020 !important; }
        .btn-primary { background: #b34020 !important; border-color: #b34020 !important; color: #fff !important; }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled):active { background: #993311 !important; border-color: #993311 !important; }
        .btn-default { background: #ffebe4 !important; border-color: #ffebe4 !important; color: #4a2a22 !important; }
        .stepwizard-row:before { background-color: #fcece8 !important; }
        .text-primary { color: #b34020 !important; }
        .btn-circle { display: flex; align-items: center; justify-content: center; padding: 0; }
        h1, h2, h3, h4, h5, h6 { color: #4a2a22; }
        fieldset.row { align-items: flex-start; }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {


            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function () {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url'],input[type='date'],input[type='file']"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });
    </script>
</head>
<body>
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Sign in Start -->
<section class="sign-in-page py-5">
    <div class="container p-0 ">
        <div class="row no-gutters height-self-center">
            <div class="col-sm-12 text-left mb-4 mt-2 pl-3">
                <a href="{{ $bankBase ?? '' }}"><img src="/admin/uploads/{{ $logo ?? '' }}" style="max-width:150px;"></a>
            </div>
            <div class="col-sm-12 align-self-center bg-[#b34020] rounded mb-5">
                <div class="row m-0 ">
                    <div class="col-12 py-2">
                    </div>
                    <div class="col-md-12 bg-white sign-in-page-data iq-card pb-0 mb-0">
                        <div class="sign-in-from">
                            <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                                <h3 class="mb-0 text-left">
                                    New Account Registration</h3>
                                @include('flash::message')
                            </div>


                            <div class="stepwizard">
                                <div class="stepwizard-row setup-panel">
                                    <div class="stepwizard-step">
                                        <a href="#step-1" type="button" class="btn btn-primary btn-circle"><i
                                                class="fa fa-circle"></i></a>

                                    </div>
                                    <div class="stepwizard-step">
                                        <a href="#step-2" type="button" class="btn btn-default btn-circle"
                                           disabled="disabled"><i class="fa fa-circle"></i></a>

                                    </div>
                                    <div class="stepwizard-step">
                                        <a href="#step-3" type="button" class="btn btn-default btn-circle"
                                           disabled="disabled"><i class="fa fa-circle"></i></a>

                                    </div>
                                    @if($enableForms->form_4 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-4" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif
                                    @if($enableForms->form_5 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-5" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif
                                    @if($enableForms->form_6 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-6" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif
                                    @if($enableForms->form_7 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-7" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_8 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-8" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_9 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-9" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_10 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-10" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_11 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-11" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_12 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-12" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_13 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-13" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_14 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-14" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    @if($enableForms->form_15 == 1)
                                        <div class="stepwizard-step">
                                            <a href="#step-15" type="button" class="btn btn-default btn-circle"
                                               disabled="disabled"><i class="fa fa-circle"></i></a>

                                        </div>
                                    @endif

                                    <div class="stepwizard-step">
                                        <a href="#step-16" type="button" class="btn btn-default btn-circle"
                                           disabled="disabled"><i class="fa fa-circle"></i></a>

                                    </div>
                                    <div class="stepwizard-step">
                                        <a href="#step-17" type="button" class="btn btn-default btn-circle"
                                           disabled="disabled"><i class="fa fa-circle"></i></a>

                                    </div>
                                </div>
                            </div>
                            <form role="form" class="text-center mt-6 bggray-cus" method="POST"
                                  action="online-open-account" enctype="multipart/form-data">
                            @csrf
                                <!-- fieldsets 1 -->
                                <fieldset class="row setup-content" id="step-1">
                                    <div class="col-12 text-left">
                                        <h5 class="mb-6" style="color: #4a2a22;">Terms and conditions:</h5>

                                        <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp1<!-- - {{$totalForm ?? '' }}--></h4>

                                        <!-- <iframe src="pdf/step1.pdf?#view=fitH" width="100%" height="500px"></iframe> -->

                                        <textarea class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" onscroll="if(this.scrollTop+this.offsetHeight>=this.scrollHeight){document.getElementById('scrlBtn').disabled = false;}"
                                                  style="height: 500px;line-height:20px;margin-bottom: 20px; width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px;"
                                                  readonly="readonly">
Account Opening Documentation:
----------------------------------------------
We seek your understanding and cooperation in furnishing the documents required for account opening and value your time and effort in doing so. We request you to provide suitable documentation as indicated below which is required by the Bank under local laws and regulations and also to comply with KYC guidelines and policy as part of the global effort to combat money laundering, terrorist financing and fraudulent activity

Important Note:
----------------------------------------------
1) Please fill the form in CAPITAL letters and tick wherever applicable.
2) Avoid any sort of alterations/cutting in the Application form.
3) Produce original documents for verification against each self attested photocopy by Account Holder(s).
4) Please produce separate documents to evidence proof of identity and proof of address for confirming name, date of birth and current residential address for each account holder.
5) Please avail of the nomination facility. w Please attach separate sheets in case the given space is insufficient.

Account Opening Requirements:
-----------------------------------------------
1. Completed Account Opening Application Form along with required documentation.
2. Recent Passport size photographs of all the Account Holder(s) duly signed on front (not more than six months old).
3. PAN Card copy or Form 60 (whichever is applicable).

Documents to be submitted for Account Opening:
------------------------------------------------
Identification Proof (List A)
* Passport
* Driving License
* PAN Card
* Voter ID Card
* Any Photo ID card issued by Central/State Govt./ PSU/Armed forces ID card

Address Proof (List B)
* Passport
* Voter ID Card
* Driving License
* Latest utility bill in the name of the applicant(s) i.e. electricity, water or telephone bill (not older than three months)
* FRRO, Visa copy / Appointment letter (applicable in case of foreign nationals only)
* Letter from the Embassy confirming residential address (applicable for Diplomats and other Embassy officials)

Special Instructions:
In case of joint account holder(s), acceptable documents which can be submitted as proofs for establishing
relationship-
* Passport
* Driving License
* PAN Card
* Voter ID Card
* Photo-Ration Card

For ascertaining Minor's date of birth, acceptable documents which can be submitted-
* Birth certificate issued by Municipal Authority.
* Passport held in the name of the minor.
*10th Class certificate indicating DOB, issued by the Central Board (C.B.S.E., I.C.S.E.) / State Board.

Note: 1. Bank may request for any further specific / additional documents as may be required.
</textarea>

                                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                            <a href="<?= asset(''); ?>" class="bg-error hover:bg-error/90 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center" style="text-decoration: none; background: #e53e3e; color: #fff;">Cancel Registration</a>
                                            <button class="btn btn-primary nextBtn btn-lg" id="scrlBtn" disabled type="button">Next</button> 
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="row setup-content" id="step-2">
                                    <div class="form-card text-left">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="col-7">
                                                <h5 class="mb-6">Do not leave any field blank, instead mention
                                                    Not applicable (N.A.)</h5>
                                            </div>
                                            <div class="col-5">
                                                <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp2<!-- - {{$totalForm ?? '' }}--></h4>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap -mx-3">
                                            <!-- <p class="text-left text-error col-md-12">Do not leave any field blank, instead mention Not applicable (N.A.)</p> -->
                                            <div class="clearfix"></div>
                                            <div class="col-12 ">
                                                <div class="mb-6" id="mainDiv">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email *</label>
                                                    <input required type="email" class="bg-surface-container-low border border-gray-300 rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="email"
                                                           id="email"
                                                           required="required"
                                                           value="{{$recover->email ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">I/We hereby request {{$bankName ?? ''}}, Ltd. to open
                                                        my/our Savings Account. in Branch *</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                                            name="branch">
                                                        <!-- <option>--select--</option><!---->
                                                        @php
                                                            $i=0;
                                                                    foreach( $branch as $feach){
                                                                        echo '<option';
                                                                        if(isset($recover->branch) ){
                                                                            if($feach->branch_name == $recover->branch){ echo ' selected ';}
                                                                        }
                                                                        echo '>'.$feach->branch_name."</option>";
                                                                    $i++;}
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency In *</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="currency">
                                                        <!-- <option>--select--</option><!---->
                                                        @php
                                                            $i=0;
                                                                    foreach( $currencies as $feach){
                                                                        echo '<option';
                                                                        if(isset($recover->currency) ){
                                                                            if($feach->currency == $recover->currency){ echo ' selected ';}
                                                                        }
                                                                        echo '>'.$feach->currency."</option>";
                                                                    $i++;}
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Type Of Account *</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="type">
                                                        <!-- <option>--select--</option><!---->
                                                        @php
                                                            $i=0;
                                                                    foreach( $type as $feach){
                                                                        echo '<option';
                                                                        if(isset($recover->type) ){
                                                                            if($feach->type_name == $recover->type){ echo ' selected ';}
                                                                        }
                                                                        echo '>'.$feach->type_name."</option>";
                                                                    $i++;}
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            $security_questions = DB::select('select * from ba_securityquestions');
                                            ?>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Security Question 1</label>
                                                    <select class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="security_ques1" id="security_ques1" required>
{{--                                                        <option>Security Question 1</option>--}}
                                                        @foreach (array_reverse($security_questions) as $ques)
                                                            <option value="{{ $ques->question }}">{{ $ques->question }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Answer 1</label>
                                                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="answer1" id="answer1" required value="" placeholder="Answer 1" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Security Question 2</label>
                                                    <select class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="security_ques2" id="security_ques2" required>
{{--                                                        <option>Security Question 2</option>--}}
                                                        @foreach ($security_questions as $ques)
                                                            <option value="{{ $ques->question }}">{{ $ques->question }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Answer 2</label>
                                                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="answer2" id="answer2" required value="" placeholder="Answer 2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>--}}
                                    <button type="button" name="next"
                                            class="btn btn-primary action-button mr-2 nextBtn float-right" value="Next">
                                        Continue
                                    </button>
                                    <!--<button type="submit" name="submit"-->
                                    <!--        class="btn btn-dark previous action-button-previous float-right mr-3"-->
                                    <!--        value="Save">Save & exit-->
                                    <!--</button>-->
                                    <a href="<?= asset(''); ?>" class="bg-error hover:bg-error/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2" style="margin-left:10px;">Cancel Registration Process</a>
                                </fieldset>

                                <fieldset class="row setup-content" id="step-3">
                                    <div class="form-card text-left">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="col-7">
                                                <h5 class="mb-6">Details of Account - Sole / First
                                                    Applicant:</h5>
                                            </div>
                                            <div class="col-5">
                                                <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp3<!-- - {{$totalForm ?? '' }}--></h4>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Title *</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="title">
                                                        <option>--select--</option>
                                                        <option <?php if (isset($recover) and ($recover->title == 'Mr.')) {
                                                            echo ' selected ';
                                                        } ?>>Mr.
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->title == 'Mrs.')) {
                                                            echo ' selected ';
                                                        } ?>>Mrs.
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->title == 'Ms.')) {
                                                            echo ' selected ';
                                                        } ?>>Ms.
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->title == 'Others')) {
                                                            echo ' selected ';
                                                        } ?>>Others
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="name"
                                                           required="required"
                                                           value="{{$recover->name ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Middle Name</label>
                                                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="middlename"

                                                           value="{{$recover->middlename ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Last Name *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="lastname"
                                                           required="required"
                                                           value="{{$recover->lastname ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Maiden Mother Name *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="mothername"
                                                           required="required"
                                                           value="{{$recover->mothername ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Other common names used /former name if any</label>
                                                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="alias"
                                                           value="{{$recover->alias ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Reason for using other name</label>
                                                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="aliasreason"

                                                           value="{{$recover->aliasreason ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Birth *</label>
                                                    <input required type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="birth"
                                                           required="required"
                                                           value="{{$recover->birth ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Gender</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="gender">
                                                        <option <?php if (isset($recover) and ($recover->gender == '--select--')) {
                                                            echo ' selected ';
                                                        } ?>>--select--
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->gender == 'Male')) {
                                                            echo ' selected ';
                                                        } ?>>Male
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->gender == 'Female')) {
                                                            echo ' selected ';
                                                        } ?>>Female
                                                        </option>
                                                        <option <?php if (isset($recover) and ($recover->gender == 'Third Gender')) {
                                                            echo ' selected ';
                                                        } ?>>Third Gender
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship *</label>
                                                    <select name="country" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                        <option value="">Please Select</option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Afghanistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Afghanistan">Afghanistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Albania ')) {
                                                                echo ' selected ';
                                                            } ?> value="Albania ">Albania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Algeria')) {
                                                                echo ' selected ';
                                                            } ?> value="Algeria">Algeria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'American Samoa')) {
                                                                echo ' selected ';
                                                            } ?> value="American Samoa">American Samoa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Andorra')) {
                                                                echo ' selected ';
                                                            } ?> value="Andorra">Andorra
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Angola')) {
                                                                echo ' selected ';
                                                            } ?> value="Angola">Angola
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Anguilla')) {
                                                                echo ' selected ';
                                                            } ?> value="Anguilla">Anguilla
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Antarctica')) {
                                                                echo ' selected ';
                                                            } ?> value="Antarctica">Antarctica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Antigua and Barbuda')) {
                                                                echo ' selected ';
                                                            } ?> value="Antigua and Barbuda">Antigua and Barbuda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Argentina ')) {
                                                                echo ' selected ';
                                                            } ?> value="Argentina ">Argentina
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Armenia')) {
                                                                echo ' selected ';
                                                            } ?> value="Armenia">Armenia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Aruba')) {
                                                                echo ' selected ';
                                                            } ?> value="Aruba">Aruba
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Australia')) {
                                                                echo ' selected ';
                                                            } ?> value="Australia">Australia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Austria')) {
                                                                echo ' selected ';
                                                            } ?> value="Austria">Austria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Azerbaijan')) {
                                                                echo ' selected ';
                                                            } ?> value="Azerbaijan">Azerbaijan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bahamas')) {
                                                                echo ' selected ';
                                                            } ?> value="Bahamas">Bahamas
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bahrain')) {
                                                                echo ' selected ';
                                                            } ?> value="Bahrain">Bahrain
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bangladesh')) {
                                                                echo ' selected ';
                                                            } ?> value="Bangladesh">Bangladesh
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Barbados')) {
                                                                echo ' selected ';
                                                            } ?> value="Barbados">Barbados
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Belarus')) {
                                                                echo ' selected ';
                                                            } ?> value="Belarus">Belarus
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Belgium')) {
                                                                echo ' selected ';
                                                            } ?> value="Belgium">Belgium
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Belize')) {
                                                                echo ' selected ';
                                                            } ?> value="Belize">Belize
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Benin')) {
                                                                echo ' selected ';
                                                            } ?> value="Benin">Benin
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bermuda')) {
                                                                echo ' selected ';
                                                            } ?> value="Bermuda">Bermuda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bhutan')) {
                                                                echo ' selected ';
                                                            } ?> value="Bhutan">Bhutan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bolivia')) {
                                                                echo ' selected ';
                                                            } ?> value="Bolivia">Bolivia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bosnia and Herzegowina')) {
                                                                echo ' selected ';
                                                            } ?> value="Bosnia and Herzegowina">Bosnia and
                                                            Herzegowina
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Botswana')) {
                                                                echo ' selected ';
                                                            } ?> value="Botswana">Botswana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bouvet Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Bouvet Island">Bouvet Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Brazil')) {
                                                                echo ' selected ';
                                                            } ?> value="Brazil">Brazil
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'British Indian Ocean Territory')) {
                                                                echo ' selected ';
                                                            } ?> value="British Indian Ocean Territory">British
                                                            Indian Ocean Territory
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Brunei Darussalam')) {
                                                                echo ' selected ';
                                                            } ?> value="Brunei Darussalam">Brunei Darussalam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Bulgaria')) {
                                                                echo ' selected ';
                                                            } ?> value="Bulgaria">Bulgaria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Burundi')) {
                                                                echo ' selected ';
                                                            } ?> value="Burundi">Burundi
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cambodia')) {
                                                                echo ' selected ';
                                                            } ?> value="Cambodia">Cambodia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cameroon')) {
                                                                echo ' selected ';
                                                            } ?> value="Cameroon">Cameroon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Canada')) {
                                                                echo ' selected ';
                                                            } ?> value="Canada">Canada
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cape Verde')) {
                                                                echo ' selected ';
                                                            } ?> value="Cape Verde">Cape Verde
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cayman Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cayman Islands">Cayman Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Central African Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Central African Republic">Central
                                                            African Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Chad')) {
                                                                echo ' selected ';
                                                            } ?> value="Chad">Chad
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Chile')) {
                                                                echo ' selected ';
                                                            } ?> value="Chile">Chile
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'China')) {
                                                                echo ' selected ';
                                                            } ?> value="China">China
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Christmas Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Christmas Island">Christmas Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cocos (Keeling) Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cocos (Keeling) Islands">Cocos (Keeling)
                                                            Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Colombia')) {
                                                                echo ' selected ';
                                                            } ?> value="Colombia">Colombia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Comoros')) {
                                                                echo ' selected ';
                                                            } ?> value="Comoros">Comoros
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Congo')) {
                                                                echo ' selected ';
                                                            } ?> value="Congo">Congo
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cook Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cook Islands">Cook Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Costa Rica')) {
                                                                echo ' selected ';
                                                            } ?> value="Costa Rica">Costa Rica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cote D\'Ivoire')) {
                                                                echo ' selected ';
                                                            } ?> value="Cote D'Ivoire">Cote D'Ivoire
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Croatia')) {
                                                                echo ' selected ';
                                                            } ?> value="Croatia">Croatia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cuba')) {
                                                                echo ' selected ';
                                                            } ?> value="Cuba">Cuba
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cyprus')) {
                                                                echo ' selected ';
                                                            } ?> value="Cyprus">Cyprus
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Czech Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Czech Republic">Czech Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Denmark')) {
                                                                echo ' selected ';
                                                            } ?> value="Denmark">Denmark
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Djibouti')) {
                                                                echo ' selected ';
                                                            } ?> value="Djibouti">Djibouti
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Dominica')) {
                                                                echo ' selected ';
                                                            } ?> value="Dominica">Dominica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Dominican Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Dominican Republic">Dominican Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'East Timor')) {
                                                                echo ' selected ';
                                                            } ?> value="East Timor">East Timor
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Ecuador')) {
                                                                echo ' selected ';
                                                            } ?> value="Ecuador">Ecuador
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Egypt')) {
                                                                echo ' selected ';
                                                            } ?> value="Egypt">Egypt
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'El Salvador')) {
                                                                echo ' selected ';
                                                            } ?> value="El Salvador">El Salvador
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Equatorial Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Equatorial Guinea">Equatorial Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Eritrea')) {
                                                                echo ' selected ';
                                                            } ?> value="Eritrea">Eritrea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Estonia')) {
                                                                echo ' selected ';
                                                            } ?> value="Estonia">Estonia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Ethiopia')) {
                                                                echo ' selected ';
                                                            } ?> value="Ethiopia">Ethiopia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Falkland Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Falkland Islands">Falkland Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Faroe Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Faroe Islands">Faroe Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Fiji')) {
                                                                echo ' selected ';
                                                            } ?> value="Fiji">Fiji
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Finland')) {
                                                                echo ' selected ';
                                                            } ?> value="Finland">Finland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'France')) {
                                                                echo ' selected ';
                                                            } ?> value="France">France
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'France (Metropolitan)')) {
                                                                echo ' selected ';
                                                            } ?> value="France (Metropolitan)">France
                                                            (Metropolitan)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'French Guiana')) {
                                                                echo ' selected ';
                                                            } ?> value="French Guiana">French Guiana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'French Polynesia')) {
                                                                echo ' selected ';
                                                            } ?> value="French Polynesia">French Polynesia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'French Southern Territories')) {
                                                                echo ' selected ';
                                                            } ?> value="French Southern Territories">French
                                                            Southern Territories
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Gabon')) {
                                                                echo ' selected ';
                                                            } ?> value="Gabon">Gabon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Gambia')) {
                                                                echo ' selected ';
                                                            } ?> value="Gambia">Gambia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Georgia')) {
                                                                echo ' selected ';
                                                            } ?> value="Georgia">Georgia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Germany')) {
                                                                echo ' selected ';
                                                            } ?> value="Germany">Germany
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Ghana')) {
                                                                echo ' selected ';
                                                            } ?> value="Ghana">Ghana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Gibraltar')) {
                                                                echo ' selected ';
                                                            } ?> value="Gibraltar">Gibraltar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Greece')) {
                                                                echo ' selected ';
                                                            } ?> value="Greece">Greece
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Greenland')) {
                                                                echo ' selected ';
                                                            } ?> value="Greenland">Greenland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Grenada')) {
                                                                echo ' selected ';
                                                            } ?> value="Grenada">Grenada
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guadeloupe')) {
                                                                echo ' selected ';
                                                            } ?> value="Guadeloupe">Guadeloupe
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guam')) {
                                                                echo ' selected ';
                                                            } ?> value="Guam">Guam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guatemala')) {
                                                                echo ' selected ';
                                                            } ?> value="Guatemala">Guatemala
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Guinea">Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guinea-Bissau')) {
                                                                echo ' selected ';
                                                            } ?> value="Guinea-Bissau">Guinea-Bissau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Guyana')) {
                                                                echo ' selected ';
                                                            } ?> value="Guyana">Guyana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Haiti')) {
                                                                echo ' selected ';
                                                            } ?> value="Haiti">Haiti
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Heard and McDonald Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Heard and McDonald Islands">Heard and
                                                            McDonald Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Honduras')) {
                                                                echo ' selected ';
                                                            } ?> value="Honduras">Honduras
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Hong Kong')) {
                                                                echo ' selected ';
                                                            } ?> value="Hong Kong">Hong Kong
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Hungary')) {
                                                                echo ' selected ';
                                                            } ?> value="Hungary">Hungary
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Iceland')) {
                                                                echo ' selected ';
                                                            } ?> value="Iceland">Iceland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'India')) {
                                                                echo ' selected ';
                                                            } ?> value="India">India
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Indonesia')) {
                                                                echo ' selected ';
                                                            } ?> value="Indonesia">Indonesia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Iran')) {
                                                                echo ' selected ';
                                                            } ?> value="Iran">Iran
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Iraq')) {
                                                                echo ' selected ';
                                                            } ?> value="Iraq">Iraq
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Ireland')) {
                                                                echo ' selected ';
                                                            } ?> value="Ireland">Ireland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Israel')) {
                                                                echo ' selected ';
                                                            } ?> value="Israel">Israel
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Italy')) {
                                                                echo ' selected ';
                                                            } ?> value="Italy">Italy
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Jamaica')) {
                                                                echo ' selected ';
                                                            } ?> value="Jamaica">Jamaica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Japan')) {
                                                                echo ' selected ';
                                                            } ?> value="Japan">Japan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Jordan')) {
                                                                echo ' selected ';
                                                            } ?> value="Jordan">Jordan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Kazakhstan')) {
                                                                echo ' selected ';
                                                            } ?> value="Kazakhstan">Kazakhstan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Kenya')) {
                                                                echo ' selected ';
                                                            } ?> value="Kenya">Kenya
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Kiribati')) {
                                                                echo ' selected ';
                                                            } ?> value="Kiribati">Kiribati
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Korea (Democratic People\'s Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Korea (Democratic People's Republic of)">
                                                            Korea (Democratic People's Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Korea (Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Korea (Republic of)">Korea (Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Kuwait')) {
                                                                echo ' selected ';
                                                            } ?> value="Kuwait">Kuwait
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Kyrgyzstan')) {
                                                                echo ' selected ';
                                                            } ?> value="Kyrgyzstan">Kyrgyzstan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Lao People\'s Democratic Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Lao People's Democratic Republic">Lao
                                                            People's Democratic Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Latvia')) {
                                                                echo ' selected ';
                                                            } ?> value="Latvia">Latvia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Lebanon')) {
                                                                echo ' selected ';
                                                            } ?> value="Lebanon">Lebanon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Lesotho')) {
                                                                echo ' selected ';
                                                            } ?> value="Lesotho">Lesotho
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Liberia')) {
                                                                echo ' selected ';
                                                            } ?> value="Liberia">Liberia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Libyan Arab Jamahiriya')) {
                                                                echo ' selected ';
                                                            } ?> value="Libyan Arab Jamahiriya">Libyan Arab
                                                            Jamahiriya
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Liechtenstein')) {
                                                                echo ' selected ';
                                                            } ?> value="Liechtenstein">Liechtenstein
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Lithuania')) {
                                                                echo ' selected ';
                                                            } ?> value="Lithuania">Lithuania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Luxembourg')) {
                                                                echo ' selected ';
                                                            } ?> value="Luxembourg">Luxembourg
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Macau')) {
                                                                echo ' selected ';
                                                            } ?> value="Macau">Macau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Macedonia')) {
                                                                echo ' selected ';
                                                            } ?> value="Macedonia">Macedonia (The Former
                                                            Yugoslav Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Madagascar')) {
                                                                echo ' selected ';
                                                            } ?> value="Madagascar">Madagascar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Malawi')) {
                                                                echo ' selected ';
                                                            } ?> value="Malawi">Malawi
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Malaysia')) {
                                                                echo ' selected ';
                                                            } ?> value="Malaysia">Malaysia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Maldives')) {
                                                                echo ' selected ';
                                                            } ?> value="Maldives">Maldives
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mali')) {
                                                                echo ' selected ';
                                                            } ?> value="Mali">Mali
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Malta')) {
                                                                echo ' selected ';
                                                            } ?> value="Malta">Malta
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Marshall Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Marshall Islands">Marshall Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Martinique')) {
                                                                echo ' selected ';
                                                            } ?> value="Martinique">Martinique
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mauritania')) {
                                                                echo ' selected ';
                                                            } ?> value="Mauritania">Mauritania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mauritius')) {
                                                                echo ' selected ';
                                                            } ?> value="Mauritius">Mauritius
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mayotte')) {
                                                                echo ' selected ';
                                                            } ?> value="Mayotte">Mayotte
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mexico')) {
                                                                echo ' selected ';
                                                            } ?> value="Mexico">Mexico
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Micronesia (Federated States of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Micronesia (Federated States of)">
                                                            Micronesia (Federated States of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Moldova (Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Moldova (Republic of)">Moldova (Republic
                                                            of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Monaco')) {
                                                                echo ' selected ';
                                                            } ?> value="Monaco">Monaco
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mongolia')) {
                                                                echo ' selected ';
                                                            } ?> value="Mongolia">Mongolia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Montserrat')) {
                                                                echo ' selected ';
                                                            } ?> value="Montserrat">Montserrat
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Morocco')) {
                                                                echo ' selected ';
                                                            } ?> value="Morocco">Morocco
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Mozambique')) {
                                                                echo ' selected ';
                                                            } ?> value="Mozambique">Mozambique
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Myanmar')) {
                                                                echo ' selected ';
                                                            } ?> value="Myanmar">Myanmar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Namibia')) {
                                                                echo ' selected ';
                                                            } ?> value="Namibia">Namibia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Nauru')) {
                                                                echo ' selected ';
                                                            } ?> value="Nauru">Nauru
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Nepal')) {
                                                                echo ' selected ';
                                                            } ?> value="Nepal">Nepal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Netherlands')) {
                                                                echo ' selected ';
                                                            } ?> value="Netherlands">Netherlands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Netherlands Antilles')) {
                                                                echo ' selected ';
                                                            } ?> value="Netherlands Antilles">Netherlands
                                                            Antilles
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'New Caledonia')) {
                                                                echo ' selected ';
                                                            } ?> value="New Caledonia">New Caledonia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'New Zealand')) {
                                                                echo ' selected ';
                                                            } ?> value="New Zealand">New Zealand
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Nicaragua')) {
                                                                echo ' selected ';
                                                            } ?> value="Nicaragua">Nicaragua
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Niger')) {
                                                                echo ' selected ';
                                                            } ?> value="Niger">Niger
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Nigeria')) {
                                                                echo ' selected ';
                                                            } ?> value="Nigeria">Nigeria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Niue')) {
                                                                echo ' selected ';
                                                            } ?> value="Niue">Niue
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Norfolk Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Norfolk Island">Norfolk Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Northern Mariana Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Northern Mariana Islands">Northern
                                                            Mariana Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Norway')) {
                                                                echo ' selected ';
                                                            } ?> value="Norway">Norway
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Oman')) {
                                                                echo ' selected ';
                                                            } ?> value="Oman">Oman
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Pakistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Pakistan">Pakistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Palau')) {
                                                                echo ' selected ';
                                                            } ?> value="Palau">Palau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Panama')) {
                                                                echo ' selected ';
                                                            } ?> value="Panama">Panama
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Papua New Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Papua New Guinea">Papua New Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Paraguay')) {
                                                                echo ' selected ';
                                                            } ?> value="Paraguay">Paraguay
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Peru')) {
                                                                echo ' selected ';
                                                            } ?> value="Peru">Peru
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Philippines')) {
                                                                echo ' selected ';
                                                            } ?> value="Philippines">Philippines
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Pitcairn')) {
                                                                echo ' selected ';
                                                            } ?> value="Pitcairn">Pitcairn
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Poland')) {
                                                                echo ' selected ';
                                                            } ?> value="Poland">Poland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Portugal')) {
                                                                echo ' selected ';
                                                            } ?> value="Portugal">Portugal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Puerto Rico')) {
                                                                echo ' selected ';
                                                            } ?> value="Puerto Rico">Puerto Rico
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Qatar')) {
                                                                echo ' selected ';
                                                            } ?> value="Qatar">Qatar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Reunion')) {
                                                                echo ' selected ';
                                                            } ?> value="Reunion">Reunion
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Romania')) {
                                                                echo ' selected ';
                                                            } ?> value="Romania">Romania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Russian Federation')) {
                                                                echo ' selected ';
                                                            } ?> value="Russian Federation">Russian Federation
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Rwanda')) {
                                                                echo ' selected ';
                                                            } ?> value="Rwanda">Rwanda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Saint Kitts and Nevis')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Kitts and Nevis">Saint Kitts and
                                                            Nevis
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Saint Lucia')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Lucia">Saint Lucia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Saint Vincent and the Grenadines')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Vincent and the Grenadines">Saint
                                                            Vincent and the Grenadines
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Samoa')) {
                                                                echo ' selected ';
                                                            } ?> value="Samoa">Samoa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'San Marino')) {
                                                                echo ' selected ';
                                                            } ?> value="San Marino">San Marino
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sao Tome and Principe')) {
                                                                echo ' selected ';
                                                            } ?> value="Sao Tome and Principe">Sao Tome and
                                                            Principe
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Saudi Arabia')) {
                                                                echo ' selected ';
                                                            } ?> value="Saudi Arabia">Saudi Arabia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sebia')) {
                                                                echo ' selected ';
                                                            } ?> value="Sebia">Sebia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Senegal')) {
                                                                echo ' selected ';
                                                            } ?> value="Senegal">Senegal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Seychelles')) {
                                                                echo ' selected ';
                                                            } ?> value="Seychelles">Seychelles
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sierra Leone')) {
                                                                echo ' selected ';
                                                            } ?> value="Sierra Leone">Sierra Leone
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Singapore')) {
                                                                echo ' selected ';
                                                            } ?> value="Singapore">Singapore
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Slovakia (Slovak Republic)')) {
                                                                echo ' selected ';
                                                            } ?> value="Slovakia (Slovak Republic)">Slovakia
                                                            (Slovak Republic)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Slovenia')) {
                                                                echo ' selected ';
                                                            } ?> value="Slovenia">Slovenia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Solomon Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Solomon Islands">Solomon Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Somalia')) {
                                                                echo ' selected ';
                                                            } ?> value="Somalia">Somalia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'South Africa')) {
                                                                echo ' selected ';
                                                            } ?> value="South Africa">South Africa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'South Georgia &amp; South Sandwich Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="South Georgia &amp; South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Spain')) {
                                                                echo ' selected ';
                                                            } ?> value="Spain">Spain
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sri Lanka')) {
                                                                echo ' selected ';
                                                            } ?> value="Sri Lanka">Sri Lanka
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'St. Helena')) {
                                                                echo ' selected ';
                                                            } ?> value="St. Helena">St. Helena
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'St. Pierre and Miquelon')) {
                                                                echo ' selected ';
                                                            } ?> value="St. Pierre and Miquelon">St. Pierre and
                                                            Miquelon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sudan')) {
                                                                echo ' selected ';
                                                            } ?> value="Sudan">Sudan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Suriname')) {
                                                                echo ' selected ';
                                                            } ?> value="Suriname">Suriname
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Svalbard and Jan Mayen Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Svalbard and Jan Mayen Islands">Svalbard
                                                            and Jan Mayen Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Swaziland')) {
                                                                echo ' selected ';
                                                            } ?> value="Swaziland">Swaziland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Sweden')) {
                                                                echo ' selected ';
                                                            } ?> value="Sweden">Sweden
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Switzerland')) {
                                                                echo ' selected ';
                                                            } ?> value="Switzerland">Switzerland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Syrian Arab Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Syrian Arab Republic">Syrian Arab
                                                            Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Taiwan (Province of China)')) {
                                                                echo ' selected ';
                                                            } ?> value="Taiwan (Province of China)">Taiwan
                                                            (Province of China)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tajikistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Tajikistan">Tajikistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tanzania (United Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Tanzania (United Republic of)">Tanzania
                                                            (United Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Thailand')) {
                                                                echo ' selected ';
                                                            } ?> value="Thailand">Thailand
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Togo')) {
                                                                echo ' selected ';
                                                            } ?> value="Togo">Togo
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tokelau')) {
                                                                echo ' selected ';
                                                            } ?> value="Tokelau">Tokelau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tonga')) {
                                                                echo ' selected ';
                                                            } ?> value="Tonga">Tonga
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Trinidad and Tobago')) {
                                                                echo ' selected ';
                                                            } ?> value="Trinidad and Tobago">Trinidad and Tobago
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tunisia')) {
                                                                echo ' selected ';
                                                            } ?> value="Tunisia">Tunisia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Turkey')) {
                                                                echo ' selected ';
                                                            } ?> value="Turkey">Turkey
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Turkmenistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Turkmenistan">Turkmenistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Turks and Caicos Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Turks and Caicos Islands">Turks and
                                                            Caicos Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Tuvalu')) {
                                                                echo ' selected ';
                                                            } ?> value="Tuvalu">Tuvalu
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Uganda')) {
                                                                echo ' selected ';
                                                            } ?> value="Uganda">Uganda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Ukraine')) {
                                                                echo ' selected ';
                                                            } ?> value="Ukraine">Ukraine
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'United Arab Emirates')) {
                                                                echo ' selected ';
                                                            } ?> value="United Arab Emirates">United Arab
                                                            Emirates
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'United Kingdom')) {
                                                                echo ' selected ';
                                                            } ?> value="United Kingdom">United Kingdom
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'United States Minor Outlying Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="United States Minor Outlying Islands">
                                                            United States Minor Outlying Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'United States of America')) {
                                                                echo ' selected ';
                                                            } ?> value="United States of America">United States
                                                            of America
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Uruguay')) {
                                                                echo ' selected ';
                                                            } ?> value="Uruguay">Uruguay
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Uzbekistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Uzbekistan">Uzbekistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Vanuatu')) {
                                                                echo ' selected ';
                                                            } ?> value="Vanuatu">Vanuatu
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Vatican City State (Holy See)')) {
                                                                echo ' selected ';
                                                            } ?> value="Vatican City State (Holy See)">Vatican
                                                            City State (Holy See)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Venezuela')) {
                                                                echo ' selected ';
                                                            } ?> value="Venezuela">Venezuela
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Viet Nam')) {
                                                                echo ' selected ';
                                                            } ?> value="Viet Nam">Viet Nam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Virgin Islands (British)')) {
                                                                echo ' selected ';
                                                            } ?> value="Virgin Islands (British)">Virgin Islands
                                                            (British)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Virgin Islands (U.S.)')) {
                                                                echo ' selected ';
                                                            } ?> value="Virgin Islands (U.S.)">Virgin Islands
                                                            (U.S.)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Wallis and Futuna Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Wallis and Futuna Islands">Wallis and
                                                            Futuna Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Western Sahara')) {
                                                                echo ' selected ';
                                                            } ?> value="Western Sahara">Western Sahara
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Yemen')) {
                                                                echo ' selected ';
                                                            } ?> value="Yemen">Yemen
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Yugoslavia')) {
                                                                echo ' selected ';
                                                            } ?> value="Yugoslavia">Yugoslavia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Zaire')) {
                                                                echo ' selected ';
                                                            } ?> value="Zaire">Zaire
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Zambia')) {
                                                                echo ' selected ';
                                                            } ?> value="Zambia">Zambia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Zimbabwe')) {
                                                                echo ' selected ';
                                                            } ?> value="Zimbabwe">Zimbabwe
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">ID Number *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="panid"
                                                           required="required"
                                                           value="{{$recover->panid ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Permanent /Residential Address *</label>
                                                <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="address"
                                                       required="required"
                                                       value="{{$recover->address ?? '' }}">
                                            </div>

                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">City *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="city"
                                                           required="required"
                                                           value="{{$recover->city ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">State *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="state"
                                                           required="required"
                                                           value="{{$recover->state ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Country *</label>
                                                    <select name="country2" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                        <option value="">Please Select</option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Afghanistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Afghanistan">Afghanistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Albania ')) {
                                                                echo ' selected ';
                                                            } ?> value="Albania ">Albania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Algeria')) {
                                                                echo ' selected ';
                                                            } ?> value="Algeria">Algeria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'American Samoa')) {
                                                                echo ' selected ';
                                                            } ?> value="American Samoa">American Samoa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Andorra')) {
                                                                echo ' selected ';
                                                            } ?> value="Andorra">Andorra
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Angola')) {
                                                                echo ' selected ';
                                                            } ?> value="Angola">Angola
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Anguilla')) {
                                                                echo ' selected ';
                                                            } ?> value="Anguilla">Anguilla
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Antarctica')) {
                                                                echo ' selected ';
                                                            } ?> value="Antarctica">Antarctica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Antigua and Barbuda')) {
                                                                echo ' selected ';
                                                            } ?> value="Antigua and Barbuda">Antigua and Barbuda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Argentina ')) {
                                                                echo ' selected ';
                                                            } ?> value="Argentina ">Argentina
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Armenia')) {
                                                                echo ' selected ';
                                                            } ?> value="Armenia">Armenia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Aruba')) {
                                                                echo ' selected ';
                                                            } ?> value="Aruba">Aruba
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Australia')) {
                                                                echo ' selected ';
                                                            } ?> value="Australia">Australia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Austria')) {
                                                                echo ' selected ';
                                                            } ?> value="Austria">Austria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Azerbaijan')) {
                                                                echo ' selected ';
                                                            } ?> value="Azerbaijan">Azerbaijan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bahamas')) {
                                                                echo ' selected ';
                                                            } ?> value="Bahamas">Bahamas
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bahrain')) {
                                                                echo ' selected ';
                                                            } ?> value="Bahrain">Bahrain
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bangladesh')) {
                                                                echo ' selected ';
                                                            } ?> value="Bangladesh">Bangladesh
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Barbados')) {
                                                                echo ' selected ';
                                                            } ?> value="Barbados">Barbados
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Belarus')) {
                                                                echo ' selected ';
                                                            } ?> value="Belarus">Belarus
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Belgium')) {
                                                                echo ' selected ';
                                                            } ?> value="Belgium">Belgium
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Belize')) {
                                                                echo ' selected ';
                                                            } ?> value="Belize">Belize
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Benin')) {
                                                                echo ' selected ';
                                                            } ?> value="Benin">Benin
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bermuda')) {
                                                                echo ' selected ';
                                                            } ?> value="Bermuda">Bermuda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bhutan')) {
                                                                echo ' selected ';
                                                            } ?> value="Bhutan">Bhutan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bolivia')) {
                                                                echo ' selected ';
                                                            } ?> value="Bolivia">Bolivia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bosnia and Herzegowina')) {
                                                                echo ' selected ';
                                                            } ?> value="Bosnia and Herzegowina">Bosnia and
                                                            Herzegowina
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Botswana')) {
                                                                echo ' selected ';
                                                            } ?> value="Botswana">Botswana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bouvet Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Bouvet Island">Bouvet Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Brazil')) {
                                                                echo ' selected ';
                                                            } ?> value="Brazil">Brazil
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'British Indian Ocean Territory')) {
                                                                echo ' selected ';
                                                            } ?> value="British Indian Ocean Territory">British
                                                            Indian Ocean Territory
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Brunei Darussalam')) {
                                                                echo ' selected ';
                                                            } ?> value="Brunei Darussalam">Brunei Darussalam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Bulgaria')) {
                                                                echo ' selected ';
                                                            } ?> value="Bulgaria">Bulgaria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Burundi')) {
                                                                echo ' selected ';
                                                            } ?> value="Burundi">Burundi
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cambodia')) {
                                                                echo ' selected ';
                                                            } ?> value="Cambodia">Cambodia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cameroon')) {
                                                                echo ' selected ';
                                                            } ?> value="Cameroon">Cameroon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Canada')) {
                                                                echo ' selected ';
                                                            } ?> value="Canada">Canada
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cape Verde')) {
                                                                echo ' selected ';
                                                            } ?> value="Cape Verde">Cape Verde
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cayman Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cayman Islands">Cayman Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Central African Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Central African Republic">Central
                                                            African Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Chad')) {
                                                                echo ' selected ';
                                                            } ?> value="Chad">Chad
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Chile')) {
                                                                echo ' selected ';
                                                            } ?> value="Chile">Chile
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'China')) {
                                                                echo ' selected ';
                                                            } ?> value="China">China
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Christmas Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Christmas Island">Christmas Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cocos (Keeling) Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cocos (Keeling) Islands">Cocos (Keeling)
                                                            Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Colombia')) {
                                                                echo ' selected ';
                                                            } ?> value="Colombia">Colombia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Comoros')) {
                                                                echo ' selected ';
                                                            } ?> value="Comoros">Comoros
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Congo')) {
                                                                echo ' selected ';
                                                            } ?> value="Congo">Congo
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cook Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Cook Islands">Cook Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Costa Rica')) {
                                                                echo ' selected ';
                                                            } ?> value="Costa Rica">Costa Rica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Cote D\'Ivoire')) {
                                                                echo ' selected ';
                                                            } ?> value="Cote D'Ivoire">Cote D'Ivoire
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Croatia')) {
                                                                echo ' selected ';
                                                            } ?> value="Croatia">Croatia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cuba')) {
                                                                echo ' selected ';
                                                            } ?> value="Cuba">Cuba
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Cyprus')) {
                                                                echo ' selected ';
                                                            } ?> value="Cyprus">Cyprus
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Czech Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Czech Republic">Czech Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Denmark')) {
                                                                echo ' selected ';
                                                            } ?> value="Denmark">Denmark
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Djibouti')) {
                                                                echo ' selected ';
                                                            } ?> value="Djibouti">Djibouti
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Dominica')) {
                                                                echo ' selected ';
                                                            } ?> value="Dominica">Dominica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Dominican Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Dominican Republic">Dominican Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'East Timor')) {
                                                                echo ' selected ';
                                                            } ?> value="East Timor">East Timor
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Ecuador')) {
                                                                echo ' selected ';
                                                            } ?> value="Ecuador">Ecuador
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Egypt')) {
                                                                echo ' selected ';
                                                            } ?> value="Egypt">Egypt
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'El Salvador')) {
                                                                echo ' selected ';
                                                            } ?> value="El Salvador">El Salvador
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Equatorial Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Equatorial Guinea">Equatorial Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Eritrea')) {
                                                                echo ' selected ';
                                                            } ?> value="Eritrea">Eritrea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Estonia')) {
                                                                echo ' selected ';
                                                            } ?> value="Estonia">Estonia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Ethiopia')) {
                                                                echo ' selected ';
                                                            } ?> value="Ethiopia">Ethiopia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Falkland Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Falkland Islands">Falkland Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Faroe Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Faroe Islands">Faroe Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Fiji')) {
                                                                echo ' selected ';
                                                            } ?> value="Fiji">Fiji
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Finland')) {
                                                                echo ' selected ';
                                                            } ?> value="Finland">Finland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'France')) {
                                                                echo ' selected ';
                                                            } ?> value="France">France
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'France (Metropolitan)')) {
                                                                echo ' selected ';
                                                            } ?> value="France (Metropolitan)">France
                                                            (Metropolitan)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'French Guiana')) {
                                                                echo ' selected ';
                                                            } ?> value="French Guiana">French Guiana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'French Polynesia')) {
                                                                echo ' selected ';
                                                            } ?> value="French Polynesia">French Polynesia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'French Southern Territories')) {
                                                                echo ' selected ';
                                                            } ?> value="French Southern Territories">French
                                                            Southern Territories
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Gabon')) {
                                                                echo ' selected ';
                                                            } ?> value="Gabon">Gabon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Gambia')) {
                                                                echo ' selected ';
                                                            } ?> value="Gambia">Gambia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Georgia')) {
                                                                echo ' selected ';
                                                            } ?> value="Georgia">Georgia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Germany')) {
                                                                echo ' selected ';
                                                            } ?> value="Germany">Germany
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Ghana')) {
                                                                echo ' selected ';
                                                            } ?> value="Ghana">Ghana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Gibraltar')) {
                                                                echo ' selected ';
                                                            } ?> value="Gibraltar">Gibraltar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Greece')) {
                                                                echo ' selected ';
                                                            } ?> value="Greece">Greece
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Greenland')) {
                                                                echo ' selected ';
                                                            } ?> value="Greenland">Greenland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Grenada')) {
                                                                echo ' selected ';
                                                            } ?> value="Grenada">Grenada
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guadeloupe')) {
                                                                echo ' selected ';
                                                            } ?> value="Guadeloupe">Guadeloupe
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guam')) {
                                                                echo ' selected ';
                                                            } ?> value="Guam">Guam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guatemala')) {
                                                                echo ' selected ';
                                                            } ?> value="Guatemala">Guatemala
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Guinea">Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guinea-Bissau')) {
                                                                echo ' selected ';
                                                            } ?> value="Guinea-Bissau">Guinea-Bissau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Guyana')) {
                                                                echo ' selected ';
                                                            } ?> value="Guyana">Guyana
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Haiti')) {
                                                                echo ' selected ';
                                                            } ?> value="Haiti">Haiti
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Heard and McDonald Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Heard and McDonald Islands">Heard and
                                                            McDonald Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Honduras')) {
                                                                echo ' selected ';
                                                            } ?> value="Honduras">Honduras
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Hong Kong')) {
                                                                echo ' selected ';
                                                            } ?> value="Hong Kong">Hong Kong
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Hungary')) {
                                                                echo ' selected ';
                                                            } ?> value="Hungary">Hungary
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Iceland')) {
                                                                echo ' selected ';
                                                            } ?> value="Iceland">Iceland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'India')) {
                                                                echo ' selected ';
                                                            } ?> value="India">India
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Indonesia')) {
                                                                echo ' selected ';
                                                            } ?> value="Indonesia">Indonesia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Iran')) {
                                                                echo ' selected ';
                                                            } ?> value="Iran">Iran
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Iraq')) {
                                                                echo ' selected ';
                                                            } ?> value="Iraq">Iraq
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Ireland')) {
                                                                echo ' selected ';
                                                            } ?> value="Ireland">Ireland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Israel')) {
                                                                echo ' selected ';
                                                            } ?> value="Israel">Israel
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Italy')) {
                                                                echo ' selected ';
                                                            } ?> value="Italy">Italy
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Jamaica')) {
                                                                echo ' selected ';
                                                            } ?> value="Jamaica">Jamaica
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Japan')) {
                                                                echo ' selected ';
                                                            } ?> value="Japan">Japan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Jordan')) {
                                                                echo ' selected ';
                                                            } ?> value="Jordan">Jordan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Kazakhstan')) {
                                                                echo ' selected ';
                                                            } ?> value="Kazakhstan">Kazakhstan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Kenya')) {
                                                                echo ' selected ';
                                                            } ?> value="Kenya">Kenya
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Kiribati')) {
                                                                echo ' selected ';
                                                            } ?> value="Kiribati">Kiribati
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Korea (Democratic People\'s Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Korea (Democratic People's Republic of)">
                                                            Korea (Democratic People's Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Korea (Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Korea (Republic of)">Korea (Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Kuwait')) {
                                                                echo ' selected ';
                                                            } ?> value="Kuwait">Kuwait
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Kyrgyzstan')) {
                                                                echo ' selected ';
                                                            } ?> value="Kyrgyzstan">Kyrgyzstan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country == 'Lao People\'s Democratic Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Lao People's Democratic Republic">Lao
                                                            People's Democratic Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Latvia')) {
                                                                echo ' selected ';
                                                            } ?> value="Latvia">Latvia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Lebanon')) {
                                                                echo ' selected ';
                                                            } ?> value="Lebanon">Lebanon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Lesotho')) {
                                                                echo ' selected ';
                                                            } ?> value="Lesotho">Lesotho
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Liberia')) {
                                                                echo ' selected ';
                                                            } ?> value="Liberia">Liberia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Libyan Arab Jamahiriya')) {
                                                                echo ' selected ';
                                                            } ?> value="Libyan Arab Jamahiriya">Libyan Arab
                                                            Jamahiriya
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Liechtenstein')) {
                                                                echo ' selected ';
                                                            } ?> value="Liechtenstein">Liechtenstein
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Lithuania')) {
                                                                echo ' selected ';
                                                            } ?> value="Lithuania">Lithuania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Luxembourg')) {
                                                                echo ' selected ';
                                                            } ?> value="Luxembourg">Luxembourg
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Macau')) {
                                                                echo ' selected ';
                                                            } ?> value="Macau">Macau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Macedonia')) {
                                                                echo ' selected ';
                                                            } ?> value="Macedonia">Macedonia (The Former
                                                            Yugoslav Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Madagascar')) {
                                                                echo ' selected ';
                                                            } ?> value="Madagascar">Madagascar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Malawi')) {
                                                                echo ' selected ';
                                                            } ?> value="Malawi">Malawi
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Malaysia')) {
                                                                echo ' selected ';
                                                            } ?> value="Malaysia">Malaysia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Maldives')) {
                                                                echo ' selected ';
                                                            } ?> value="Maldives">Maldives
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mali')) {
                                                                echo ' selected ';
                                                            } ?> value="Mali">Mali
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Malta')) {
                                                                echo ' selected ';
                                                            } ?> value="Malta">Malta
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Marshall Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Marshall Islands">Marshall Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Martinique')) {
                                                                echo ' selected ';
                                                            } ?> value="Martinique">Martinique
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mauritania')) {
                                                                echo ' selected ';
                                                            } ?> value="Mauritania">Mauritania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mauritius')) {
                                                                echo ' selected ';
                                                            } ?> value="Mauritius">Mauritius
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mayotte')) {
                                                                echo ' selected ';
                                                            } ?> value="Mayotte">Mayotte
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mexico')) {
                                                                echo ' selected ';
                                                            } ?> value="Mexico">Mexico
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Micronesia (Federated States of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Micronesia (Federated States of)">
                                                            Micronesia (Federated States of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Moldova (Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Moldova (Republic of)">Moldova (Republic
                                                            of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Monaco')) {
                                                                echo ' selected ';
                                                            } ?> value="Monaco">Monaco
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mongolia')) {
                                                                echo ' selected ';
                                                            } ?> value="Mongolia">Mongolia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Montserrat')) {
                                                                echo ' selected ';
                                                            } ?> value="Montserrat">Montserrat
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Morocco')) {
                                                                echo ' selected ';
                                                            } ?> value="Morocco">Morocco
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Mozambique')) {
                                                                echo ' selected ';
                                                            } ?> value="Mozambique">Mozambique
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Myanmar')) {
                                                                echo ' selected ';
                                                            } ?> value="Myanmar">Myanmar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Namibia')) {
                                                                echo ' selected ';
                                                            } ?> value="Namibia">Namibia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Nauru')) {
                                                                echo ' selected ';
                                                            } ?> value="Nauru">Nauru
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Nepal')) {
                                                                echo ' selected ';
                                                            } ?> value="Nepal">Nepal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Netherlands')) {
                                                                echo ' selected ';
                                                            } ?> value="Netherlands">Netherlands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Netherlands Antilles')) {
                                                                echo ' selected ';
                                                            } ?> value="Netherlands Antilles">Netherlands
                                                            Antilles
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'New Caledonia')) {
                                                                echo ' selected ';
                                                            } ?> value="New Caledonia">New Caledonia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'New Zealand')) {
                                                                echo ' selected ';
                                                            } ?> value="New Zealand">New Zealand
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Nicaragua')) {
                                                                echo ' selected ';
                                                            } ?> value="Nicaragua">Nicaragua
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Niger')) {
                                                                echo ' selected ';
                                                            } ?> value="Niger">Niger
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Nigeria')) {
                                                                echo ' selected ';
                                                            } ?> value="Nigeria">Nigeria
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Niue')) {
                                                                echo ' selected ';
                                                            } ?> value="Niue">Niue
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Norfolk Island')) {
                                                                echo ' selected ';
                                                            } ?> value="Norfolk Island">Norfolk Island
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Northern Mariana Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Northern Mariana Islands">Northern
                                                            Mariana Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Norway')) {
                                                                echo ' selected ';
                                                            } ?> value="Norway">Norway
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Oman')) {
                                                                echo ' selected ';
                                                            } ?> value="Oman">Oman
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Pakistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Pakistan">Pakistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Palau')) {
                                                                echo ' selected ';
                                                            } ?> value="Palau">Palau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Panama')) {
                                                                echo ' selected ';
                                                            } ?> value="Panama">Panama
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Papua New Guinea')) {
                                                                echo ' selected ';
                                                            } ?> value="Papua New Guinea">Papua New Guinea
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Paraguay')) {
                                                                echo ' selected ';
                                                            } ?> value="Paraguay">Paraguay
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Peru')) {
                                                                echo ' selected ';
                                                            } ?> value="Peru">Peru
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Philippines')) {
                                                                echo ' selected ';
                                                            } ?> value="Philippines">Philippines
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Pitcairn')) {
                                                                echo ' selected ';
                                                            } ?> value="Pitcairn">Pitcairn
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Poland')) {
                                                                echo ' selected ';
                                                            } ?> value="Poland">Poland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Portugal')) {
                                                                echo ' selected ';
                                                            } ?> value="Portugal">Portugal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Puerto Rico')) {
                                                                echo ' selected ';
                                                            } ?> value="Puerto Rico">Puerto Rico
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Qatar')) {
                                                                echo ' selected ';
                                                            } ?> value="Qatar">Qatar
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Reunion')) {
                                                                echo ' selected ';
                                                            } ?> value="Reunion">Reunion
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Romania')) {
                                                                echo ' selected ';
                                                            } ?> value="Romania">Romania
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Russian Federation')) {
                                                                echo ' selected ';
                                                            } ?> value="Russian Federation">Russian Federation
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Rwanda')) {
                                                                echo ' selected ';
                                                            } ?> value="Rwanda">Rwanda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Saint Kitts and Nevis')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Kitts and Nevis">Saint Kitts and
                                                            Nevis
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Saint Lucia')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Lucia">Saint Lucia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Saint Vincent and the Grenadines')) {
                                                                echo ' selected ';
                                                            } ?> value="Saint Vincent and the Grenadines">Saint
                                                            Vincent and the Grenadines
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Samoa')) {
                                                                echo ' selected ';
                                                            } ?> value="Samoa">Samoa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'San Marino')) {
                                                                echo ' selected ';
                                                            } ?> value="San Marino">San Marino
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sao Tome and Principe')) {
                                                                echo ' selected ';
                                                            } ?> value="Sao Tome and Principe">Sao Tome and
                                                            Principe
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Saudi Arabia')) {
                                                                echo ' selected ';
                                                            } ?> value="Saudi Arabia">Saudi Arabia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sebia')) {
                                                                echo ' selected ';
                                                            } ?> value="Sebia">Sebia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Senegal')) {
                                                                echo ' selected ';
                                                            } ?> value="Senegal">Senegal
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Seychelles')) {
                                                                echo ' selected ';
                                                            } ?> value="Seychelles">Seychelles
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sierra Leone')) {
                                                                echo ' selected ';
                                                            } ?> value="Sierra Leone">Sierra Leone
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Singapore')) {
                                                                echo ' selected ';
                                                            } ?> value="Singapore">Singapore
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Slovakia (Slovak Republic)')) {
                                                                echo ' selected ';
                                                            } ?> value="Slovakia (Slovak Republic)">Slovakia
                                                            (Slovak Republic)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Slovenia')) {
                                                                echo ' selected ';
                                                            } ?> value="Slovenia">Slovenia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Solomon Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Solomon Islands">Solomon Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Somalia')) {
                                                                echo ' selected ';
                                                            } ?> value="Somalia">Somalia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'South Africa')) {
                                                                echo ' selected ';
                                                            } ?> value="South Africa">South Africa
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'South Georgia &amp; South Sandwich Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="South Georgia &amp; South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Spain')) {
                                                                echo ' selected ';
                                                            } ?> value="Spain">Spain
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sri Lanka')) {
                                                                echo ' selected ';
                                                            } ?> value="Sri Lanka">Sri Lanka
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'St. Helena')) {
                                                                echo ' selected ';
                                                            } ?> value="St. Helena">St. Helena
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'St. Pierre and Miquelon')) {
                                                                echo ' selected ';
                                                            } ?> value="St. Pierre and Miquelon">St. Pierre and
                                                            Miquelon
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sudan')) {
                                                                echo ' selected ';
                                                            } ?> value="Sudan">Sudan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Suriname')) {
                                                                echo ' selected ';
                                                            } ?> value="Suriname">Suriname
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Svalbard and Jan Mayen Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Svalbard and Jan Mayen Islands">Svalbard
                                                            and Jan Mayen Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Swaziland')) {
                                                                echo ' selected ';
                                                            } ?> value="Swaziland">Swaziland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Sweden')) {
                                                                echo ' selected ';
                                                            } ?> value="Sweden">Sweden
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Switzerland')) {
                                                                echo ' selected ';
                                                            } ?> value="Switzerland">Switzerland
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Syrian Arab Republic')) {
                                                                echo ' selected ';
                                                            } ?> value="Syrian Arab Republic">Syrian Arab
                                                            Republic
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Taiwan (Province of China)')) {
                                                                echo ' selected ';
                                                            } ?> value="Taiwan (Province of China)">Taiwan
                                                            (Province of China)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tajikistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Tajikistan">Tajikistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tanzania (United Republic of)')) {
                                                                echo ' selected ';
                                                            } ?> value="Tanzania (United Republic of)">Tanzania
                                                            (United Republic of)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Thailand')) {
                                                                echo ' selected ';
                                                            } ?> value="Thailand">Thailand
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Togo')) {
                                                                echo ' selected ';
                                                            } ?> value="Togo">Togo
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tokelau')) {
                                                                echo ' selected ';
                                                            } ?> value="Tokelau">Tokelau
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tonga')) {
                                                                echo ' selected ';
                                                            } ?> value="Tonga">Tonga
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Trinidad and Tobago')) {
                                                                echo ' selected ';
                                                            } ?> value="Trinidad and Tobago">Trinidad and Tobago
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tunisia')) {
                                                                echo ' selected ';
                                                            } ?> value="Tunisia">Tunisia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Turkey')) {
                                                                echo ' selected ';
                                                            } ?> value="Turkey">Turkey
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Turkmenistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Turkmenistan">Turkmenistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Turks and Caicos Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Turks and Caicos Islands">Turks and
                                                            Caicos Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Tuvalu')) {
                                                                echo ' selected ';
                                                            } ?> value="Tuvalu">Tuvalu
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Uganda')) {
                                                                echo ' selected ';
                                                            } ?> value="Uganda">Uganda
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Ukraine')) {
                                                                echo ' selected ';
                                                            } ?> value="Ukraine">Ukraine
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'United Arab Emirates')) {
                                                                echo ' selected ';
                                                            } ?> value="United Arab Emirates">United Arab
                                                            Emirates
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'United Kingdom')) {
                                                                echo ' selected ';
                                                            } ?> value="United Kingdom">United Kingdom
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'United States Minor Outlying Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="United States Minor Outlying Islands">
                                                            United States Minor Outlying Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'United States of America')) {
                                                                echo ' selected ';
                                                            } ?> value="United States of America">United States
                                                            of America
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Uruguay')) {
                                                                echo ' selected ';
                                                            } ?> value="Uruguay">Uruguay
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Uzbekistan')) {
                                                                echo ' selected ';
                                                            } ?> value="Uzbekistan">Uzbekistan
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Vanuatu')) {
                                                                echo ' selected ';
                                                            } ?> value="Vanuatu">Vanuatu
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Vatican City State (Holy See)')) {
                                                                echo ' selected ';
                                                            } ?> value="Vatican City State (Holy See)">Vatican
                                                            City State (Holy See)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Venezuela')) {
                                                                echo ' selected ';
                                                            } ?> value="Venezuela">Venezuela
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Viet Nam')) {
                                                                echo ' selected ';
                                                            } ?> value="Viet Nam">Viet Nam
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Virgin Islands (British)')) {
                                                                echo ' selected ';
                                                            } ?> value="Virgin Islands (British)">Virgin Islands
                                                            (British)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Virgin Islands (U.S.)')) {
                                                                echo ' selected ';
                                                            } ?> value="Virgin Islands (U.S.)">Virgin Islands
                                                            (U.S.)
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Wallis and Futuna Islands')) {
                                                                echo ' selected ';
                                                            } ?> value="Wallis and Futuna Islands">Wallis and
                                                            Futuna Islands
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Western Sahara')) {
                                                                echo ' selected ';
                                                            } ?> value="Western Sahara">Western Sahara
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Yemen')) {
                                                                echo ' selected ';
                                                            } ?> value="Yemen">Yemen
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Yugoslavia')) {
                                                                echo ' selected ';
                                                            } ?> value="Yugoslavia">Yugoslavia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Zaire')) {
                                                                echo ' selected ';
                                                            } ?> value="Zaire">Zaire
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Zambia')) {
                                                                echo ' selected ';
                                                            } ?> value="Zambia">Zambia
                                                        </option>
                                                        <option
                                                            <?php if (isset($recover) and ($recover->country2 == 'Zimbabwe')) {
                                                                echo ' selected ';
                                                            } ?> value="Zimbabwe">Zimbabwe
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Pin Code / Zip Code *</label>
                                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="zipcode"
                                                           required="required"
                                                           value="{{$recover->zipcode ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2" style="display: inline-block;padding-right: 0px !important;">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Country code *</label>
                                                    <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="countrycode">
                                                        <option value="">Code</option>
       
    <option value="93">Afghanistan +93</option>
    <option value="358">Aland Islands +358</option>
    <option value="355">Albania +355</option>
    <option value="213">Algeria +213</option>
    <option value="1684">American Samoa +1684</option>
    <option value="376">Andorra +376</option>
    <option value="244">Angola +244</option>
    <option value="1264">Anguilla +1264</option>
    <option value="672">Antarctica +672</option>
    <option value="1268">Antigua and Barbuda +1268</option>
    <option value="54">Argentina +54</option>
    <option value="374">Armenia +374</option>
    <option value="297">Aruba +297</option>
    <option value="61">Australia +61</option>
    <option value="43">Austria +43</option>
    <option value="994">Azerbaijan +994</option>
    <option value="1242">Bahamas +1242</option>
    <option value="973">Bahrain +973</option>
    <option value="880">Bangladesh +880</option>
    <option value="1246">Barbados +1246</option>
    <option value="375">Belarus +375</option>
    <option value="32">Belgium +32</option>
    <option value="501">Belize +501</option>
    <option value="229">Benin +229</option>
    <option value="1441">Bermuda +1441</option>
    <option value="975">Bhutan +975</option>
    <option value="591">Bolivia +591</option>
    <option value="599">Bonaire, Sint Eustatius and Saba +599</option>
    <option value="387">Bosnia and Herzegovina +387</option>
    <option value="267">Botswana +267</option>
    <option value="55">Bouvet Island +55</option>
    <option value="55">Brazil +55</option>
    <option value="246">British Indian Ocean Territory +246</option>
    <option value="673">Brunei Darussalam +673</option>
    <option value="359">Bulgaria +359</option>
    <option value="226">Burkina Faso +226</option>
    <option value="257">Burundi +257</option>
    <option value="855">Cambodia +855</option>
    <option value="237">Cameroon +237</option>
    <option value="1">Canada +1</option>
    <option value="238">Cape Verde +238</option>
    <option value="1345">Cayman Islands +1345</option>
    <option value="236">Central African Republic +236</option>
    <option value="235">Chad +235</option>
    <option value="56">Chile +56</option>
    <option value="86">China +86</option>
    <option value="61">Christmas Island +61</option>
    <option value="672">Cocos (Keeling) Islands +672</option>
    <option value="57">Colombia +57</option>
    <option value="269">Comoros +269</option>
    <option value="242">Congo +242</option>
    <option value="242">Congo, Democratic Republic of the Congo +242</option>
    <option value="682">Cook Islands +682</option>
    <option value="506">Costa Rica +506</option>
    <option value="225">Cote D'Ivoire +225</option>
    <option value="385">Croatia +385</option>
    <option value="53">Cuba +53</option>
    <option value="599">Curacao +599</option>
    <option value="357">Cyprus +357</option>
    <option value="420">Czech Republic +420</option>
    <option value="45">Denmark +45</option>
    <option value="253">Djibouti +253</option>
    <option value="1767">Dominica +1767</option>
    <option value="1809">Dominican Republic +1809</option>
    <option value="593">Ecuador +593</option>
    <option value="20">Egypt +20</option>
    <option value="503">El Salvador +503</option>
    <option value="240">Equatorial Guinea +240</option>
    <option value="291">Eritrea +291</option>
    <option value="372">Estonia +372</option>
    <option value="251">Ethiopia +251</option>
    <option value="500">Falkland Islands (Malvinas) +500</option>
    <option value="298">Faroe Islands +298</option>
    <option value="679">Fiji +679</option>
    <option value="358">Finland +358</option>
    <option value="33">France +33</option>
    <option value="594">French Guiana +594</option>
    <option value="689">French Polynesia +689</option>
    <option value="262">French Southern Territories +262</option>
    <option value="241">Gabon +241</option>
    <option value="220">Gambia +220</option>
    <option value="995">Georgia +995</option>
    <option value="49">Germany +49</option>
    <option value="233">Ghana +233</option>
    <option value="350">Gibraltar +350</option>
    <option value="30">Greece +30</option>
    <option value="299">Greenland +299</option>
    <option value="1473">Grenada +1473</option>
    <option value="590">Guadeloupe +590</option>
    <option value="1671">Guam +1671</option>
    <option value="502">Guatemala +502</option>
    <option value="44">Guernsey +44</option>
    <option value="224">Guinea +224</option>
    <option value="245">Guinea-Bissau +245</option>
    <option value="592">Guyana +592</option>
    <option value="509">Haiti +509</option>
    <option value="39">Holy See (Vatican City State) +39</option>
    <option value="504">Honduras +504</option>
    <option value="852">Hong Kong +852</option>
    <option value="36">Hungary +36</option>
    <option value="354">Iceland +354</option>
    <option value="91">India +91</option>
    <option value="62">Indonesia +62</option>
    <option value="98">Iran, Islamic Republic of +98</option>
    <option value="964">Iraq +964</option>
    <option value="353">Ireland +353</option>
    <option value="44">Isle of Man +44</option>
    <option value="972">Israel +972</option>
    <option value="39">Italy +39</option>
    <option value="1876">Jamaica +1876</option>
    <option value="81">Japan +81</option>
    <option value="44">Jersey +44</option>
    <option value="962">Jordan +962</option>
    <option value="7">Kazakhstan +7</option>
    <option value="254">Kenya +254</option>
    <option value="686">Kiribati +686</option>
    <option value="850">Korea, Democratic People's Republic of +850</option>
    <option value="82">Korea, Republic of +82</option>
    <option value="381">Kosovo +383</option>
    <option value="965">Kuwait +965</option>
    <option value="996">Kyrgyzstan +996</option>
    <option value="856">Lao People's Democratic Republic +856</option>
    <option value="371">Latvia +371</option>
    <option value="961">Lebanon +961</option>
    <option value="266">Lesotho +266</option>
    <option value="231">Liberia +231</option>
    <option value="218">Libyan Arab Jamahiriya +218</option>
    <option value="423">Liechtenstein +423</option>
    <option value="370">Lithuania +370</option>
    <option value="352">Luxembourg +352</option>
    <option value="853">Macao +853</option>
    <option value="389">Macedonia, the Former Yugoslav Republic of +389</option>
    <option value="261">Madagascar +261</option>
    <option value="265">Malawi +265</option>
    <option value="60">Malaysia +60</option>
    <option value="960">Maldives +960</option>
    <option value="223">Mali +223</option>
    <option value="356">Malta +356</option>
    <option value="692">Marshall Islands +692</option>
    <option value="596">Martinique +596</option>
    <option value="222">Mauritania +222</option>
    <option value="230">Mauritius +230</option>
    <option value="262">Mayotte +262</option>
    <option value="52">Mexico +52</option>
    <option value="691">Micronesia, Federated States of +691</option>
    <option value="373">Moldova, Republic of +373</option>
    <option value="377">Monaco +377</option>
    <option value="976">Mongolia +976</option>
    <option value="382">Montenegro +382</option>
    <option value="1664">Montserrat +1664</option>
    <option value="212">Morocco +212</option>
    <option value="258">Mozambique +258</option>
    <option value="95">Myanmar +95</option>
    <option value="264">Namibia +264</option>
    <option value="674">Nauru +674</option>
    <option value="977">Nepal +977</option>
    <option value="31">Netherlands +31</option>
    <option value="599">Netherlands Antilles +599</option>
    <option value="687">New Caledonia +687</option>
    <option value="64">New Zealand +64</option>
    <option value="505">Nicaragua +505</option>
    <option value="227">Niger +227</option>
    <option value="234">Nigeria +234</option>
    <option value="683">Niue +683</option>
    <option value="672">Norfolk Island +672</option>
    <option value="1670">Northern Mariana Islands +1670</option>
    <option value="47">Norway +47</option>
    <option value="968">Oman +968</option>
    <option value="92">Pakistan +92</option>
    <option value="680">Palau +680</option>
    <option value="970">Palestinian Territory, Occupied +970</option>
    <option value="507">Panama +507</option>
    <option value="675">Papua New Guinea +675</option>
    <option value="595">Paraguay +595</option>
    <option value="51">Peru +51</option>
    <option value="63">Philippines +63</option>
    <option value="64">Pitcairn +64</option>
    <option value="48">Poland +48</option>
    <option value="351">Portugal +351</option>
    <option value="1787">Puerto Rico +1787</option>
    <option value="974">Qatar +974</option>
    <option value="262">Reunion +262</option>
    <option value="40">Romania +40</option>
    <option value="7">Russian Federation +7</option>
    <option value="250">Rwanda +250</option>
    <option value="590">Saint Barthelemy +590</option>
    <option value="290">Saint Helena +290</option>
    <option value="1869">Saint Kitts and Nevis +1869</option>
    <option value="1758">Saint Lucia +1758</option>
    <option value="590">Saint Martin +590</option>
    <option value="508">Saint Pierre and Miquelon +508</option>
    <option value="1784">Saint Vincent and the Grenadines +1784</option>
    <option value="684">Samoa +684</option>
    <option value="378">San Marino +378</option>
    <option value="239">Sao Tome and Principe +239</option>
    <option value="966">Saudi Arabia +966</option>
    <option value="221">Senegal +221</option>
    <option value="381">Serbia +381</option>
    <option value="381">Serbia and Montenegro +381</option>
    <option value="248">Seychelles +248</option>
    <option value="232">Sierra Leone +232</option>
    <option value="65">Singapore +65</option>
    <option value="721">Sint Maarten +721</option>
    <option value="421">Slovakia +421</option>
    <option value="386">Slovenia +386</option>
    <option value="677">Solomon Islands +677</option>
    <option value="252">Somalia +252</option>
    <option value="27">South Africa +27</option>
    <option value="500">South Georgia and the South Sandwich Islands +500</option>
    <option value="211">South Sudan +211</option>
    <option value="34">Spain +34</option>
    <option value="94">Sri Lanka +94</option>
    <option value="249">Sudan +249</option>
    <option value="597">Suriname +597</option>
    <option value="47">Svalbard and Jan Mayen +47</option>
    <option value="268">Swaziland +268</option>
    <option value="46">Sweden +46</option>
    <option value="41">Switzerland +41</option>
    <option value="963">Syrian Arab Republic +963</option>
    <option value="886">Taiwan, Province of China +886</option>
    <option value="992">Tajikistan +992</option>
    <option value="255">Tanzania, United Republic of +255</option>
    <option value="66">Thailand +66</option>
    <option value="670">Timor-Leste +670</option>
    <option value="228">Togo +228</option>
    <option value="690">Tokelau +690</option>
    <option value="676">Tonga +676</option>
    <option value="1868">Trinidad and Tobago +1868</option>
    <option value="216">Tunisia +216</option>
    <option value="90">Turkey +90</option>
    <option value="7370">Turkmenistan +7370</option>
    <option value="1649">Turks and Caicos Islands +1649</option>
    <option value="688">Tuvalu +688</option>
    <option value="256">Uganda +256</option>
    <option value="380">Ukraine +380</option>
    <option value="971">United Arab Emirates +971</option>
    <option value="44">United Kingdom +44</option>
    <option value="1">United States +1</option>
    <option value="1">United States Minor Outlying Islands +1</option>
    <option value="598">Uruguay +598</option>
    <option value="998">Uzbekistan +998</option>
    <option value="678">Vanuatu +678</option>
    <option value="58">Venezuela +58</option>
    <option value="84">Viet Nam +84</option>
    <option value="1284">Virgin Islands, British +1284</option>
    <option value="1340">Virgin Islands, U.s. +1340</option>
    <option value="681">Wallis and Futuna +681</option>
    <option value="212">Western Sahara +212</option>
    <option value="967">Yemen +967</option>
    <option value="260">Zambia +260</option>
    <option value="263">Zimbabwe +263</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-10" style="display: inline-block; padding-left: 0px !important;">
                                                <div class="mb-6">
                                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel *</label>
                                                    <input required type="number" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="tel"
                                                           required="required"
                                                           value="{{$recover->tel ?? '' }}">
                                                </div>
                                            </div>
                                            
<style>
.file-error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}
</style>

<div class="col-12">
    <div class="mb-6">
        <label class="block text-sm font-semibold text-on-surface-variant mb-2">
            Upload Clear Passport Size Photograph
            <small class="text-outline">(PNG, JPG, JPEG | Max 2MB)</small>
        </label>

        <input type="file"
               class="form-control file-validate"
               name="passportPhoto"
               accept="image/png,image/jpeg,image/jpg">

        <div class="file-error"></div>
    </div>
</div>

<div class="col-12">
    <div class="mb-6">
        <label class="block text-sm font-semibold text-on-surface-variant mb-2">
            Upload a valid Government issued Identification
            <small class="text-outline">(PNG, JPG, JPEG | Max 2MB)</small>
        </label>

        <input type="file"
               class="form-control file-validate"
               name="passportId"
               accept="image/png,image/jpeg,image/jpg">

        <div class="file-error"></div>
    </div>
</div>


                                        </div>
                                    </div>

                                    <button type="submit" name="submit"
                                            class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"
                                            value="Submit">Submit
                                    </button>
                                    <!--<button type="submit" name="submit"-->
                                    <!--        class="btn btn-dark previous action-button-previous float-right mr-3"-->
                                    <!--        value="Save">Save & exit-->
                                    <!--</button>-->
                                    <a href="<?= asset(''); ?>" class="bg-error hover:bg-error/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2" style="margin-left:10px;">Cancel Registration Process</a>
                                </fieldset>
                                <!--  permanent address 4 -->
                                
                               
                            <!--  submit-->
                               

                        </div>
                        </form>


                    </div>
                </div>

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

<script type="text/javascript">
    jQuery("#load").fadeOut();
    jQuery("#loading").delay().fadeOut("");
</script>


<div class="modal " id="resumeotp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-card text-left">
                    <form id="form-wizard2" class="text-center mt-6 bggray-cus" method="POST"
                          action="online-open-account" enctype="multipart/form-data">@csrf
                        <div class="flex flex-wrap -mx-3">
                            <div class="col-12">
                                <h4 class="text-center">Resume Registration</h4>
                                <p class="text-center">Enter the Registration Number from the previous process you
                                    started to resume that</p>

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="w-full md:w-1/2 px-3">
                                <div class="mb-6">
                                    <!-- <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name: *</label> -->
                                    <input required type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="continueregister"
                                           value="{{$recover->continueregister ?? '' }}"
                                           placeholder="Enter registration no.">
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" value="Recover" class="btn btn-success mt-2">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
    const maxSize = 2 * 1024 * 1024; // ✅ 2MB

    document.querySelectorAll('.file-validate').forEach(input => {

        const errorBox = input.closest('.form-group').querySelector('.file-error');

        input.addEventListener('change', function () {

            errorBox.textContent = '';

            const file = this.files[0];
            if (!file) return;

            // ❌ File type validation
            if (!allowedTypes.includes(file.type)) {
                errorBox.textContent = 'Only PNG, JPG, JPEG files are allowed.';
                this.value = '';
                return;
            }

            // ❌ File size validation
            if (file.size > maxSize) {
                errorBox.textContent = 'Maximum file size allowed is 2MB.';
                this.value = '';
                return;
            }

        });

    });

});
</script>

