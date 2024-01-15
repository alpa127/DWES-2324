<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido__productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('cantidad');
            $table->float('precioU');
            //FK convencion de nombre Laravel
            $table->foreign('pedido_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            //FK sin convencion de nombres Laravel
            $table->integer('producto');
            $table->foreign('producto')->references('id')->on('producto')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido__productos');
    }
};
