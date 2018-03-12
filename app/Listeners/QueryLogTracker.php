<?php
namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use DateTime;
use DB;

/**
 * Export Query Log
 *
 * @package app.Listeners
 */
class QueryLogTracker
{
    /**
     * Handle the event.
     *
     * @param    QueryExecuted $event
     * @internal param $query
     * @internal param $bindings
     * @internal param $time
     */
    public function handle(QueryExecuted $event)
    {
        // Formatting Query
        $time     = $event->time;
        $bindings = $event->bindings;
        foreach ($bindings as $i => $binding) {
            if ($binding instanceof DateTime) {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } elseif (is_string($binding)) {
                $bindings[$i] = DB::getPdo()->quote($binding);
            } elseif (null === $binding) {
                $bindings[$i] = 'null';
            }
        }
        $query = str_replace(['%', '?', "\r", "\n", "\t"], ['%%', '%s', ' ', ' ', ' '], $event->sql);
        $query = preg_replace('/\s+/uD', ' ', $query);
        $query = vsprintf($query, $bindings) . ';';

        // Export LogFile
        app('sql-log')->debug($query, compact('time'));
    }
}
