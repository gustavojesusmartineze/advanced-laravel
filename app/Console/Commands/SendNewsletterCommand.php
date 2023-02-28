<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NewsletterNotification;
use Illuminate\Console\Command;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email newsletter';

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
     * @return int
     */
    public function handle()
    {
        $emails = $this->argument('emails');

        $builder= User::query();

        if (isset($emails) && count($emails) > 0) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();

        if (!$count) {
            $this->info("No email sent");
        } else {
            $this->output->progressStart($count);
            $builder->whereNotNull('email_verified_at')
                ->each(function(User $user) {
                    $user->notify(new NewsletterNotification());
                    $this->output->progressAdvance();
                });

            $this->info("{$count} Emails sent");
            $this->output->progressFinish();
        }
    }
}
