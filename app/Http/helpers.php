<?php
use App\Utils\DateHelper;
use App\Models\MstFiscalYear;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Convert BS date to AD
 *
 * @param string|null $date_ad
 * @return string
 */
function convert_bs_from_ad(string $date_ad = null) {
    if(empty($date_ad)) {
        $date_ad = Carbon::now()->todateString();
    }

    $dateHelper = new DateHelper();
    return $dateHelper->convertBsFromAd($date_ad);
}

function get_current_fiscal_year(){
    $date_ad = Carbon::now()->todateString();
    $dateHelper = new DateHelper();
    $date_bs =  $dateHelper->convertBsFromAd($date_ad);
    return $dateHelper->fiscalYear($date_bs);
}

function get_next_fiscal_year()
{
    $fiscal_year_id = MstFiscalYear::where('code',get_current_fiscal_year())->pluck('id')->first();
    return MstFiscalYear::where('id','>', $fiscal_year_id)->limit(1)->pluck('code')->first();  
    
}
/**
 * Convert date from AD to BS
 *
 * @param string|null $date_bs
 * @return string
 */
function convert_ad_from_bs(string $date_bs = null) {
    if(empty($date_bs)) {
        $date_bs = Carbon::now()->todateString();
    }

    $dateHelper = new DateHelper();
    return $dateHelper->convertAdFromBs($date_bs);
}
