<?php

namespace App\Console\Commands\RolePermission;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Call extends Command
{
    protected $signature = 'role-permission:setup';
    protected $description = 'Set up all role and permission related components';

    private $steps = [
        'create:role-permission-folder-files' => 'Creating folders and files',
        'update:route-role-permission' => 'Updating routes',
        'update:role-permission-dashboard-sidebar' => 'Updating dashboard sidebar',
        'update:view-role-permission' => 'Updating views',
        'update:js-role-permission' => 'Updating JavaScript',
        'update:controller-role-permission' => 'Updating controllers',
    ];

    public function handle()
    {
        $this->info('Starting role and permission setup...');
        $this->newLine();

        $bar = $this->output->createProgressBar(count($this->steps));
        $bar->start();

        foreach ($this->steps as $command => $description) {
            $this->x($command, $description, $bar);
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Role and permission setup completed successfully!');
    }

    private function x($command, $description, $bar)
    {
        $this->newLine();
        $this->line("  <fg=yellow>➤</> $description...");

        // Simulate command execution with a loading animation
        $this->simulateLoading();

        Artisan::call($command);
        $bar->advance();

        $this->line("  <fg=green>✔</> $description completed.");
        $this->newLine();

        // Add a delay between steps
        sleep(1);
    }

    private function simulateLoading()
    {
        $chars = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];
        $iterations = 10;

        for ($i = 0; $i < $iterations; $i++) {
            $char = $chars[$i % count($chars)];
            $this->output->write("\r  $char");
            usleep(100000); // 0.1 second delay
        }

        $this->output->write("\r");
    }
}
