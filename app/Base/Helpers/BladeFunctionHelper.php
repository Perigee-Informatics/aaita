<?php 

namespace App\Base\Helpers;

use  App\Utils\DateHelper;
use Illuminate\Support\Carbon;

class BladeFunctionHelper {

    public static function getDateOnly($date_ad)
    {
        $reg_date = Carbon::parse($date_ad)->todateString();
        return $reg_date;
    }

    public static function getBsDateToday()
    {
        $date=Carbon::now()->format('yy/m/d');
        $dateHelper = new DateHelper();
        $date=$dateHelper->convertBsFromAd($date);

        return $date;

    }

    public static function englishToNepali($input){
        $standard_numsets = array("0","1","2","3","4","5","6","7","8","9",".");
        $devanagari_numsets = array("०","१","२","३","४","५","६","७","८","९","|");
        
        return str_replace($standard_numsets, $devanagari_numsets, $input);
      }

      public static function currencyFormat($value, $decimalPlaces = 0)
      {
          $pos = strpos($value, ".");  // find current position of decimal place
          // dd($pos);
          if ($pos === false) {
              $whole_number = abs($value);
              $dec_digits = str_repeat("0", $decimalPlaces);
          } else {
              //decimals digits
              $dec_digits = substr($value, $pos);
              // dd($dec_digits);
              $dec_digits = round($dec_digits, $decimalPlaces);
              //  dd($dec_digits)
              $pos1 = strpos($dec_digits, ".");
              $dec_digits = substr($dec_digits, $pos1 + 1);
              // dd($dec_digits);
              $dec_digits = $dec_digits . str_repeat("0", $decimalPlaces - strlen($dec_digits));
              // dd($dec_digits);
              $whole_number = abs(substr($value, 0, $pos));
              // dd($whole_number);
          }
          $num = substr($whole_number, -3);        //get the last 3 digits
          // dd($num);
          $whole_number = substr($whole_number, 0, -3);    //omit the last 3 digits already stored in $num
          while (strlen($whole_number) > 0)        //loop the process - further get digits 2 by 2
          {
              $num = substr($whole_number, -2) . "," . $num;
              $whole_number = substr($whole_number, 0, -2);
          }
          if ($decimalPlaces < 1) {
              $result = $num;
          } else {
              $result = $num . "|" . $dec_digits;
          }
          return $result;
      }
  
      //Currency Format with nepali digits
      public static function currencyFormatNepaliDigits($value, $decimalPlaces = 0){
          $formattedDigits = BladeFunctionHelper::currencyFormat($value, $decimalPlaces = 0);
          $convertedDigits = BladeFunctionHelper::englishToNepali($formattedDigits);
          return $convertedDigits;
      }

    public static function checkIfRole($input){
        $user = backpack_user();
        $roles = $user->roles;
        $roles_arr = [];
        foreach($roles as $r){
            $roles_arr [] = $r->name;
        }

        //check if there is array for input,
        if(count($input)>0){
            foreach($input as $i){
                if(in_array($i,$roles_arr)){
                    $value = false;
                break;
                }else{
                    $value = true;
                }
            }
        }else{
                if(in_array($input,$roles_arr)){
                    $value =  false;
                }else{
                    $value =  true;
                }
        }

    return $value;

    }
}
 