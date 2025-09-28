<?php

namespace App\Console\Commands;

use App\Models\Site;
use Illuminate\Console\Command;

class CheckSiteStatus extends Command
{
    protected $signature = 'winfree:check-status';
    protected $description = 'Check status of all Winfree sites by pinging them';

    public function handle()
    {
        $this->info('Starting to check Winfree site statuses...');
        $sites = Site::all();

        foreach ($sites as $site) {
            // Deteksi OS untuk perintah ping yang benar
            $pingCommand = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                ? "ping -n 1 -w 1000 " . escapeshellarg($site->ip_address)
                : "ping -c 1 -W 1 " . escapeshellarg($site->ip_address);

            exec($pingCommand, $output, $result);

            $site->status = ($result == 0);
            $site->last_checked_at = now();
            $site->save();

            $statusText = $site->status ? '<info>UP</info>' : '<error>DOWN</error>';
            $this->line("Site '{$site->name}' ({$site->ip_address}) is {$statusText}.");
        }

        $this->info('All sites have been checked.');
        return 0;
    }
}
