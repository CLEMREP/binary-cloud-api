<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $phone
 * @property string $password
 * @property datetime $email_verified_at
 * @property string $remember_token
 * @property bool $admin
 * @property Address $address
 * @property Company $company
 * @property int $address_id
 * @property int $company_id
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'admin',
        'company_id',
        'address_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
        'address_id' => 'integer',
        'company_id' => 'integer',
    ];


    public function address() : BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function invoice() : HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the company of the user
     */
    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the clients of the user
     */
    public function clients() : HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
