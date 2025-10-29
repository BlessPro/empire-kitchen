<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $foreignKeyMap = [
            'measurements'           => ['column' => 'project_id', 'action' => 'cascade'],
            'designs'                => ['column' => 'project_id', 'action' => 'cascade'],
            'installations'          => ['column' => 'project_id', 'action' => 'cascade'],
            'comments'               => ['column' => 'project_id', 'action' => 'cascade'],
            'expenses'               => ['column' => 'project_id', 'action' => 'cascade'],
            'incomes'                => ['column' => 'project_id', 'action' => 'cascade'],
            'invoices'               => ['column' => 'project_id', 'action' => 'cascade'],
            'follow_ups'             => ['column' => 'project_id', 'action' => 'null'],
            'measurement_schedules'  => ['column' => 'project_id', 'action' => 'cascade'],
        ];

        foreach ($foreignKeyMap as $tableName => $config) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, $config['column'])) {
                Schema::table($tableName, function (Blueprint $table) use ($config) {
                    $table->dropForeign([$config['column']]);
                });
            }
        }

        // 1) Turn off FK checks so we can drop in any order
        Schema::disableForeignKeyConstraints();

        // 2) Drop dependents first (if they exist)
        if (Schema::hasTable('product_accessory')) {
            Schema::drop('product_accessory');
        }
        if (Schema::hasTable('products')) {
            Schema::drop('products');
        }

        // If you had other children that reference projects, drop them here as well
        // e.g. project_schedules, project_stage_logs …
        // if (Schema::hasTable('project_schedules')) Schema::drop('project_schedules');

        // 3) Drop the parent
        Schema::dropIfExists('projects');

        // 4) Re-enable FK checks for clean creates
        Schema::enableForeignKeyConstraints();

        // 5) Recreate PROJECTS with your new spec
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('technical_supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('designer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('production_officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('installation_officer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name', 150);

            // Three distinct states
            $table->enum('status', ['COMPLETED','ON_GOING','IN_REVIEW'])->default('ON_GOING');
            $table->enum('current_stage', ['MEASUREMENT','DESIGN','PRODUCTION','INSTALLATION'])->nullable();
            $table->enum('booked_status', ['UNBOOKED','BOOKED'])->default('UNBOOKED');

            $table->decimal('estimated_budget', 12, 2)->nullable();

            $table->timestamps();
        });

        // 6) Recreate PRODUCTS (child of projects)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();

            $table->string('name', 150);
            $table->string('product_type', 80)->nullable();
            $table->string('type_of_finish', 80)->nullable();

            $table->char('finish_color_hex', 7)->nullable();         // #RRGGBB
            $table->string('sample_finish_image_path', 255)->nullable();

            $table->string('glass_door_type', 80)->nullable();

            $table->string('worktop_type', 80)->nullable();
            $table->char('worktop_color_hex', 7)->nullable();
            $table->string('sample_worktop_image_path', 255)->nullable();

            $table->string('sink_top_type', 80)->nullable();
            $table->string('handle', 80)->nullable();
            $table->char('sink_color_hex', 7)->nullable();
            $table->string('sample_sink_image_path', 255)->nullable();

            $table->timestamp('installed_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->index('project_id');
        });

        // 7) ACCESSORIES (catalog) — create only if you don't already have it
        if (!Schema::hasTable('accessories')) {
            Schema::create('accessories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->string('category', 80)->nullable();
                $table->decimal('length_mm', 8, 2)->nullable();
                $table->decimal('width_mm', 8, 2)->nullable();
                $table->decimal('height_mm', 8, 2)->nullable();
                $table->decimal('diameter_mm', 8, 2)->nullable();
                $table->string('size', 80)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 8) PIVOT product_accessory
        Schema::create('product_accessory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('accessory_id')->constrained('accessories')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['product_id','accessory_id']); // prevent duplicates per product
        });

        foreach ($foreignKeyMap as $tableName => $config) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, $config['column'])) {
                Schema::table($tableName, function (Blueprint $table) use ($config) {
                    $foreign = $table->foreign($config['column'])->references('id')->on('projects');
                    if ($config['action'] === 'null') {
                        $foreign->nullOnDelete();
                    } else {
                        $foreign->cascadeOnDelete();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_accessory');
        Schema::dropIfExists('products');
        Schema::dropIfExists('projects');
        Schema::enableForeignKeyConstraints();
    }
};
