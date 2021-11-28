<?php

namespace JWCobb\LaravelToolkit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWCobb\LaravelToolkit\Models\Presenters\EmailAddressPresenter;

/**
 * @mixin IdeHelperEmailAddress
 */
class EmailAddress extends Model
{
    use HasFactory, SoftDeletes, HasPrimary;

    protected $table = 'email_addresses';
    protected $presenter = EmailAddressPresenter::class;

    protected $fillable = [
        'label',
        'email_address',
        'is_primary',
    ];

    protected $casts = [
        'label'         => 'string',
        'email_address' => 'string',
        'is_primary'    => 'boolean',
    ];


    public function emailable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }


    public function setEmailAddressAttribute($value): void
    {
        $this->attributes['email_address'] = strtolower(trim($value));
    }
}
