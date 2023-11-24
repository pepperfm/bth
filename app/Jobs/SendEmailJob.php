<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Notifications\CreateProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->product->notify(new CreateProductNotification());
    }
}
