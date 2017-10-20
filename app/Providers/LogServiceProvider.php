<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;

/**
 * Logger Registration Provider
 *
 * @package app.Providers
 */
class LogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     */
    public function register()
    {
        $this->app->singleton('log', function () {
            return $this->createAppLogger();
        });
        $this->app->singleton('sql-log', function () {
            return $this->createSqlLogger();
        });
    }

    /**
     * Create the app logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createAppLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureHandler($log, 'app');
        return $log;
    }

    /**
     * Create the sql logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createSqlLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureHandler($log, 'sql');
        return $log;
    }

    /**
     * Get the name of the log "channel".
     *
     * @return string
     */
    protected function channel()
    {
        return $this->app->bound('env') ? $this->app->environment() : 'production';
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string $base_name
     * @return void
     */
    protected function configureHandler(Writer $log, $base_name)
    {
        $this->{'configure'.ucfirst($this->handler()).'Handler'}($log, $base_name);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string $base_name
     * @return void
     */
    protected function configureSingleHandler(Writer $log, $base_name)
    {
        $log->useFiles(
            sprintf('%s/logs/%s%s.log', $this->app->storagePath(), $this->getFilePrefix(), $base_name),
            $this->logLevel()
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string $base_name
     * @return void
     */
    protected function configureDailyHandler(Writer $log, $base_name)
    {
        $log->useDailyFiles(
            sprintf('%s/logs/%s%s.log', $this->app->storagePath(), $this->getFilePrefix(), $base_name),
            $this->maxFiles(),
            $this->logLevel()
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string $base_name
     * @return void
     */
    protected function configureSyslogHandler(Writer $log, $base_name)
    {
        $log->useSyslog($base_name, $this->logLevel());
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer  $log
     * @param  string $base_name
     * @return void
     */
    protected function configureErrorlogHandler(Writer $log, $base_name)
    {
        $log->useErrorLog($this->logLevel());
    }

    /**
     * Get the default log handler.
     *
     * @return string
     */
    protected function handler()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log', 'single');
        }

        return 'single';
    }

    /**
     * Get the log level for the application.
     *
     * @return string
     */
    protected function logLevel()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_level', 'debug');
        }

        return 'debug';
    }

    /**
     * Get the maximum number of log files for the application.
     *
     * @return int
     */
    protected function maxFiles()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_max_files', 5);
        }

        return 0;
    }

    /**
     * Get thee FilePrefix
     *
     * @return string
     */
    private function getFilePrefix()
    {
        return php_sapi_name() == 'cli' ? 'cli_' : '';
    }

}