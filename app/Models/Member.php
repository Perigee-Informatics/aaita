<?php

namespace App\Models;

use App\Base\BaseModel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Member extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'members'; 
    protected $primaryKey = 'id';
    // public $timestamps = false;

    public static $status = [1=>'Applied',2=>'Under Review',3=>'Approved'];
    protected $guarded = ['id'];
    protected $fillable = ['gender_id','dob_ad','dob_bs','nrn_number','first_name','middle_name','last_name','photo_path',
                        'is_other_country','country_id','province_id','district_id','current_organization','past_organization',
                        'doctorate_degree','masters_degree','bachelors_degree','awards','expertise','affiliation',
                        'mailing_address','phone','email','link_to_google_scholar','international_publication','national_publication','status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function genderEntity()
    {
        return $this->belongsTo(MstGender::class,'gender_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function fullName()
    {
        $name = [ $this->first_name,$this->middle_name,$this->last_name];

        return implode(' ',$name);

    }

    public function dob()
    {
        return $this->dob_bs."\n".$this->dob_ad; 
    }

    public function mailingAddress()
    {
        return wordwrap($this->mailing_address,70,"\n",false);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setPhotoPathAttribute($value){
        $attribute_name = "photo_path";
        $disk = "uploads";

        $member_id = (isset(request()->id) ? request()->id : 0);
        $path  = 'Members_photo/###member_ID###/';
        $destination_path = str_replace("###member_ID###", $member_id, $path);

        // dd($destination_path);


        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }


        if (\Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.$filename, $image->stream());
            // 3. Save the public path to the database
        // but first, remove "public/" from the path, since we're pointing to it from the root folder
        // that way, what gets saved in the database is the user-accesible URL
            // $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $destination_path.$filename;
        }
        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($obj) {
            \Storage::disk('uploads')->delete($obj->photo_path);
        });
    }
}
