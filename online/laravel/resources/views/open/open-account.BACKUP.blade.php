<!doctype html>
<html lang="en">
<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{$bankName}}</title>
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
.input-group-text{font-size: 20px;}
body{background: #e7ecee;}
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
        <section class="sign-in-page py-5">
            <div class="container p-0 ">
                <div class="row no-gutters height-self-center">

                  <div class="col-sm-12 align-self-center bg-[#b34020] rounded mb-5">
                    <div class="row m-0 ">
                     <div class="col-12 py-3">
                        <a href="{{ $bankBase ?? '' }}"><img src="/admin/uploads/{{ $logo }}" style="max-width:150px;"></a>
                     </div>
                      <div class="col-md-12 bg-white sign-in-page-data iq-card pb-0 mb-0">
                          <div class="sign-in-from">
                           <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                              <h3 class="mb-0 text-left">
                                  New Account Registration</h3>
                               @include('flash::message')
                           </div>
                              
                               <div class="flex flex-wrap -mx-3">
                               <div class="col-12 text-dark">
                               <form id="form-wizard1" class="text-center mt-6 bggray-cus" method="POST" action="online-open-account">@csrf
<!-- fieldsets 1 -->
                                   <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Terms and conditions:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp1<!-- - {{$totalForm ?? '' }}--></h4>
                                       </div>
                                       <div class="col-12">
                                          <!-- <iframe src="pdf/step1.pdf?#view=fitH" width="100%" height="500px"></iframe> -->

<textarea class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" style="height: 500px;line-height:20px;margin-bottom: 35px;" readonly="readonly">
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

For ascertaining Minor’s date of birth, acceptable documents which can be submitted-
* Birth certificate issued by Municipal Authority.
* Passport held in the name of the minor.
*10th Class certificate indicating DOB, issued by the Central Board (C.B.S.E., I.C.S.E.) / State Board.

Note: 1. Bank may request for any further specific / additional documents as may be required.
</textarea>
                                       </div>
                                    </div>
                                 </div>
                                
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                  <button type="button"  data-toggle="modal" data-target="#resumeotp" class="btn btn-success mr-3 float-right" >Resume Registration</button>
                               </fieldset>
<!-- fieldsets 2 -->
                                   <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Do not leave any field blank, instead mention Not applicable (N.A.)</h5>
                                       </div>
                                       <div class="col-5">
                                          <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp2<!-- - {{$totalForm ?? '' }}--></h4>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                       <!-- <p class="text-left text-error col-md-12">Do not leave any field blank, instead mention Not applicable (N.A.)</p> -->
                                       <div class="clearfix"></div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">I/We hereby request {{$bankName}}, Ltd.  to open my/our Savings Account. in Branch</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="branch">
                                                <option>--select--</option>
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
                                                 <!--<?php if(isset($recover) and ($recover->branch == '45') ){ echo ' selected '; } ?>-->
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency In</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="currency">
                                                <option>--select--</option>
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
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Type Of Account</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="type">
                                                <option>--select--</option>
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
                                    </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
<!-- Details of Account 3 -->
                                   <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Details of Account - Sole / First Applicant:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h4 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp3<!-- - {{$totalForm ?? '' }}--></h4>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Title</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="title">
                                                <option>--select--</option>
                                                <option <?php if(isset($recover) and ($recover->title == "Mr.") ){ echo " selected "; } ?>>Mr.</option>
                                                <option <?php if(isset($recover) and ($recover->title == "Mrs.") ){ echo " selected "; } ?>>Mrs.</option>
                                                <option <?php if(isset($recover) and ($recover->title == "Ms.") ){ echo " selected "; } ?>>Ms.</option>
                                                <option <?php if(isset($recover) and ($recover->title == "Others") ){ echo " selected "; } ?>>Others</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="name" value="{{$recover->name ?? ''}}">
                                          </div>
                                       </div>
                                         <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Other common names used /former name if any</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="alias" value="{{$recover->alias ?? ''}}">
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Reason for using other name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="aliasreason">
                                           <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="aliasreason" value="{{$recover->aliasreason ?? '' }}">

                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Birth</label>
                                             <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="birth">
                                          </div>
                                       </div>
                                        <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Gender</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="gender">
                                                <option>--select--</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Third Gender</option>
                                             </select>
                                          </div>
                                       </div>
                                       
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                             <select name="country" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                <option selected="selected" value="">Please Select</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania ">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina ">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="France (Metropolitan)">France (Metropolitan)</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern Territories</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea (Democratic People's Republic of)">Korea (Democratic People's Republic of)</option>
                                                <option value="Korea (Republic of)">Korea (Republic of)</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia (The Former Yugoslav Republic of)</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia (Federated States of)">Micronesia (Federated States of)</option>
                                                <option value="Moldova (Republic of)">Moldova (Republic of)</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Sebia">Sebia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia (Slovak Republic)">Slovakia (Slovak Republic)</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia &amp; South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="St. Helena">St. Helena</option>
                                                <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                <option value="Taiwan (Province of China)">Taiwan (Province of China)</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania (United Republic of)">Tanzania (United Republic of)</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                                                <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Yugoslavia">Yugoslavia</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                              </select>
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">PAN Number</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="pan">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Minor Account</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="minor">
                                                <option>--select--</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Senoir Citizen</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="senior">
                                                <option>--select--</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Name of Parent / Guardian</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="guardian">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Relationship with minor</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="relwithminor">
                                          </div>
                                       </div>
                                  </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
<!--  permanent address 4 -->
@if($enableForms->form_4 == 1)
<fieldset>
                                    <div class="form-card text-left">
                                       <div class="flex flex-wrap -mx-3">
                                          <div class="col-7">
                                             <h5 class="mb-6">Communication Details:</h5>
                                          </div>
                                          <div class="col-5">
                                             <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp4<!-- - {{$totalForm ?? '' }}--></h2>
                                          </div>
                                       </div>
                                       <div class="flex flex-wrap -mx-3">
                                       <h5 class="col-12 my-3 border-bottom-1 pb-2"></h5>
                                       <div class="col-12">
                                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Permanent /Residential Address:</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="address">
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">City</label>
                                              <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="city">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Pin Code / Zip Code</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="zipcode">
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                             <select name="country2" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                <option selected="selected" value="">Please Select</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania ">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina ">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="France (Metropolitan)">France (Metropolitan)</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern Territories</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea (Democratic People's Republic of)">Korea (Democratic People's Republic of)</option>
                                                <option value="Korea (Republic of)">Korea (Republic of)</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia (The Former Yugoslav Republic of)</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia (Federated States of)">Micronesia (Federated States of)</option>
                                                <option value="Moldova (Republic of)">Moldova (Republic of)</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Sebia">Sebia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia (Slovak Republic)">Slovakia (Slovak Republic)</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia &amp; South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="St. Helena">St. Helena</option>
                                                <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                <option value="Taiwan (Province of China)">Taiwan (Province of China)</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania (United Republic of)">Tanzania (United Republic of)</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                                                <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Yugoslavia">Yugoslavia</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                              </select>
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel: Residence(With STD Code)</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="tel">
                                          </div>
                                       </div>

<!-- // end permanent address -->
<!--   Correspondence address -->
                              
                                        <div class="col-12">
                                          <div class="mb-6">
                                           <label class="block text-sm font-semibold text-on-surface-variant mb-2">Correspondence / Mailing Address</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="mailaddress">
                                          </div>
                                       </div>
                                       <div class="col-12   ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">City</label>
                                              <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="mailcity">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Pin Code / Zip Code</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="mailzipcode">
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                             <select name="country3" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                <option selected="selected" value="">Please Select</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania ">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina ">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="France (Metropolitan)">France (Metropolitan)</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern Territories</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea (Democratic People's Republic of)">Korea (Democratic People's Republic of)</option>
                                                <option value="Korea (Republic of)">Korea (Republic of)</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia (The Former Yugoslav Republic of)</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia (Federated States of)">Micronesia (Federated States of)</option>
                                                <option value="Moldova (Republic of)">Moldova (Republic of)</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Sebia">Sebia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia (Slovak Republic)">Slovakia (Slovak Republic)</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia &amp; South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="St. Helena">St. Helena</option>
                                                <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                <option value="Taiwan (Province of China)">Taiwan (Province of China)</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania (United Republic of)">Tanzania (United Republic of)</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                                                <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Yugoslavia">Yugoslavia</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                              </select>
                                          </div>
                                       </div>


                                     </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
<!--  contact Detail 5 -->
@if($enableForms->form_5 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Contact Detail</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp5<!-- - {{$totalForm ?? '' }}--></h2>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <h5 class="col-12 my-3 border-bottom-1 pb-2"></h5>
                                       <div class="col-12   ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                              <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="mobile">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel : Residence(with STD code)</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="telresidence">
                                          </div>
                                       </div>
                                      
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel: Office(With STD Code)</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="teloffice">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax: With STD Code</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fax">
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="email">
                                          </div>
                                       </div>

                                  </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
<!--  Personal Detail 6 -->     
@if($enableForms->form_6 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Personal Details</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp6<!-- - {{$totalForm ?? '' }}--></h2>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <h5 class="col-12  my-3 border-bottom-1 pb-2"></h5>

                                       <div class="col-12   ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Educational Qualification</label>
                                              <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="education">
                                                <option>--select--</option>
                                                <option>Undergraduate</option>
                                                <option>Graduate</option>
                                                <option>Postgraduate</option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-12   ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Marital Status</label>
                                              <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="marital">
                                                <option>--select--</option>
                                                <option>Unmarried</option>
                                                <option>Married</option>
                                                <option>Postgraduate</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Number of Dependents</label>
                                        </div>
                                       <div class="col-12   ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Adults</label>
                                              <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="dependants">
                                          </div>
                                       </div>

                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Children</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="children">
                                          </div>
                                       </div>
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Annual Income</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="annualincome">
                                          </div>
                                       </div>
                               </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif                               
<!--  Ocupation Detail 7 n 8 -->
@if($enableForms->form_7 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Occupation Details:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp7<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <h5 class="col-12  my-3 border-bottom-1 pb-2"> </h5>

                                       <div class="col-sm-12 col-md-12  ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Occupation Type</label>
                                              <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="occupation">
                                                <option>--select--</option>
                                                <option>Salaried</option>
                                                <option>Self-employed</option>
                                                <option>Business</option>
                                                <option>Retired</option>
                                                <option>Housewife</option>
                                                <option>Student</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-12  ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Salaried (Please provide Employer details, Designation, Job Profile and Nature of Work)</label>
                                              <textarea cols="3" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="employer"></textarea>
                                          </div>
                                       </div>

                                      <div class="col-12  ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Self-employed</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="selfemployed">
                                                <option>--select--</option>
                                                <option>Chartered Accountant / CPA</option>
                                                <option>Doctor</option>
                                                <option>Engineer</option>
                                                <option>Lawyer / Notary</option>
                                                <option>Consultant / Professional</option>
                                                <option>Other</option>
                                             </select>
                                             <br/>
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Please mention briefly nature of professional work undertaken</label>
                                              <textarea cols="3" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="work"></textarea>
                                          </div>
                                      </div>

                                       <div class="col-12  ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Business</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="sector">
                                                <option>--select--</option>
                                                <option>Manufacturing</option>
                                                <option>Retailer / Stockist</option>
                                                <option>Finance / Investment</option>
                                                <option>Wholesaler</option>
                                                <option>Export / Import</option>
                                                <option>Commission Agent / Broker</option>
                                                <option>Service Provider</option>
                                                <option>Lottery</option>
                                                <option>Trading</option>
                                                <option>Arms and Ammunition</option>
                                                <option>Antique Dealer</option>
                                                <option>Dealer in precious metals / stones</option>
                                                <option>Bar / Night Club / Casino</option>
                                                <option>Money exchanger</option>
                                                <option>Real Estate Agent</option>
                                                <option>Other</option>
                                             </select>
                                             <br/>
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Please mention briefly nature of business activities undertaken</label>
                                              <textarea cols="3" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"></textarea>
                                          </div>
                                      </div>

                                      <div class="col-12  ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Business</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="sector2">
                                                <option>--select--</option>
                                                <option>Manufacturing</option>
                                                <option>Retailer / Stockist</option>
                                                <option>Finance / Investment</option>
                                                <option>Wholesaler</option>
                                                <option>Export / Import</option>
                                                <option>Commission Agent / Broker</option>
                                                <option>Service Provider</option>
                                                <option>Lottery</option>
                                                <option>Trading</option>
                                                <option>Arms and Ammunition</option>
                                                <option>Antique Dealer</option>
                                                <option>Dealer in precious metals / stones</option>
                                                <option>Bar / Night Club / Casino</option>
                                                <option>Money exchanger</option>
                                                <option>Real Estate Agent</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                      </div>

<!-- end Ocupation Detail -->


                                    </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>

                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif                              
@if($enableForms->form_8 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Details of Account Holder(s):</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp8<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
 <!--  Details of Account Holder(s): -->
                                       <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>

                                       <!-- first apllicant -->
                                       <div class="col-12">
                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2"><strong>Sole / First Applicant’s Details:</strong></label>
                                       </div>
                                       <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="pic" accept="image/*">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="firstappname">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="firstappwife">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="firstappmobile">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="firstappfax">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="firstappemail">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="signature" accept="image/*">
                                          </div>
                                       </div>
                                      <!-- end first applicant -->
                                        <!-- second apllicant -->
                                      <div class="col-12">
                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2"><strong>Second Applicant’s Details:</strong></label>
                                       </div>
                                       <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secapppic" accept="image/*">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappname" >
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappwife">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappmobile">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappfax">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappemail">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="secappsignature" accept="image/*">
                                          </div>
                                       </div> 
                                       <!-- end second applicant -->
                                         <!-- third apllicant -->
                                       <div class="col-12">
                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2"><strong>Third Applicant’s Details:</strong></label>
                                       </div>
                                       <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="thirdapppic" accept="image/*">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="thirdappname">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="thirdappwife">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="thirdappmobile">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="thirdappfax">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="thirdappemail">
                                           </div>
                                        </div>
                                        <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                             <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="thirdappsignature" accept="image/*">
                                          </div>
                                       </div> 
                                      <!--  end third applicant -->
 <!--  End Details of Account Holder(s): -->
  <!--  Mode of Account Operation -->
                                       <div class="col-12 ">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mode of Account Operation:</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="accoperation">
                                                <option>--select--</option>
                                                <option>Singly</option>
                                                <option>Anyone or Survivor</option>
                                                <option>Jointly</option>
                                                <option>Power of Attorney</option>
                                                <option>Either or Survivor</option>
                                                <option>Former or Survivor</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                       </div>
   <!-- end Mode of Account Operation -->
                                     </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif                              
<!--  Details of Accounts held with other Banks (Mandatory as per RBI guidelines): 9 -->
@if($enableForms->form_9 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Credit Facilities with other Banks:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp9<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row ">
                                        <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> Details of Accounts held with other Banks (Mandatory as per RBI guidelines):</h5>
                                       <div class="col-12">
                                           <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Whether account(s) held by the applicant(s) with any other bank(s)</label>
                                             <div class="radio d-inline-block mr-2">
                                                <input type="radio" name="bsradio" id="radio1" checked="" value='yes'>
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                             </div>
                                             <div class="radio d-inline-block mr-2">
                                                <input type="radio" name="bsradio" id="radio2" value='no'>
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                             </div>
                                           </div>
                                        </div>
                                       <div class="col-12">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2"> If Yes, please provide details of the account(s) maintained with other bank(s):</label>
                                       </div>
                                       <div class="col-12">
                                          <div class="flex flex-wrap -mx-3">
                                             <div class="col-12 ">
                                                <div class="mb-6">
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of the Bank</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="namebank">
                                                </div>
                                             </div>
                                             <div class="col-12 ">
                                                <div class="mb-6">
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Branch Address</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="branchaddress">
                                                </div>
                                             </div>
                                             <div class="col-12 ">
                                                <div class="mb-6">
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2">Type of Account</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="branchacc">
                                                </div>
                                             </div>
                                             <div class="col-12 ">
                                                <div class="mb-6">
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Number</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="branchaccnumber">
                                                </div>
                                             </div>
                                          </div>
                                      </div>

                                  </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
<!-- Credit Facilities with other Banks: 10 -->
@if($enableForms->form_10 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Credit Facilities with other Banks:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp10<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row ">
                                    <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"></h5>
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input" id="customCheck5"  name="nocredit">
                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2"> I /We declare that I/we do not enjoy credit facilities with other bank(s)/any other branch of your bank and undertake
                                          to inform the bank in writing as soon as any credit facility is availed from any other Bank/ any other branch of your
                                          Bank.</label>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input" id="customCheck6"  name="yescredit">
                                          <label class="block text-sm font-semibold text-on-surface-variant mb-2"> I /We declare that I/we enjoy credit facilities with other bank(s)/ other branch (es) of your bank as per the following
                                          details:</label>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="table" class="table-editable">
                                             <span class="table-add float-right mb-6 mr-2">
                                             <button class="btn btn-sm iq-bg-success"><i
                                                class="ri-add-fill"><span class="pl-1">Add New</span></i>
                                             </button>
                                             </span>
                                             <table class="w-full text-left border-collapse">
                                                <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap"ead class="bg-surface-container-low text-on-surface-variant font-semibold">
                                                   <tr>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">S.No</th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Nature of Credit Facility etc.</th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Amount  sanctioned</th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Amount utilized as on date</th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Name of the Bank</th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Address of the Bank </th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Account No. </th>
                                                      <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Remove</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                                      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                                         <span class="table-remove"><button type="button"
                                                            class="btn iq-bg-danger btn-rounded btn-sm my-0">Remove</button></span>
                                                      </td>
                                                   </tr>
                                                  
                                                </tbody>
                                             </table>
                                          </div>
                                    </div>

                               </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
<!--  Initial Payment Details: 11-->
@if($enableForms->form_11 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Initial Payment Details:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp11<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row ">
                                      <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"></h5>
                                      <div class="col-12">
                                         <h5><strong>A. Funding details</strong></h5>
                                      </div>
                                      <div class="col-12 ">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fundcurr">
                                       </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Amount</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fundamount">
                                          </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Cheque No.</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="cheque">
                                          </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Dated</label>
                                            <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="dated">
                                          </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Drawn on Bank</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="drawn">
                                          </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="branchfund">
                                          </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Account Number</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fundaccountnumber">
                                          </div>
                                      </div>
                                      <div class="col-12">
                                         <p>Cheque should be crossed A/C Payee & drawn payable to “{{$bankName}}, Ltd. A/C - Account Name” and should be 
                                          from own account with other bank. Please ensure that signature(s) on funding cheque match with the specimen signature (s) provided to the bank.</p>
                                      </div>

                                      <div class="col-12">
                                         <h5><strong>B. Inward Remittance</strong></h5>
                                      </div>
                                      <div class="col-12 ">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Remitter</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="remiter">
                                       </div>
                                      </div>
                                      <div class="col-12 ">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Address</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="remiteraddress">
                                          </div>
                                      </div>
                                      <div class="col-12">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency and Amount</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="remitercurrencyammount">
                                          </div>
                                      </div>
                                      <div class="col-12">
                                          <div class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Remitting Bank and Branch Address</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="remiterbranch">
                                          </div>
                                      </div>
                               </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
<!--  Introducer Details: 12-->
@if($enableForms->form_12 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Introducer Details:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp12<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row ">
                                    <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>
                                    <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of Introducing customer</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="introname">
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account number of the Introducer</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="introacc">
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">I/We confirm that I/We maintain an account with {{$bankName}}, Ltd.</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="intromaintain">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">_Branch for over 12 months. I/We personally know the applicant(s) detailed in the Application form for more than 6 months and confirm his/her /their identity, occupation and address.</label>
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of Introducer:</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="introsignature">
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date:</label>
                                         <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="introdate">
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Place:</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="introplace">
                                       </div>
                                   </div>
                         </div>
                        </div>
                        <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                        <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                     </fieldset>
@endif
<!--  Minor Declaration 13,14,15-->
@if($enableForms->form_13 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Minor Declaration (In case of Minor, Please submit copies of identification and address document for the Guardian.):</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp13<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row ">
                                   <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>
                                    <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">I hereby declare that the date of birth of the minor who is my</label>
                                         <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="minordeclare1">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">and I am his/her natural and lawful Guardian / Guardian appointed by court order dated</label>
                                         <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="minordeclare2">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">(copy enclosed). I shall represent the said minor in all future transactions of any 
                                          description in the above account until the said minor attains majority. I, indemnify the Bank against the claim of the 
                                          above minor for any withdrawal/transactions made by me in his/her account. Upon attaining majority, I undertake 
                                          to produce the minor at the Bank along with required documents for conversion of account status from minor to 
                                          major and shall not operate the account further on behalf of the minor. I understand that the Bank may temporarily 
                                          freeze operations in the account until the required formalities have been fulfilled by me/minor turned major.</label>
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of Parent / Guardian</label>
                                         <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="minordeclaresignature">
                                       </div>
                                   </div>
                                  
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date:</label>
                                         <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="minordeclaredate">
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of Parent / Guardian:</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="minordeclareparent">
                                       </div>
                                   </div>
<!-- End Minor Declaration -->

<!--  Senior Citizen Declaration: -->
                                   <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> Senior Citizen Declaration:</h5>
                                    <div class="col-12">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">I/We, hereby undertake and declare that I/we qualify as a Senior Citizen as per the prevailing rules and regulations. I/
                                          We further state that the documents/statements/declarations furnished/made by me/us to {{$bankName}}, Ltd.,</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="seniordeclare1">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch or as represented herein are true and correct. Further, in the event any of the  documents/statements/declarations are found to be incorrect in material particular or otherwise, I/We hereby undertake to indemnify {{$bankName}}, Ltd.,</label>
                                         <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="seniordeclare2">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch for all times hereafter against all losses, 
                                          costs, claims, actions, demands, risks, charges, expenses, damages etc., whatsoever which the Bank may suffer and/ or incur on account of the representations being made by me/us.</label>
                                       </div>
                                   </div>
                                   <div class="col-sm-4">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of 1st Applicant</label>
                                         <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="seniordeclare3">
                                       </div>
                                   </div>
                                   <div class="col-sm-4">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of 2nd Applicant</label>
                                         <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="seniordeclare4">
                                       </div>
                                   </div>
                                   <div class="col-sm-4">
                                       <div class="mb-6">
                                         <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of 3rd Applicant</label>
                                         <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="seniordeclare5">
                                       </div>
                                   </div>
                                  
<!-- End Senior Citizen Declaration: -->
                                     </div>
                                 </div>

                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>

                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif
@if($enableForms->form_14 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Know Your Customer (KYC) Details:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp14<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row col-sm-12">
                                         <h5 class="col-sm-12 my-3 border-bottom-1 pb-2">First Applicant</h5>
                                          <div class="col-12">
                                              <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Document submitted for Proof of Identity / Address</label>
                                                   <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyouraddress'>
                                              </div>
                                           </div>
                                           <div class="col-12">
                                              <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Document Identification No. (If Any)</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name='knowyourid'>
                                              </div>
                                           </div>
                                           <div class="col-12">
                                              <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Place of Issue</label>
                                                   <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name='knowyourplace'>
                                              </div>
                                           </div>
                                           <div class="col-12">
                                              <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Issue</label>
                                                   <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourdate'>
                                              </div>
                                           </div>
                                           <div class="col-12">
                                              <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Expiry</label>
                                                   <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourexpire'>
                                              </div>
                                           </div>
                                           <h5 class="col-sm-12 mt-6 pb-2">1. Purpose of Account Opening:</h5>
                                          <div class="col-12">
                                          <div class="mb-6">
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourpurpose'>
                                                <option>--select--</option>
                                                <option>Salary</option>
                                                <option>Loan Repayment</option>
                                                <option>Business</option>
                                                <option>Basic Household Expenses</option>
                                                <option>Investment</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                         </div>
                                          <h5 class="col-sm-12 mt-6 pb-2">2. Expected Source of Funds:</h5>
                                          <div class="col-12">
                                          <div class="mb-6">
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyoursource'>
                                                <option>--select--</option>
                                                <option>Salary Receipts</option>
                                                <option>Business Income</option>
                                                <option>Income from Investments</option>
                                                <option>Consultation / Professional Fees</option>
                                                <option>Savings</option>
                                                <option>Rental Income</option>
                                                <option>Interest / Dividend Income</option>
                                                <option>Inheritance</option>
                                                <option>Others</option>
                                             </select>
                                          </div>
                                           </div>
                                          <h5 class="col-sm-12 mt-6 pb-2">3. Expected Account Turnover:</h5>
                                          <div class="col-12">
                                          <div class="mb-6">
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourturn'>
                                          </div>
                                           </div>
                                          <h5 class="col-sm-12 mt-6 pb-2">4. Expected Number of Transactions per year:</h5>
                                          <div class="col-12">
                                          <div class="mb-6">
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourtrans'>
                                          </div>
                                           </div>
                                          <h5 class="col-sm-12 mt-6 pb-2">5. Expected Account Activity:</h5>
                                          <div class="col-12">
                                          <div class="mb-6">
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyouractivity'>
                                          </div>
                                           </div>
                                          <h5 class="col-sm-12 mt-6 pb-2">6. Whether existing account holder</h5>
                                          <div class="col-12">
                                             <div class="radio d-inline-block mr-2">
                                                <input type="radio" name="knowbsradio" id="radio1" checked="">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                             </div>
                                             <div class="radio d-inline-block mr-2">
                                                <input type="radio" name="knowbsradio" id="radio2" >
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Customer ID</label>
                                                <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourcustid'>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Number</label>
                                                <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name='knowyour2accno'>
                                             </div>
                                          </div>
                                           <h5 class="col-sm-12 mt-6 pb-2">7. Whether Letter of Authority/Power of Attorney given to another person</h5>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Whether account(s) held by the applicant(s) with any other bank(s)</label>
                                                <div class="radio d-inline-block mr-2">
                                                   <input type="radio" name="know2bsradio" id="radio1" checked="">
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                                </div>
                                                <div class="radio d-inline-block mr-2">
                                                   <input type="radio" name="know2bsradio" id="radio2" >
                                                   <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Please provide POA Holder’s name</label>
                                                <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourpoa'>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Birth</label>
                                                <input type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourpoabirth'>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Address</label>
                                                <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourpoaaddress'>
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Identification document(for confirmation of name, date of birth and address)</label>
                                                <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name='knowyourpoaid'>
                                             </div>
                                          </div>

                                       </div>
                                    </div>
                                  <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>

                                 <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
@endif                             
@if($enableForms->form_15 == 1)
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Final Step</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step @php $cual =+ 1; echo $cual; @endphp15<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                                    <div class="row col-sm-12">
                                       <div class="col-12">
<textarea class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" style="height: 500px;line-height:20px;margin-bottom: 35px;" readonly="readonly">
Foreign Exchange Management Act, 1999 (FEMA)
----------------------------------------------
I/We hereby declare that the transactions relating to foreign exchange routed through your Bank do not involve, and are not designed for the purpose of any contravention or evasion of the provisions of the aforesaid Act or of any rule, regulation, direction, or order made here under. I/We also hereby agree and undertake to give such information/ documents as will reasonably satisfy you about the transactions in terms of the above declaration.

Authority For Collection of Cheque/Drafts/Documents
----------------------------------------------
I/We may have occasion from time-to-time to hand over to you for collection or negotiation Cheques, Drafts or Bills of Exchange (with or without documents attached) and I/we hereby agree to your forwarding the same to your agents for the time being for collection or negotiation. In the event of your having no independent collecting agent at any centre, I/we hereby authorize you to send cheques, drafts, etc. by mail directly to the drawee bank itself.
I/We agree and undertake to hold you harmless, free from any responsibility and indemnified for any loss suffered by you in handling this business or transactions due to any cause whatsoever including delay in transit presentation, payment or default by your agent.
In addition to your ordinary rights as holder of such Cheques, Drafts or Bill of Exchange, you are authorized to accept in payment thereof a banker’s cheque or banker’s cheques payable at your station or at other places and in the event of such cheque(s) not being paid on presentation to debit the amount to our account with all charges incurred thereon. I/We confirm that you can present Bills and receive the amount in respect thereof in accordance with the usage of the place where the Bills are made payable. It is understood that these transactions are in all respects at my/our entire risk and responsibility.

Customer Declaration
-----------------------------------------------
I/We hereby acknowledge that I/we have received, read and understood the Bank’s prevailing Terms, Conditions and Rules Governing Deposit Account and Schedule of Fees and Charges relating to the above account being opened by me/ us.
I/We agree to abide by the same as amended from time-to-time and further agree to abide by any additional terms and conditions governing any facilities, products and/or services offered by the Bank as I/we may apply for and/or utilize from time to time.
I/We agree to abide by the rules/provisions as prescribed by the Reserve Bank of India from time-to-time.
I/We hereby confirm having opted/chosen to get Statement of Account monthly/periodically issued by the Bank pertaining to the Account to be opened pursuant to this Application.
I/We also confirm not to commence or undertake any activity/transaction which is not permissible under the prevalent Foreign Direct Investment Policy or any other applicable Policy or guidelines of the Government of India/Reserve Bank of India save and except after obtaining specific prior approval from the concerned authorities under advice to the Bank.
I/We hereby confirm and declare that in relation to any Transaction, Dealing(s), Credit including advise or confirmation of the same, the obligations of the Bank shall be subject to the condition that the terms thereof including any document or drafts do not contain state or mention, including without limitation:
(i) Any countries, organizations, entities, or individuals (under any law) relating to any sanction parties listed under United Nation, European Union, United States of America, Japan, India and other authorities;
(ii) Any goods of origin from sanction countries listed under United Nation, European Union, United States of America, Japan, India and other authorities;
(iii) Any prohibited goods under the list of United Nation, European Union, United States of America, Japan, India and other authorities;
(iv) Any place or loading, place of discharge, or place of transhipment under the list of United Nation, European Union, United States of America, Japan, India and other authorities; and/or
(v) Any vessel or carrier relating to any sanction parties listed under United Nation, European Union, United States of America, Japan, India and other authorities.

I/We shall maintain the minimum balance requirement as applicable at all times and the Bank shall levy 
prescribed charges in case of non-maintenance of minimum balance. In case of change of mailing address and 
other contact details, the same shall be communicated to the Bank in writing.
It is understood that the above account will be opened on the basis of the statements, declarations made by me/us and I/We represent that the information provided by me/us in this application form and in any other document(s) provided by me/us to the Bank is true, accurate and complete.
I/We acknowledge that the Bank may decline my/our application without providing any reason in which event no contractual relationship will arise between the Bank and me/us.
</textarea>
                                       </div>
                                    </div>
                                  
                                 </div>
                                   
    <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>

    <button type="submit" name="submit"  class="btn btn-dark previous action-button-previous float-right mr-3" value="Save">Save & exit</button><button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                      
                              </fieldset>
@endif
                            <!--  submit-->                                   
<fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Are you sure you want to create an account?</h5>
                                           <p>
@if($enableForms->auto_activate == 1)
Your account will be activated automatically
@else
Your account will be reviewed by our staff
@endif                             
                                           </p>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps"><!--Step 15<!-- - {{$totalForm ?? ''}}--></h2>
                                       </div>
                                    </div>
                                    
                              
                                 </div>
                                   

    <button type="submit" name="submit"  class="btn btn-primary next action-button float-right mr-5" value="Submit">Submit</button> 
    
    <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
    
    
                      
                              </fieldset>

                            <!--  success-->                                   
                              <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-12">
                                          <h3 class="mb-6">Success</h3>
                                       </div>
                                    </div>
                                    <div class="text-center">
                                       <img src="images/check.gif" class="success">
                                    </div>
                                 </div>
                              </fieldset>
                                   
                           </form>
                               </div>
                            </div>
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
      <script src="js/custom.js"></script> 
      <script type="text/javascript">
        jQuery("#load").fadeOut();
        jQuery("#loading").delay().fadeOut("");
      </script>


      <div class="modal " id="resumeotp"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                   <form id="form-wizard2" class="text-center mt-6 bggray-cus" method="POST" action="online-open-account">@csrf
                  <div class="flex flex-wrap -mx-3">
                     <div class="col-12">
                        <h4 class="text-center">Resume Registration</h4>
                        <p class="text-center">Enter the Registration Number from the previous process you started to resume that</p>
                        
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     <div class="w-full md:w-1/2 px-3">
                        <div class="mb-6">
                           <!-- <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name: *</label> -->
                           <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="continueregister" placeholder="Enter registration no.">
                        </div>
                        <div class="text-center">                          
                            <button type="submit" name="submit" value="Recover"  class="btn btn-success mt-2" >Continue</button>
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
