@extends('layouts.stack')

@section('content')
  <style type="text/css">
    .ui-widget-content {
      border: 1px solid var(--iq-border-light);
      background: #fff !important;
      color: #1e3d73;
    }
    .online-support {
      margin-top: 10px;
    }

    .online-support h3 {
      background: #fe517e;
      color: #fff;
      padding-left: 15px;
      margin-bottom: 10px;
      border:1px solid transparent;
      box-shadow: 0px 2px 5px 2px rgba(0,0,0,0.1)
    }

    .online-support .btn-link {
      color:#fff;
      border-bottom: 1px solid #fff;
      border-radius: 0px;
    }

    .input-group-text {
      font-size: 20px;
    }

    body {
      background: #e7ecee;
    }
  </style>

  <!-- loader Start -->
  <div id="loading">
    <div id="loading-center">
    </div>
  </div><!--/ loader END -->

  <!-- registration section -->
  <section class="sign-in-page py-5">
    <!-- main wrapper container -->
    <div class="container p-0 ">
      <!-- main wrapper row -->
      <div class="row no-gutters height-self-center">
        <!-- main wrapper col -->
        <div class="col-sm-12 align-self-center bg-[#004226] border border-[#aaf2c4]/30 shadow-2xl rounded-2xl mb-5">
          <!-- main row -->
          <div class="row m-0 ">
            <div class="col-12 py-3">
              <img src="images/logo-full.png" style="max-width:150px; filter: brightness(0) invert(1);">
            </div>
            <!-- main col -->
            <div class="col-md-12 bg-white sign-in-page-data iq-card pb-0 mb-0">
              <!-- signin form -->
              <div class="sign-in-from">
                <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                  <h3 class="mb-0 text-left">New Account Registration</h3>
                </div>
                <!-- row -->
                <div class="flex flex-wrap -mx-3">
                  <!-- main col for form-->
                  <div class="col-12 text-dark">
                    <!-- registration form -->
                    <div
                      id="form-wizard1"
                      class="text-center mt-6 bggray-cus">
                      <!-- fieldset - 1 -->
                      <fieldset id="fs_one">
                        <div class="form-card text-left">
                          <div class="flex flex-wrap -mx-3">
                            <div class="col-7">
                              <h5 class="mb-6">Terms and conditions:</h5>
                            </div>
                            <div class="col-5">
                              <h4 class="steps">Step 1 - 15</h4>
                            </div>
                            <div class="col-12">
                              <textarea
                                class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                style="
                                height: 500px;
                                line-height:20px;
                                margin-bottom: 35px;"
                                readonly="readonly">
                                Account Opening Documentation:
                                ----------------------------------------------
                                We seek your understanding and cooperation in
                                furnishing the documents required for account
                                opening and value your time and effort in doing
                                so. We request you to provide suitable
                                documentation as indicated below which is
                                required by the Bank under local laws and
                                regulations and also to comply with KYC
                                guidelines and policy as part of the global
                                effort to combat money laundering, terrorist
                                financing and fraudulent activity

                                Important Note:
                                ----------------------------------------------
                                1) Please fill the form in CAPITAL letters and
                                tick wherever applicable.
                                2) Avoid any sort of alterations/cutting in the
                                Application form.
                                3) Produce original documents for verification
                                against each self attested photocopy by Account
                                Holder(s).
                                4) Please produce separate documents to evidence
                                proof of identity and proof of address for
                                confirming name, date of birth and current
                                residential address for each account holder.
                                5) Please avail of the nomination facility.
                                Please attach separate sheets in case the given
                                space is insufficient.

                                Account Opening Requirements:
                                -----------------------------------------------
                                1. Completed Account Opening Application Form
                                along with required documentation.
                                2. Recent Passport size photographs of all the
                                Account Holder(s) duly signed on front (not more
                                than six months old).
                                3. PAN Card copy or Form 60
                                (whichever is applicable).

                                Documents to be submitted for Account Opening:
                                ------------------------------------------------
                                Identification Proof (List A)
                                * Passport
                                * Driving License
                                * PAN Card
                                * Voter ID Card
                                * Any Photo ID card issued by Central/State Govt.
                                / PSU/Armed forces ID card

                                Address Proof (List B)
                                * Passport
                                * Voter ID Card
                                * Driving License
                                * Latest utility bill in the name of the
                                applicant(s) i.e. electricity, water or telephone
                                bill (not older than three months)
                                * FRRO, Visa copy / Appointment letter
                                (applicable in case of foreign nationals only)
                                * Letter from the Embassy confirming residential
                                address (applicable for Diplomats and other
                                Embassy officials)

                                Special Instructions:
                                In case of joint account holder(s), acceptable
                                documents which can be submitted as proofs for
                                establishing
                                relationship-
                                * Passport
                                * Driving License
                                * PAN Card
                                * Voter ID Card
                                * Photo-Ration Card

                                For ascertaining Minor’s date of birth,
                                acceptable documents which can be submitted-
                                * Birth certificate issued by Municipal Authority.
                                * Passport held in the name of the minor.
                                *10th Class certificate indicating DOB, issued
                                by the Central Board (C.B.S.E., I.C.S.E.) / State
                                Board.

                                Note: 1. Bank may request for any further
                                specific / additional documents as may be
                                required.
                              </textarea>
                            </div>
                          </div>
                        </div>

                        <!-- 
                          when the user click this button for first time,
                          generate random regID for resume the registration,
                          incase the user stopped the registration in midway.
                        -->  

                        <button
                          id="genID"
                          type="button"
                          name="next"
                          class="
                          btn
                          btn-primary
                          next
                          action-button
                          float-right"
                          value="Next">
                          Continue
                        </button>

                        <button
                          type="button"
                          data-toggle="modal"
                          data-target="#resumeotp"
                          class="
                          btn
                          btn-success
                          mr-3
                          float-right">
                          Resume Registration
                        </button>
                      </fieldset><!--/ fieldset - 1 ends -->

                      <!-- fieldset 2 --ao_fs-account-opening fieldset -->
                      <fieldset id="fs_two">
                        <form
                          id="ao_fs_two"
                          action=""
                          method="POST">
                          @csrf
                          <div class="form-card text-left">
                            <div class="flex flex-wrap -mx-3">
                              <div class="col-7">
                                <h5 class="mb-6">
                                  Do not leave any field blank,
                                  instead mention Not applicable (N.A.)
                                </h5>
                              </div>
                              <div class="col-5">
                                <h4 class="steps">Step 2 - 15</h4>
                              </div>
                            </div>
                            <div class="flex flex-wrap -mx-3">
                              <div class="clearfix"></div>
                              <!-- account mode -->
                              <div class="col-12">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    I/We hereby request MUFG Bank, Ltd.
                                    to open my/our Savings Account. in Branch
                                  </label>
                                  <select
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="fa_bank" 
                                    >
                                      <option value="">--select--</option>
                                      @foreach($branchLocations as $branchLocation)
                                        <option 
                                          value="{{ $branchLocation->id }}">
                                          {{ $branchLocation->branch_name }}
                                        </option>
                                      @endforeach  
                                  </select>
                                </div>
                                <div id="emailError"></div>
                              </div><!--/ account mode ends -->

                              <!-- currency -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency In</label>
                                  <select
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="fa_currency">
                                    <option value="">--select--</option>
                                    @foreach($currencies as $currency)
                                      <option value="{{ $currency->id }}">
                                        {{ $currency->currency }}
                                      </option>
                                    @endforeach
                                  </select>
                                </div>
                              </div><!--/ currency ends -->

                              <!-- account type -->
                              <div class="col-12">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Type Of Account</label>
                                  <select
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="fa_ac_type">
                                    <option value="">--select--</option>
                                    @foreach($accountTypes as $accountType)
                                      <option value="{{ $accountType->id }}">
                                        {{ $accountType->type_name }}
                                      </option>
                                    @endforeach
                                  </select>
                                </div>
                              </div><!--/ account type ends -->
                            </div><!--/ row ends -->
                          </div><!--/ form card ends -->
                        </form>
                        <button
                          id="aoc_fs_two"
                          type="button"
                          name="next"
                          class="
                          btn
                          btn-primary
                          next
                          action-button
                          float-right"
                          value="Next">
                          Continue
                        </button>
                        <button
                          type="button"
                          name="previous"
                          class="
                          btn
                          btn-dark
                          previous
                          action-button-previous
                          float-right
                          mr-3"
                          value="Previous">
                          Previous
                        </button>
                      </fieldset><!-- fieldset 2 ends -->

                      <!-- fieldset 3-->
                      <fieldset id="fs_three">
                        <form
                          id="ao_fs_three"
                          action=""
                          method="POST">
                          @csrf
                          <!-- form card -->
                          <div class="form-card text-left">
                            <div class="flex flex-wrap -mx-3">
                              <div class="col-7">
                                <h5 class="mb-6">
                                  Details of Account - Sole / First Applicant:
                                </h5>
                              </div>
                              <div class="col-5">
                                <h4 class="steps">Step 3 - 15</h4>
                              </div>
                            </div>
                            <!-- row -->
                            <div class="flex flex-wrap -mx-3">
                              <!-- title -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Title</label>
                                  <select
                                  name ="title"
                                  type="text"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <option value="">--select--</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                  </select>
                                </div>
                              </div><!--/ title ends -->

                              <!-- ac name -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Name</label>
                                  <input
                                  name ="cust_name"
                                  type="text"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                </div>
                              </div><!-- account name ends -->

                              <!-- alias-->
                              <div class="col-12">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    Other common names used /former name if any
                                  </label>
                                  <input
                                  name="fa_alias"
                                  type="text"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                </div>
                              </div><!-- alias ends -->

                              <!-- alias reason -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Reason for using other name</label>
                                  <input
                                  name="fa_alias_reason"
                                  type="text"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                </div>
                              </div><!-- alias reason ends -->

                              <!-- DOB -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Birth</label>
                                  <input
                                  name="dob"
                                  type="date" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                </div>
                              </div><!--/ DOB ends -->

                              <!-- gender-->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Gender</label>
                                  <select
                                  name="fa_gender"
                                  type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <option value="">--select--</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Third Gender</option>
                                  </select>
                                </div>
                              </div><!--/ gender ends -->

                              <!-- Nationality-->
                              <div class="col-12 ">
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                    <select name="fa_nationality" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
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
                              </div><!-- Nationality ends -->

                              <!-- PAN number -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">PAN Number</label>
                                  <input
                                  name="fa_pan"
                                  type="text"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                </div>
                              </div><!--/ PAN number ends -->

                              <!-- Minor account -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Minor Account</label>
                                  <select
                                    name="fa_is_ma"
                                    type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <option value="0">--select--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                              </div><!--/ minor account ends -->

                              <!-- senior citizen -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Senoir Citizen</label>
                                  <select
                                    name="fa_sc"
                                    type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <option value="0">--select--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                              </div><!--/ senior citizen ends -->

                              <!-- parent / gaurdian -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Name of Parent / Guardian</label>
                                  <input
                                  name="fa_ward"
                                  type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                </div>
                              </div><!--/ parent / gaurdian ends -->

                              <!-- relation -->
                              <div class="col-12 ">
                                <div class="mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Relationship with minor</label>
                                  <input
                                  name="fa_rel"
                                  type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                </div>
                              </div><!--/ realtion ends -->
                            </div><!--/ row ends -->
                          </div><!--/ form card ends -->
                        </form>
                        <!-- continue btn -->
                        <button
                          id="aoc_fs_three"

                          type="button"
                          name="next"
                          class="
                          btn
                          btn-primary
                          fa_save
                          next
                          action-button
                          float-right"
                          value="Next">
                          Continue
                        </button>
                        <!-- previous btn -->
                        <button
                          type="button"
                          name="previous"
                          class="
                          btn
                          btn-dark
                          previous
                          action-button-previous
                          float-right
                          mr-3"
                          value="Previous">
                          Previous
                        </button>
                      </fieldset><!--/ fieldset 3 ends -->

                      <!-- fieldset 4 cd - comminication details -->
                      @if($enabledForms->form_4 == 1)
                        <fieldset id="fs_four">
                          <form
                            id="ao_fs_four"
                            method="POST"
                            action="">
                            <!-- form card -->
                            <div class="form-card text-left">
                              <!-- row -->
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Communication Details:</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 4 - 15</h2>
                                </div>
                              </div><!--/ row ends -->

                              <!-- row -->
                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-12 my-3 border-bottom-1 pb-2"></h5>
                                <!-- addresss-->
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Permanent /Residential Address</label>
                                    <input
                                    name="cd_addr"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ address ends -->

                                <!-- city -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">City</label>
                                    <input
                                    name="cd_city"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ city ends -->

                                <!-- pincode -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Pin Code / Zip Code</label>
                                    <input
                                    name="cd_pincode"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ pincode ends -->

                                <!-- nationality -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                    <select
                                      name="cd_citizenship"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
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
                                </div><!-- nationality ends -->

                                <!-- resident tell -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel: Residence(With STD Code)</label>
                                    <input
                                    name="cd_tell"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                                  </div>
                                </div><!-- res tell ends -->

                                <!-- mailing address -->
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Correspondence / Mailing Address</label>
                                    <input
                                    name="cd_maddr"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!-- mainling address ends -->

                                <!-- mailing city -->
                                <div class="col-12   ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">City</label>
                                    <input
                                    name="cd_mcity"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ mailing city ends -->

                                <!-- mailing pincode -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Pin Code / Zip Code</label>
                                    <input
                                    name="cd_mpincode"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ mailing pincode ends -->

                                <!-- mailing citizenship -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Nationality / Citizenship</label>
                                    <select
                                      name="cd_mcitizenship"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
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
                              </div><!--/ row ends -->
                            </div><!--/ form card ends -->
                          </form>
                          <!-- continue btn -->
                          <button
                            form="ao_fs_four"
                            id="aoc_fs_four"
                            type="button"
                            name="next"
                            class="btn btn-primary next action-button float-right"
                            value="Next">
                            Continue
                          </button>
                          <!-- previous btn -->
                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 4 ends -->

                      <!-- fieldset 5 - ro - reachout details-->
                      @if($enabledForms->form_5 == 1)
                        <fieldset id="fs_five">
                          <form
                            id="ao_fs_five"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Contact Detail</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 5 - 15</h2>
                                </div>
                              </div>

                              <!-- row -->
                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-12 my-3 border-bottom-1 pb-2"></h5>
                                <!-- mobile -->
                                <div class="col-12   ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                    <input
                                    name="ro_mobile"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ mobile ends -->

                                <!-- residence -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel : Residence(with STD code)</label>
                                    <input
                                    name="ro_tell"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ residenc ends -->

                                <!-- office -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Tel: Office(With STD Code)</label>
                                    <input
                                    name="ro_office_tell"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                                  </div>
                                </div><!-- office tell ends -->

                                <!-- fax -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax: With STD Code</label>
                                    <input
                                    name="ro_fax"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ fax ends -->

                                <!-- email -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email</label>
                                    <input
                                    name="ro_email"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ email ends -->
                              </div><!--/ row ends  -->
                            </div><!-- form card ends -->
                          </form>
                          <button
                            id="aoc_fs_five"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 5 ends -->

                      <!-- fieldset -6- pd-personal details -->
                      @if($enabledForms->form_6 == 1)
                        <fieldset id="fs_six">
                          <form
                            id="ao_fs_six"
                            method="POST"
                            action="">
                            @csrf
                            <!-- form card -->
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Personal Details</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 6 - 15</h2>
                                </div>
                              </div>

                              <!-- row -->
                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-12  my-3 border-bottom-1 pb-2"></h5>

                                <!-- educational qualification-->
                                <div class="col-12   ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Educational Qualification</label>
                                    <select
                                      name="pd_edu"
                                      type="text"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Undergraduate</option>
                                      <option value="2">Graduate</option>
                                      <option value="3">Postgraduate</option>
                                    </select>
                                  </div>
                                </div><!-- edu quali ends -->

                                <!-- marital status-->
                                <div class="col-12   ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Marital Status</label>
                                    <select
                                      name="pd_marital"
                                      type="text"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Unmarried</option>
                                      <option value="2">Married</option>
                                      <option value="3">Postgraduate</option>
                                    </select>
                                  </div>
                                </div><!--/ marital status ends -->

                                <!-- dependent -->
                                <div class="col-12 ">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Number of Dependents</label>
                                </div>
                                <!-- adults -->
                                <div class="col-12   ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Adults</label>
                                    <input
                                    name="pd_adults"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ adults -->

                                <!-- childrens -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Children</label>
                                    <input
                                    name="pd_kids"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ childrens -->

                                <!-- annual income -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Annual Income (in INR)</label>
                                    <input
                                    name="pd_ai"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div><!--/ ai ends -->
                              </div><!--/ row ends -->
                            </div><!--/ form card ends -->
                          </form>

                          <button
                            id="aoc_fs_six"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 6 ends -->

                      <!-- filedset -7- od-occupational details-- -->
                      @if($enabledForms->form_7 == 1)
                        <fieldset id="fs_seven">
                          <form
                            id="ao_fs_seven"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Occupation Details:</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 7 - 15</h2>
                                </div>
                              </div>
                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-12  my-3 border-bottom-1 pb-2"> </h5>
                                <!-- occupation type -->
                                <div class="col-sm-12 col-md-12  ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Occupation Type</label>
                                    <select
                                      name="od_type"
                                      type="text"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Salaried</option>
                                      <option value="2">Self-employed</option>
                                      <option value="3">Business</option>
                                      <option value="4">Retired</option>
                                      <option value="5">Housewife</option>
                                      <option value="6">Student</option>
                                      <option value="7">Other</option>
                                    </select>
                                  </div>
                                </div><!--/ occupation type ends -->

                                <!-- od details-->
                                <div class="col-12  ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      In case of Salaried (Please provide Employer
                                      details, Designation, Job Profile and Nature of
                                      Work)
                                    </label>
                                    <textarea
                                    name="od_details"
                                    cols="3"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"></textarea>
                                  </div>
                                </div><!--/ details ends -->

                                <!-- od self -->
                                <div class="col-12  ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Self-employed</label>
                                    <select
                                    name="od_self"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Chartered Accountant / CPA</option>
                                      <option value="2">Doctor</option>
                                      <option value="3">Engineer</option>
                                      <option value="4">Lawyer / Notary</option>
                                      <option value="5">Consultant / Professional</option>
                                      <option value="6">Other</option>
                                    </select>
                                    <br/>
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Please mention briefly nature of professional work
                                      undertaken
                                    </label>
                                    <textarea
                                    name="od_self_details"
                                    cols="3"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    </textarea>
                                  </div>
                                </div><!--/ od self ends -->

                                <!-- od business -->
                                <div class="col-12  ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">In case of Business</label>
                                    <select
                                      name="od_business"
                                      type="text"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Manufacturing</option>
                                      <option value="2">Retailer / Stockist</option>
                                      <option value="3">Finance / Investment</option>
                                      <option value="4">Wholesaler</option>
                                      <option value="5">Export / Import</option>
                                      <option value="6">Commission Agent / Broker</option>
                                      <option value="7">Service Provider</option>
                                      <option value="8">Lottery</option>
                                      <option value="9">Trading</option>
                                      <option value="10">Arms and Ammunition</option>
                                      <option value="11">Antique Dealer</option>
                                      <option value="12">Dealer in precious metals / stones</option>
                                      <option value="13">Bar / Night Club / Casino</option>
                                      <option value="14">Money exchanger</option>
                                      <option value="15">Real Estate Agent</option>
                                      <option value="16">Other</option>
                                    </select>
                                    <br/>
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Please mention briefly nature of business
                                      activities undertaken
                                    </label>
                                    <textarea
                                      name="od_business_details"
                                      cols="3"
                                      class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    </textarea>
                                  </div>
                                </div><!--/ od business ends -->
                              </div><!--/ row ends -->
                            </div><!-- / form card ends -->
                          </form>
                          <button
                            id="aoc_fs_seven"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 7 ends -->

                      <!-- fieldset 8 jh-joint account holder -->
                      @if($enabledForms->form_8 == 1)
                        <fieldset id="fs_eight">
                          <form
                            id="ao_fs_eight"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Details of Account Holder(s):</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 8 - 15</h2>
                                </div>
                              </div>
                              <!-- row -->
                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>
                                <!-- first apllicant -->
                                <div class="col-12">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2"><strong>Sole / First Applicant’s Details:</strong></label>
                                </div>
                                <!-- UPLOAD IMAGE -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_fimage"
                                    accept="image/*">
                                  </div>
                                </div>

                                <!-- name -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                    <input
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_name">
                                  </div>
                                </div>

                                <!-- ward name -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                    <input
                                    name="jh_fward"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ ward name ends -->

                                <!-- mobile -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                    <input
                                    name="jh_fmobile"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ mobile ends -->

                                <!-- fax -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                    <input
                                    name="jh_ffax"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ fax ends -->

                                <!-- email -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                    <input
                                    name="jh_femail"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ email ends -->

                                <!-- signature image -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_fsign"
                                    accept="image/*">
                                  </div>
                                </div><!--/ signature ends -->

                                <!-- second apllicant -->
                                <div class="col-12">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    <strong>Second Applicant’s Details</strong>
                                  </label>
                                </div>
                                <!-- 2nd holder image-->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_simage"
                                    accept="image/*">
                                  </div>
                                </div><!--/ image ends -->

                                <!-- name -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                    <input
                                    name="jh_sname"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!-- name ends -->

                                <!-- ward -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                    <input
                                    name="jh_sward"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ ward ends-->

                                <!-- mobile -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                    <input
                                    name="jh_smobile"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ mobile ends -->

                                <!-- fax -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                    <input
                                    name="jh_sfax"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ fax ends -->

                                <!-- email -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                    <input
                                    name="jh_semail"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div>

                                <!-- signature-->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_ssign"
                                    accept="image/*">
                                  </div>
                                </div><!--/ sign ends -->

                                <!-- third apllicant -->
                                <div class="col-12">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2"><strong>Third Applicant’s Details:</strong></label>
                                </div>

                                <!-- image -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Your Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_timage"
                                    accept="image/*">
                                  </div>
                                </div><!--/ image ends -->

                                <!-- name -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name</label>
                                    <input
                                    name="jh_tname"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ name ends -->

                                <!-- ward-->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Father’s/Spouse’s Name</label>
                                    <input
                                    name="jh_tward"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ ward name-->

                                <!-- mobile-->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mobile</label>
                                    <input
                                    name="jh_tmobile"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ mobile-->

                                <!-- fax -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Fax</label>
                                    <input
                                    name="jh_tfax"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ fax ends -->

                                <!-- email -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Email Id</label>
                                    <input
                                    name="jh_temail"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                  </div>
                                </div><!--/ email ends -->

                                <!-- sign -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Signature Photo:</label>
                                    <input
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                    name="jh_tsign"
                                    accept="image/*">
                                  </div>
                                </div><!--/ sign ends -->

                                <!-- operate mode -->
                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Mode of Account Operation:</label>
                                    <select
                                    name="jh_operate_mode"
                                    type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Singly</option>
                                      <option value="2">Anyone or Survivor</option>
                                      <option value="3">Jointly</option>
                                      <option value="4">Power of Attorney</option>
                                      <option value="5">Either or Survivor</option>
                                      <option value="6">Former or Survivor</option>
                                      <option value="7">Other</option>
                                    </select>
                                  </div>
                                </div><!--/ operate mode ends -->
                              </div><!--/ row ends -->
                            </div><!--/ form card ends -->
                          </form>
                          <button
                            id="aoc_fs_eight"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>
                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 8 ends -->

                      <!-- fieldset -9- ob-other bank accounts-->
                      @if($enabledForms->form_9 == 1)
                        <fieldset id="fs_nine">
                          <form
                            id="ao_fs_nine"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Credit Facilities with other Banks:</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 9 - 15</h2>
                                </div>
                              </div>

                              <!-- row -->
                              <div class="row ">
                                <h5 class="col-sm-12 my-3 border-bottom-1 pb-2">
                                  Details of Accounts held with other Banks
                                  (Mandatory as per RBI guidelines)
                                </h5>
                                <!-- other bank -->
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Whether account(s) held by the applicant(s)
                                      with any other bank(s)
                                    </label>
                                    <div class="radio d-inline-block mr-2">
                                      <input
                                      type="radio"
                                      name="ob_other_bank"
                                      value="1"
                                      id="radio1"
                                      checked="">
                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                    </div>
                                    <div class="radio d-inline-block mr-2">
                                      <input
                                      type="radio"
                                      name="ob_other_bank"
                                      value="2"
                                      id="radio2" >
                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                    </div>
                                  </div>
                                </div><!--/ other bank ends -->

                                <div class="col-12">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    If Yes, please provide details of the account(s)
                                    maintained with other bank(s)
                                  </label>
                                </div>

                                <!-- inner col -->
                                <div class="col-12">
                                  <div class="flex flex-wrap -mx-3">
                                    <!-- bank name -->
                                    <div class="col-12 ">
                                      <div class="mb-6">
                                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of the Bank</label>
                                        <input
                                        name="ob_bank_name"
                                        type="text"
                                        class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                      </div>
                                    </div><!--/ bank name ends -->

                                    <!-- brnch addr-->
                                    <div class="col-12 ">
                                      <div class="mb-6">
                                        <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Branch Address</label>
                                        <input
                                        name="ob_branch"
                                        type="text"
                                        class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                      </div>
                                    </div><!--/ branch addr ends -->

                                    <!-- type of account-->
                                    <div class="col-12 ">
                                      <div class="mb-6">
                                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Type of Account</label>
                                        <input
                                        name="ob_ac_type"
                                        type="text"
                                        class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" >
                                      </div>
                                    </div><!--/ type of ac ends -->

                                    <!-- ac number -->
                                    <div class="col-12 ">
                                      <div class="mb-6">
                                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Number</label>
                                        <input
                                        name="ob_ac_number"
                                        type="text"
                                        class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                                      </div>
                                    </div><!--/ ac number ends -->
                                  </div><!--/ row ends -->
                                </div><!--/ col ends -->
                              </div><!--/ row ends -->
                            </div><!--/ form card ends -->
                          </form>
                          <button
                            id="aoc_fs_nine"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>
                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 9 ends -->

                      <!-- fieldset -10- credit facilities with other banks -->
                      @if($enabledForms->form_10 == 1)
                      <fieldset id="fs_ten">
                        <form
                          id="ao_fs_ten"
                          method="POST"
                          action="">
                          @csrf

                          <div class="form-card text-left">
                            <div class="flex flex-wrap -mx-3">
                              <div class="col-7">
                                <h5 class="mb-6">Credit Facilities with other Banks:</h5>
                              </div>
                              <div class="col-5">
                                <h2 class="steps">Step 10 - 15</h2>
                              </div>
                            </div>

                            <div class="flex flex-wrap -mx-3">
                              <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"></h5>
                              <!-- declaration -->
                              <div class="col-12">
                                <div
                                  class="
                                  custom-control
                                  custom-checkbox
                                  custom-control-inline">
                                  <input
                                  type="checkbox"
                                  class="custom-control-input"
                                  id="customCheck5" required>
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    I /We declare that I/we do not enjoy credit
                                    facilities with other bank(s)/any other branch of
                                    your bank and undertake
                                    to inform the bank in writing as soon as any credit
                                    facility is availed from any other Bank/ any other
                                    branch of your Bank.
                                  </label>
                                </div>
                              </div><!--/ declaration ends -->

                              <!-- declaration -->
                              <div class="col-12">
                                <div
                                class="
                                custom-control
                                custom-checkbox
                                custom-control-inline">
                                  <input
                                  type="checkbox"
                                  class="custom-control-input"
                                  id="customCheck6" required>
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                    I /We declare that I/we enjoy credit facilities
                                    with other bank(s)/ other branch (es) of your bank
                                    as per the following details.
                                  </label>
                                </div>
                              </div><!--/ declaration ends -->


                              <div class="col-12">
                                <div id="table" class="table-editable">
                                  <span class="table-add float-right mb-6 mr-2">
                                    <button
                                      class="
                                      btn
                                      btn-sm
                                      iq-bg-success">
                                      <i class="ri-add-fill">
                                        <span class="pl-1">Add New</span>
                                      </i>
                                    </button>
                                  </span>
                                  <table
                                    class="
                                    table
                                    table-bordered
                                    table-responsive-md
                                    table-striped
                                    text-center">
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
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"

                                          contenteditable="true">

                                          </td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true">
                                          <input type="" name="cf_nature">
                                        </td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" contenteditable="true"></td>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                          <span class="table-remove">
                                            <button
                                              type="button"
                                              class="
                                              btn
                                              iq-bg-danger
                                              btn-rounded
                                              btn-sm
                                              my-0">
                                              Remove
                                            </button>
                                          </span>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div><!--/ table ends -->
                            </div><!--/ row ends -->
                          </div><!--/ form card ends -->
                        </form>
                        <button
                          id="aoc_fs_ten"
                          type="button"
                          name="next"
                          class="
                          btn
                          btn-primary
                          next
                          action-button
                          float-right"
                          value="Next">
                          Continue
                        </button>
                        <button
                          type="button"
                          name="previous"
                          class="
                          btn
                          btn-dark
                          previous
                          action-button-previous
                          float-right
                          mr-3"
                          value="Previous">
                          Previous
                        </button>
                      </fieldset>
                      @endif<!--/ fieldset 10 ends -->

                      <!-- fieldset -11- initial payments-->
                      @if($enabledForms->form_11 == 1)
                        <fieldset id="fs_eleven">
                          <form
                            id="ao_fs_eleven"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Initial Payment Details:</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 11 - 15</h2>
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
                                    <input
                                    name="ip_currency"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Amount</label>
                                    <input
                                    name="ip_amnt"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Cheque No.</label>
                                    <input
                                    name="ip_cheque"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Dated</label>
                                    <input
                                    name="ip_dated"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Drawn on Bank</label>
                                    <input
                                    name="ip_drawn"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch</label>
                                    <input
                                    name="ip_branch"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2"> Account Number</label>
                                    <input
                                    name="ip_ac"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <p>
                                    Cheque should be crossed A/C Payee & drawn payable to
                                    “MUFG Bank, Ltd. A/C - Account Name” and should be
                                    from own account with other bank. Please ensure that
                                    signature(s) on funding cheque match with the
                                    specimen signature (s) provided to the bank.
                                  </p>
                                </div>

                                <div class="col-12">
                                  <h5><strong>B. Inward Remittance</strong></h5>
                                </div>

                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Remitter</label>
                                    <input
                                    name="ipr_name"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <div class="col-12 ">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Address</label>
                                    <input
                                    name="ipr_addr"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Currency and Amount</label>
                                    <input
                                    name="ipr_cur_amnt"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Remitting Bank and Branch Address</label>
                                    <input
                                    name="ipr_bank_addr"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                              </div>
                            </div>
                          </form>

                          <button
                            id="aoc_fs_eleven"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>
                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 11 ends -->

                      <!-- fieldset -12- id - introducer details -->
                      @if($enabledForms->form_12 == 1)
                        <fieldset id="fs_twelve">
                          <form
                            id="ao_fs_twelve"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">Introducer Details:</h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 12 - 15</h2>
                                </div>
                              </div>

                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of Introducing customer</label>
                                    <input
                                    name="int_name"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account number of the Introducer</label>
                                    <input
                                    name="int_ac"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">I/We confirm that I/We maintain an account with MUFG Bank, Ltd.</label>
                                    <input
                                    name="int_branch"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      _Branch for over 12 months. I/We personally know the
                                      applicant(s) detailed in the Application form for
                                      more than 6 months and confirm his/her /their
                                      identity, occupation and address.
                                    </label>
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of Introducer:</label>
                                    <input
                                    name="int_sign"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date:</label>
                                    <input
                                    name="int_date"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Place:</label>
                                    <input
                                    name="int_place"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>

                          <button
                            id="aoc_fs_twelve"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 12 ends -->

                      <!-- fieldset -13--ma-minor account-->
                      @if($enabledForms->form_13 == 1)
                        <fieldset id="fs_thirteen">
                          <form
                            id="ao_fs_thirteen"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">
                                    Minor Declaration (In case of Minor, Please submit
                                    copies of identification and address document for the
                                    Guardian.)
                                  </h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 13 - 15</h2>
                                </div>
                              </div>

                              <div class="flex flex-wrap -mx-3">
                                <h5 class="col-sm-12 my-3 border-bottom-1 pb-2"> </h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      I hereby declare that the date of birth of
                                      the minor who is my
                                    </label>

                                    <input
                                    name="mc_dated"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">

                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      and I am his/her natural and lawful
                                      Guardian / Guardian appointed by court
                                      order dated
                                    </label>

                                    <input
                                    name="mc_date"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">

                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      (copy enclosed). I shall represent the said minor
                                      in all future transactions of any description in
                                      the above account until the said minor attains
                                      majority. I, indemnify the Bank against the claim
                                      of the above minor for any withdrawal/transactions
                                      made by me in his/her account. Upon attaining
                                      majority, I undertake to produce the minor at the
                                      Bank along with required documents for conversion
                                      of account status from minor to major and shall
                                      not operate the account further on behalf of the
                                      minor. I understand that the Bank may temporarily
                                      freeze operations in the account until the
                                      required formalities have been fulfilled by
                                      me/minor turned major.
                                    </label>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of Parent / Guardian</label>
                                    <input
                                    name="mc_ward_sign"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date:</label>
                                    <input
                                    name="mc_dob"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Name of Parent / Guardian:</label>
                                    <input
                                    name="mc_ward"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>

                          <button
                            id="aoc_fs_thirteen"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset><!--/ fieldset 13 ends -->
                      @endif

                      <!-- fieldset -14- sc-senior citizen details-->
                      @if($enabledForms->form_14 == 1)
                        <fieldset id="fs_fourteen">
                          <form
                            id="ao_fs_fourteen"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <h5
                                  class="col-sm-12 my-3 border-bottom-1 pb-2">
                                  Senior Citizen Declaration
                                </h5>

                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      I/We, hereby undertake and declare that I/we
                                      qualify as a Senior Citizen as per the prevailing
                                      rules and regulations. I/We further state that the
                                      documents/statements/declarations furnished/made by
                                      me/us to MUFG Bank, Ltd.,
                                    </label>

                                    <input
                                    name="sc_branch_one"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch or as represented herein are true and
                                      correct. Further, in the event any of the
                                      documents/statements/declarations are found to be
                                      incorrect in material particular or otherwise,
                                      I/We hereby undertake to indemnify MUFG Bank, Ltd.,
                                    </label>

                                    <input
                                    name="sc_branch_two"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">

                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Branch for all times hereafter against all
                                      losses, costs, claims, actions, demands, risks,
                                      charges, expenses, damages etc., whatsoever which
                                      the Bank may suffer and/ or incur on account of the
                                      representations being made by me/us.
                                    </label>
                                  </div>
                                </div>

                                <div class="col-sm-4">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of 1st Applicant</label>
                                    <input
                                    name="sc_app_one"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-sm-4">
                                  <div class="mb-6">
                                    <input
                                    name="sc_app_two"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-sm-4">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Signature of 3rd Applicant</label>
                                    <input
                                    name="sc_app_three"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <button
                            id="aoc_fs_fourteen"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 14 ends -->

                      <!-- fieldset 15 kyc-know your customer -->
                      @if($enabledForms->form_15 == 1)
                        <fieldset id="fs_fifteen">
                          <form
                            id="ao_fs_fifteen"
                            method="POST"
                            action="">
                            @csrf
                            <div class="form-card text-left">
                              <div class="flex flex-wrap -mx-3">
                                <div class="col-7">
                                  <h5 class="mb-6">
                                    Know Your Customer (KYC) Details
                                  </h5>
                                </div>
                                <div class="col-5">
                                  <h2 class="steps">Step 14 - 15</h2>
                                </div>
                              </div>

                              <div class="row col-sm-12">
                                <h5 class="col-sm-12 my-3 border-bottom-1 pb-2">First Applicant</h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Document submitted for Proof of Identity / Address
                                    </label>
                                    <input
                                    name="kyc_proof"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Document Identification No. (If Any)</label>
                                    <input
                                    name="kyc_doc_no"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Place of Issue</label>
                                    <input
                                    name="kyc_place"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Issue</label>
                                    <input
                                    name="kyc_issue_date"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Expiry</label>
                                    <input
                                    name="kyc_exp_date"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <h5 class="col-sm-12 mt-6 pb-2">
                                  1. Purpose of Account Opening:
                                </h5>

                                <div class="col-12">
                                  <div class="mb-6">
                                    <select
                                    name="kyc_purpose"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Salary</option>
                                      <option value="2">Loan Repayment</option>
                                      <option value="3">Business</option>
                                      <option value="4">Basic Household Expenses</option>
                                      <option value="5">Investment</option>
                                      <option value="6">Other</option>
                                    </select>
                                  </div>
                                </div>


                                <h5 class="col-sm-12 mt-6 pb-2">2. Expected Source of Funds:</h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <select
                                    name="kyc_source"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                      <option value="0">--select--</option>
                                      <option value="1">Salary Receipts</option>
                                      <option value="2">Business Income</option>
                                      <option value="3">Income from Investments</option>
                                      <option value="4">Consultation / Professional Fees</option>
                                      <option value="5">Savings</option>
                                      <option value="6">Rental Income</option>
                                      <option value="7">Interest / Dividend Income</option>
                                      <option value="8">Inheritance</option>
                                      <option value="9">Others</option>
                                    </select>
                                  </div>
                                </div>


                                <h5 class="col-sm-12 mt-6 pb-2">
                                  3. Expected Account Turnover (INR)
                                </h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <input
                                    name="kyc_ac_to"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <h5 class="col-sm-12 mt-6 pb-2">
                                  4. Expected Number of Transactions per year
                                </h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <input
                                    name="kyc_transaction"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <h5 class="col-sm-12 mt-6 pb-2">5. Expected Account Activity:</h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <input
                                    name="kyc_activity"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                                <h5 class="col-sm-12 mt-6 pb-2">
                                  6. Whether existing account holder
                                </h5>
                                <div class="col-12">
                                  <div class="radio d-inline-block mr-2">
                                    <input
                                    type="radio"
                                    name="kyc_exist_ac"
                                    value="1"
                                    id="radio1"
                                    checked="">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                  </div>
                                  <div class="radio d-inline-block mr-2">
                                    <input
                                    name="kyc_exist_ac"
                                    value="2"
                                    type="radio"
                                    name="bsradio"
                                    id="radio2" >
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Customer ID</label>
                                    <input
                                    name="kyc_cust_id"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Number</label>
                                    <input
                                    name="kyc_ac"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <h5 class="col-sm-12 mt-6 pb-2">
                                  7. Whether Letter of Authority/Power of Attorney given
                                  to another person
                                </h5>
                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Whether account(s) held by the applicant(s) with
                                      any other bank(s)
                                    </label>
                                    <div class="radio d-inline-block mr-2">
                                      <input
                                      type="radio"
                                      name="kyc_auth"
                                      id="radio1"
                                      value="1"
                                      checked="">
                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2">Yes</label>
                                    </div>
                                    <div class="radio d-inline-block mr-2">
                                      <input
                                      type="radio"
                                      name="kyc_auth"
                                      value="2"
                                      id="radio2" >
                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2">No</label>
                                    </div>
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Please provide POA Holder’s name</label>
                                    <input
                                    name="kyc_poa"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Date of Birth</label>
                                    <input
                                    name="kyc_dob"
                                    type="date"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Address</label>
                                    <input
                                    name="kyc_addr"
                                    type="text"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>


                                <div class="col-12">
                                  <div class="mb-6">
                                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                      Identification document(for confirmation of name,
                                      date of birth and address)
                                    </label>
                                    <input
                                    name="kyc_proof_doc"
                                    type="file"
                                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                  </div>
                                </div>

                              </div>
                            </div>
                          </form>

                          <button
                            id="aoc_fs_fifteen"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button
                            float-right"
                            value="Next">
                            Continue
                          </button>

                          <button
                            type="button"
                            name="previous"
                            class="
                            btn
                            btn-dark
                            previous
                            action-button-previous
                            float-right
                            mr-3"
                            value="Previous">
                            Previous
                          </button>
                        </fieldset>
                      @endif<!--/ fieldset 15 ends -->

                      <!-- final step-->
                      <fieldset>
                        <div class="form-card text-left">
                          <div class="flex flex-wrap -mx-3">
                            <div class="col-7">
                              <h5 class="mb-6">Final Step</h5>
                            </div>
                            <div class="col-5">
                              <h2 class="steps">Step 15 - 15</h2>
                            </div>
                          </div>

                          <div class="row col-sm-12">
                            <div class="col-12">
                              <textarea
                                class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                style="
                                height: 500px;
                                line-height:20px;
                                margin-bottom: 35px;"
                                readonly="readonly">
                                Foreign Exchange Management Act, 1999 (FEMA)
                                ----------------------------------------------
                                I/We hereby declare that the transactions relating to
                                foreign exchange routed through your Bank do not involve,
                                and are not designed for the purpose of any contravention
                                or evasion of the provisions of the aforesaid Act or of
                                any rule, regulation, direction, or order made here
                                under. I/We also hereby agree and undertake to give such
                                information/ documents as will reasonably satisfy you
                                about the transactions in terms of the above declaration.

                                Authority For Collection of Cheque/Drafts/Documents
                                ----------------------------------------------
                                I/We may have occasion from time-to-time to hand over
                                to you for collection or negotiation Cheques, Drafts or
                                Bills of Exchange (with or without documents attached)
                                and I/we hereby agree to your forwarding the same to your
                                agents for the time being for collection or negotiation.
                                In the event of your having no independent collecting
                                agent at any centre, I/we hereby authorize you to send
                                cheques, drafts, etc. by mail directly to the drawee bank
                                itself.
                                I/We agree and undertake to hold you harmless, free from
                                any responsibility and indemnified for any loss suffered
                                by you in handling this business or transactions due to
                                any cause whatsoever including delay in transit
                                presentation, payment or default by your agent.
                                In addition to your ordinary rights as holder of such
                                Cheques, Drafts or Bill of Exchange, you are authorized
                                to accept in payment thereof a banker’s cheque or banker’s
                                cheques payable at your station or at other places and
                                in the event of such cheque(s) not being paid on
                                presentation to debit the amount to our account with all
                                charges incurred thereon. I/We confirm that you can
                                present Bills and receive the amount in respect thereof
                                in accordance with the usage of the place where the Bills
                                are made payable. It is understood that these transactions
                                are in all respects at my/our entire risk and
                                responsibility.

                                Customer Declaration
                                -----------------------------------------------
                                I/We hereby acknowledge that I/we have received, read and
                                understood the Bank’s prevailing Terms, Conditions and
                                Rules Governing Deposit Account and Schedule of Fees and
                                Charges relating to the above account being opened by
                                me/ us.
                                I/We agree to abide by the same as amended from
                                time-to-time and further agree to abide by any additional
                                terms and conditions governing any facilities, products
                                and/or services offered by the Bank as I/we may apply for
                                and/or utilize from time to time.
                                I/We agree to abide by the rules/provisions as prescribed
                                by the Reserve Bank of India from time-to-time.
                                I/We hereby confirm having opted/chosen to get Statement
                                of Account monthly/periodically issued by the Bank
                                pertaining to the Account to be opened pursuant to this
                                Application.
                                I/We also confirm not to commence or undertake any
                                activity/transaction which is not permissible under the
                                prevalent Foreign Direct Investment Policy or any other
                                applicable Policy or guidelines of the Government of
                                India/Reserve Bank of India save and except after
                                obtaining specific prior approval from the concerned
                                authorities under advice to the Bank.
                                I/We hereby confirm and declare that in relation to any
                                Transaction, Dealing(s), Credit including advise or
                                confirmation of the same, the obligations of the Bank
                                shall be subject to the condition that the terms thereof
                                including any document or drafts do not contain state or
                                mention, including without limitation:
                                (i) Any countries, organizations, entities, or
                                individuals (under any law) relating to any sanction
                                parties listed under United Nation, European Union,
                                United States of America, Japan, India and other
                                authorities;
                                (ii) Any goods of origin from sanction countries listed
                                under United Nation, European Union, United States of
                                America, Japan, India and other authorities;
                                (iii) Any prohibited goods under the list of United
                                Nation, European Union, United States of America, Japan,
                                India and other authorities;
                                (iv) Any place or loading, place of discharge, or place
                                of transhipment under the list of United Nation, European
                                Union, United States of America, Japan, India and other
                                authorities; and/or
                                (v) Any vessel or carrier relating to any sanction parties
                                listed under United Nation, European Union, United States
                                of America, Japan, India and other authorities.

                                I/We shall maintain the minimum balance requirement as
                                applicable at all times and the Bank shall levy
                                prescribed charges in case of non-maintenance of minimum
                                balance. In case of change of mailing address and
                                other contact details, the same shall be communicated to
                                the Bank in writing.
                                It is understood that the above account will be opened
                                on the basis of the statements, declarations made by
                                me/us and I/We represent that the information provided
                                by me/us in this application form and in any other
                                document(s) provided by me/us to the Bank is true,
                                accurate and complete.
                                I/We acknowledge that the Bank may decline my/our
                                application without providing any reason in which event
                                no contractual relationship will arise between the Bank
                                and me/us.
                              </textarea>
                            </div>
                          </div>
                        </div>
                        <button
                          type="button"
                          class="
                          btn
                          btn-primary
                          next
                          action-button
                          float-right
                          mr-5"
                          value="Submit">
                          Submit
                        </button>
                      </fieldset><!--/ final step ends -->

                      <!-- success message -->
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
                      </fieldset><!--/ success message ends -->
                    </div><!--/ reg form ends -->
                  </div><!--/ col for form ends -->
                </div><!--/ row ends -->
              </div><!--/signin form ends -->
            </div><!--/ main col ends -->
          </div><!--/ main row ends -->
        </div><!--/ main wrapper col ends -->
      </div><!--/ main wrapper row ends -->
    </div><!--/ main wrapper container ends -->
  </section><!--/ registration section ends -->

  <!-- resume reg modal-->
  <div
    class="modal"
    id="resumeotp"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-card text-left">

            <div class="flex flex-wrap -mx-3">
              <div class="col-12">
                <h4 class="text-center">Resume Registration</h4>
                <p class="text-center">
                  Enter the Registration Number from the previous process you
                  started to resume that
                </p>
                </div>
            </div>

            <div class="row justify-content-center">
              <div class="w-full md:w-1/2 px-3">
                <div class="mb-6">
                  <input
                    type="text"
                    class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                    name="fname"
                    placeholder="Enter registration no.">
                </div>
                <div class="text-center">
                  <button
                    type="button"
                    class="btn btn-success mt-2">
                    Submit
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div><!--/ resume reg modal ends -->
 <div id="open-error" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- Parsley form validation -->
<script type="text/javascript">

</script>
@endsection
