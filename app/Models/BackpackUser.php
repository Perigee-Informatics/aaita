<?php

namespace App\Models;

use App\Models\User;
use App\Models\AppClient;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;

class BackpackUser extends User
{
    use Notifiable;

    protected $table = 'users';

    // public $incrementing = false;

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function clientEntity(){
        return $this->belongsTo(AppClient::class,'client_id','id');
    }
}

