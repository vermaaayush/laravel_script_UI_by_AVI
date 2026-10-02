@include('header4')


        <!-- partial -->

        <div class="container-fluid page-body-wrapper">



            <!-- partial:partials/_sidebar.html -->



            <!-- partial -->

            <div class="main-panel" style="width: calc(100%);">



                <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">

                            <span class="page-title-icon bg-gradient-primary text-white mr-2">

                                <i class="mdi mdi-home"></i>

                            </span> System Config </h3>

                        <nav aria-label="breadcrumb">

                            <ul class="breadcrumb">

                                <li class="breadcrumb-item active" aria-current="page">

                                    <span></span>System Config Overview <i

                                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>

                                </li>

                            </ul>

                        </nav>

                    </div>

                    <div class="col-lg-12 stretch-card">

                        <!-- Tabs with icons on Card -->

                        <div class="card card-nav-tabs" style="flex-direction: row; min-height: 50rem;">

                            <div class="card-header card-header-primary"

                                style="margin-left: 0px; margin-right: 0px; padding-top: 69px;">

                                <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->

                                <div class="nav-tabs-navigation" style="font-size: 9rem;">

                                    <div class="nav-tabs-wrapper">

                                        <ul class="nav nav-tabs justify-content-center text-right"

                                            style="width: 20vw; border-bottom: 0px solid #ebedf2;" data-tabs="tabs">

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link active" href="#general-settings" data-toggle="tab">

                                                    General Settings

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#change-password" data-toggle="tab">

                                                    Change Password

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#api-settings" data-toggle="tab">

                                                    API Settings

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#master-switch" data-toggle="tab">

                                                    Master Switch

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#modules" data-toggle="tab">

                                                    enable / disable modules

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#message-modules" data-toggle="tab">

                                                    Message Modules

                                                </a>

                                            </li>

                                            <!-- <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#connection" data-toggle="tab">

                                                    Database connection

                                                </a>

                                            </li> -->

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#color-theme" data-toggle="tab">

                                                    Client Side Color Theme

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#language" data-toggle="tab">

                                                    Client Side Language

                                                </a>

                                            </li>
                                             <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#IVR_message" data-toggle="tab">

                                                    IVR Messages 

                                                </a>

                                            </li>
                                             <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#IVR_language" data-toggle="tab">

                                                    IVR  Language

                                                </a>

                                            </li>

                                            <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#reset-script" data-toggle="tab">

                                                    Reset Script

                                                </a>

                                            </li>

                                            <!-- <li class="nav-item custom-nav-item">

                                                <a class="nav-link" href="#update" data-toggle="tab">

                                                    Script Update Manager

                                                </a>

                                            </li> -->

                                        </ul>



                                    </div>

                                </div>

                            </div>



                            <div class="col-md-8 grid-margin">

                                <div class="card-body" style=" padding-right: 0px; padding-top: 90px;">



                                    <div class="tab-content">

                                        <div class="tab-pane active" id="general-settings">

                                            @include('flash::message')

                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Client

                                                    Side General Settings</label>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Name</label>

                                                    <input type="text" class="form-control" name="bank_name" id="bank_name" required value="{{ $config[0]->bank_name }}" placeholder="Bank Name" />

                                                </div>
                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank URL</label>

                                                    <input type="text" class="form-control" name="bank_url" id="bank_name" required value="{{ $config[0]->bank_url }}" placeholder="Bank Url" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Address</label>

                                                    <input type="text" class="form-control" name="bank_address" id="bank_address" required value="{{ $config[0]->bank_address }}" placeholder="Bank Address" />

                                                </div>



                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Telephone Number</label>

                                                    <input type="text" class="form-control" name="bank_phone" id="bank_phone" required value="{{ $config[0]->bank_phone }}" placeholder="Bank Telephone Number" />

                                                </div>
                                                 <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Fax</label>

                                                    <input type="text" class="form-control" name="bank_fax" id="bank_phone" required value="{{ $config[0]->bank_fax }}" placeholder="Bank Fax" />

                                                </div>
                                                 <div class="form-group">

                                                    <label for="exampleInputPassword1">Admin Support Phone</label>

                                                    <input type="text" class="form-control" 
                                                    name="admin_support_phone" id="bank_phone" required value="{{ $config[0]->admin_support_phone}}" placeholder="Bank Telephone Number" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Email</label>

                                                    <input type="email" class="form-control" name="bank_email" id="bank_email" required value="{{ $config[0]->bank_email }}" placeholder="Bank Email" />

                                                </div>
                                                
                                                 <div class="form-group">

                                                    <label for="exampleInputPassword1">Bank Support Person</label>

                                                    <input type="text" class="form-control" name="bank_support_person" id="bank_email" required value="{{ $config[0]->bank_support_person }}" placeholder="Bank Support person" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Time Zone</label>

                                                    <select class="form-control" name="timezone" id="timezone" required>
                                                        <option value="">Select Timezone</option>
                                                        @foreach($timezones as $timezone)
                                                        <option value="{{ $timezone->place }}" @if($timezone->place == $config[0]->timezone) selected @endif>{{ $timezone->timezone }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                        <div class="form-group">

                                                    <label for="time">Set logout time</label>

                                                    <input type="text" class="form-control" name="logout_time" id="logout_time" 
                                                     onkeypress="return AllowOnlyNumbers(event);" required value="{{ $config[0]->logout_time }}" placeholder="Set logout time" />

                                                </div>
                                                <div class="form-group">

                                                    <label>Logo PNG File</label>

                                                    <input type="file" name="logo" id="logo" value="" class="file-upload-default" />

                                                    <div class="input-group col-xs-12">

                                                        <input type="text" class="form-control file-upload-info"

                                                            disabled placeholder="Upload Logo PNG">

                                                        <span class="input-group-append">

                                                            <button class="file-upload-browse btn btn-gradient-primary"

                                                                style="height: 45px; top: -5px;"

                                                                type="button">Upload</button>

                                                        </span>

                                                    </div>

                                                    <strong>Current Logo:</strong>

                                                    <img src="{{ asset('uploads/' . $config[0]->logo) }}" class="card-img" alt="Logo" style="width: 100px;" />

                                                </div>
                                            
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="change-password">



                                            <form class="forms-sample" method="POST" action="{{ asset('update-password') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Change

                                                    Admin login Password</label>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Current Password</label>

                                                    <input type="password" class="form-control" name="pass" id="pass" required value="" placeholder="Current Password" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">New Password</label>

                                                    <input type="password" class="form-control" name="new_pass" id="new_pass" required value="" placeholder="New Password" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Confirm Password</label>

                                                    <input type="password" class="form-control" name="confirm_pass" id="confirm_pass" required value="" placeholder="Confirm Password" />

                                                </div>

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="api-settings">



                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">SMS API

                                                    Settings</label>


                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Token</label>

                                                    <input type="text" class="form-control" name="sms_token" id="sms_token" required value="{{ $config[0]->sms_token }}" placeholder="Token" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">SID </label>

                                                    <input type="text" class="form-control" name="sms_sid" id="sms_sid" required value="{{ $config[0]->sms_sid }}" placeholder="SID" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Phone Number </label>

                                                    <input type="text" class="form-control" name="sms_phone" id="sms_phone" required value="{{ $config[0]->sms_phone }}" placeholder="Phone Number" />

                                                </div>



                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Email

                                                    API

                                                    Settings</label>



                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Token</label>

                                                    <input type="text" class="form-control" name="email_token" id="email_token" required value="{{ $config[0]->email_token }}" placeholder="Token" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">SID </label>

                                                    <input type="text" class="form-control" name="email_sid" id="email_sid" required value="{{ $config[0]->email_sid }}" placeholder="SID" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Phone Number </label>

                                                    <input type="text" class="form-control" name="email_phone" id="email_phone" required value="{{ $config[0]->email_phone }}" placeholder="Phone Number" />

                                                </div>

                                                    <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Twilio Call API Details

                                                    </label>



                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">Token</label>

                                                    <input type="text" class="form-control" name="twilio_token" id="twilio_token" required value="{{ $config[0]->twilio_token }}" placeholder="Token" />

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleInputPassword1">SID </label>

                                                    <input type="text" class="form-control" name="twilio_sid" id="twilio_sid" required value="{{ $config[0]->twilio_sid }}" placeholder="SID" />

                                                </div>
                                         <div class="form-group">

                                        <label for="exampleInputPassword1">IVR Url (Note:https://example/anyfolder/admin)</label>

                                                    <input type="text" class="form-control" name="ivr_url" id="ivr_url" required value="{{ $config[0]->ivr_url }}" placeholder="ivr url" />

                                                </div>

                                            {{--     <div class="form-group">

                                                    <label for="exampleInputPassword1">Phone Number </label>

                                                    <input type="text" class="form-control" name="twilio_phone" id="twilio_phone" required value="{{ $config[0]->twilio_phone }}" placeholder="Phone Number" />

                                                </div> --}}

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>

                                        </div>



                                        <div class="tab-pane" id="master-switch">



                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="type" value="1" />

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Client

                                                    Master Switch </label>



                                                <div class="togglebutton" style="padding-bottom: 6rem;">

                                                    <label>

                                                        <input type="checkbox" name="client_side" id="client_side" value="1" @if($config[0]->client_side == 1) checked @endif />

                                                        <span class="toggle"></span>

                                                        Client Side

                                                    </label>

                                                </div>



                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="modules">


                                            <?php $_modules = DB::table('ba_enable_disable_module')->where('id','1')->first(); ?>
                                            <form class="forms-sample" method="POST" action="{{ asset('update-module-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Enable

                                                    / Disable Client Side Modules </label>



                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="transfer" id="" value="1" @if($_modules->transfer == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Transfer Module
                                                    </label>
                                                </div>

                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="cheque" id="" value="1" @if($_modules->cheque == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Cheques Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="cards" id="" value="1" @if($_modules->cards == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Cards Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="loans" id="" value="1" @if($_modules->loans == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Loans Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="payment_collection" id="" value="1" @if($_modules->payment_collection == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Payments & Collection Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="account_limit" id="" value="1" @if($_modules->account_limit == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Account Limit Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="withdraw" id="" value="1" @if($_modules->withdraw == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Withdrawals Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="feedback" id="" value="1" @if($_modules->feedback == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Feedback Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="system_config" id="" value="1" @if($_modules->system_config == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        System Config Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="transaction" id="" value="1" @if($_modules->transaction == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Transaction Module
                                                    </label>
                                                </div>
                                                
                                                <div class="togglebutton" style="padding-bottom: 4rem;">
                                                    <label>
                                                        <input type="checkbox" name="deposit" id="" value="1" @if($_modules->deposit == 1) checked @endif />
                                                        <span class="toggle"></span>
                                                        Deposit Module
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="message-modules">



                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="type" value="3" />

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Enable

                                                    / Disable Client Side Message Modules </label>



                                                <div class="togglebutton" style="padding-bottom: 6rem;">

                                                    <label>

                                                        <input type="checkbox" name="email_action" id="email_action" value="1" @if($config[0]->email_action == 1) checked @endif />

                                                        <span class="toggle"></span>

                                                        Enable / Disable Email Actions on Client Side

                                                    </label>

                                                </div>

                                                <div class="togglebutton" style="padding-bottom: 6rem;">

                                                    <label>

                                                        <input type="checkbox" name="sms_action" id="sms_action" value="1" @if($config[0]->sms_action == 1) checked @endif />

                                                        <span class="toggle"></span>

                                                        Enable / Disable SMS Actions on Client Side

                                                    </label>

                                                </div>

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="color-theme">



                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Client

                                                    / Admin

                                                    Side Color Theme</label>



                                                <div class="form-group">

                                                    <label for="exampleSelectGender">Select Client Side Color

                                                        Theme</label>

                                                    <select class="form-control" name="client_side_color" id="client_side_color" required>

                                                        <option value="">Select Color</option>

                                                        <option value="Purple" @if($config[0]->client_side_color == 'Purple') selected @endif>Puple</option>

                                                        <option value="Gray" @if($config[0]->client_side_color == 'Gray') selected @endif>Gray</option>

                                                        <option value="Red" @if($config[0]->client_side_color == 'Red') selected @endif>Red</option>

                                                        <option value="Green" @if($config[0]->client_side_color == 'Green') selected @endif>Green</option>

                                                        <option value="Black" @if($config[0]->client_side_color == 'Black') selected @endif>Black</option>

                                                        <option value="Yellow" @if($config[0]->client_side_color == 'Yellow') selected @endif>Yellow</option>

                                                        <option value="Brown" @if($config[0]->client_side_color == 'Brown') selected @endif>Brown</option>

                                                        <option value="Blue" @if($config[0]->client_side_color == 'Blue') selected @endif>Blue</option>

                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label for="exampleSelectGender">Select Admin Side Color

                                                        Theme</label>

                                                    <select class="form-control" name="admin_side_color" id="admin_side_color" required>

                                                        <option value="">Select Color</option>

                                                        <option value="Purple" @if($config[0]->admin_side_color == 'Purple') selected @endif>Puple</option>

                                                        <option value="Gray" @if($config[0]->admin_side_color == 'Gray') selected @endif>Gray</option>

                                                        <option value="Red" @if($config[0]->admin_side_color == 'Red') selected @endif>Red</option>

                                                        <option value="Green" @if($config[0]->admin_side_color == 'Green') selected @endif>Green</option>

                                                        <option value="Black" @if($config[0]->admin_side_color == 'Black') selected @endif>Black</option>

                                                        <option value="Yellow" @if($config[0]->admin_side_color == 'Yellow') selected @endif>Yellow</option>

                                                        <option value="Brown" @if($config[0]->admin_side_color == 'Brown') selected @endif>Brown</option>

                                                        <option value="Blue" @if($config[0]->admin_side_color == 'Blue') selected @endif>Blue</option>

                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                        Settings</button>

                                                    <a href="{{ asset('dashboard') }}"><button type="button" class="btn btn-light">Cancel</button></a>

                                                </div>

                                            </form>



                                        </div>

                                        <div class="tab-pane" id="language">

                                            <form class="forms-sample" method="POST" action="{{ asset('update-config') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Client

                                                    Side Language Settings</label>

                                                <div class="form-group">

                                                    <label for="exampleSelectGender">Select Language</label>

                                                    <select class="form-control" name="client_side_lang" id="client_side_lang" required>

                                                        <option value="">Select Languages</option>

                                                        <option value="ENGLISH" @if($config[0]->client_side_lang == 'ENGLISH') selected @endif>ENGLISH</option>

                                                        <option value="SPANISH" @if($config[0]->client_side_lang == 'SPANISH') selected @endif>SPANISH</option>

                                                        <option value="PORTUGUESE" @if($config[0]->client_side_lang == 'PORTUGUESE') selected @endif>PORTUGUESE</option>

                                                        <option value="JAPANESE" @if($config[0]->client_side_lang == 'JAPANESE') selected @endif>JAPANESE</option>

                                                        <option value="GERMAN" @if($config[0]->client_side_lang == 'GERMAN') selected @endif>GERMAN</option>

                                                        <option value="FRENCH" @if($config[0]->client_side_lang == 'FRENCH') selected @endif>FRENCH</option>

                                                        <option value="ARABIC" @if($config[0]->client_side_lang == 'ARABIC') selected @endif>ARABIC</option>

                                                    </select>

                                                </div>

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                        Settings</button>

                                                    <a href="{{ asset('dashboard') }}"><button type="button" class="btn btn-light">Cancel</button></a>

                                            </form>

                                        </div>

                                          <div class="tab-pane" id="IVR_message">

                                            <form class="forms-sample" method="POST" action="{{ asset('ivr-message') }}">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                               <input type = "hidden" name = "id" value = "{{$ivr_message[0]->id}}">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">IVR

                                                     Message Management </label>


                                               <div class="row">
                                                   <div class="col-md-6">
                                                       <div class="form-group">

                                            <label for="Support Phone">Transfer Message 1 </label>

                                            <input type="text" class="form-control" name="transfer_message_1" id="transfer_message_1 " required
                                             value="{{$ivr_message[0]->transfer_message_1}}"
                                             placeholder=" " />

                                            </div>
                                            <div class="form-group">

                                                <label for="Support Phone">Transfer Message 2</label>

                                                <input type="text" class="form-control" name="transfer_message_2" id="transfer_message_2" required 
                                                value="{{$ivr_message[0]->transfer_message_2}}"
                                                 placeholder=" " />
                                           </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                        <div class="form-group col-md-4">

                                            <label for="Support Phone">Allow Message 1</label>

                                           <input type="checkbox" value="{{$ivr_message[0]->allow_transfer_message_1}}" 
                                           {{ $ivr_message[0]->allow_transfer_message_1=='1' ? 'checked' : '' }}
                                           class="form-control" 
                                           name="allow_transfer_message_1" >

                                            </div>
                                            <div class="form-group col-md-4">

                                            <label for="Support Phone">Allow Message 2</label>

                                           <input type="checkbox" value="{{$ivr_message[0]->allow_transfer_message_2}}" 
                                            {{ $ivr_message[0]->allow_transfer_message_2=='1' ? 'checked' : '' }} 
                                           class="form-control" name="allow_transfer_message_2" >

                                            </div>
                                                   </div>
                                               </div>

                                                 <div class="row">
                                                   <div class="col-md-6">
                                                      
                                             <div class="form-group">

                                            <label for="Support Phone">Transfer Message 3 </label>

                                            <input type="text" class="form-control" name="transfer_message_3" id="transfer_message_3" 
                                              required value="{{$ivr_message[0]->transfer_message_3}}"

                                             placeholder="" />

                                            </div>
                                            <div class="form-group col-md-4">

                                            <label for="Support Phone"> Allow Deduction</label>

                                           <input type="checkbox"  class="form-control" name=" allow_deduction" >

                                            </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                       
                                                     <div class="form-group col-md-4">

                                            <label for="Support Phone">Allow Message 3</label>

                                           <input type="checkbox" value="{{$ivr_message[0]->allow_transfer_message_3}}" 
                                           {{ $ivr_message[0]->allow_transfer_message_3=='1' ? 'checked' : '' }} 
                                           class="form-control" name="allow_transfer_message_3" >

                                            </div>
                                                   </div>
                                               </div>

                                               
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    </button>

                                                <a href="{{ asset('dashboard') }}"><button class="btn btn-light" type="button">Cancel</button></a>

                                            </form>

                                        </div>

                                        <div class="tab-pane" id="IVR_language">

                                            <form class="forms-sample" method="POST" action="{{ asset('update-lang') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">IVR

                                                     Language Settings</label>
                                                     @php 

                                                          $ivr_lang = explode(',',$config[0]->ivr_lang);  


                                                      @endphp

                                                <div class="form-group">

                                                    <label for="exampleSelectGender">Select Language</label>

                                                    <select class="form-control" name="ivr_lang[]" 
                                                        multiple id="ivr_lang"  required>

                                                        <option value="">Select Languages</option>

                                                        <option value="ENGLISH" {{ ((in_array('ENGLISH', $ivr_lang)?"selected=selected":"")) }}>ENGLISH</option>

                                                        <option value="SPANISH"{{ ((in_array('SPANISH', $ivr_lang)?"selected=selected":"")) }}>SPANISH</option>

                                                        <option value="PORTUGUESE" {{ ((in_array('PORTUGUESE', $ivr_lang)?"selected=selected":"")) }}>PORTUGUESE</option>

                                                        <option value="JAPANESE" {{ ((in_array('JAPANESE', $ivr_lang)?"selected=selected":"")) }}>JAPANESE</option>

                                                        <option value="GERMAN" {{ ((in_array('GERMAN', $ivr_lang)?"selected=selected":"")) }}>GERMAN</option>

                                                        <option value="FRENCH" {{ ((in_array('FRENCH', $ivr_lang)?"selected=selected":"")) }} >FRENCH</option>

                                                        <option value="ARABIC" {{ ((in_array('ARABIC', $ivr_lang)?"selected=selected":"")) }}>ARABIC</option>


                                                    </select>
                                                    

                                                </div>

                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                        Settings</button>

                                                    <a href="{{ asset('dashboard') }}"><button type="button" class="btn btn-light">Cancel</button></a>

                                            </form>
                                        

                                        </div>



                                        <div class="tab-pane" id="reset-script">



                                            <form class="forms-sample">

                                                <label for="exampleInputPassword1" class=" text-center"

                                                    style="width: 100%; font-size: large; padding-bottom: 2rem;">Reset

                                                    all Functions to Default</label>

                                                <!-- Classic Modal Button -->

                                                <button type="button" class="btn btn-block btn-danger" data-toggle="modal"

                                                    data-target="#myResetModal" style="font-size: larger; height: 100px;">

                                                    <i class="mdi mdi-reload" style="font-size: larger;"></i>

                                                    RESET TO ALL DEFAULT SETTINGS

                                                    <div class="ripple-container"></div>

                                                </button>

                                                <!--End Classic Modal Button -->

                                            </form>



                                        </div>



                                        <div class="tab-pane" id="update">



                                            <form class="forms-sample">



                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update

                                                    Settings</button>

                                                <button class="btn btn-light">Cancel</button>

                                            </form>



                                        </div>



                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- End Tabs-->

                    </div>

                </div>

                <!-- content-wrapper ends -->

                <div class="modal fade" id="myResetModal" tabindex="-1" role="dialog">

                    <div class="modal-dialog modal-dialog-centered" role="document">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">Warning</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    <i class="material-icons">Close</i>

                                </button>

                            </div>

                            <div class="modal-body">

                                <p>Are you sure you want to reset to default?</p>

                            </div>

                            <div class="modal-footer">

                                <a href="{{ asset('reset-default') }}"><button type="button" class="btn btn-link">Yes</button></a>

                                <button type="button" class="btn btn-danger btn-link"

                                    data-dismiss="modal">Close</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- partial:partials/_footer.html -->

                @include('footer')

                <!-- partial -->

            </div>

            <!-- main-panel ends -->

        </div>



        <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->



























    <!-- plugins:js -->

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script>
        function AllowOnlyNumbers(e) {

            e = (e) ? e : window.event;
            var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
            var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
            var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);
            
            return (/^\d+$/.test(str));
            }
    </script>

    <!-- endinject -->

    <!-- Plugin js for this page -->



    <!-- End plugin js for this page -->

    <!-- inject:js -->

    <script src="{{ asset('js/off-canvas.js') }}"></script>

    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>

    <script src="{{ asset('js/misc.js') }}"></script>

    <!-- endinject -->

    <!-- Custom js for this page -->

    <script src="{{ asset('config-assets/material-kit.min.js') }}"></script>

    <script src="{{ asset('js/file-upload.js') }}"></script>

    <script src="{{ asset('config-assets/popper.min.js') }}"></script>

    <script src="{{ asset('config-assets/bootstrap-material-design.min.js') }}"></script>

    <script src="{{ asset('config-assets/jquery.min.js') }}"></script>

    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  

</body>



</html>