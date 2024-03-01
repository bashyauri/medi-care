<?php

use App\Models\Vendor;
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
        Schema::create('vendor_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->integer('service_type_id');
            $table->string('license_number');
            $table->string('license_issueing_body');
            $table->string('board_certification')->nullable();
            $table->boolean('telehealth_enabled')->nullable();
            $table->string('document');
            $table->date('expiry_date');
            $table->string('status')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_services');
    }
};
