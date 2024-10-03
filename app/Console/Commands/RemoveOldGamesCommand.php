<?php

namespace App\Console\Commands;

use App\Enums\BoardState;
use App\Models\Board;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class RemoveOldGamesCommand extends Command
{
    protected $signature = 'remove:old-games';

    protected $description = 'Remove games that are no longer being played to help save space';

    public function handle(): void
    {
        if ($this->output->isVerbose()) {
            info('Deleting boards that are over');
        }
        Board::where('state', BoardState::Over)
            ->orWhere('created_at', '<=', now()->subWeek())
            ->delete();
    }
}
