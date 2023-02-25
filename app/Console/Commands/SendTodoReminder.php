<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TodoReminder;
class SendTodoReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todos:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Todo reminder';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $todos = Todo::whereDate('end_date', Carbon::today())->get();

        foreach($todos as $todo) {
            Mail::to($todo->user->email)->send(new TodoReminder($todo));
        }

        // We may add logs here.
    }
}
