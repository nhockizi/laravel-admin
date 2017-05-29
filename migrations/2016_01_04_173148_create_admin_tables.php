<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->create(config('admin.database.category_news_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->integer('parent_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('number_sort')->default(true);
            $table->timestamps();
        });
        Schema::connection($connection)->create(config('admin.database.batch_schedule_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('command',50)->nullable();
            $table->text('comment')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('time_command', 255)->nullable();
            $table->tinyInteger('effect')->default(1);
            $table->timestamp('last_run')->nullable();
            $table->timestamp('last_start_run')->nullable();
        });
        Schema::connection($connection)->create(config('admin.database.news_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 250)->nullable();
            $table->string('images', 250)->nullable();
            $table->string('description', 250)->nullable();
            $table->text('detail')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('number_sort')->default(true);
            $table->timestamps();
        });
        Schema::connection($connection)->create(config('admin.database.crawler_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('url', 50)->nullable();
            $table->text('parame_url')->nullable();
            $table->tinyInteger('number_run')->default(1);
            $table->boolean('active')->default(true);
            $table->string('item', 50)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('images', 50)->nullable();
            $table->string('description', 50)->nullable();
            $table->string('url_detail', 50)->nullable();
            $table->string('detail', 50)->nullable();
            $table->string('category', 50)->nullable();
            $table->timestamps();
        });
        Schema::connection($connection)->create(config('admin.database.users_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 190)->unique();
            $table->string('password', 60);
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.roles_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.permissions_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.menu_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->integer('order')->default(0);
            $table->string('title', 50);
            $table->string('icon', 50);
            $table->string('uri', 50);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.role_users_table'), function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('user_id');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.role_permissions_table'), function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('permission_id');
            $table->index(['role_id', 'permission_id']);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.user_permissions_table'), function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('permission_id');
            $table->index(['user_id', 'permission_id']);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.role_menu_table'), function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->index(['role_id', 'menu_id']);
            $table->timestamps();
        });

        Schema::connection($connection)->create(config('admin.database.operation_log_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('path');
            $table->string('method', 10);
            $table->string('ip', 15);
            $table->text('input');
            $table->index('user_id');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        Schema::connection($connection)->dropIfExists(config('admin.database.users_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.roles_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.menu_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_users_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_menu_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.operation_log_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_menu_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.crawler_table'));
    }
}
