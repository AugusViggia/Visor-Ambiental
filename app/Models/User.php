<?php

namespace App\Models;

use App\Models\Traits\MustBeApproved;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordCustomized;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use MustBeApproved;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'document_number',
        'email',
        'institution',
        'password',
        'requested_at',
        'approved_at',
        'enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordCustomized($token));
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function scopeSearch($query, $data)
    {
        if (isset($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }

        if (isset($data['document_number'])) {
            $query->where('document_number', 'like', "%{$data['document_number']}%");
        }

        if ((collect($data))->get('enabled') !== null) {
            $query->where('enabled', $data['enabled']);
        }

        return $query;
    }

    public function scopeSearchApi($query, $data)
    {
        if (isset($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }
    }
}
