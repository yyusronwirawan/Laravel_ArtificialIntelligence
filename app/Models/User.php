<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Subscriptions as SubscriptionsModel;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'affiliate_id',
        'affiliate_code',
        'remaining_words',
        'remaining_images',
        'email_confirmation_code',
        'email_confirmed',
        'password_reset_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fullName(){
        return $this->name.' '.$this->surname;
    }

    public function openai(){
        return $this->hasMany(UserOpenai::class);
    }

    public function orders(){
        return $this->hasMany(UserOrder::class);
    }

    public function plan(){
        return $this->hasMany(UserOrder::class)->where('type', 'subscription')->orderBy('created_at', 'desc')->first();
    }

    public function activePlan(){

        // $activeSub = $this->subscriptions()->where('stripe_status', 'active')->orWhere('stripe_status', 'trialing')->first();
        // $userId=Auth::user()->id;
        $userId=$this->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if ($activeSub != null){
            $plan = PaymentPlans::where('id', $activeSub->plan_id)->first();
            if ($plan == null){
                return null;
            }
            $difference = $activeSub->updated_at->diffInDays(Carbon::now());
            if ($plan->frequency == 'monthly'){
                if ($difference < 31){
                    return $plan;
                }
            }elseif ($plan->frequency == 'yearly'){
                if ($difference < 365){
                    return $plan;
                }
            }
        }else{
            return null;
        }

    }


    //Support Requests
    public function supportRequests(){
        return $this->hasMany(UserSupport::class);
    }

    //Favorites
    public function favoriteOpenai(){
        return $this->belongsToMany(OpenAIGenerator::class, 'user_favorites', 'user_id', 'openai_id');
    }

    //Affiliate
    public function affiliates(){
        return $this->hasMany(User::class, 'affiliate_id', 'id');
    }

    public function affiliateOf(){
        return $this->belongsTo(User::class, 'affiliate_id', 'id');
    }

    public function withdrawals(){
        return $this->hasMany(UserAffiliate::class);
    }

    //Chat
    public function openaiChat(){
        return $this->hasMany(UserOpenaiChat::class);
    }

    //Avatar
    public function getAvatar(){
        if ($this->avatar == null){
            return '<span class="avatar">'.Str::upper(substr($this->name, 0, 1)).Str::upper(substr($this->surname, 0, 1)).'</span>';
        }else{
            $avatar = $this->avatar;
            if (strpos($avatar, 'http') === false || strpos($avatar, 'https') === false) {
                $avatar = '/'. $avatar;
            }
            return  ' <span class="avatar" style="background-image: url('.$avatar.')"></span>';
        }
    }
}
