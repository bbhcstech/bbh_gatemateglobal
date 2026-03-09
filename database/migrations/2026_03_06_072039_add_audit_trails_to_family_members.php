<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditTrailsToFamilyMembers extends Migration
{
    public function up()
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->tinyInteger('activity_status')->default(1)->after('mobile');
            $table->tinyInteger('deleted_status')->default(0)->after('activity_status');
            $table->bigInteger('created_by')->nullable()->after('deleted_status');
            $table->bigInteger('updated_by')->nullable()->after('created_at');
            $table->bigInteger('deleted_by')->nullable()->after('updated_at');
            $table->timestamp('deleted_at')->nullable()->after('deleted_by');
        });
    }

    public function down()
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->dropColumn([
                'activity_status',
                'deleted_status',
                'created_by',
                'updated_by',
                'deleted_by',
                'deleted_at'
            ]);
        });
    }
}
