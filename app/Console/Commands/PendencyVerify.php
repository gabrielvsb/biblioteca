<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PendencyVerify extends Command
{
    const FINE_AMOUNT = 0.30;

    protected $signature = 'pendency:verify';
    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $loansExpireds = Loan::where('date_end', '<', Carbon::now())->get();

        if(!$loansExpireds->isEmpty()){
            $loansExpireds->each(function ($loan, $key){
                if(!DB::table('pendencies')->where('id_loan', '=', $loan->id)->count()){
                    DB::table('pendencies')->insert([
                        'id_loan' => $loan->id,
                        'fine_amount' => self::FINE_AMOUNT
                    ]);
                }
                DB::table('pendencies')
                    ->where('id_loan', '=', $loan->id)
                    ->where('status', '=', 'A')
                    ->increment('fine_amount', self::FINE_AMOUNT);
            });
        }
    }
}
