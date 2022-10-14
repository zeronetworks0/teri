<?php

echo @color("nevy","───────────────────────────────────────────\n");
echo @color("green","               www.Gatcha.org             \n");
echo @color("green","               t.me/trick_ngirit          \n");
echo @color("nevy","───────────────────────────────────────────\n");
echo @color('purple', "NOMOR\t\t: ");
$nomor = trim(fgets(STDIN));
$login = login($nomor);
echo @color('green', $login['message']."\n");
echo @color('purple', "OTP\t\t: ");
$otp = trim(fgets(STDIN));
$login = otplogin($nomor,$otp);
if (strpos(json_encode($login), '"status":true')) {
	$secret = $login['secretKey'];
	$plan = $login['callPlan'];
    $nomor = $login['msisdn'];
    $profil = profil($nomor,$plan,$secret);
    $balance = $profil['creditBalance'];
    $aktif = $profil['activeUntil'];
    $sisakuota = $profil['sumOfInternet'];
    $poin = $profil['stotalPoin'];

	echo @color('yellow', "PULSA\t\t: ");
	echo @color('nevy', "$balance\n");
	echo @color('yellow', "MASA AKTIF\t: ");
	echo @color('nevy', "$aktif\n");
    echo @color('yellow', "SISA KUOTA\t: ");
    echo @color('nevy', "$sisakuota\n");
    echo @color('yellow', "BONSTRI\t\t: ");
    echo @color('nevy', "$poin Poin\n");
    cek:
    echo @color('green', "PILIH PAKET:\n");
    echo @color('yellow', "[1] Welcome Reward 5GB ==> Rp 1\n[2] (NEW) 10GB 30 Hari ==> Rp 15000\n[3] (NEW) 10GB 30 Hari ==> Rp 15000\n[4] (NEW) 15GB 30 Hari ==> Rp 20000\n[5] (Diskon) 25GB 25rb 30 Hari ==> Rp 25000\n[6] (Diskon) 25GB 25rb 30 Hari ==> Rp 25000\n[7] (NEW) 50GB 30 Hari ==> Rp 50000\n[8] (NEW) 55GB 30 Hari ==> Rp 50000\n[9] (NEW) 60GB 30 Hari ==> Rp 60000\n[10] (NEW) 65GB 30 Hari ==> Rp 60000\n[11] (NEW) 70GB 30 Hari ==> Rp 75000\n[12] (NEW) 75GB 30 Hari ==> Rp 75000\n[13] (NEW) 75GB 30 Hari ==> Rp 75000\n[14] (NEW) 100GB 30 Hari ==> Rp 90000\n");
    echo @color('green', "PILIH : ");
    $pilih = trim(fgets(STDIN));
    switch ($pilih) {
            case '1':
            $prodid = '25669';
            break;
            case '2':
            $prodid = '25245';
            break;
            case '3':
            $prodid = '25265';
            break;
            case '4':
            $prodid = '25459';
            break;
            case '5':
            $prodid = '22635';
            break;
            case '6':
            $prodid = '22648';
            break;
            case '7':
            $prodid = '25691';
            break;
            case '8':
            $prodid = '25469';
            break;
            case '9':
            $prodid = '25688';
            break;
            case '10':
            $prodid = '25690';
            break;
            case '11':
            $prodid = '25475';
            break;
            case '12':
            $prodid = '25247';
            break;
            case '13':
            $prodid = '25473';
            break;
            case '14':
            $prodid = '25693';
            break;
        
        default:
            echo @color('red', "PILIH PAKET TERLEBIH DAHULU\n");
            goto cek;
            break;
    }
    $cek = cek($prodid);
    $name = $cek['product']['productName'];
    $price = $cek['product']['productPrice'];
    $deskripsi = $cek['product']['productDescription'];
    echo @color('yellow', "NAMA PAKET\t: ");
    echo @color('nevy', "$name\n");
    echo @color('yellow', "HARGA\t\t: ");
    echo @color('nevy', "$price\n");
    echo @color('yellow', "DESKRIPSI\t: ");
    echo @color('nevy', "$deskripsi\n");
    echo @color('green', "LANJUT ? (y/n) :");
    $aa = trim(fgets(STDIN));
    if(strtolower($aa) !== 'y') {
        goto cek;
    }
    $beli = beli($nomor,$plan,$secret,$prodid);
    if ($beli['status'] == true) {
        echo @color('green', "SUKSES \n");
    } else {
        echo @color('red', "GAGAL .! \n");
    }


} else {
    echo @color('red', $login['message']."\n");
    
}

function login($nomor){
	$host = "bimaplus.tri.co.id";        
    $data = '{"imei":"Android 93488a982824b403","language":1,"msisdn":"'.$nomor.'"}';
    $ceknom = rekuest($host,"POST",'/api/v1/login/otp-request', $data);
        return $ceknom;
}
function otplogin($nomor,$otp){
	$host = "bimaplus.tri.co.id";        
    $data = '{"deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","msisdn":"'.$nomor.'","otp":"'.$otp.'"}';
    $ceknom = rekuest($host,"POST",'/api/v1/login/login-with-otp', $data);
        return $ceknom;
}
function profil($nomor,$plan,$secret){
    $host = "bimaplus.tri.co.id";        
    $data = '{"callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"msisdn":"'.$nomor.'","page":1,"secretKey":"'.$secret.'","subscriberType":"Prepaid"}';
    $ceknom = rekuest($host,"POST",'/api/v1/homescreen/profile', $data);
        return $ceknom;
}

function cek($prodid){
	$host = "my.tri.co.id";        
    $data = '{"imei":"WebSelfcare","language":"","callPlan":"","msisdn":"","secretKey":"","subscriberType":"","productId":"'.$prodid.'"}';
    $ceknom = rekuest($host,"POST",'/apibima/product/product-detail', $data);
        return $ceknom;
}

function beli($nomor,$plan,$secret,$prodid){
    $host = "bimaplus.tri.co.id";        
    $data = '{"addonMenuCategory":"","addonMenuSubCategory":"","balance":"","callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"menuCategory":"3","menuCategoryName":"TriProduct","menuIdSource":"","menuSubCategory":"","menuSubCategoryName":"","msisdn":"'.$nomor.'","paymentMethod":"00","productAddOnId":"","productId":"'.$prodid.'","secretKey":"'.$secret.'","servicePlan":"Default","sms":true,"subscriberType":"Prepaid","totalProductPrice":"","utm":"","utmCampaign":"","utmContent":"","utmMedium":"","utmSource":"","utmTerm":"","vendorId":"11"}';
    $ceknom = rekuest($host,"POST",'/api/v1/purchase/purchase-product', $data);
        return $ceknom;
}

function rekuest($host, $method, $url, $data = null){ 
        $headers[] = 'Host: '.$host;
		$headers[] = 'App-Version: 4.2.6';
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $headers[] = 'User-Agent: okhttp/4.9.0';
        
        $c = curl_init("https://".$host.$url);  
        switch ($method){
            case "GET":
            curl_setopt($c, CURLOPT_POST, false);
            break;
            case "POST":               
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
            break;
            case "PUT":               
            curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
            break;
        }
        
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($c, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($c);
        $httpcode = curl_getinfo($c);
        if (!$httpcode){
            return false;
        }
        else {
            $headers = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
            $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        }
        
        curl_close($c);
        $json = json_decode($body, true);
        return $json;
    }


function color($color = "default" , $text = "")
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
