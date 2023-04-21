<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $state
 * @property string $zip
 * @property string $city
 * @property string $address
 * @property int $id
 */
class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'address',
        'city',
        'zip',
        'state',
    ];
}
