<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class StockToken extends Model
{
    

 public $table = 'stock_tokens';

    protected $fillable = [
        'token',
        'expire_at',
        'used',
        'ip_address',
        'user_agent',
        'referer',
    ];


    public function isExpired()
    {
        return $this->expire_at && $this->expire_at->isPast();
    }

    public function markAsUsed()
    {
        $this->used = true;
        $this->save();
    }

    
    public function store(string|null $token, string|null $expireAt, string|null $ipAddress, string|null $userAgent, string|null $referer)
    {
        return self::create([
            'token' => $token,
            'expire_at' => $expireAt,
            'used' => false,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referer' => $referer,
        ]);
    }

    public function getToken(string $token)
    {
        return self::where('token', $token)->first();
    }

    public function last_updated_token()
    {
        $tokenId = Session::get('token_stock_id');
        if ($tokenId) {
            /** Mise à jour de updated_at pour le token */
            $token = self::find($tokenId);
            if ($token) {
                $token->touch(); // Met à jour le champ updated_at
                return $token;
            }
        }
        return null;
    }
}
