<?php

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->string('locale')->unique()->comment('en, es, fr, bn');
            $table->string('name')->unique()->comment('English, Spanish, France');
            $table->string('native_name')->nullable()->comment('English, Español');
            $table->string('flag_icon')->nullable();
            $table->string('status')->default(LanguageStatus::ACTIVE->value);
            $table->boolean('is_default')->default(false);
            $table->string('direction')->default(LanguageDirections::LTR->value);
            
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
