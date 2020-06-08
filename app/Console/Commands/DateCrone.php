<?php

namespace App\Console\Commands;

use App\Models\DateFilm;
use Illuminate\Console\Command;

class DateCrone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date:run';

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
        $filmsAllDate = DateFilm::all();
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Asia/Yerevan'));
        $nowDate = $date->format('Y.m.d H:i');
        foreach ($filmsAllDate as $index => $item) {
            if ($nowDate >= $item->start_date && $item->status === 'active') {
                $item->status = 'passive';
                $item->save();
                foreach ($item->checked as $check) {
                    $check->status = 'passive';
                    $check->save();
                }
            }
        }
        $this->info('crone successfully');
        return exit(0);
    }
}
