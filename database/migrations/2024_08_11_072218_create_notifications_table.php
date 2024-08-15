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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');                             // Stores the notification class name
            $table->morphs('notifiable');                         // Creates 'notifiable_id' and 'notifiable_type' (Note: the notifiable is the user in this case)
            $table->text('data');                               // Stores the notification data
            $table->boolean('serialized')->nullable()->default(false);  // True if the notification data is serialized
            $table->timestamp('read_at')->nullable();           // Tracks if the notification has been read
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
