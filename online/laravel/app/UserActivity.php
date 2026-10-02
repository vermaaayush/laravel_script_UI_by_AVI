<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use Request;

class UserActivity extends Model
{
    public static function saveUserActivity($customer,$activity){
        
        
        
        try 
        {
        $ip = ""; $country = "";$city = "";$browser = "";$os = "";
        if(Request::ip() && Request::ip() != null){
            $ip = Request::ip();
        }    
        $ipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
        //$ipdata = json_decode(file_get_contents("http://ipinfo.io/?ip=".$ip));
        if($ipdata && $ipdata != null && $ipdata != "")
            {
            $country    = $ipdata->geoplugin_countryName;
            $city       = $ipdata->geoplugin_city;
            
            //$country    = $ipdata->country;
            //$city       = $ipdata->city;
            }
                        
                        
        } catch (\Throwable $th) 
        {
            $country    = null;
            $city       = null;
            $ip = null;
                         
        }
        
        
        
        $browser    = static::getBrowser();
        $os         = static::getOS();
        $data = [
            'customer'      => $customer,
            'activity'      => $activity,
            'ip'            => $ip,
            'country'       => $country,
            'city'          => $city,
            'browser'       => $browser,
            'os'            => $os,
            'cat'           => date('Y-m-d H:i:s')
        ];
        DB::table('ba_user_activities')->insert($data);
    }
    
    private static function getOS($user_agent = null)
    {
        if(!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }
    
        // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
        $os_array = [
            'windows nt 10'                              =>  'Windows 10',
            'windows nt 6.3'                             =>  'Windows 8.1',
            'windows nt 6.2'                             =>  'Windows 8',
            'windows nt 6.1|windows nt 7.0'              =>  'Windows 7',
            'windows nt 6.0'                             =>  'Windows Vista',
            'windows nt 5.2'                             =>  'Windows Server 2003/XP x64',
            'windows nt 5.1'                             =>  'Windows XP',
            'windows xp'                                 =>  'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000'  =>  'Windows 2000',
            'windows me'                                 =>  'Windows ME',
            'windows nt 4.0|winnt4.0'                    =>  'Windows NT',
            'windows ce'                                 =>  'Windows CE',
            'windows 98|win98'                           =>  'Windows 98',
            'windows 95|win95'                           =>  'Windows 95',
            'win16'                                      =>  'Windows 3.11',
            'mac os x 10.1[^0-9]'                        =>  'Mac OS X Puma',
            'macintosh|mac os x'                         =>  'Mac OS X',
            'mac_powerpc'                                =>  'Mac OS 9',
            'linux'                                      =>  'Linux',
            'ubuntu'                                     =>  'Linux - Ubuntu',
            'iphone'                                     =>  'iPhone',
            'ipod'                                       =>  'iPod',
            'ipad'                                       =>  'iPad',
            'android'                                    =>  'Android',
            'blackberry'                                 =>  'BlackBerry',
            'webos'                                      =>  'Mobile',
    
            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})'=>'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})'=>'Windows',
            '(win)([0-9]{2})'=>'Windows',
            '(windows)([0-9x]{2})'=>'Windows',
    
            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg
    
            'Win 9x 4.90'=>'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})'=>'Windows',
            'win32'=>'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'=>'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'=>'Solaris',
            'dos x86'=>'DOS',
            'Mac OS X'=>'Mac OS X',
            'Mac_PowerPC'=>'Macintosh PowerPC',
            '(mac|Macintosh)'=>'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})'=>'RISC OS',
            'unix'=>'Unix',
            'os/2'=>'OS/2',
            'freebsd'=>'FreeBSD',
            'openbsd'=>'OpenBSD',
            'netbsd'=>'NetBSD',
            'irix'=>'IRIX',
            'plan9'=>'Plan9',
            'osf'=>'OSF',
            'aix'=>'AIX',
            'GNU Hurd'=>'GNU Hurd',
            '(fedora)'=>'Linux - Fedora',
            '(kubuntu)'=>'Linux - Kubuntu',
            '(ubuntu)'=>'Linux - Ubuntu',
            '(debian)'=>'Linux - Debian',
            '(CentOS)'=>'Linux - CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - SUSE',
            '(Dropline)'=>'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)'=>'Linux - ASPLinux',
            '(Red Hat)'=>'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)'=>'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'=>'AmigaOS',
            'amiga-aweb'=>'AmigaOS',
            'amiga'=>'Amiga',
            'AvantGo'=>'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}'=>'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'=>'WebTV',
            'Dreamcast'=>'Dreamcast OS',
            'GetRight'=>'Windows',
            'go!zilla'=>'Windows',
            'gozilla'=>'Windows',
            'gulliver'=>'Windows',
            'ia archiver'=>'Windows',
            'NetPositive'=>'Windows',
            'mass downloader'=>'Windows',
            'microsoft'=>'Windows',
            'offline explorer'=>'Windows',
            'teleport'=>'Windows',
            'web downloader'=>'Windows',
            'webcapture'=>'Windows',
            'webcollage'=>'Windows',
            'webcopier'=>'Windows',
            'webstripper'=>'Windows',
            'webzip'=>'Windows',
            'wget'=>'Windows',
            'Java'=>'Unknown',
            'flashget'=>'Windows',
    
            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage'=>'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            'libwww-perl'=>'Unix',
            'UP.Browser'=>'Windows CE',
            'NetAnts'=>'Windows',
        ];
    
        // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
        $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';
    
        foreach ($os_array as $regex => $value) {
            if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
                return $value.' x'.$arch;
            }
        }
    
        return 'Unknown';
    }
    
    private static function getBrowser(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
           return 'Internet explorer';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
            return 'Internet explorer';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
           return 'Mozilla Firefox';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
           return 'Google Chrome';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
           return "Opera Mini";
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
           return "Opera";
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
           return "Safari";
         else
           return 'Cant Find';
    }
    
    private static function getCountryName($key){
        $countries = array(
        	'AF' => 'Afghanistan',
        	'AX' => 'Aland Islands',
        	'AL' => 'Albania',
        	'DZ' => 'Algeria',
        	'AS' => 'American Samoa',
        	'AD' => 'Andorra',
        	'AO' => 'Angola',
        	'AI' => 'Anguilla',
        	'AQ' => 'Antarctica',
        	'AG' => 'Antigua And Barbuda',
        	'AR' => 'Argentina',
        	'AM' => 'Armenia',
        	'AW' => 'Aruba',
        	'AU' => 'Australia',
        	'AT' => 'Austria',
        	'AZ' => 'Azerbaijan',
        	'BS' => 'Bahamas',
        	'BH' => 'Bahrain',
        	'BD' => 'Bangladesh',
        	'BB' => 'Barbados',
        	'BY' => 'Belarus',
        	'BE' => 'Belgium',
        	'BZ' => 'Belize',
        	'BJ' => 'Benin',
        	'BM' => 'Bermuda',
        	'BT' => 'Bhutan',
        	'BO' => 'Bolivia',
        	'BA' => 'Bosnia And Herzegovina',
        	'BW' => 'Botswana',
        	'BV' => 'Bouvet Island',
        	'BR' => 'Brazil',
        	'IO' => 'British Indian Ocean Territory',
        	'BN' => 'Brunei Darussalam',
        	'BG' => 'Bulgaria',
        	'BF' => 'Burkina Faso',
        	'BI' => 'Burundi',
        	'KH' => 'Cambodia',
        	'CM' => 'Cameroon',
        	'CA' => 'Canada',
        	'CV' => 'Cape Verde',
        	'KY' => 'Cayman Islands',
        	'CF' => 'Central African Republic',
        	'TD' => 'Chad',
        	'CL' => 'Chile',
        	'CN' => 'China',
        	'CX' => 'Christmas Island',
        	'CC' => 'Cocos (Keeling) Islands',
        	'CO' => 'Colombia',
        	'KM' => 'Comoros',
        	'CG' => 'Congo',
        	'CD' => 'Congo, Democratic Republic',
        	'CK' => 'Cook Islands',
        	'CR' => 'Costa Rica',
        	'CI' => 'Cote D\'Ivoire',
        	'HR' => 'Croatia',
        	'CU' => 'Cuba',
        	'CY' => 'Cyprus',
        	'CZ' => 'Czech Republic',
        	'DK' => 'Denmark',
        	'DJ' => 'Djibouti',
        	'DM' => 'Dominica',
        	'DO' => 'Dominican Republic',
        	'EC' => 'Ecuador',
        	'EG' => 'Egypt',
        	'SV' => 'El Salvador',
        	'GQ' => 'Equatorial Guinea',
        	'ER' => 'Eritrea',
        	'EE' => 'Estonia',
        	'ET' => 'Ethiopia',
        	'FK' => 'Falkland Islands (Malvinas)',
        	'FO' => 'Faroe Islands',
        	'FJ' => 'Fiji',
        	'FI' => 'Finland',
        	'FR' => 'France',
        	'GF' => 'French Guiana',
        	'PF' => 'French Polynesia',
        	'TF' => 'French Southern Territories',
        	'GA' => 'Gabon',
        	'GM' => 'Gambia',
        	'GE' => 'Georgia',
        	'DE' => 'Germany',
        	'GH' => 'Ghana',
        	'GI' => 'Gibraltar',
        	'GR' => 'Greece',
        	'GL' => 'Greenland',
        	'GD' => 'Grenada',
        	'GP' => 'Guadeloupe',
        	'GU' => 'Guam',
        	'GT' => 'Guatemala',
        	'GG' => 'Guernsey',
        	'GN' => 'Guinea',
        	'GW' => 'Guinea-Bissau',
        	'GY' => 'Guyana',
        	'HT' => 'Haiti',
        	'HM' => 'Heard Island & Mcdonald Islands',
        	'VA' => 'Holy See (Vatican City State)',
        	'HN' => 'Honduras',
        	'HK' => 'Hong Kong',
        	'HU' => 'Hungary',
        	'IS' => 'Iceland',
        	'IN' => 'India',
        	'ID' => 'Indonesia',
        	'IR' => 'Iran, Islamic Republic Of',
        	'IQ' => 'Iraq',
        	'IE' => 'Ireland',
        	'IM' => 'Isle Of Man',
        	'IL' => 'Israel',
        	'IT' => 'Italy',
        	'JM' => 'Jamaica',
        	'JP' => 'Japan',
        	'JE' => 'Jersey',
        	'JO' => 'Jordan',
        	'KZ' => 'Kazakhstan',
        	'KE' => 'Kenya',
        	'KI' => 'Kiribati',
        	'KR' => 'Korea',
        	'KW' => 'Kuwait',
        	'KG' => 'Kyrgyzstan',
        	'LA' => 'Lao People\'s Democratic Republic',
        	'LV' => 'Latvia',
        	'LB' => 'Lebanon',
        	'LS' => 'Lesotho',
        	'LR' => 'Liberia',
        	'LY' => 'Libyan Arab Jamahiriya',
        	'LI' => 'Liechtenstein',
        	'LT' => 'Lithuania',
        	'LU' => 'Luxembourg',
        	'MO' => 'Macao',
        	'MK' => 'Macedonia',
        	'MG' => 'Madagascar',
        	'MW' => 'Malawi',
        	'MY' => 'Malaysia',
        	'MV' => 'Maldives',
        	'ML' => 'Mali',
        	'MT' => 'Malta',
        	'MH' => 'Marshall Islands',
        	'MQ' => 'Martinique',
        	'MR' => 'Mauritania',
        	'MU' => 'Mauritius',
        	'YT' => 'Mayotte',
        	'MX' => 'Mexico',
        	'FM' => 'Micronesia, Federated States Of',
        	'MD' => 'Moldova',
        	'MC' => 'Monaco',
        	'MN' => 'Mongolia',
        	'ME' => 'Montenegro',
        	'MS' => 'Montserrat',
        	'MA' => 'Morocco',
        	'MZ' => 'Mozambique',
        	'MM' => 'Myanmar',
        	'NA' => 'Namibia',
        	'NR' => 'Nauru',
        	'NP' => 'Nepal',
        	'NL' => 'Netherlands',
        	'AN' => 'Netherlands Antilles',
        	'NC' => 'New Caledonia',
        	'NZ' => 'New Zealand',
        	'NI' => 'Nicaragua',
        	'NE' => 'Niger',
        	'NG' => 'Nigeria',
        	'NU' => 'Niue',
        	'NF' => 'Norfolk Island',
        	'MP' => 'Northern Mariana Islands',
        	'NO' => 'Norway',
        	'OM' => 'Oman',
        	'PK' => 'Pakistan',
        	'PW' => 'Palau',
        	'PS' => 'Palestinian Territory, Occupied',
        	'PA' => 'Panama',
        	'PG' => 'Papua New Guinea',
        	'PY' => 'Paraguay',
        	'PE' => 'Peru',
        	'PH' => 'Philippines',
        	'PN' => 'Pitcairn',
        	'PL' => 'Poland',
        	'PT' => 'Portugal',
        	'PR' => 'Puerto Rico',
        	'QA' => 'Qatar',
        	'RE' => 'Reunion',
        	'RO' => 'Romania',
        	'RU' => 'Russian Federation',
        	'RW' => 'Rwanda',
        	'BL' => 'Saint Barthelemy',
        	'SH' => 'Saint Helena',
        	'KN' => 'Saint Kitts And Nevis',
        	'LC' => 'Saint Lucia',
        	'MF' => 'Saint Martin',
        	'PM' => 'Saint Pierre And Miquelon',
        	'VC' => 'Saint Vincent And Grenadines',
        	'WS' => 'Samoa',
        	'SM' => 'San Marino',
        	'ST' => 'Sao Tome And Principe',
        	'SA' => 'Saudi Arabia',
        	'SN' => 'Senegal',
        	'RS' => 'Serbia',
        	'SC' => 'Seychelles',
        	'SL' => 'Sierra Leone',
        	'SG' => 'Singapore',
        	'SK' => 'Slovakia',
        	'SI' => 'Slovenia',
        	'SB' => 'Solomon Islands',
        	'SO' => 'Somalia',
        	'ZA' => 'South Africa',
        	'GS' => 'South Georgia And Sandwich Isl.',
        	'ES' => 'Spain',
        	'LK' => 'Sri Lanka',
        	'SD' => 'Sudan',
        	'SR' => 'Suriname',
        	'SJ' => 'Svalbard And Jan Mayen',
        	'SZ' => 'Swaziland',
        	'SE' => 'Sweden',
        	'CH' => 'Switzerland',
        	'SY' => 'Syrian Arab Republic',
        	'TW' => 'Taiwan',
        	'TJ' => 'Tajikistan',
        	'TZ' => 'Tanzania',
        	'TH' => 'Thailand',
        	'TL' => 'Timor-Leste',
        	'TG' => 'Togo',
        	'TK' => 'Tokelau',
        	'TO' => 'Tonga',
        	'TT' => 'Trinidad And Tobago',
        	'TN' => 'Tunisia',
        	'TR' => 'Turkey',
        	'TM' => 'Turkmenistan',
        	'TC' => 'Turks And Caicos Islands',
        	'TV' => 'Tuvalu',
        	'UG' => 'Uganda',
        	'UA' => 'Ukraine',
        	'AE' => 'United Arab Emirates',
        	'GB' => 'United Kingdom',
        	'US' => 'United States',
        	'UM' => 'United States Outlying Islands',
        	'UY' => 'Uruguay',
        	'UZ' => 'Uzbekistan',
        	'VU' => 'Vanuatu',
        	'VE' => 'Venezuela',
        	'VN' => 'Viet Nam',
        	'VG' => 'Virgin Islands, British',
        	'VI' => 'Virgin Islands, U.S.',
        	'WF' => 'Wallis And Futuna',
        	'EH' => 'Western Sahara',
        	'YE' => 'Yemen',
        	'ZM' => 'Zambia',
        	'ZW' => 'Zimbabwe',
        );   
        return $countries[$key];
    }
}