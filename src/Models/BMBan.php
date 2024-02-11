<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Azuriom\Plugin\Battlemetrics\Api\Resources\Ban;
use Azuriom\Plugin\Battlemetrics\Events\BMBanCreated;
use Azuriom\Plugin\Battlemetrics\Events\BMBanUpdated;
use Azuriom\Plugin\Battlemetrics\Listeners\ConnectSteamIdToBan;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property ?int $battlemetrics_user_id
 * @property int $organization_id
 * @property int $battlemetrics_id
 * @property ?string $steam_id
 * @property DateTime $timestamp
 * @property string $reason
 * @property ?string $note
 * @property ?DateTime $expires_at
 * @property array $identifiers
 * @property bool $organization_wide
 * @property bool $auto_add_enabled
 * @property ?bool $native_enabled
 * @property ?DateTime $last_sync
 * @property ?User $user
 */
class BMBan extends Model
{
    use Searchable;

    public $timestamps = false;

    protected $table = 'battlemetrics_bans';

    protected $fillable = [
        'user_id',
        'battlemetrics_user_id',
        'organization_id',
        'battlemetrics_id',
        'steam_id',
        'timestamp',
        'reason',
        'note',
        'expires_at',
        'identifiers',
        'organization_wide',
        'auto_add_enabled',
        'native_enabled',
        'last_sync',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'expires_at' => 'datetime',
        'identifiers' => 'array',
        'last_sync' => 'datetime',
    ];

    protected array $searchable = [
        'steam_id',
        'reason',
        'timestamp',
        'expires_at',
    ];

    protected $dispatchesEvents = [
        'created' => BMBanCreated::class,
        'updated' => BMBanUpdated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the total tracked ban count used on the admin dashboard card.
     */
    public static function totalBansCount(): int
    {
        return self::query()->count(['id']);
    }

    /**
     * Returns the total tacked active ban count on the admin dashboard card.
     *
     * Definition of active:
     * - expires_at equals now or in the future
     * - expires_at is NULL (permanently banned)
     */
    public static function activeBansCount(): int
    {
        return self::query()
            ->where('expires_at', '>=', new DateTime())
            ->orWhereNull('expires_at')
            ->count('id');
    }
}
