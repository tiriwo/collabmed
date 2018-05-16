<?php

namespace App\Console\Commands;

use App\Asset;
use Illuminate\Console\Command;

class GenerateMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly report';

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
        $availableAssets= Asset::where('user_id',null)->get();
        $leasedAssets= Asset::where('user_id','!=',null)->get();
        return response()->json(['available'=>$availableAssets,'leased'=>$leasedAssets]);
    }
}
