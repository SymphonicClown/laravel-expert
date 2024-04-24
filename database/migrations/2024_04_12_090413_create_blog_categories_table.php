<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id(); // Автоинкремент?
            $table->integer('parent_id')->unsigned()->default(0);
            // создаем поле parent_id типа integer,unsigned - от нуля и выше
            //(чтобы быть такой же как автоинкремент) , default(0) - по умолчанию значение 0, т/е/ без parent

            $table->string('slug')->unique();
            // поля для построения урлов, будет транслитом и должно быть уникальным - unique.
            // у string можно поставить длину строки через запятую, если нет то макс длина строки в бд
            $table->string('title'); // название категории
            $table->text('description')->nullable(); // поле описания nullable - по-умолчанию можно не заполнять

            $table->timestamps(); //поля created && updated - когда запись создана и изменена
            $table->softDeletes(); //поля deleted ad - когда запись была удалена

            // $table->foreign('parent_id')->references('id')->on('blog_categories');
            // // говорим что у нас это поле user_id и подключаемся id в таблице users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
