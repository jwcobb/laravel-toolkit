<?php

namespace JWCobb\LaravelToolkit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWCobb\LaravelToolkit\Models\Presenters\PhoneNumberPresenter;

/**
 * @mixin IdeHelperPhoneNumber
 */
class PhoneNumber extends Model
{
    use HasFactory, SoftDeletes, HasPrimary;

    protected $table = 'phone_numbers';
    protected $presenter = PhoneNumberPresenter::class;

    protected $fillable = [
        'label',
        'country_code',
        'number',
        'extension',
        'is_primary',
    ];

    protected $casts = [
        'label'        => 'string',
        'country_code' => 'string',
        'number'       => 'string',
        'extension'    => 'string',
        'is_primary'   => 'boolean',
    ];


    public function phoneable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }

}
