<?php

use App\Enums\UserAccountStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('country_id');

            $table->string('username')->nullable()->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('display_name')->nullable();

            $table->string('avatar')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en');
            $table->string('currency')->default('USD');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('phone')->nullable()->index();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('user_type')->default(UserType::BUYER->value);
            $table->string('account_status')->default(UserAccountStatus::PENDING_VERIFICATION->value);

            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();

            $table->boolean('two_factor_enabled')->default(false);

            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamp('privacy_accepted_at')->nullable();

            $table->timestamp('last_synced_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $this->addMorphedAuditColumns($table);

            // Indexes
            $table->index('email');
            $table->index('user_type');
            $table->index('account_status');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
