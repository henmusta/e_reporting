<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('permission_roles', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('permission_id');
      $table->unsignedBigInteger('role_id');
      $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('no action')->onDelete('no action');
      $table->foreign('role_id')->references('id')->on('roles')->onUpdate('no action')->onDelete('no action');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('permission_roles');
  }
}
