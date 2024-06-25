<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any invalid status values to 'pending'
        DB::table('applications')
            ->whereNotIn('status', ['pending', 'accepted', 'rejected'])
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse the status update
    }
};
