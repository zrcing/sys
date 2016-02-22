<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class Monitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart php-fpm of services of server on "502 Bad Gateway"';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $command = env('SERVICE_PHP_FPM');
        $url = env('MONITORING_URL');
        $exec = "curl  connect-timeout 3 -I $url 2>/dev/null";
        $res = shell_exec($exec);
        
        if (stripos($res, '502 Bad Gateway') !== false) {
            Log::notice('Restart PHP-FPM');
            shell_exec($command);
        }
    }
}
