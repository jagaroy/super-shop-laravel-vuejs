<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class NetUser extends Authenticatable
{
	// test for Auth starts
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
	protected $guard = 'netuser';
	// test for Auth ends 

    // use SoftDeletes;

    protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = ["id", "net_user_name", "email", "password", "remember_token", "net_user_status", "package_id", "net_user_ip", "net_user_expiration", "last_extend_days", "net_user_phone", "net_user_address", "net_user_price", "net_user_registered", "router_id", "user_type", "queue_id", "pppoe_id", "net_user_connection_type", "remarks", "authored_by"];

    public function package()
	{
		return $this->belongsTo(Package::class, "package_id");
	}
    
	public function router()
	{
		return $this->belongsTo(Router::class, "router_id");
	}

	public function queue()
	{
		return $this->belongsTo(Queue::class, "queue_id");
	}

	public function pppoe()
	{
		return $this->belongsTo(Pppoe::class, "pppoe_id");
	}

}
