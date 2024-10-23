<?php

namespace App\Console\Commands\RolePermission\Create;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FolderFilesCommand extends Command
{
    protected $signature = 'create:role-permission-folder-files';
    protected $description = 'Create folder and files for role and permission';

    public function handle()
    {
        $this->createViewFiles();
        $this->createRouteFile();
        $this->createJSFiles();
        $this->createControllers();
        $this->info('Folder and files creation completed.');
    }

    private function createViewFiles()
    {
        $privilegesPath = resource_path('views/dashboard/pages/privileges');
        $this->createDirectory($privilegesPath);

        $files = ['role.blade.php', 'permission.blade.php'];
        foreach ($files as $file) {
            $this->createFile($privilegesPath . '/' . $file);
        }
    }

    private function createRouteFile()
    {
        $routePath = base_path('routes');
        $this->createDirectory($routePath);
        $this->createFile($routePath . '/RolePermission.php');
    }

    private function createControllers()
    {
        $controllerPath = app_path('Http/Controllers/Dashboard/Privileges');
        $this->createDirectory($controllerPath);

        $controllers = [
            'RoleController.php',
            'PermissionController.php'
        ];

        foreach ($controllers as $file) {
            $this->createFile($controllerPath . '/' . $file);
        }
    }


    private function createJSFiles()
    {
        $jsPath = public_path('js/web/dashboard/privileges');
        $this->createDirectory($jsPath);

        $files = ['role.js', 'permission.js'];
        foreach ($files as $file) {
            $this->createFile($jsPath . '/' . $file);
        }
    }

    private function createDirectory($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
            $this->info("Created directory: $path");
        } else {
            $this->info("Directory already exists: $path");
        }
    }

    private function createFile($path, $content = '')
    {
        if (!File::exists($path)) {
            File::put($path, $content);
            $this->info("Created file: $path");
        } else {
            $this->info("File already exists: $path");
        }
    }
}
