# Tadah
The Tadah Website

## CI/CD
Tadah.Web is available on the Tadah CI. TeamCity builds the Docker image and uploads it to the Tadah internal Docker image registry (CI), and then tells the server to pull the newest image (CD).
- [production](https://ci.tadah.sipr/buildConfiguration/Tadah_Web_Production) (on https://tadah.rocks/)
- [development](https://ci.tadah.sipr/buildConfiguration/Tadah_Web_Development) (on https://tadahlabs.rocks/)

## Notes
- Deploys are run on each push to `dev`. They are pushed to https://tadahlabs.rocks. Upon proper assessment, these updates can manually be pushed to production on https://tadah.rocks. The dev website is barred off and should only be accessible to developers. A mock database will be run on https://tadahlabs.rocks - it shall not be linked to the production database.
- Do not force-push build artifacts, such as CSS or JavaScript assets generated from Laravel Mix. Laravel Mix gets run during the deploy process. Force pushing build artifacts will result in endless merge conflicts, and is generally bad practice.
- Please submit bugs, issues, and features to add as an issue. New features should be a separate branch and should be a pull request once ready to merge with the trunk branch. The production branch should never be touched manually.
- Please sign your commits.

## Stack
Tadah uses a BALL stack; Bootstrap, Alpine, Livewire, Laravel. On the backend, we use PostgreSQL for our Database. Additionally, Redis is used for cache, Meilisearch is used for search, and Mailhog is used for mail environment simulation.

Docker is used both on the developer's environment (in the form of Laravel Sail) and on the production environment (in the form a fully independent Docker container.)

## Local Environment
If on Linux, read steps starting from step 5. If on Windows, read all steps.

1. Download and install Ubuntu (no version -- get generic) from the Microsoft Store
2. Download and install Docker Desktop for Windows. Install WSL2 if need be.
3. Enable Docker -> Ubuntu integration by opening Docker Desktop and navigating to Settings -> Resources -> WSL Integration and toggling Ubuntu
4. Open your Ubuntu terminal. Navigate to where you are keeping the Tadah repository (i.e. if on `C:\Tadah`, you do `cd /mnt/c/Tadah`)
5. Copy `.env.example` to `.env`. Line breaks might be malformed on Windows. If so, replace all occurrences of `\r\n` in `.env` with `\n`
7. Run `composer install` if you don't have the composer dependencies installed yet.
8. Run `./vendor/bin/sail up -d`
9. Generate the application keys:
    - App: `./vendor/bin/sail artisan key:generate`
    - Pusher: `./vendor/bin/sail artisan pusher:secret`
    - Ciphersweet: `./vendor/bin/sail artisan ciphersweet:key`
    - Meilisearch: `./vendor/bin/sail artisan meilisearch:key`
10. Run `./vendor/bin/sail npm ci && npm run dev`
11. Run `./vendor/bin/sail artisan migrate` if your migrations are not up already.
12. You may now navigate to http://127.0.0.1 to view Tadah.

You may consult the [Laravel Sail documentation](https://laravel.com/docs/8.x/sail) for running Artisan and Composer commands.

## License
~~Copyright (c) Tadah 2021-2022. All rights reserved. Not for public use.~~

Licensed under the GNU Affero General Public License v3.0. A copy of it [has been included](https://github.com/tadah-foss/web/blob/trunk/LICENSE).
