<?php

namespace App\Console\Commands;

use App\Jobs\ReadMailbox;
use App\Models\Mailbox;
use Illuminate\Console\Command;

/**
 * Class PostEmailToTelegram
 * @package App\Console\Commands
 */
class PostEmailToTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postEmailToTelegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user email to telegram';

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
        $mailboxes = Mailbox::with('user')->isActive()->get();
        foreach ($mailboxes as $mailbox) {
            if($mailbox->user->hasValidTelegramConfig()) {
                ReadMailbox::dispatch($mailbox)->onQueue('read.mailbox');
            }
        }
    }
}
