<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class MeilisearchKeyGenerate extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:key
        {--show : Display the key instead of modifying files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and set a random Meilisearch key';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $key = $this->generateRandomKey();

        if ($this->option('show'))
        {
            $this->line('<comment>' . $key . '</comment>');
            return;
        }

        if (!$this->setKeyInEnvironmentFile($key))
        {
            return;
        }

        $this->laravel['config']['scout.meilisearch.key'] = $key;

        $this->info('Meilisearch key set successfully.');
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     * @throws \Exception
     */
    protected function generateRandomKey(): string
    {
        return bin2hex(random_bytes(64));
    }

    /**
     * Set the Meilisearch key in the environment file.
     *
     * @param string $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key): bool
    {
        if (!$this->confirmToProceed())
        {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key);

        return true;
    }

    /**
     * Write a new environment file with the given Meilisearch key.
     *
     * @param string $key
     */
    protected function writeNewEnvironmentFileWith($key)
    {
        /** @var mixed */
        $laravel = $this->laravel;

        $content = file_get_contents(
            $laravel->environmentFilePath()
        );

        if (!Str::contains($content, 'MEILISEARCH_KEY'))
        {
            file_put_contents(
                $laravel->environmentFilePath(),
                'MEILISEARCH_KEY=' . $key,
                FILE_APPEND
            );

            return;
        }

        file_put_contents(
            $laravel->environmentFilePath(),
            preg_replace(
                $this->keyReplacementPattern(),
                'MEILISEARCH_KEY=' . $key,
                $content
            )
        );
    }

    /**
     * Get a regex pattern that will match env MEILISEARCH_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['scout.meilisearch.key'], '/');

        return "/^MEILISEARCH_KEY{$escaped}/m";
    }
}
