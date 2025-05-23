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
 * 
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Developers> $developers
 * @property-read int|null $developers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Countries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Countries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Countries query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Countries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Countries whereName($value)
 */
	class M_Countries extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $image
 * @property int $developer_id
 * @property-read \App\Models\M_Developers $developer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages whereDeveloperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_DeveloperImages whereImage($value)
 */
	class M_DeveloperImages extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $founded_date
 * @property string|null $description
 * @property int|null $country_id
 * @property string|null $website_link
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\M_Countries|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $games
 * @property-read int|null $games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_DeveloperImages> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereFoundedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Developers whereWebsiteLink($value)
 */
	class M_Developers extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $image
 * @property int $game_id
 * @property-read \App\Models\M_Games $game
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameImages whereImage($value)
 */
	class M_GameImages extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameStates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameStates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameStates query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameStates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_GameStates whereName($value)
 */
	class M_GameStates extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $trailer_link
 * @property int $visible
 * @property int $developer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\M_Developers $developer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_GameStates> $gameStates
 * @property-read int|null $game_states_count
 * @property-read mixed $average_rating
 * @property-read mixed $is_wishlisted
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_GameImages> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\M_Prices|null $latestPrice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $owners
 * @property-read int|null $owners_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Platforms> $platforms
 * @property-read int|null $platforms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Prices> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Reviews> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Stores> $stores
 * @property-read int|null $stores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Tags> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $wishers
 * @property-read int|null $wishers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereDeveloperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereTrailerLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Games whereVisible($value)
 */
	class M_Games extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $games
 * @property-read int|null $games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Prices> $prices
 * @property-read int|null $prices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Platforms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Platforms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Platforms query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Platforms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Platforms whereName($value)
 */
	class M_Platforms extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $price
 * @property string $date
 * @property int $discount
 * @property int $game_id
 * @property int $platform_id
 * @property int $store_id
 * @property-read \App\Models\M_Games $game
 * @property-read \App\Models\M_Platforms $platform
 * @property-read \App\Models\M_Stores $store
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Prices whereStoreId($value)
 */
	class M_Prices extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $comment
 * @property int $rating
 * @property int $game_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\M_Games $game
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Reviews whereUserId($value)
 */
	class M_Reviews extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $website_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Prices> $prices
 * @property-read int|null $prices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Stores whereWebsiteLink($value)
 */
	class M_Stores extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|M_Tags whereName($value)
 */
	class M_Tags extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_admin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $ownedGames
 * @property-read int|null $owned_games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Reviews> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\M_Games> $wishedGames
 * @property-read int|null $wished_games_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

