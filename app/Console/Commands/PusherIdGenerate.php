<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class PusherIdGenerate extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pusher:id
        {--show : Display the ID instead of modifying files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and set a random Pusher app ID';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $id = $this->generateRandomId();

        if ($this->option('show'))
        {
            $this->line('<comment>' . $id . '</comment>');
            return;
        }

        if (!$this->setIdInEnvironmentFile($id))
        {
            return;
        }

        $this->laravel['config']['broadcasting.connections.pusher.app_id'] = $id;

        $this->info('Pusher app ID set successfully.');
    }

    /**
     * Generate a random ID for the application.
     *
     * @return string
     * @throws \Exception
     */
    protected function generateRandomId(): string
    {
        return uuid();
    }

    /**
     * Set the application ID in the environment file.
     *
     * @param string $id
     * @return bool
     */
    protected function setIdInEnvironmentFile($id): bool
    {
        if (!$this->confirmToProceed())
        {
            return false;
        }

        $this->writeNewEnvironmentFileWith($id);

        return true;
    }

    /**
     * Write a new environment file with the given app ID.
     *
     * @param string $id
     */
    protected function writeNewEnvironmentFileWith($id)
    {
        /** @var mixed */
        $laravel = $this->laravel;

        $content = file_get_contents(
            $laravel->environmentFilePath()
        );

        if (!Str::contains($content, 'PUSHER_APP_ID'))
        {
            file_put_contents(
                $laravel->environmentFilePath(),
                'PUSHER_APP_ID=' . $id,
                FILE_APPEND
            );

            return;
        }

        file_put_contents(
            $laravel->environmentFilePath(),
            preg_replace(
                $this->idReplacementPattern(),
                'PUSHER_APP_ID=' . $id,
                $content
            )
        );
    }

    /**
     * Get a regex pattern that will match env PUSHER_APP_ID with any random app ID.
     *
     * @return string
     */
    protected function idReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['broadcasting.connections.pusher.app_id'], '/');

        return "/^PUSHER_APP_ID{$escaped}/m";
    }
}
