<?php

namespace Lunar\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lunar\Base\Addressable;
use Lunar\Base\BaseModel;
use Lunar\Base\Traits\CachesProperties;
use Lunar\Base\Traits\HasMacros;
use Lunar\Base\Traits\LogsActivity;
use Lunar\Base\ValueObjects\Cart\TaxBreakdown;
use Lunar\Database\Factories\CartAddressFactory;
use Lunar\DataTypes\Price;
use Lunar\DataTypes\ShippingOption;

/**
 * @property int $id
 * @property int $cart_id
 * @property ?int $country_id
 * @property ?string $title
 * @property ?string $first_name
 * @property ?string $last_name
 * @property ?string $company_name
 * @property ?string $line_one
 * @property ?string $line_two
 * @property ?string $line_three
 * @property ?string $city
 * @property ?string $state
 * @property ?string $postcode
 * @property ?string $delivery_instructions
 * @property ?string $contact_email
 * @property ?string $contact_phone
 * @property string $type
 * @property ?string $shipping_option
 * @property array $meta
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class CartAddress extends BaseModel implements Addressable
{
    use HasFactory;
    use LogsActivity;
    use HasMacros;
    use CachesProperties;

    /**
     * Array of cachable class properties.
     *
     * @var array
     */
    public $cachableProperties = [
        'shippingOption',
        'shippingSubTotal',
        'shippingTaxTotal',
        'shippingTotal',
        'taxBreakdown',
    ];

    /**
     * The applied shipping option.
     *
     * @var ShippingOption|null
     */
    public ?ShippingOption $shippingOption = null;

    /**
     * The shipping sub total.
     *
     * @var Price|null
     */
    public ?Price $shippingSubTotal = null;

    /**
     * The shipping tax total.
     *
     * @var Price|null
     */
    public ?Price $shippingTaxTotal = null;

    /**
     * The shipping total.
     *
     * @var Price|null
     */
    public ?Price $shippingTotal = null;

    /**
     * The tax breakdown.
     *
     * @var TaxBreakdown
     */
    public ?TaxBreakdown $taxBreakdown = null;

    /**
     * Return a new factory instance for the model.
     *
     * @return CartAddressFactory
     */
    protected static function newFactory(): CartAddressFactory
    {
        return CartAddressFactory::new();
    }

    /**
     * Define which attributes should be
     * protected from mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'title',
        'first_name',
        'last_name',
        'company_name',
        'line_one',
        'line_two',
        'line_three',
        'city',
        'state',
        'postcode',
        'delivery_instructions',
        'contact_email',
        'contact_phone',
        'meta',
        'type',
        'shipping_option',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'object',
    ];

    /**
     * Return the cart relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Return the country relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
