<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class PusherSecretGenerate extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pusher:secret
        {--show : Display the secret instead of modifying files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and set a random Pusher app secret';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $secret = $this->generateRandomSecret();

        if ($this->option('show'))
        {
            $this->line('<comment>' . $secret . '</comment>');
            return;
        }

        if (!$this->setSecretInEnvironmentFile($secret))
        {
            return;
        }

        $this->laravel['config']['broadcasting.connections.pusher.secret'] = $secret;

        $this->info('Pusher secret set successfully.');
    }

    /**
     * Generate a random secret for the application.
     *
     * @return string
     * @throws \Exception
     */
    protected function generateRandomSecret(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Set the application secret in the environment file.
     *
     * @param string $secret
     * @return bool
     */
    protected function setSecretInEnvironmentFile($secret): bool
    {
        if (!$this->confirmToProceed())
        {
            return false;
        }

        $this->writeNewEnvironmentFileWith($secret);

        return true;
    }

    /**
     * Write a new environment file with the given secret.
     *
     * @param string $secret
     */
    protected function writeNewEnvironmentFileWith($secret)
    {
        /** @var mixed */
        $laravel = $this->laravel;

        $content = file_get_contents(
            $laravel->environmentFilePath()
        );

        if (!Str::contains($content, 'PUSHER_APP_SECRET'))
        {
            file_put_contents(
                $laravel->environmentFilePath(),
                'PUSHER_APP_SECRET=' . $secret,
                FILE_APPEND
            );

            return;
        }

        file_put_contents(
            $laravel->environmentFilePath(),
            preg_replace(
                $this->secretReplacementPattern(),
                'PUSHER_APP_SECRET=' . $secret,
                $content
            )
        );
    }

    /**
     * Get a regex pattern that will match env PUSHER_APP_SECRET with any random secret.
     *
     * @return string
     */
    protected function secretReplacementPattern(): string
    {
        $escaped = preg_quote('=' . $this->laravel['config']['broadcasting.connections.pusher.secret'], '/');

        return "/^PUSHER_APP_SECRET{$escaped}/m";
    }
}
