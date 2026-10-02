@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Account Manager</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Account Manager</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Account Manager</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Edit Account Manager Form</h4>
                                    <p class="card-description">Enter all the account manager Information</p>
                                    <form action="{{ asset('update-account-manager') }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" name = "editid" value = "{{ $am[0]->id }}">
                                        <input type = "hidden" name = "current_photo" value = "{{ $am[0]->photo }}">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Full Name</label>
                                            <input type="text" class="form-control" name="fullname" id="fullname" required value="{{ $am[0]->name }}" placeholder="Full Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword4">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="email" required value="{{ $am[0]->email }}" placeholder="Email Address" />
                                        </div>
                                        <div class="col-md-2" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important;">
                                            <div class="form-group">
                                                <label for="exampleSelectGender">Code</label>
                                                <select class="form-control" name="code" id="code" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important;">
                                            <div class="form-group">
                                                <label for="exampleInputEmail3">Phone Number</label>
                                                <input type="text" class="form-control" name="phone" id="phone" required value="{{ $am[0]->phone }}" placeholder="Phone Number" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Photo</label>
                                            <input type="file" name="photo" id="photo" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                    placeholder="Upload Photo">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-gradient-primary"
                                                        type="button">Upload</button>
                                                </span>
                                            </div>
                                            Current Photo: <img src="{{ $am[0]->photo }}" style="width: 100px;" />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                        <a href="view-customer" class="btn btn-light">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- content-wrapper ends -->


                <!-- partial:../../partials/_footer.html -->
                @include('footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->










    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>
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
    var currentCode = "{{ $am[0]->countrycode }}";
    var content = '<option value="">Code</option>';
    for(var code in codes) {
        var extra = '';
        if(currentCode === '+' + codes[code].dial_code) {
            var extra = 'selected';
        }
        content += '<option value="+'+codes[code].dial_code+'" ' + extra + '>+'+codes[code].dial_code+' (' + codes[code].country + ')</option>';
    }
    $('#code').append(content);
    $('#code_confirm').append(content);
});
</script>  
</body>

</html>