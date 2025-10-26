<?php

use App\Enums\CurrencyStatus;
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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->index()->default(0);
            $table->string('code')->unique()->comment('USD, EUR, GBP, BDT');
            $table->string('symbol')->nullable()->comment('&#xa3;, &#xa2;, &#x24;');
            $table->string('name')->unique()->comment('US Dollar, Euro');
            $table->decimal('exchange_rate', 18, 6)->comment('against base currency');
            $table->integer('decimal_places')->default(2);

            $table->string('status')->index()->default(CurrencyStatus::ACTIVE->value);
            $table->boolean('is_default')->default(false);

            $table->softDeletes();
            $table->timestamps();
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
