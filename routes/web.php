<?php

// Controllers

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\CcoController;
use App\Http\Controllers\CuacaMingguanController;
use App\Http\Controllers\DetailPekerjaanController;
use App\Http\Controllers\DokumentasiMingguanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\LaporanMingguanController;
use App\Http\Controllers\LaporanPelaksanaanController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PreorderController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;

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

require __DIR__ . '/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//UI Pages Routs
Route::get('/', [HomeController::class, 'uisheet'])->name('uisheet');

Route::group(['middleware' => 'auth'], function () {
    // Permission Module
    Route::get('/role-permission', [RolePermission::class, 'index'])->name('role.permission.list');
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Master Bahan
    Route::resource('bahan', BahanController::class);

    // Master Pekerjaan
    Route::resource('pekerjaan', PekerjaanController::class);

    // Master Tenaga Kerja
    Route::resource('tenaga-kerja', TenagaKerjaController::class);

    // Proyek
    Route::resource('proyek', ProyekController::class);
    Route::get('proyek/{id}/print-rab', [ProyekController::class, 'printRab'])->name('proyek.print-rab');
    Route::get('proyek/{id}/print-boq', [ProyekController::class, 'printBoq'])->name('proyek.print-boq');
    Route::get('proyek/{id}/print-rekap', [ProyekController::class, 'printRekap'])->name('proyek.print-rekap');

    // Detail Pekerjaan
    Route::resource('detail-pekerjaan', DetailPekerjaanController::class);
    Route::get('proyek/{id}/index-detail-pekerjaan', [DetailPekerjaanController::class, 'indexDetailPekerjaan'])->name('proyek.detail-pekerjaan.index');
    Route::get('proyek/{id}/create-detail-pekerjaan', [DetailPekerjaanController::class, 'createDetailPekerjaan'])->name('proyek.detail-pekerjaan.create');

    // CCO
    Route::resource('cco-pekerjaan', CcoController::class);
    Route::get('proyek/{id}/index-cco-pekerjaan', [CcoController::class, 'indexCcoPekerjaan'])->name('proyek.cco-pekerjaan.index');
    Route::get('proyek/{id}/create-cco-pekerjaan', [CcoController::class, 'createCcoPekerjaan'])->name('proyek.cco-pekerjaan.create');
    Route::get('proyek/{id}/print-cco-pekerjaan', [CcoController::class, 'printCcoPekerjaan'])->name('proyek.cco-pekerjaan.print');
    
    // Preorder
    Route::resource('preorder', PreorderController::class);
    Route::get('/get-preorder-minggu-ke/{id}', [PreorderController::class, 'getMingguKe']);
    Route::get('preorder/{id}/print', [PreorderController::class, 'printPreorder'])->name('preorder.print');
    Route::get('preorder/{id}/print-selected', [PreorderController::class, 'printSelectedPreorder'])->name('preorder.print-selected');

    // Approval
    Route::resource('approval', ApprovalController::class);

    // Laporan Harian
    Route::resource('laporan-harian', LaporanHarianController::class);
    Route::get('/get-data-proyek/{id}', [LaporanHarianController::class, 'getDataProyek']);
    Route::get('laporan-harian/{id}/print', [LaporanHarianController::class, 'printLaporanHarian'])->name('laporan-harian.print');

    // Laporan Mingguan
        // Laporan Progress
        Route::resource('laporan-mingguan', LaporanMingguanController::class);
        Route::get('/get-detail-pekerjaan/{id}', [LaporanMingguanController::class, 'getDetailPekerjaan']);
        Route::get('/get-minggu-ke/{id}', [LaporanMingguanController::class, 'getMingguKe']);
        Route::get('laporan-mingguan/{id}/print', [LaporanMingguanController::class, 'printLaporanMingguan'])->name('laporan-mingguan.print');

        // Dokumentasi Mingguan
        Route::resource('dokumentasi-mingguan', DokumentasiMingguanController::class);
        Route::get('/get-dok-minggu-ke/{id}', [DokumentasiMingguanController::class, 'getMingguKe']);
        Route::get('dokumentasi-mingguan/{id}/print', [DokumentasiMingguanController::class, 'printDokumentasiMingguan'])->name('dokumentasi-mingguan.print');

        // Laporan Cuaca
        Route::resource('cuaca-mingguan', CuacaMingguanController::class);
        Route::get('/get-cuaca-minggu-ke/{id}', [CuacaMingguanController::class, 'getMingguKe']);
        Route::get('cuaca-mingguan/{id}/print', [CuacaMingguanController::class, 'printCuacaMingguan'])->name('cuaca-mingguan.print');

    // Laporan Bulanan
        // Laporan Pelaksanaan
        Route::resource('laporan-pelaksanaan', LaporanPelaksanaanController::class);
        Route::get('laporan-pelaksanaan/{id}/print', [LaporanPelaksanaanController::class, 'printPelaksanaan'])->name('laporan-pelaksanaan.print');

        // Laporan Kegiatan
        Route::resource('laporan-kegiatan', LaporanKegiatanController::class);
        Route::get('laporan-kegiatan/{id}/print', [LaporanKegiatanController::class, 'printKegiatan'])->name('laporan-kegiatan.print');

    // Users
    Route::resource('users', UserController::class);
});

//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function () {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
Route::group(['prefix' => 'special-pages'], function () {
    //Example Page Routs
    Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
    Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
    Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
    Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
    Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
});

//Widget Routs
Route::group(['prefix' => 'widget'], function () {
    Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
    Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
    Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
});

//Maps Routs
Route::group(['prefix' => 'maps'], function () {
    Route::get('google', [HomeController::class, 'google'])->name('maps.google');
    Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function () {
    Route::get('signin', [HomeController::class, 'signin'])->name('auth.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function () {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});


//Forms Pages Routs
Route::group(['prefix' => 'forms'], function () {
    Route::get('element', [HomeController::class, 'element'])->name('forms.element');
    Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
    Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
});


//Table Page Routs
Route::group(['prefix' => 'table'], function () {
    Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
});

//Icons Page Routs
Route::group(['prefix' => 'icons'], function () {
    Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
    Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
    Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
    Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
});
//Extra Page Routs
Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');
