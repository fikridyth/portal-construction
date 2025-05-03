<?php
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Facades\Crypt;

function removeSession($session){
    if(\Session::has($session)){
        \Session::forget($session);
    }
    return true;
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list,$column_name,$id){
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where($column_name,$id)->count();
            if($check_data > 0) return false ;
        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model,$file,$name)
{
    if($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon',$skip=true)
{
    if (!\Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl= isset($media)?$media->getPath():'';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    }
    else
    {
        switch ($collection) {
            case 'image_icon':
                $media = asset('images/avatars/01.png');
                break;
            case 'profile_image':
                $media = asset('images/avatars/01.png');
                break;
            default:
                $media = asset('images/common/add.png');
                break;
        }
        return $media;
    }
}

// File exist check
function getFileExistsCheck($media)
{
    $mediaCondition = false;
    if($media) {
        if($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function toRoman($number) {
    $map = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1,
    ];
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function toAlphabet($number)
{
    $map = [
        1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E',
        6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J',
        11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O',
        16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T',
        21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y',
        26 => 'Z'
    ];

    $returnValue = '';

    while ($number > 0) {
        if ($number <= 26) {
            $returnValue = $map[$number] . $returnValue;
            break;
        } else {
            $mod = ($number - 1) % 26 + 1;
            $returnValue = $map[$mod] . $returnValue;
            $number = intval(($number - $mod) / 26);
        }
    }

    return $returnValue;
}

function numberToText($angka)
{
    $angka = abs($angka);
    $baca = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $hasil = "";

    if ($angka < 12) {
        $hasil = $baca[$angka];
    } elseif ($angka < 20) {
        $hasil = numberToText($angka - 10) . " belas";
    } elseif ($angka < 100) {
        $hasil = numberToText(intval($angka / 10)) . " puluh " . numberToText($angka % 10);
    } elseif ($angka < 200) {
        $hasil = "seratus " . numberToText($angka - 100);
    } elseif ($angka < 1000) {
        $hasil = numberToText(intval($angka / 100)) . " ratus " . numberToText($angka % 100);
    } elseif ($angka < 2000) {
        $hasil = "seribu " . numberToText($angka - 1000);
    } elseif ($angka < 1000000) {
        $hasil = numberToText(intval($angka / 1000)) . " ribu " . numberToText($angka % 1000);
    } else {
        $hasil = "terlalu besar";
    }

    return strtoupper(trim($hasil));
}

function enkrip(string $value)
{
    try {
        return Crypt::encryptString($value);
    } catch (EncryptException $e) {
        return $e->getMessage();
    }
}

// decrypting a value
function dekrip(string $value)
{
    try {
        return Crypt::decryptString($value);
    } catch (DecryptException $e) {
        return $e->getMessage();
    }
}