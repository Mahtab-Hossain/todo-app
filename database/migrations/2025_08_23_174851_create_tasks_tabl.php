<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks_new', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        // copy data from old table if exists
        if (Schema::hasTable('tasks')) {
            DB::table('tasks_new')->insertUsing(
                ['id','title','description','status','user_id','created_at','updated_at'],
                DB::table('tasks')->select('id','title','description','status','user_id','created_at','updated_at')
            );

            Schema::drop('tasks');
            Schema::rename('tasks_new', 'tasks');
        } else {
            Schema::rename('tasks_new', 'tasks');
        }
    }

    public function down()
    {
        // no-op or implement reverse if needed
    }
};