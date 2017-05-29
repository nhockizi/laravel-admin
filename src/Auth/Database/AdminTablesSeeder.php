<?php

namespace Kizi\Admin\Auth\Database;

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name'     => 'Administrator',
        ]);
        // create a crawler.
        CrawlerDb::truncate();
        CrawlerDb::insert([
            [
                'code' => 'abc1',
                'url' => 'https://techmaster.vn',
                'parame_url'     => '/posts',
                'item'     => '',
                'images'     => 'div.card-image a img',
                'title'     => 'div.card-content h2.card-title a p',
                'description'     => 'div.card-content h2.card-title a p',
                'url_detail'     => 'div.card-content h2.card-title a',
                'detail'     => 'div.main-post',
                'category'     => '',
                'number_run' => 1
            ],
            [
                'code' => 'abc2',
                'url' => 'http://www.chiasephp.net',
                'parame_url'     => '/tut/lap-trinh-php/php-co-ban/trang-{page}.html',
                'item'     => 'div.widget div.post-outer',
                'images'     => 'div.img-thumbnail img',
                'title'     => 'div.post-outer h2.post-title a',
                'description'     => 'div.post-body div.snippets',
                'url_detail'     => 'div.post-outer h2.post-title a',
                'detail'     => 'div.post-outer article.post',
                'category'     => 'span.author-info a',
                'number_run' => 3
            ]
        ]);
        // create a crawler.
        CategoryNews::truncate();
        CategoryNews::insert([
            [
                'name' => 'Lập trình PHP',
                'parent_id' => '0',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'PHP Cơ bản',
                'parent_id' => '1',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'PHP nâng cao',
                'parent_id' => '1',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Codeinighter',
                'parent_id' => '1',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Regular Expression',
                'parent_id' => '1',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Curl',
                'parent_id' => '1',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Database',
                'parent_id' => '0',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Học Mysql',
                'parent_id' => '7',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Học MongoDB',
                'parent_id' => '7',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Học JSON',
                'parent_id' => '7',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Học XML',
                'parent_id' => '7',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Javascript',
                'parent_id' => '0',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'JQuery tutorial',
                'parent_id' => '12',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'NodeJs',
                'parent_id' => '12',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Phát triển web',
                'parent_id' => '0',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'HTML & CSS',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'PHP & MySQL',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Smarty Engine',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'PHP MVC',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Htaccess',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'Ajax',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
            [
                'name' => 'PHP Tutorials',
                'parent_id' => '15',
                'active' => '1',
                'number_sort' => '1',
            ],
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Index',
                'icon'      => 'fa-bar-chart',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'Admin',
                'icon'      => 'fa-tasks',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'Users',
                'icon'      => 'fa-users',
                'uri'       => 'users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => 'Roles',
                'icon'      => 'fa-user',
                'uri'       => 'roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => 'Permission',
                'icon'      => 'fa-user',
                'uri'       => 'permissions',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => 'Menu',
                'icon'      => 'fa-bars',
                'uri'       => 'menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => 'Operation log',
                'icon'      => 'fa-history',
                'uri'       => 'logs',
            ],
            [
                'parent_id' => 0,
                'order'     => 8,
                'title'     => 'Helpers',
                'icon'      => 'fa-gears',
                'uri'       => '',
            ],
            [
                'parent_id' => 8,
                'order'     => 9,
                'title'     => 'Scaffold',
                'icon'      => 'fa-keyboard-o',
                'uri'       => 'helpers/scaffold',
            ],
            [
                'parent_id' => 8,
                'order'     => 10,
                'title'     => 'Database terminal',
                'icon'      => 'fa-database',
                'uri'       => 'helpers/terminal/database',
            ],
            [
                'parent_id' => 8,
                'order'     => 11,
                'title'     => 'Laravel artisan',
                'icon'      => 'fa-terminal',
                'uri'       => 'helpers/terminal/artisan',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save(Role::first());
        Menu::find(8)->roles()->save(Role::first());
    }
}
