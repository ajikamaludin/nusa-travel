<?php

namespace App\Console\Commands;

use App\Mail\OrderInvoice;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use function React\Async\async;
use React\EventLoop\Loop;

class Trigger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trigger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Sending Email....');
        Loop::addTimer(0, async(function () {
            $order = Order::first();
            Mail::to('aji19kamaludin@gmail.com')->send(new OrderInvoice($order));
        }));
        $this->info('Email Sent.');

    }
}
