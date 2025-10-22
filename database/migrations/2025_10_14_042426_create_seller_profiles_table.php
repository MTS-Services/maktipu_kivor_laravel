<?php

use App\Enums\SellerLevel;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('user_id');;
            $table->string('shop_name');
            $table->text('shop_description')->nullable();

            $table->boolean('seller_verified')->default(false);
            $table->timestamp('seller_verified_at')->nullable();

            $table->string('seller_level')->default(SellerLevel::BRONZE->value);

            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->decimal('minimum_payout', 10, 2)->default(50.00);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};
