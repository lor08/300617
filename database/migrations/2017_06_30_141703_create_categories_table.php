<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->unique();
			$table->text('preview_text')->nullable();
			$table->string('preview_img')->nullable();
			$table->text('detail_text')->nullable();
			$table->string('detail_img')->nullable();
			$table->integer('order')->unsigned()->default(0);
			NestedSet::columns($table);
			$table->timestamps();
		});
		Schema::create('categories_relations', function (Blueprint $table) {
			$table->integer('category_id');
			$table->morphs('categorizable');
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
		Schema::dropIfExists('categories');
		Schema::dropIfExists('categories_relations');
	}
}
