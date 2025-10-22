<?php
// database/migrations/xxxx_xx_xx_add_unique_idx_to_project_phases.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('project_phases', function (Blueprint $table) {
            $table->unique(['project_id','phase_template_id'], 'project_phases_project_template_unique');
        });
    }
    public function down(): void {
        Schema::table('project_phases', function (Blueprint $table) {
            $table->dropUnique('project_phases_project_template_unique');
        });
    }
};
