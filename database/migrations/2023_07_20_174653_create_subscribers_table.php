<?php

use App\Models\Subscriber;
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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->enum('state', [
                Subscriber::STATE_ACTIVE,
                Subscriber::STATE_UNSUBSCRIBED,
                Subscriber::STATE_JUNK,
                Subscriber::STATE_BOUNCE,
                Subscriber::STATE_UNCONFIRMED
            ])->default(Subscriber::STATE_ACTIVE);
            $table->string('source');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
};
