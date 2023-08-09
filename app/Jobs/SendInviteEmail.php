<?php

namespace App\Jobs;

use App\Mail\InviteEmail;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendInviteEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $sendTo;
    protected $settings;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $sendTo)
    {
        $this->user = $user;
        $this->sendTo = $sendTo;
        $this->settings = Setting::first();

    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->sendTo)->send(new InviteEmail($this->user, $this->settings));
    }
}
