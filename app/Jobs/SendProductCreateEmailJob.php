<?php

namespace App\Jobs;

use App\Mail\CreateProductMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendProductCreateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $managerEmail, $product;
    /**
     * Create a new job instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
        $this->managerEmail = User::where('type',1)->first()->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->managerEmail)->send(new CreateProductMail($this->product));
    }
}
