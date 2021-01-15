<?php

use App\Constants\Currencies;
use App\Constants\Payments;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->string('process_url')->nullable();
            $table->enum('status', Payments::values())->default(Payments::STATUS_PENDING);
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->string('last_digit')->nullable();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedDecimal('amount');
            $table->enum('currency', Currencies::values())->default(Currencies::COP);
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
        Schema::dropIfExists('payments');
    }
}
