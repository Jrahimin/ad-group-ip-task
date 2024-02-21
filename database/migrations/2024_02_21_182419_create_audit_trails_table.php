<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTrailsTable extends Migration
{
    protected string $tableName = 'audit_trails';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type', 50);
            $table->unsignedBigInteger('auditable_id');
            $table->unsignedTinyInteger('action_type');
            $table->string('old_label')->nullable();
            $table->string('new_label')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
