<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom public path for InfinityFree (htdocs is the web root)
        if (str_contains(base_path(), 'htdocs')) {
            $this->app->instance('path.public', base_path());
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            \Illuminate\Support\Facades\Storage::extend('google', function ($app, $config) {
                $options = [];
                // Definisikan target Folder ID ke sharedFolderId agar di-treat sebagai ID, bukan path string
                if (!empty($config['folder'])) {
                    $options['sharedFolderId'] = $config['folder'];
                }

                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new \Google\Service\Drive($client);
                
                // Parameter kedua (root) kita kosongkan agar adapter patuh pada sharedFolderId
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, '', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Drive Provider Boot Error: ' . $e->getMessage());
        }
    }
}