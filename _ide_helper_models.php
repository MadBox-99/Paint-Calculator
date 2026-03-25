<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TilePaint> $paints
 * @property-read int|null $paints_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory active()
 * @method static \Database\Factories\PaintCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaintCategory whereUpdatedAt($value)
 */
	class PaintCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $region_id
 * @property string $company_name
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerShop whereUpdatedAt($value)
 */
	class PartnerShop extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PartnerShop> $partnerShops
 * @property-read int|null $partner_shops_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Store> $stores
 * @property-read int|null $stores_count
 * @method static \Database\Factories\RegionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $region_id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Region $region
 * @method static \Database\Factories\StoreFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereUpdatedAt($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $paint_category_id
 * @property string $type
 * @property string|null $name
 * @property string|null $description
 * @property string|null $paint_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $images
 * @property string|null $inspiration_video
 * @property string|null $brief_implementation
 * @property string|null $where_to_buy
 * @property string|null $expert_help
 * @property string|null $important_info
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TilePaintDescription> $descriptions
 * @property-read int|null $descriptions_count
 * @property-read \App\Models\PaintCategory $paintCategory
 * @method static \Database\Factories\TilePaintFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereBriefImplementation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereExpertHelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereImportantInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereInspirationVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint wherePaintCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint wherePaintOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaint whereWhereToBuy($value)
 */
	class TilePaint extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tile_paint_id
 * @property string $description
 * @property int $min
 * @property int $max
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TilePaint $tilePaint
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereTilePaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TilePaintDescription whereUpdatedAt($value)
 */
	class TilePaintDescription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

