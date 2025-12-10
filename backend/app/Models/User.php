<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'bio',
        'location',
        'is_host',
        'email_verified_at',
        'host_since'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_host' => 'boolean',
            'host_since' => 'datetime'
        ];
    }

    // Accessors
    public function getAvatarAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function getLocationAttribute(): string
    {
        return $this->location ?? '';
    }

    public function getIsVerifiedAttribute(): bool
    {
        return !is_null($this->email_verified_at);
    }

    // Scopes
    public function scopeHosts($query): string
    {
        return $query->where('is_host', true);
    }

    // Business Logic
    public function becomeHost(): void
    {
        $this->update(['is_host' => true, 'host_since' => now()]);
    }

    public function hostSince() {
        return $this->host_since ?? now();
    }
    // Relations

   public function listings(): HasMany
   {
       return $this->hasMany(Listing::class, 'host_id');
   }

   public function bookings(): HasMany
   {
       return $this->hasMany(Booking::class);
   }

   public function reviews(): HasMany
   {
       return $this->hasMany(Review::class);
   }

   public function receivedReviews(): HasMany
   {
       return $this->hasMany(Review::class, 'host_id');
   }
}
