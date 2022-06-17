<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend as Backend;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return redirect()->route('backend.login');
// });
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::prefix('backend')->name('backend.')->group(function () {
  Route::post('/', [LoginController::class, 'login'])->name('login');
  Route::post('resetpassword', [Backend\UserController::class, 'resetpassword'])->name('users.resetpassword');
  Route::get('dashboard', [Backend\DashboardController::class, 'index'])->name('index');

  Route::get('reporting/select2', [Backend\ReportingController::class, 'select2'])->name('reporting.select2');
  Route::resource('reporting', Backend\ReportingController::class);

  Route::resource('terumumkan', Backend\TerumumkanController::class);

  Route::resource('proseskontrak', Backend\ProsesKontrakController::class);

  Route::resource('pelaksanaan', Backend\PelaksanaanController::class);

  Route::resource('laporan', Backend\LaporanController::class);

  Route::get('selesai/{id}/cekstatus', [Backend\SelesaiController::class, 'cekstatus'])->name('selesai.cekstatus');
  Route::resource('selesai', Backend\SelesaiController::class);

  Route::resource('settings', Backend\SettingsController::class);

  Route::get('paket/select2', [Backend\PaketController::class, 'select2'])->name('paket.select2');
  Route::resource('paket', Backend\PaketController::class);

  Route::resource('users', Backend\UserController::class);

  Route::get('roles/select2', [Backend\RoleController::class, 'select2'])->name('roles.select2');
  Route::resource('roles', Backend\RoleController::class);

  Route::resource('permissions', Backend\PermissionController::class);
  Route::get('menupermissions/select2', [Backend\MenuPermissionController::class, 'select2'])->name('menupermissions.select2');
  Route::resource('menupermissions', Backend\MenuPermissionController::class)->except('create', 'edit', 'show');
  Route::resource('menu', Backend\MenuManagerController::class)->except('create', 'show');
  Route::post('menu/changeHierarchy', [Backend\MenuManagerController::class, 'changeHierarchy'])->name('menu.changeHierarchy');
 });
// });
