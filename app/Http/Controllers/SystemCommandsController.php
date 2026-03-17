<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class SystemCommandsController extends Controller
{
    public function run(Request $request)
    {
        try {
            $keys = $request->input('keys');

            if (!is_array($keys) || empty($keys)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No commands provided',
                ], 422);
            }

            $map = [
                'route_clear'    => 'route:clear',
                'route_cache'    => 'route:cache',
                'cache_clear'    => 'cache:clear',
                'config_clear'   => 'config:clear',
                'config_cache'   => 'config:cache',
                'view_clear'     => 'view:clear',
                'view_cache'     => 'view:cache',
                'event_clear'    => 'event:clear',
                'event_cache'    => 'event:cache',
                'optimize_clear' => 'optimize:clear',
                'queue_restart'  => 'queue:restart',
                'schedule_run'   => 'schedule:run',
                'storage_link'   => 'storage:link',
            ];

            $results = [];
            $executed = 0;

            foreach ($keys as $key) {
                if (!isset($map[$key])) {
                    continue;
                }

                $command = $map[$key];

                try {
                    Artisan::call($command);
                    $results[] = "✔ {$command}";
                    $executed++;
                } catch (Throwable $e) {
                    Log::error('System command failed', [
                        'key' => $key,
                        'command' => $command,
                        'error' => $e->getMessage(),
                    ]);

                    $results[] = " {$command} — {$e->getMessage()}";
                }
            }

            return response()->json([
                'ok' => true,
                'executed' => $executed,
                'results' => $results,
            ]);

        } catch (Throwable $e) {
            Log::critical('SystemCommandsController fatal error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

}
