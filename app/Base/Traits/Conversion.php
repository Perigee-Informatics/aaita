<?php
namespace App\Base\Traits;


/**
 * To get combo filed from model
 */
trait Conversion
{

    public function convertToNepaliNumber($input)
    {
        $standard_numsets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", '-', '/');
        $devanagari_numsets = array("०", "१", "२", "३", "४", "५", "६", "७", "८", "९", '-', '/');
        return str_replace($standard_numsets, $devanagari_numsets, $input);
    }

    public function convertNumberToNepaliWord($input)
    {
        $standard_numsets = array("१", "२", "३", "४", "५", "६", "७", "८", "९", "१०", "११", "१२", "१३", "१४", "१५");
        $nepali_numsets = array("पहिलो", "दोस्रो", "तेस्रो", "चौंथो", "पाँचौ", "छैठौ", "सातौ", "आठौ", "नवौ", "दशौ", "एघारौ", 'बार्हौ', "तेर्हौं", "चौधौं", "पन्ध्रौ");
        return str_replace($standard_numsets, $nepali_numsets, $input);
    }

    public function convertNumberToNepaliMonth($input)
    {   
        $standard_numsets = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $nepali_numsets = array("बैशाख", "जेठ", "असार", "श्रावण", "भाद्र", "अषोज", "कार्तिक", "मंसिर", "पौष", "माघ", "फाल्गुन","चैत्र");
        return str_replace($standard_numsets, $nepali_numsets, $input);
    }

    public function convertToNepaliDay($input)
    {
        $english_day = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        $nepali_day = array("आइतबार", "सोमबार", "मंगलबार", "बुधबार", "बिहिबार", "शुक्रबार", "शनिबार");
        return str_replace($english_day, $nepali_day, $input);
    }

    public function convert24to12($input){
        $standard_numsets = array("13", "14", "15", "16", "17", "18", "19", "20", "21", "22", '23','24');
        $new_numsets = array("1", "2", "3", "4", "5", "6", "7", "8", "9", '10', '11','12');
        return str_replace($standard_numsets, $new_numsets, $input);
    }


    
    public function formatTimeOnly($time){
        $match = preg_split('/[: ]/', $time);
        $hour = $match[0];
        $minute = $match[1];
        $samaya = " बिहान ";
        if($hour > 12){
            $hour = $this->convert24to12($hour);
            $samaya = " अपरान्ह ";
        }
        $hour = $this->convertToNepaliNumber($hour);
        $minute = $this->convertToNepaliNumber($minute);
        $time  = $hour.":".$minute;
        return $samaya.$time.' बजे ';
    }
    
    public function formatEnglishTimeOnly($time){
        $match = preg_split('/[: ]/', $time);
        $hour = $match[0];
        $minute = $match[1];
        $shift = " AM ";
        if($hour > 12){
            $hour = $this->convert24to12($hour);
            $shift = " PM ";
        }
        $time  = $hour.":".$minute;
        return $time.$shift;
    }
}
