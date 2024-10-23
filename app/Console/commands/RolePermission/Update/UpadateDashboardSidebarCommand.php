<?php

namespace App\Console\Commands\RolePermission\Update;

use Illuminate\Console\Command;

class UpadateDashboardSidebarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:role-permission-dashboard-sidebar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dashboard sidebar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sidebarPath = resource_path('views/dashboard/components/sidebar.blade.php');
        $sidebarContent = file_get_contents($sidebarPath);

        $newMenuItem = <<<EOD
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ request()->routeIs('dashboard.privileges.*') ? 'show' : '' }} menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="bi bi-shield-lock fs-2">
                                </i>
                            </span>
                            <span class="menu-title">Privileges</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('dashboard.privileges.roles.*') ? 'active' : '' }}"
                                    href="{{ route('dashboard.privileges.roles.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Roles</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('dashboard.privileges.permissions.*') ? 'active' : '' }}"
                                    href="{{ route('dashboard.privileges.permissions.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Permissions</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
    EOD;

        $position = '{{-- PRIVILEGES --}}';
        $insertPosition = strpos($sidebarContent, $position);
        if ($insertPosition !== false) {
            $updatedContent = substr_replace($sidebarContent, $newMenuItem, $insertPosition, 0);
            file_put_contents($sidebarPath, $updatedContent);
            $this->info('Dashboard sidebar updated successfully.');
        } else {
            $this->error('Unable to find the insertion point in the sidebar file.');
            $this->error('Please add the position of the privileges in the sidebar file.');
            $this->error('You can add the position of the privileges in the sidebar by writing {{-- PRIVILEGES --}} in the sidebar file.');
        }
    }
}
