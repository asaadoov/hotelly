<?php

namespace App\Console\Commands;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

use Illuminate\Console\Command;
use App\Libraries\Notifications;
use App\Notifications\Reservation;

class EmailReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify
    {count : The number of bookings to retrieve}
    {--dry-run= : To have this command do no actual work.}';


    /**
     * The console command description.
     *
     * @var string
     */
    
    protected $description = 'Notify reservations holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Notifications $notify)
    {
        $this->notify = $notify;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   $answer = $this->choice(
        'What service should we use?',
            ['sms', 'email'],
            'email'
        );
        var_dump($answer);
        
        $count = $this->argument('count');
        if (!is_numeric($count)) {
            $this->alert('The count must be a number');
            return 1;
        }

        $bookings = \App\Booking::with(['room.roomType', 'users'])->limit($count)->get();
        $this->info(sprintf('The number of bookings to alert for is: %d', $bookings->count()));

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, $bookings->count());

        $progress->setProgressCharacter('#');

        $progress->start();

        print "\n";
        foreach ($bookings as $booking){
            $this->processBooking($booking);
            $progress->advance();
        }

        $progress->finish();
        print "\n";
        
        $this->comment('Command completed!');

    }

    public function processBooking($booking){
        if ($this->option('dry-run')) {
            $this->info('Would process booking');

        } else {
            // $this->notify->send();
            $booking->notify(new Reservation('Asaad Babiker'));
            // Notifications::send();
        }
    }
}
