<?php

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
        Schema::create('vehicle_requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Staff Information
            $table->string('staff_name');
            $table->string('designation');
            $table->string('mobile');
            $table->text('purpose');
            
            // Journey Details
            $table->date('starting_date');
            $table->time('starting_time');
            $table->date('ending_date');
            $table->time('ending_time');
            
            // Flight Details (Optional)
            $table->string('flight_no')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
            
            // Budget Code
            $table->string('business_unit')->nullable();
            $table->string('account')->nullable();
            $table->string('contract')->nullable();
            $table->string('department')->nullable();
            $table->string('analysis_code')->nullable();
            $table->string('project_id')->nullable();
            $table->string('project_activity')->nullable();
            
            // Pickup/Drop locations
            $table->string('pickup_address');
            $table->string('drop_address');
            
            // Type (Official/Personal)
            $table->enum('requisition_type', ['official', 'personal'])->default('official');
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            
            // Vehicle Assignment
            $table->string('assigned_driver')->nullable();
            $table->string('assigned_vehicle')->nullable();
            $table->timestamp('assigned_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_requisitions');
    }
};