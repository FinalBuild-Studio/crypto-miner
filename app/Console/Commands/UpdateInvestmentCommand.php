<?php

namespace App\Console\Commands;

use App\Investment;
use Illuminate\Console\Command;

class UpdateInvestmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $investments = Investment::where('status', '!=', Investment::EXPIRED);

        foreach ($investments as $investment) {
            if ($investment->expired_at && $investment->expired_at->isYesterday()) {
                $investment->update(['status' => Investment::EXPIRED]);
            }
        }
    }
}
