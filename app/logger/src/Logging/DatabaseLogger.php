<?php
namespace App\Logger\Logging;

use Monolog\Logger as Monolog;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;

class DatabaseLogger
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger(new Monolog('database'));

        $logger->pushHandler(new class extends AbstractProcessingHandler {
            protected function write(LogRecord $record): void
            {
                DB::table('logs')->insert([
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => json_encode($record['context']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return $logger;
    }
}