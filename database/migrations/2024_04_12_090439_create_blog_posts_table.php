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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('category_id')->unsigned(); // id категории, ссылка на данные из таблицы blog_categories
            $table->bigInteger('user_id')->unsigned(); // id автора, ссылка на данные из таблицы users
            // bigInteger для элементов которые являются инкрементными

            $table->string('slug')->unique();
            // поля для построения урлов, будет транслитом и должно быть уникальным - unique.
            // у string можно поставить длину строки через запятую, если нет то макс длина строки в бд
            $table->string('title'); // название поста

            $table->text('excerpt')->nullable(); // выдержка статьи

            $table->text('content_raw')->nullable();
            // сырой контент, при написании статей будем использовать markdown
            // при сохранении автоматически будет превращаться в html
            $table->text('content_html')->nullable(); // контент в html, напрямую не меняем, только читаем, меняем только raw

            $table->boolean('is_published')->default(false); // на самом деле tinyInt false - в бд будет 0
            $table->timestamp('published_at')->nullable(); // когда опубликована

            $table->timestamps(); //поля created && updated - когда запись создана и изменена
            $table->softDeletes(); //поля deleted ad - когда запись была удалена

            // создаем связи
            $table->foreign('user_id')->references('id')->on('users');
            // говорим что у нас это поле user_id и подключаемся id в таблице users
            $table->foreign('category_id')->references('id')->on('blog_categories');
            // говорим что у нас это поле category_id и подключаемся id в таблице blog_categories
            // если не будет созданы таблички users и blog_categories то получим ошибку
            // лучше называть поля для связи точно с совпадением 
            $table->index('is_published');
            // создаем индекс для поля, имя для индекса laravel придумал сам
            // имя ограничено и это нужно учитывать если названия табличек длинные
            // поэтому можно задать имя самому
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
