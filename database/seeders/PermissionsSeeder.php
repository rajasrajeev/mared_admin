<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Menu;
use App\Models\Submenu;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard Permissions
            [
                'name' => 'View Dashboard',
                'slug' => 'view-dashboard',
                'route' => 'admin.dashboard',
                'menu_id' => Menu::where('slug', 'dashboard')->first()->id,
                'submenu_id' => null,
            ],

            // Class Permissions
            [
                'name' => 'Manage Classes',
                'slug' => 'manage-classes',
                'route' => 'admin.categories',
                'menu_id' => Menu::where('slug', 'class')->first()->id,
                'submenu_id' => null,
            ],

            // Course Permissions
            [
                'name' => 'Manage Course',
                'slug' => 'manage-course',
                'route' => 'admin.courses',
                'menu_id' => Menu::where('slug', 'course')->first()->id,
                'submenu_id' => Submenu::where('slug', 'manage-course')->first()->id,
            ],
            [
                'name' => 'Add New Course',
                'slug' => 'add-new-course',
                'route' => 'admin.course.create',
                'menu_id' => Menu::where('slug', 'course')->first()->id,
                'submenu_id' => Submenu::where('slug', 'add-new-course')->first()->id,
            ],
            [
                'name' => 'Coupons',
                'slug' => 'coupons',
                'route' => 'admin.coupons',
                'menu_id' => Menu::where('slug', 'course')->first()->id,
                'submenu_id' => Submenu::where('slug', 'coupons')->first()->id,
            ],

            // Student Enrollment Permissions
            [
                'name' => 'Enrollment History',
                'slug' => 'enrollment-history',
                'route' => 'admin.enroll.history',
                'menu_id' => Menu::where('slug', 'student-enrollment')->first()->id,
                'submenu_id' => Submenu::where('slug', 'enrollment-history')->first()->id,
            ],
            [
                'name' => 'Enroll Student',
                'slug' => 'enroll-student',
                'route' => 'admin.student.enroll',
                'menu_id' => Menu::where('slug', 'student-enrollment')->first()->id,
                'submenu_id' => Submenu::where('slug', 'enroll-student')->first()->id,
            ],

            // Payment Report Permissions
            [
                'name' => 'Offline Payments',
                'slug' => 'offline-payments',
                'route' => 'admin.offline.payments',
                'menu_id' => Menu::where('slug', 'payment-report')->first()->id,
                'submenu_id' => Submenu::where('slug', 'offline-payments')->first()->id,
            ],
            [
                'name' => 'Admin Revenue',
                'slug' => 'admin-revenue',
                'route' => 'admin.revenue',
                'menu_id' => Menu::where('slug', 'payment-report')->first()->id,
                'submenu_id' => Submenu::where('slug', 'admin-revenue')->first()->id,
            ],
            [
                'name' => 'Agent Revenue',
                'slug' => 'agent-revenue',
                'route' => 'admin.instructor.revenue',
                'menu_id' => Menu::where('slug', 'payment-report')->first()->id,
                'submenu_id' => Submenu::where('slug', 'agent-revenue')->first()->id,
            ],
            [
                'name' => 'Payment History',
                'slug' => 'payment-history',
                'route' => 'admin.purchase.history',
                'menu_id' => Menu::where('slug', 'payment-report')->first()->id,
                'submenu_id' => Submenu::where('slug', 'payment-history')->first()->id,
            ],

            // User Permissions
            [
                'name' => 'Manage Users',
                'slug' => 'manage-users',
                'route' => 'admin.users',
                'menu_id' => Menu::where('slug', 'users')->first()->id,
                'submenu_id' => Submenu::where('slug', 'manage-user')->first()->id,
            ],
            [
                'name' => 'Role',
                'slug' => 'role',
                'route' => 'admin.user_roles',
                'menu_id' => Menu::where('slug', 'users')->first()->id,
                'submenu_id' => Submenu::where('slug', 'role')->first()->id,
            ],
            [
                'name' => 'Permissions',
                'slug' => 'permissions',
                'route' => 'admin.user_permissions',
                'menu_id' => Menu::where('slug', 'users')->first()->id,
                'submenu_id' => Submenu::where('slug', 'permissions')->first()->id,
            ],

            // Newsletter Permissions
            [
                'name' => 'Manage Newsletters',
                'slug' => 'manage-newsletters',
                'route' => 'admin.newsletter',
                'menu_id' => Menu::where('slug', 'newsletter')->first()->id,
                'submenu_id' => Submenu::where('slug', 'manage-newsletters')->first()->id,
            ],
            [
                'name' => 'Subscribed Users',
                'slug' => 'subscribed-users',
                'route' => 'admin.subscribed_user',
                'menu_id' => Menu::where('slug', 'newsletter')->first()->id,
                'submenu_id' => Submenu::where('slug', 'subscribed-user')->first()->id,
            ],

            // Blog Permissions
            [
                'name' => 'Manage Blogs',
                'slug' => 'manage-blogs',
                'route' => 'admin.blogs',
                'menu_id' => Menu::where('slug', 'blogs')->first()->id,
                'submenu_id' => Submenu::where('slug', 'manage-blogs')->first()->id,
            ],
            [
                'name' => 'Pending Blogs',
                'slug' => 'pending-blogs',
                'route' => 'admin.blog.pending',
                'menu_id' => Menu::where('slug', 'blogs')->first()->id,
                'submenu_id' => Submenu::where('slug', 'pending-blogs')->first()->id,
            ],

            // System Settings Permissions
            [
                'name' => 'System Settings',
                'slug' => 'system-settings',
                'route' => 'admin.system.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'system-settings')->first()->id,
            ],
            [
                'name' => 'Website Settings',
                'slug' => 'website-settings',
                'route' => 'admin.website.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'website-settings')->first()->id,
            ],
            [
                'name' => 'Payment Settings',
                'slug' => 'payment-settings',
                'route' => 'admin.payment.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'payment-settings')->first()->id,
            ],
            [
                'name' => 'Manage Language',
                'slug' => 'manage-language',
                'route' => 'admin.manage.language',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'manage-language')->first()->id,
            ],
            [
                'name' => 'Live Class Settings',
                'slug' => 'live-class-settings',
                'route' => 'admin.live.class.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'live-class-settings')->first()->id,
            ],
            [
                'name' => 'SMTP Settings',
                'slug' => 'smtp-settings',
                'route' => 'admin.notification.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'smtp-settings')->first()->id,
            ],
            [
                'name' => 'Certificate Settings',
                'slug' => 'certificate-settings',
                'route' => 'admin.certificate.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'certificate-settings')->first()->id,
            ],
            [
                'name' => 'Player Settings',
                'slug' => 'player-settings',
                'route' => 'admin.player.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'player-settings')->first()->id,
            ],
            [
                'name' => 'Open AI Settings',
                'slug' => 'open-ai-settings',
                'route' => 'admin.open.ai.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'open-ai-settings')->first()->id,
            ],
            [
                'name' => 'Home Page Builder',
                'slug' => 'home-page-builder',
                'route' => 'admin.pages',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'home-page-builder')->first()->id,
            ],
            [
                'name' => 'SEO Settings',
                'slug' => 'seo-settings',
                'route' => 'admin.seo.settings',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'seo-settings')->first()->id,
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'route' => 'admin.about',
                'menu_id' => Menu::where('slug', 'system-settings')->first()->id,
                'submenu_id' => Submenu::where('slug', 'about')->first()->id,
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
