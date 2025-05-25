<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Submenu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed the menus table
        $menus = [
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'admin.dashboard',
                'order' => 1,
            ],
            [
                'name' => 'Class',
                'slug' => 'class',
                'icon' => 'fas fa-school',
                'route' => 'admin.categories',
                'order' => 2,
            ],
            [
                'name' => 'Course',
                'slug' => 'course',
                'icon' => 'fas fa-school',
                'route' => 'admin.courses',
                'order' => 3,
            ],
            [
                'name' => 'Student enrollment',
                'slug' => 'student-enrollment',
                'icon' => 'fas fa-school',
                'route' => 'admin.enroll.history',
                'order' => 4,
            ],
            [
                'name' => 'Payment Report',
                'slug' => 'payment-report',
                'icon' => 'fas fa-money-bill-wave',
                'route' => 'admin.purchase.history',
                'order' => 5,
            ],
            [
                'name' => 'Users',
                'slug' => 'users',
                'icon' => 'fas fa-users',
                'route' => 'admin.users',
                'order' => 6,
            ],
            [
                'name' => 'Message',
                'slug' => 'message',
                'icon' => 'fas fa-envelope',
                'route' => 'admin.message',
                'order' => 7,
            ],
            [
                'name' => 'Newsletter',
                'slug' => 'newsletter',
                'icon' => 'fas fa-newspaper',
                'route' => 'admin.newsletter',
                'order' => 8,
            ],
            [
                'name' => 'Contacts',
                'slug' => 'contacts',
                'icon' => 'fas fa-address-book',
                'route' => 'admin.contacts',
                'order' => 9,
            ],
            [
                'name' => 'Blogs',
                'slug' => 'blogs',
                'icon' => 'fas fa-school',
                'route' => 'admin.blogs',
                'order' => 10,
            ],
            [
                'name' => 'System Settings',
                'slug' => 'system-settings',
                'icon' => 'fas fa-cogs',
                'route' => 'admin.system.settings',
                'order' => 11,
            ],
            [
                'name' => 'Manage Profile',
                'slug' => 'manage-profile',
                'icon' => 'fas fa-user',
                'route' => 'admin.manage.profile',
                'order' => 12,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
        // Seed the submenus table
        $submenus = [
            [
                'name' => 'Manage Course',
                'slug' => 'manage-course',
                'menu_id' => 3,
                'route' => 'admin.courses',
                'order' => 1,
            ],
            [
                'name' => 'Add New Course',
                'slug' => 'add-new-course',
                'menu_id' => 3,
                'route' => 'admin.course.create',
                'order' => 2,
            ],
            [
                'name' => 'Coupons',
                'slug' => 'coupons',
                'menu_id' => 3,
                'route' => 'admin.coupons',
                'order' => 3,
            ],
            [
                'name' => 'Enrollment History',
                'slug' => 'enrollment-history',
                'menu_id' => 4,
                'route' => 'admin.enroll.history',
                'order' => 1,
            ],
            [
                'name' => 'Enroll student',
                'slug' => 'enroll-student',
                'menu_id' => 4,
                'route' => 'admin.student.enroll',
                'order' => 2,
            ],
            [
                'name' => 'Offline payments',
                'slug' => 'offline-payments',
                'menu_id' => 5,
                'route' => 'admin.offline.payments',
                'order' => 1,
            ],
            [
                'name' => 'Admin Revenue',
                'slug' => 'admin-revenue',
                'menu_id' => 5,
                'route' => 'admin.revenue',
                'order' => 2,
            ],
            [
                'name' => 'Agent Revenue',
                'slug' => 'agent-revenue',
                'menu_id' => 5,
                'route' => 'admin.instructor.revenue',
                'order' => 3,
            ],
            [
                'name' => 'Payment History',
                'slug' => 'payment-history',
                'menu_id' => 5,
                'route' => 'admin.purchase.history',
                'order' => 4,
            ],
            [
                'name' => 'Role',
                'slug' => 'role',
                'menu_id' => 6,
                'route' => 'admin.user_roles',
                'order' => 1,
            ],
            [
                'name' => 'Permissions',
                'slug' => 'permissions',
                'menu_id' => 6,
                'route' => 'admin.user_permissions',
                'order' => 2,
            ],
            [
                'name' => 'Manage User',
                'slug' => 'manage-user',
                'menu_id' => 6,
            ],
            [
                'name' => 'Manage Newsletters',
                'slug' => 'manage-newsletters',
                'menu_id' => 8,
                'route' => 'admin.newsletter',
                'order' => 1,
            ],
            [
                'name' => 'Subscribed User',
                'slug' => 'subscribed-user',
                'menu_id' => 8,
                'route' => 'admin.subscribed_user',
                'order' => 2,
            ],
            [
                'name' => 'Manage Blogs',
                'slug' => 'manage-blogs',
                'menu_id' => 10,
                'route' => 'admin.blogs',
                'order' => 1,
            ],
            [
                'name' => 'Pending Blogs',
                'slug' => 'pending-blogs',
                'menu_id' => 10,
                'route' => 'admin.blog.pending',
                'order' => 2,
            ],
            [
                'name' => 'Class',
                'slug' => 'class',
                'menu_id' => 10,
                'route' => 'admin.blog.category',
                'order' => 3,
            ],
            [
                'name' => 'Settings',
                'slug' => 'settings',
                'menu_id' => 10,
                'route' => 'admin.blog.settings',
                'order' => 4,
            ],
            [
                'name' => 'System Settings',
                'slug' => 'system-settings',
                'menu_id' => 11,
                'route' => 'admin.system.settings',
                'order' => 1,
            ],
            [
                'name' => 'Website Settings',
                'slug' => 'website-settings',
                'menu_id' => 11,
                'route' => 'admin.website.settings',
                'order' => 2,
            ],
            [
                'name' => 'Payment Settings',
                'slug' => 'payment-settings',
                'menu_id' => 11,
                'route' => 'admin.payment.settings',
                'order' => 3,
            ],
            [
                'name' => 'Manage Language',
                'slug' => 'manage-language',
                'menu_id' => 11,
                'route' => 'admin.manage.language',
                'order' => 4,
            ],
            [
                'name' => 'Live Class Settings',
                'slug' => 'live-class-settings',
                'menu_id' => 11,
                'route' => 'admin.live.class.settings',
                'order' => 5,
            ],
            [
                'name' => 'SMTP Settings',
                'slug' => 'smtp-settings',
                'menu_id' => 11,
                'route' => 'admin.notification.settings',
                'order' => 6,
            ],
            [
                'name' => 'Certificate Settings',
                'slug' => 'certificate-settings',
                'menu_id' => 11,
                'route' => 'admin.certificate.settings',
                'order' => 7,
            ],
            [
                'name' => 'Player Settings',
                'slug' => 'player-settings',
                'menu_id' => c,
                'route' => 'admin.player.settings',
                'order' => 8,
            ],
            [
                'name' => 'Open AI Settings',
                'slug' => 'open-ai-settings',
                'menu_id' => 11,
                'route' => 'admin.open.ai.settings',
                'order' => 9,
            ],
            [
                'name' => 'Home Page Builder',
                'slug' => 'home-page-builder',
                'menu_id' => 11,
                'route' => 'admin.pages',
                'order' => 10,
            ],
            [
                'name' => 'SEO Settings',
                'slug' => 'seo-settings',
                'menu_id' => 11,
                'route' => 'admin.seo.settings',
                'order' => 11,
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'menu_id' => 11,
                'route' => 'admin.about',
                'order' => 12,
            ],
        ];

           foreach ($submenus as $submenu)
            {
                Submenu::create($submenu);
            }

            


        
    }

}
