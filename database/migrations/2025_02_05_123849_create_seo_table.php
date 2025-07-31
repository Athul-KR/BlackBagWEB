
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    

    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();

            $table->string('seokey',6)->nullable();

            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('ogtitle')->nullable();
            $table->text('ogimage')->nullable();
            $table->text('twittercard')->nullable();
            $table->integer('clinicid')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo');
    }
}
