<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('viewProfile') }}">Identity Overview</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold"><?php if($type == 'update'){ ?>Security Verification<?php }else{ ?>Modify Information<?php } ?></span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">
                    <?php if($type == 'update'){ ?>Identity Verification Challenge<?php }else{ ?>Update Legal Profile<?php } ?>
                </h1>
                <p class="text-sm text-[#53625b] mt-1">Manage and certify personal custody identification metadata under banking regulations.</p>
            </div>
            <a href="{{ url('viewProfile') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#f2f4f3] hover:bg-[#e6e9e8] text-[#191c1c] text-xs font-bold transition-all">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Back to Profile</span>
            </a>
        </div>
        
        <div class="mt-4">
            @include('flash::message')
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] mb-8 overflow-hidden">
        <div class="p-6 sm:p-8">
            <?php if($type == 'update'){ ?>
                <form action="editProfileVerify" class="profile-update-form" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <input type="hidden" name="cust_name" value="<?php echo $cust_name ?>" />
                        <input type="hidden" name="idnumber" value="<?php echo $idnumber ?>" />
                        <input type="hidden" name="cust_dob" value="<?php echo $cust_dob ?>" />
                        <input type="hidden" name="mother_maiden" value="<?php echo $mother_maiden ?>" />
                        <input type="hidden" name="cust_mail" value="<?php echo $cust_mail ?>" />
                        <input type="hidden" name="cust_address" value="<?php echo $cust_address ?>" />
                        <input type="hidden" name="cust_city" value="<?php echo $cust_city ?>" />
                        <input type="hidden" name="cust_state" value="<?php echo $cust_state ?>" />
                        <input type="hidden" name="cust_country" value="<?php echo $cust_country ?>" />
                        <input type="hidden" name="post_code" value="<?php echo $post_code ?>" />
                        <input type="hidden" name="max_amount" value="<?php echo $max_amount ?>" />
                        <input type="hidden" name="cust_phone" value="<?php echo $cust_phone ?>" />
                        <input type="hidden" name="cust_countrycode" value="<?php echo $cust_countrycode ?? ($customer[0]->cust_countrycode ?? '') ?>" />
                        <input type="hidden" name="redType" value="old" />
                        
                        <div class="max-w-md mx-auto py-6 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#e8f7ee] border border-[#aaf2c4] text-[#004226] flex items-center justify-center mx-auto mb-4">
                                <span class="material-symbols-outlined text-[32px]">shield</span>
                            </div>
                            <h3 class="text-lg font-bold font-headline text-[#191c1c] mb-2">Two-Factor Authorization</h3>
                            <p class="text-xs text-[#53625b] mb-6">A one-time cryptographic authorization token has been dispatched to your verified communication channel. Please authorize to persist profile alterations.</p>
                            
                            <div class="mb-6 text-left">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Security Verification Token</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3.5 px-4 text-[#191c1c] font-mono tracking-widest text-center text-lg outline-none transition-all placeholder-[#53625b]/40" name="otp" required value="" placeholder="• • • • • •" autocomplete="one-time-code">
                            </div>
                            
                            <button type="submit" id="verify" class="w-full bg-[#004226] hover:bg-[#0f5b38] text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>Authorize & Apply Changes</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            <?php }else{ ?>
                <form action="editProfile" class="profile-update-form" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                        <input type="hidden" name="redType" value="new" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Legal Entity / Full Name</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="cust_name" required value="{{ $customer[0]->cust_name }} {{$customer[0]->middle_name}} {{$customer[0]->sur_name}}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">National ID / Passport Number</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-mono font-semibold text-[#191c1c] outline-none transition-all" name="idnumber" required value="{{ $customer[0]->idnumber ?? '' }}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Date of Birth (YYYY-MM-DD)</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-mono font-semibold text-[#191c1c] outline-none transition-all" name="cust_dob" required value="{{ $customer[0]->dob ?? '' }}">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Mother's Maiden Name</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="mother_maiden" required value="{{ $customer[0]->mother_maiden ?? '' }}">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Primary Registered Email</label>
                                <input type="email" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="cust_mail" required value="{{ $customer[0]->cust_mail ?? ($customer[0]->cust_email ?? '') }}">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Telephone Number</label>
                                <div class="flex gap-2">
                                    <select class="w-1/3 bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-3 text-xs font-semibold text-[#191c1c] outline-none transition-all cursor-pointer" name="cust_countrycode" id="code" required >
                                    </select>
                                    <input type="text" class="w-2/3 bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-mono font-semibold text-[#191c1c] outline-none transition-all numbers" name="cust_phone" id="phone" value="{{ $customer[0]->cust_phone ?? '' }}" required>
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <div class="w-full border-t border-[#f2f4f3] my-2"></div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Street Address</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="cust_address" required value="{{ $customer[0]->cust_address ?? '' }}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">City</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="cust_city" required value="{{ $customer[0]->cust_city ?? '' }}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">State / Province / Canton</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all" name="cust_state" required value="{{ $customer[0]->cust_state ?? '' }}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Country / Jurisdiction</label>
                                <select class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-xs font-semibold text-[#191c1c] outline-none transition-all cursor-pointer" name="cust_country" id="country" required>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Postal / Zip Code</label>
                                <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-mono font-semibold text-[#191c1c] outline-none transition-all" name="post_code" required value="{{ $customer[0]->post_code ?? '' }}">
                            </div>

                            <!-- Hidden Max Withdrawal Amount -->
                            <div style="display:none;">
                                <input type="text" name="max_amount" required value="{{ $customer[0]->max_amount ?? 50000 }}">
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-[#f2f4f3] flex items-center justify-end gap-4">
                            <a href="{{ url('viewProfile') }}" class="px-6 py-3 rounded-xl border border-[#e6e9e8] text-[#53625b] hover:bg-[#f8faf9] text-xs font-bold transition-all">
                                Cancel
                            </a>
                            <button type="submit" id="verify" class="bg-[#004226] hover:bg-[#0f5b38] text-white font-bold py-3 px-8 rounded-xl transition-all shadow-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                <span>Save & Submit Changes</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<script>
var codes = {"AF":{"country":"Afghanistan","dial_code":"93"},"AL":{"country":"Albania","dial_code":"355"},"DZ":{"country":"Algeria","dial_code":"213"},
"AS":{"country":"American Samoa","dial_code":"1"},"AD":{"country":"Andorra","dial_code":"376"},"AO":{"country":"Angola","dial_code":"244"},
"AI":{"country":"Anguilla","dial_code":"1"},"AG":{"country":"Antigua and Barbuda","dial_code":"1"},"AR":{"country":"Argentina","dial_code":"54"},
"AM":{"country":"Armenia","dial_code":"374"},"AW":{"country":"Aruba","dial_code":"297"},"AC":{"country":"Ascension","dial_code":"247"},
"AU":{"country":"Australia","dial_code":"61"},"AX":{"country":"Australian External Territories","dial_code":"672"},"AT":{"country":"Austria","dial_code":"43"},
"AZ":{"country":"Azerbaijan","dial_code":"994"},"BS":{"country":"Bahamas","dial_code":"1"},"BH":{"country":"Bahrain","dial_code":"973"},
"BD":{"country":"Bangladesh","dial_code":"880"},"BB":{"country":"Barbados","dial_code":"1"},"BY":{"country":"Belarus","dial_code":"375"},"BE":{"country":"Belgium","dial_code":"32"},
"BZ":{"country":"Belize","dial_code":"501"},"BJ":{"country":"Benin","dial_code":"229"},"BM":{"country":"Bermuda","dial_code":"1"},"BT":{"country":"Bhutan","dial_code":"975"},
"BO":{"country":"Bolivia","dial_code":"591"},"BA":{"country":"Bosnia and Herzegovina","dial_code":"387"},"BW":{"country":"Botswana","dial_code":"267"},
"BR":{"country":"Brazil","dial_code":"55"},"VG":{"country":"British Virgin Islands","dial_code":"1"},"BN":{"country":"Brunei Darussalam","dial_code":"673"},
"BG":{"country":"Bulgaria","dial_code":"359"},"BF":{"country":"Burkina Faso","dial_code":"226"},"BI":{"country":"Burundi","dial_code":"257"},
"KH":{"country":"Cambodia","dial_code":"855"},"CM":{"country":"Cameroon","dial_code":"237"},"CA":{"country":"Canada","dial_code":"1"},"CV":{"country":"Cape Verde","dial_code":"238"},
"KY":{"country":"Cayman Islands","dial_code":"1"},"CF":{"country":"Central African Republic","dial_code":"236"},"TD":{"country":"Chad","dial_code":"235"},
"CL":{"country":"Chile","dial_code":"56"},"CN":{"country":"China","dial_code":"86"},"CO":{"country":"Colombia","dial_code":"57"},"KM":{"country":"Comoros","dial_code":"269"},
"CG":{"country":"Congo","dial_code":"242"},"CK":{"country":"Cook Islands","dial_code":"682"},"CR":{"country":"Costa Rica","dial_code":"506"},
"CI":{"country":"Cote d'Ivoire","dial_code":"225"},"HR":{"country":"Croatia","dial_code":"385"},"CU":{"country":"Cuba","dial_code":"53"},"CW":{"country":"Curacao","dial_code":"599"},
"CY":{"country":"Cyprus","dial_code":"357"},"CZ":{"country":"Czech Republic","dial_code":"420"},"CD":{"country":"Democratic Republic of the Congo","dial_code":"243"},
"DK":{"country":"Denmark","dial_code":"45"},"DG":{"country":"Diego Garcia","dial_code":"246"},"DJ":{"country":"Djibouti","dial_code":"253"},
"DM":{"country":"Dominica","dial_code":"1"},"DO":{"country":"Dominican Republic","dial_code":"1"},"TL":{"country":"East Timor","dial_code":"670"},
"EC":{"country":"Ecuador","dial_code":"593"},"EG":{"country":"Egypt","dial_code":"20"},"SV":{"country":"El Salvador","dial_code":"503"},
"GQ":{"country":"Equatorial Guinea","dial_code":"240"},"ER":{"country":"Eritrea","dial_code":"291"},"EE":{"country":"Estonia","dial_code":"372"},
"ET":{"country":"Ethiopia","dial_code":"251"},"FK":{"country":"Falkland Islands","dial_code":"500"},"FO":{"country":"Faroe Islands","dial_code":"298"},
"FJ":{"country":"Fiji","dial_code":"679"},"FI":{"country":"Finland","dial_code":"358"},"FR":{"country":"France","dial_code":"33"},"GF":{"country":"French Guiana","dial_code":"594"},
"PF":{"country":"French Polynesia","dial_code":"689"},"GA":{"country":"Gabon","dial_code":"241"},"GM":{"country":"Gambia","dial_code":"220"},
"GE":{"country":"Georgia","dial_code":"995"},"DE":{"country":"Germany","dial_code":"49"},"GH":{"country":"Ghana","dial_code":"233"},"GI":{"country":"Gibraltar","dial_code":"350"},
"GR":{"country":"Greece","dial_code":"30"},"GL":{"country":"Greenland","dial_code":"299"},"GD":{"country":"Grenada","dial_code":"1"},"GP":{"country":"Guadeloupe","dial_code":"590"},
"GU":{"country":"Guam","dial_code":"1"},"GT":{"country":"Guatemala","dial_code":"502"},"GN":{"country":"Guinea","dial_code":"224"},"GW":{"country":"Guinea-Bissau","dial_code":"245"},
"GY":{"country":"Guyana","dial_code":"592"},"HT":{"country":"Haiti","dial_code":"509"},"HN":{"country":"Honduras","dial_code":"504"},"HK":{"country":"Hong Kong","dial_code":"852"},
"HU":{"country":"Hungary","dial_code":"36"},"IS":{"country":"Iceland","dial_code":"354"},"IN":{"country":"India","dial_code":"91"},
"ID":{"country":"Indonesia","dial_code":"62"},"IR":{"country":"Iran","dial_code":"98"},"IQ":{"country":"Iraq","dial_code":"964"},"IE":{"country":"Ireland","dial_code":"353"},
"IL":{"country":"Israel","dial_code":"972"},"IT":{"country":"Italy","dial_code":"39"},"JM":{"country":"Jamaica","dial_code":"1"},"JP":{"country":"Japan","dial_code":"81"},
"JO":{"country":"Jordan","dial_code":"962"},"KZ":{"country":"Kazakhstan","dial_code":"7"},"KE":{"country":"Kenya","dial_code":"254"},"KI":{"country":"Kiribati","dial_code":"686"},
"KW":{"country":"Kuwait","dial_code":"965"},"KG":{"country":"Kyrgyzstan","dial_code":"996"},"LA":{"country":"Laos","dial_code":"856"},"LV":{"country":"Latvia","dial_code":"371"},
"LB":{"country":"Lebanon","dial_code":"961"},"LS":{"country":"Lesotho","dial_code":"266"},"LR":{"country":"Liberia","dial_code":"231"},"LY":{"country":"Libya","dial_code":"218"},
"LI":{"country":"Liechtenstein","dial_code":"423"},"LT":{"country":"Lithuania","dial_code":"370"},"LU":{"country":"Luxembourg","dial_code":"352"},
"MO":{"country":"Macao","dial_code":"853"},"MK":{"country":"Macedonia","dial_code":"389"},"MG":{"country":"Madagascar","dial_code":"261"},"MW":{"country":"Malawi","dial_code":"265"},
"MY":{"country":"Malaysia","dial_code":"60"},"MV":{"country":"Maldives","dial_code":"960"},"ML":{"country":"Mali","dial_code":"223"},"MT":{"country":"Malta","dial_code":"356"},
"MH":{"country":"Marshall Islands","dial_code":"692"},"MQ":{"country":"Martinique","dial_code":"596"},"MR":{"country":"Mauritania","dial_code":"222"},
"MU":{"country":"Mauritius","dial_code":"230"},"MX":{"country":"Mexico","dial_code":"52"},"FM":{"country":"Micronesia","dial_code":"691"},"MD":{"country":"Moldova","dial_code":"373"},
"MC":{"country":"Monaco","dial_code":"377"},"MN":{"country":"Mongolia","dial_code":"976"},"ME":{"country":"Montenegro","dial_code":"382"},"MS":{"country":"Montserrat","dial_code":"1"},
"MA":{"country":"Morocco","dial_code":"212"},"MZ":{"country":"Mozambique","dial_code":"258"},"MM":{"country":"Myanmar","dial_code":"95"},
"NA":{"country":"Namibia","dial_code":"264"},"NR":{"country":"Nauru","dial_code":"674"},"NP":{"country":"Nepal","dial_code":"977"},"NL":{"country":"Netherlands","dial_code":"31"},
"AN":{"country":"Netherlands Antilles","dial_code":"599"},"NC":{"country":"New Caledonia","dial_code":"687"},"NZ":{"country":"New Zealand","dial_code":"64"},
"NI":{"country":"Nicaragua","dial_code":"505"},"NE":{"country":"Niger","dial_code":"227"},"NG":{"country":"Nigeria","dial_code":"234"},"NU":{"country":"Niue","dial_code":"683"},
"KP":{"country":"North Korea","dial_code":"850"},"MP":{"country":"Northern Mariana Islands","dial_code":"1"},"NO":{"country":"Norway","dial_code":"47"},
"OM":{"country":"Oman","dial_code":"968"},"PK":{"country":"Pakistan","dial_code":"92"},"PW":{"country":"Palau","dial_code":"680"},"PS":{"country":"Palestine","dial_code":"970"},
"PA":{"country":"Panama","dial_code":"507"},"PG":{"country":"Papua New Guinea","dial_code":"675"},"PY":{"country":"Paraguay","dial_code":"595"},
"PE":{"country":"Peru","dial_code":"51"},"PH":{"country":"Philippines","dial_code":"63"},"PL":{"country":"Poland","dial_code":"48"},"PT":{"country":"Portugal","dial_code":"351"},
"PR":{"country":"Puerto Rico","dial_code":"1"},"QA":{"country":"Qatar","dial_code":"974"},"RE":{"country":"Reunion","dial_code":"262"},"RO":{"country":"Romania","dial_code":"40"},
"RU":{"country":"Russia","dial_code":"7"},"RW":{"country":"Rwanda","dial_code":"250"},"SH":{"country":"Saint Helena","dial_code":"290"},
"KN":{"country":"Saint Kitts and Nevis","dial_code":"1"},"LC":{"country":"Saint Lucia","dial_code":"1"},"PM":{"country":"Saint Pierre and Miquelon","dial_code":"508"},
"VC":{"country":"Saint Vincent and Grenadines","dial_code":"1"},"WS":{"country":"Samoa","dial_code":"685"},"SM":{"country":"San Marino","dial_code":"378"},
"ST":{"country":"Sao Tome and Principe","dial_code":"239"},"SA":{"country":"Saudi Arabia","dial_code":"966"},"SN":{"country":"Senegal","dial_code":"221"},
"RS":{"country":"Serbia","dial_code":"381"},"SC":{"country":"Seychelles","dial_code":"248"},"SL":{"country":"Sierra Leone","dial_code":"232"},
"SG":{"country":"Singapore","dial_code":"65"},"SK":{"country":"Slovakia","dial_code":"421"},"SI":{"country":"Slovenia","dial_code":"386"},
"SB":{"country":"Solomon Islands","dial_code":"677"},"SO":{"country":"Somalia","dial_code":"252"},"ZA":{"country":"South Africa","dial_code":"27"},
"KR":{"country":"South Korea","dial_code":"82"},"SS":{"country":"South Sudan","dial_code":"211"},"ES":{"country":"Spain","dial_code":"34"},
"LK":{"country":"Sri Lanka","dial_code":"94"},"SD":{"country":"Sudan","dial_code":"249"},"SR":{"country":"Suriname","dial_code":"597"},
"SZ":{"country":"Swaziland","dial_code":"268"},"SE":{"country":"Sweden","dial_code":"46"},"CH":{"country":"Switzerland","dial_code":"41"},
"SY":{"country":"Syria","dial_code":"963"},"TW":{"country":"Taiwan","dial_code":"886"},"TJ":{"country":"Tajikistan","dial_code":"992"},
"TZ":{"country":"Tanzania","dial_code":"255"},"TH":{"country":"Thailand","dial_code":"66"},"TG":{"country":"Togo","dial_code":"228"},
"TK":{"country":"Tokelau","dial_code":"690"},"TO":{"country":"Tonga","dial_code":"676"},"TT":{"country":"Trinidad and Tobago","dial_code":"1"},
"TN":{"country":"Tunisia","dial_code":"216"},"TR":{"country":"Turkey","dial_code":"90"},"TM":{"country":"Turkmenistan","dial_code":"993"},
"TC":{"country":"Turks and Caicos Islands","dial_code":"1"},"TV":{"country":"Tuvalu","dial_code":"688"},"UG":{"country":"Uganda","dial_code":"256"},
"UA":{"country":"Ukraine","dial_code":"380"},"AE":{"country":"United Arab Emirates","dial_code":"971"},"GB":{"country":"United Kingdom","dial_code":"44"},
"US":{"country":"United States","dial_code":"1"},"UY":{"country":"Uruguay","dial_code":"598"},"VI":{"country":"US Virgin Islands","dial_code":"1"},
"UZ":{"country":"Uzbekistan","dial_code":"998"},"VU":{"country":"Vanuatu","dial_code":"678"},"VA":{"country":"Vatican City","dial_code":"379"},
"VE":{"country":"Venezuela","dial_code":"58"},"VN":{"country":"Vietnam","dial_code":"84"},"WF":{"country":"Wallis and Futuna","dial_code":"681"},
"YE":{"country":"Yemen","dial_code":"967"},"ZM":{"country":"Zambia","dial_code":"260"},"ZW":{"country":"Zimbabwe","dial_code":"263"}};
document.addEventListener('DOMContentLoaded', function(){
    var content = '<option value="">Select Country</option>';
    for(var code in codes) {
        content += '<option value="'+codes[code].country+'">'+codes[code].country+'</option>';
    }
    $('#country').append(content);
    <?php if(isset($customer)){ ?>
        $('#country').val('<?= $customer[0]->cust_country ?>');
    <?php } ?>    
    var content = '<option value="">Code</option>';
    for(var code in codes) {
        content += '<option value="+'+codes[code].dial_code+'">+'+codes[code].dial_code+' (' + codes[code].country + ')</option>';
    }
    $('#code').append(content);
    <?php if(isset($customer)){ ?>
        $('#code').val('<?= $customer[0]->cust_countrycode ?? ($cust_countrycode ?? '') ?>');
    <?php } ?>
    $('#code_confirm').append(content);
});
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
