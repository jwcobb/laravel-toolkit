<?php

namespace JWCobb\LaravelToolkit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWCobb\LaravelToolkit\Models\Presenters\AddressPresenter;
use TheHiveTeam\Presentable\HasPresentable;

/**
 * @mixin IdeHelperAddress
 */
class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasPresentable;
    use HasPrimary;

    protected $table = 'addresses';
    protected $presenter = AddressPresenter::class;

    protected $fillable = [
        'label',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'locality',
        'region',
        'postal_code',
        'country_code',
        'is_primary',
        'is_po_box',
        'latitude',
        'longitude',
        'timezone',
    ];

    protected $casts = [
        'label' => 'string',
        'address_line_1' => 'string',
        'address_line_2' => 'string',
        'address_line_3' => 'string',
        'locality' => 'string',
        'region' => 'string',
        'postal_code' => 'string',
        'country_code' => 'string',
        'is_primary' => 'boolean',
        'is_po_box' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'timezone' => 'string',
    ];

    public function addressable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }
}
