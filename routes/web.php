<?php


use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\MaterialInController;
use App\Http\Controllers\MaterialOutController;
use App\Http\Controllers\MaterialReturnController;
use App\Http\Controllers\RelaxInController;
use App\Http\Controllers\RelaxOutController;
use App\Http\Controllers\RelaxReturnController;
use App\Http\Controllers\CbdController;
use App\Http\Controllers\ItemVariantController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockRelaxController;
use App\Http\Controllers\AccessoriesInController;
use App\Http\Controllers\AccessoriesOutController;
use App\Http\Controllers\AccessoriesReturnController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PurchaseOrderSendController;
use App\Http\Controllers\BomController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|                                       
*/


require __DIR__ . '/auth.php';

Route::get('/login', function () {

    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'agent') {
            return redirect()->route('agent.dashboard');
        } elseif (auth()->user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
    }
    return view('admin.admin_login');
});


Route::get('/admin/login', [AdminController::class, 'store'])->name('admin.login');

//admin group middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/', [AdminController::class, 'AdminDashboard'])->name('admin.login');
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
});



Route::middleware(['auth', 'role:admin'])->group(function () {

    //permission all route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('can:add.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('can:add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission')->middleware('can:add.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('can:add.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('can:delete.permission');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });

    //role all route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('can:all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('can:add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles')->middleware('can:add.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('can:edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('can:delete.roles');


        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('can:add.roles.permission');
        Route::post('/add/permission/store', 'RolesPermissionStore')->name('roles.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('can:all.roles.permission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles')->middleware('can:admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles')->middleware('can:admin.delete.roles');
    });


    //Admin User All Route
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('can:all.admin');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('can:add.admin');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('can:edit.admin');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('can:delete.admin');
    });



    //color User All Color
    Route::controller(ColorController::class)->group(function () {
        Route::get('/all/color', 'AllColor')->name('all.color')->middleware('can:all.color');
        Route::get('/get/color', 'GetColor')->name('get.color')->middleware('can:all.color');
        Route::get('/get/colorglobal', 'GetColorGlobal')->name('get.colorglobal');
        Route::get('/add/color', 'AddColor')->name('add.color')->middleware('can:add.color');

        Route::post('/store/color', 'StoreColor')->name('store.color');
        Route::get('/edit/color/{id}', 'EditColor')->name('edit.color')->middleware('can:edit.color');
        Route::post('/update/color/{id}', 'UpdateColor')->name('update.color');
        Route::get('/delete/color/{id}', 'DeleteColor')->name('delete.color')->middleware('can:delete.color');;
        Route::get('/export/color', 'ExportColor')->name('export.color');
    });
    Route::controller(UnitController::class)->group(function () {
        Route::get('/all/unit', 'Allunit')->name('all.unit')->middleware('can:all.unit');
        Route::get('/get/unit', 'Getunit')->name('get.unit')->middleware('can:all.unit');
        Route::get('/get/unitglobal', 'GetunitGlobal')->name('get.unitglobal');
        Route::get('/add/unit', 'Addunit')->name('add.unit')->middleware('can:add.unit');

        Route::post('/store/unit', 'Storeunit')->name('store.unit')->middleware('can:add.unit');
        Route::get('/edit/unit/{id}', 'Editunit')->name('edit.unit')->middleware('can:edit.unit');
        Route::post('/update/unit/{id}', 'Updateunit')->name('update.unit');
        Route::get('/delete/unit/{id}', 'Deleteunit')->name('delete.unit')->middleware('can:delete.unit');
        Route::get('/export/unit', 'Exportunit')->name('export.unit');
    });

    Route::controller(CategorieController::class)->group(function () {
        Route::get('/all/category', 'Allcategory')->name('all.category')->middleware('can:all.category');
        Route::get('/get/category', 'Getcategory')->name('get.category')->middleware('can:get.category');
        Route::get('/get/categoryglobal', 'GetCategoryGlobal')->name('get.categoryglobal');
        Route::get('/add/category', 'Addcategory')->name('add.category')->middleware('can:add.category');

        Route::post('/store/category', 'Storecategory')->name('store.category')->middleware('can:add.category');
        Route::get('/edit/category/{id}', 'Editcategory')->name('edit.category')->middleware('can:edit.category');
        Route::post('/update/category/{id}', 'Updatecategory')->name('update.category')->middleware('can:edit.category');
        Route::get('/delete/category/{id}', 'Deletecategory')->name('delete.category')->middleware('can:delete.category');
        Route::get('/export/category', 'Exportcategory')->name('export.category');
    });

    Route::controller(SizeController::class)->group(function () {
        Route::get('/all/size', 'Allsize')->name('all.size')->middleware('can:all.size');
        Route::get('/get/size', 'Getsize')->name('get.size')->middleware('can:all.size');
        Route::get('/get/sizeglobal', 'GetsizeGlobal')->name('get.sizeglobal');
        Route::get('/add/size', 'Addsize')->name('add.size')->middleware('can:add.size');

        Route::post('/store/size', 'Storesize')->name('store.size');
        Route::get('/edit/size/{id}', 'Editsize')->name('edit.size')->middleware('can:edit.size');
        Route::post('/update/size/{id}', 'Updatesize')->name('update.size');
        Route::get('/delete/size/{id}', 'Deletesize')->name('delete.size')->middleware('can:delete.size');
        Route::get('/export/size', 'Exportsize')->name('export.size');
    });
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/all/supplier', 'Allsupplier')->name('all.supplier')->middleware('can:all.supplier');
        Route::get('/get/supplier', 'Getsupplier')->name('get.supplier')->middleware('can:all.supplier');
        Route::get('/get/supplierglobal', 'GetsupplierGlobal')->name('get.supplierglobal');
        Route::get('/add/supplier', 'Addsupplier')->name('add.supplier')->middleware('can:add.supplier');

        Route::post('/store/supplier', 'Storesupplier')->name('store.supplier')->middleware('can:add.supplier');
        Route::get('/edit/supplier/{id}', 'Editsupplier')->name('edit.supplier')->middleware('can:edit.supplier');
        Route::post('/update/supplier/{id}', 'Updatesupplier')->name('update.supplier');
        Route::get('/delete/supplier/{id}', 'Deletesupplier')->name('delete.supplier');
        Route::get('/export/supplier', 'Exportsupplier')->name('export.supplier');
    });

    Route::controller(BomController::class)->group(function () {
        Route::get('/all/bom', 'Allbom')->name('all.bom')->middleware('can:all.bom');
        Route::get('/add/bom', 'Addbom')->name('add.bom')->middleware('can:add.bom');
        Route::post('/store/bom', 'Storebom')->name('store.bom');
        Route::get('/edit/bom/{id}', 'Editbom')->name('edit.bom')->middleware('can:edit.bom');
        Route::post('/update/bom/{id}', 'Updatebom')->name('update.bom')->middleware('can:edit.bom');
        Route::get('/delete/bom/{id}', 'Deletebom')->name('delete.bom')->middleware('can:delete.bom');
        Route::get('/export/bom', 'Exportbom')->name('export.bom')->middleware('can:export.bom');;
        Route::get('/get/bom', 'Getbom')->name('get.bom')->middleware('can:all.bom');
        Route::get('/get/bomall', 'Getbomall')->name('get.bomall')->middleware('can:all.bom');
        Route::get('/get/bomdetails', 'Getbomdetails')->name('get.bomdetails')->middleware('can:all.bom');
    });




    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/all/employee', 'AllEmployee')->name('all.employee')->middleware('can:all.employee');
        Route::get('/add/employee', 'AddEmployee')->name('add.employee')->middleware('can:add.employee');
        Route::post('/store/employee', 'StoreEmployee')->name('store.employee');
        Route::get('/edit/employee/{id}', 'EditEmployee')->name('edit.employee')->middleware('can:edit.employee');
        Route::post('/update/employee/{id}', 'UpdateEmployee')->name('update.employee')->middleware('can:edit.employee');
        Route::get('/delete/employee/{id}', 'DeleteEmployee')->name('delete.employee')->middleware('can:delete.employee');
        Route::get('/export/employee', 'ExportEmployee')->name('export.employee')->middleware('can:export.employee');;
        Route::get('/get/employee', 'Getemployee')->name('get.employee')->middleware('can:all.employee');
        Route::get('/get/employeecount', 'GetEmployeeCount')->name('get.employeecount');
        Route::get('/get/posisiemployee', 'GetPosisi')->name('get.posisiemployee');
        Route::post('/check/employee', 'CheckEmployee')->name('check.employee');
        Route::get('/print/employee', 'PrintEmployee')->name('print.employee')->middleware('can:export.employee');
        Route::post('/pdf/employee', 'exportPDF')->name('pdf.employee')->middleware('can:export.employee');
        Route::post('/import/employee', 'ImportEmployee')->name('import.employee')->middleware('can:import.employee');
        Route::get('/import/employees', 'Importemployees')->name('import.employees')->middleware('can:import.employee');
    });



    Route::controller(ItemController::class)->group(function () {
        Route::get('/all/item', 'Allitem')->name('all.item')->middleware('can:all.item');
        Route::get('/add/item', 'Additem')->name('add.item')->middleware('can:add.item');
        Route::post('/store/item', 'Storeitem')->name('store.item');
        Route::get('/edit/item/{id}', 'Edititem')->name('edit.item')->middleware('can:edit.item');
        Route::post('/update/item/{id}', 'Updateitem')->name('update.item');
        Route::get('/delete/item/{id}', 'DeleteItem')->name('delete.item')->middleware('can:delete.item');
        Route::get('/export/item', 'Exportitem')->name('export.item')->middleware('can:export.item');
        Route::get('/get/item', 'Getitem')->name('get.item')->middleware('can:all.item');
        Route::get('/get/itemglobal', 'Getitemglobal')->name('get.itemglobal')->middleware('can:get.itemglobal');
        Route::get('/get/itemcount', 'GetitemCount')->name('get.itemcount');
        Route::get('/get/posisi', 'GetPosisi')->name('get.posisi');
        Route::post('/check/item', 'Checkitem')->name('check.item');
        Route::get('/print/item', 'Printitem')->name('print.item')->middleware('can:export.item');
        Route::post('/pdf/item', 'exportPDF')->name('pdf.item')->middleware('can:export.item');
        Route::post('/import/item', 'Importitem')->name('import.item')->middleware('can:import.item');
        Route::get('/import/items', 'Importitems')->name('import.items')->middleware('can:import.item');
    });


    Route::controller(RakController::class)->group(function () {
        Route::get('/all/rak', 'Allrak')->name('all.rak')->middleware('can:all.rak');
        Route::get('/add/rak', 'Addrak')->name('add.rak')->middleware('can:add.rak');
        Route::post('/store/rak', 'Storerak')->name('store.rak')->middleware('can:add.rak');
        Route::get('/edit/rak/{id}', 'Editrak')->name('edit.rak')->middleware('can:edit.rak');
        Route::post('/update/rak/{id}', 'Updaterak')->name('update.rak')->middleware('can:edit.rak');
        Route::get('/delete/rak/{id}', 'Deleterak')->name('delete.rak')->middleware('can:delete.rak');
        Route::get('/export/rak', 'Exportrak')->name('export.rak')->middleware('can:export.rak');;
        Route::get('/get/rak', 'Getrak')->name('get.rak')->middleware('can:all.rak');
        Route::get('/get/rakcount', 'GetrakCount')->name('get.rakcount');
        Route::get('/get/posisirak', 'GetPosisi')->name('get.posisirak');
        Route::post('/check/rak', 'Checkrak')->name('check.rak');
        Route::get('/print/rak', 'Printrak')->name('print.rak')->middleware('can:export.rak');
        Route::post('/pdf/rak', 'exportPDF')->name('pdf.rak')->middleware('can:export.rak');
        Route::post('/import/rak', 'Importrak')->name('import.rak')->middleware('can:import.rak');
        Route::get('/import/raks', 'Importraks')->name('import.raks')->middleware('can:import.rak');
    });


    Route::controller(CbdController::class)->group(function () {
        Route::get('/all/cbd', 'Allcbd')->name('all.cbd')->middleware('can:all.cbd');
        Route::get('/add/cbd', 'Addcbd')->name('add.cbd')->middleware('can:add.cbd');
        Route::post('/store/cbd', 'Storecbd')->name('store.cbd');
        Route::get('/edit/cbd/{id}', 'Editcbd')->name('edit.cbd')->middleware('can:edit.cbd');
        Route::post('/update/cbd/{id}', 'Updatecbd')->name('update.cbd')->middleware('can:edit.cbd');
        Route::get('/delete/cbd/{id}', 'Deletecbd')->name('delete.cbd')->middleware('can:delete.cbd');
        Route::get('/export/cbd', 'Exportcbd')->name('export.cbd')->middleware('can:export.cbd');;
        Route::get('/get/cbd', 'Getcbd')->name('get.cbd')->middleware('can:all.cbd');
        Route::get('/get/cbddetail', 'Getcbddetail')->name('get.cbddetail')->middleware('can:all.cbd');
        Route::get('/get/cbddetaillimit', 'Getcbddetaillimit')->name('get.cbddetaillimit')->middleware('can:all.cbd');
        Route::get('/get/cbdglobal', 'Getcbdglobal')->name('get.cbdglobal');
        Route::get('/get/cbdcount', 'GetcbdCount')->name('get.cbdcount');
        Route::get('/get/posisicbd', 'GetPosisi')->name('get.posisicbd');
        Route::post('/check/cbd', 'Checkcbd')->name('check.cbd');
        Route::get('/print/cbd', 'Printcbd')->name('print.cbd')->middleware('can:export.cbd');
        Route::post('/pdf/cbd', 'exportPDF')->name('pdf.cbd')->middleware('can:export.cbd');
        Route::post('/import/cbd', 'Importcbd')->name('import.cbd')->middleware('can:import.cbd');
        Route::get('/import/cbds', 'Importcbds')->name('import.cbds')->middleware('can:import.cbd');
    });


    Route::controller(PurchaseRequestController::class)->group(function () {
        Route::get('/all/purchaserequest', 'Allpurchaserequest')->name('all.purchaserequest')->middleware('can:all.purchaserequest');
        Route::get('/add/purchaserequest', 'Addpurchaserequest')->name('add.purchaserequest')->middleware('can:add.purchaserequest');
        Route::get('/add/purchaserequestid/{id}', 'Addpurchaserequestid')->name('add.purchaserequestid')->middleware('can:add.purchaserequest');
        Route::post('/store/purchaserequest', 'Storepurchaserequest')->name('store.purchaserequest');
        Route::get('/edit/purchaserequest/{id}', 'Editpurchaserequest')->name('edit.purchaserequest')->middleware('can:edit.purchaserequest');
        Route::post('/update/purchaserequest/{id}', 'Updatepurchaserequest')->name('update.purchaserequest')->middleware('can:edit.purchaserequest');
        Route::delete('/delete/purchaserequest/{id}', 'Deletepurchaserequest')->name('delete.purchaserequest')->middleware('can:delete.purchaserequest');
        Route::get('/export/purchaserequest', 'Exportpurchaserequest')->name('export.purchaserequest')->middleware('can:export.purchaserequest');;
        Route::get('/get/purchaserequest', 'Getpurchaserequest')->name('get.purchaserequest')->middleware('can:all.purchaserequest');
        Route::get('/get/purchaserequestsp', 'Getpurchaserequestsp')->name('get.purchaserequestsp')->middleware('can:all.purchaserequest');
        Route::get('/get/purchaserequestitems', 'Getpurchaserequestitems')->name('get.purchaserequestitems')->middleware('can:all.purchaserequest');
        Route::get('/get/purchaserequestcount', 'GetpurchaserequestCount')->name('get.purchaserequestcount');
        Route::get('/get/purchaserequestcountPR', 'GetpurchaserequestCountPR')->name('get.purchaserequestcountPR');
        Route::get('/get/purchaserequestcountPending', 'GetpurchaserequestCountPending')->name('get.purchaserequestcountPending');
        Route::get('/all/purchaserequestwaiting', 'AllpurchaserequestWaiting')->name('all.purchaserequestwaiting');
        Route::get('/get/purchaserequestwaiting', 'Getpurchaserequestwaiting')->name('get.purchaserequestwaiting');
        Route::get('/print/purchaserequest', 'Printpurchaserequest')->name('print.purchaserequest')->middleware('can:export.purchaserequest');
        Route::get('/pdf/purchaserequest/{id}', 'exportPDF')->name('pdf.purchaserequest')->middleware('can:export.purchaserequest');
        Route::post('/import/purchaserequest', 'Importpurchaserequest')->name('import.purchaserequest')->middleware('can:import.purchaserequest');
        Route::get('/import/purchaserequests', 'Importpurchaserequests')->name('import.purchaserequests')->middleware('can:import.purchaserequest');
    });

    Route::controller(PurchaseOrderController::class)->group(function () {
        Route::get('/all/purchaseorder', 'Allpurchaseorder')->name('all.purchaseorder')->middleware('can:all.purchaseorder');
        Route::get('/add/purchaseorder', 'Addpurchaseorder')->name('add.purchaseorder')->middleware('can:add.purchaseorder');
        Route::get('/add/purchaseorderid/{id}', 'Addpurchaseorderid')->name('add.purchaseorderid')->middleware('can:add.purchaseorder');
        Route::post('/store/purchaseorder', 'Storepurchaseorder')->name('store.purchaseorder');
        Route::get('/edit/purchaseorder/{id}', 'Editpurchaseorder')->name('edit.purchaseorder')->middleware('can:edit.purchaseorder');
        Route::post('/update/purchaseorder/{id}', 'Updatepurchaseorder')->name('update.purchaseorder')->middleware('can:edit.purchaseorder');
        Route::get('/delete/purchaseorder/{id}', 'Deletepurchaseorder')->name('delete.purchaseorder')->middleware('can:delete.purchaseorder');
        Route::get('/export/purchaseorder', 'Exportpurchaseorder')->name('export.purchaseorder')->middleware('can:export.purchaseorder');;
        Route::get('/get/purchaseorder', 'Getpurchaseorder')->name('get.purchaseorder')->middleware('can:all.purchaseorder');
        Route::get('/get/purchaseordersupplier', 'Getpurchaseordersupplier')->name('get.purchaseordersupplier')->middleware('can:all.purchaseorder');
        Route::get('/get/purchaseorderitem', 'Getpurchaseorderitem')->name('get.purchaseorderitem')->middleware('can:all.purchaseorder');
        Route::get('/get/purchaseordercount', 'GetpurchaseorderCount')->name('get.purchaseordercount');
        Route::get('/get/purchaseordersup', 'GetpurchaseorderSup')->name('get.purchaseordersup');
        Route::get('/get/purchaseordercountPO', 'GetpurchaseorderCountPO')->name('get.purchaseordercountPO');
        Route::get('/print/purchaseorder', 'Printpurchaseorder')->name('print.purchaseorder')->middleware('can:export.purchaseorder');
        Route::get('/pdf/purchaseorder/{id}', 'exportPDF')->name('pdf.purchaseorder')->middleware('can:export.purchaseorder');
        Route::post('/import/purchaseorder', 'Importpurchaseorder')->name('import.purchaseorder')->middleware('can:import.purchaseorder');
        Route::get('/import/purchaseorders', 'Importpurchaseorders')->name('import.purchaseorders')->middleware('can:import.purchaseorder');
        Route::get('/get/purchaseorderid/{original_no}', 'Getpurchaseorderid')->name('get.purchaseorderid')->middleware('can:all.qr_code');
    });


    Route::controller(PurchaseOrderSendController::class)->group(function () {
        Route::get('/all/purchaseordersend', 'Allpurchaseordersend')->name('all.purchaseordersend')->middleware('can:all.purchaseordersend');
        Route::get('/add/purchaseordersend', 'Addpurchaseordersend')->name('add.purchaseordersend')->middleware('can:add.purchaseordersend');
        Route::post('/store/purchaseordersend', 'Storepurchaseordersend')->name('store.purchaseordersend');
        Route::get('/delete/purchaseordersend/{id}', 'Deletepurchaseordersend')->name('delete.purchaseordersend')->middleware('can:delete.purchaseordersend');
        Route::get('/export/purchaseordersend', 'Exportpurchaseordersend')->name('export.purchaseordersend')->middleware('can:export.purchaseordersend');;
        Route::get('/get/purchaseordersend', 'Getpurchaseordersend')->name('get.purchaseordersend')->middleware('can:all.purchaseordersend');
        Route::get('/get/purchaseordersendcount', 'Getpurchaseordersendcount')->name('get.purchaseordersendcount');
        Route::get('/get/purchaseordersendall', 'Getpurchaseordersendall')->name('get.purchaseordersendall')->middleware('can:all.purchaseordersend');
    });



    Route::controller(ConsumptionController::class)->group(function () {
        Route::get('/all/consumption', 'Allconsumption')->name('all.consumption')->middleware('can:all.consumption');
        Route::get('/add/consumption', 'Addconsumption')->name('add.consumption')->middleware('can:add.consumption');
        Route::post('/store/consumption', 'Storeconsumption')->name('store.consumption');
        Route::get('/edit/consumption/{id}', 'Editconsumption')->name('edit.consumption')->middleware('can:edit.consumption');
        Route::post('/update/consumption/{id}', 'Updateconsumption')->name('update.consumption')->middleware('can:edit.consumption');
        Route::get('/delete/consumption/{id}', 'Deleteconsumption')->name('delete.consumption')->middleware('can:delete.consumption');
        Route::get('/export/consumption', 'Exportconsumption')->name('export.consumption')->middleware('can:export.consumption');;
        Route::get('/get/consumption', 'Getconsumption')->name('get.consumption')->middleware('can:all.consumption');
    });


    Route::controller(QRCodeController::class)->group(function () {
        Route::get('/all/qr_code', 'Allqr_code')->name('all.qr_code')->middleware('can:all.qr_code');
        Route::get('/add/qr_code', 'Addqr_code')->name('add.qr_code')->middleware('can:add.qr_code');
        Route::post('/store/qr_code', 'Storeqr_code')->name('store.qr_code');
        Route::get('/edit/qr_code/{id}', 'Editqr_code')->name('edit.qr_code')->middleware('can:edit.qr_code');
        Route::post('/update/qr_code/{id}', 'Updateqr_code')->name('update.qr_code')->middleware('can:edit.qr_code');
        Route::get('/delete/qr_code/{id}', 'DeleteQrcode')->name('delete.qr_code')->middleware('can:delete.qr_code');
        Route::get('/export/qr_code', 'Exportqr_code')->name('export.qr_code')->middleware('can:export.qr_code');;
        Route::get('/get/qr_code', 'Getqr_code')->name('get.qr_code')->middleware('can:all.qr_code');
        Route::get('/get/original', 'Getoriginal')->name('get.original')->middleware('can:all.qr_code');
        Route::get('/print/qr_code', 'Printqr_code')->name('print.qr_code')->middleware('can:export.qr_code');
        Route::post('/import/qr_code', 'Importqr_code')->name('import.qr_code')->middleware('can:import.qr_code');
        Route::get('/import/qr_codes', 'Importqr_codes')->name('import.qr_codes')->middleware('can:import.qr_code');
        Route::post('/pdf/qr_code', 'exportPDF')->name('pdf.qr_code')->middleware('can:all.qr_code');
        Route::get('/get/qr_codein/{original_no}', 'Getqr_codein')->name('get.qr_codein')->middleware('can:all.qr_code');
    });


    Route::controller(MaterialInController::class)->group(function () {
        Route::get('/all/materialin', 'Allmaterialin')->name('all.materialin')->middleware('can:all.materialin');
        Route::get('/all/materialindetail', 'Allmaterialindetail')->name('all.materialindetail')->middleware('can:all.materialin');
        Route::get('/add/materialin', 'Addmaterialin')->name('add.materialin')->middleware('can:add.materialin');
        Route::get('/add/materialinsp', 'Addmaterialinsp')->name('add.materialinsp')->middleware('can:add.materialin');
        Route::post('/store/materialin', 'Storematerialin')->name('store.materialin');
        Route::post('/store/materialinsp', 'Storematerialinsp')->name('store.materialinsp');
        Route::get('/edit/materialin/{id}', 'Editmaterialin')->name('edit.materialin')->middleware('can:edit.materialin');
        Route::post('/update/materialin/{id}', 'Updatematerialin')->name('update.materialin')->middleware('can:edit.materialin');
        Route::get('/delete/materialin/{id}', 'Deletematerialin')->name('delete.materialin')->middleware('can:delete.materialin');
        Route::get('/export/materialin', 'Exportmaterialin')->name('export.materialin')->middleware('can:all.materialin');;
        Route::get('/get/materialin', 'Getmaterialin')->name('get.materialin')->middleware('can:all.materialin');
        Route::get('/get/materialincount', 'Getmaterialincount')->name('get.materialincount')->middleware('can:all.materialin');
        Route::get('/get/materialindetail', 'Getmaterialindetail')->name('get.materialindetail')->middleware('can:all.materialin');

        Route::post('/check/materialin', 'Checkmaterialin')->name('check.materialin');
        Route::get('/print/materialin', 'Printmaterialin')->name('print.materialin')->middleware('can:export.materialin');
        Route::get('/pdf/materialin/{id}', 'exportPDF')->name('pdf.materialin')->middleware('can:export.materialin');
        Route::post('/import/materialin', 'Importmaterialin')->name('import.materialin')->middleware('can:import.materialin');
        Route::get('/import/materialins', 'Importmaterialins')->name('import.materialins')->middleware('can:import.materialin');
        Route::get('/get/materialinoriginal/{original_no}', 'Getmaterialinoriginal')->name('get.materialinoriginal')->middleware('can:all.materialin');
    });


    Route::controller(MaterialOutController::class)->group(function () {
        Route::get('/all/materialout', 'Allmaterialout')->name('all.materialout')->middleware('can:all.materialout');
        Route::get('/all/materialoutdetail', 'Allmaterialoutdetail')->name('all.materialoutdetail')->middleware('can:all.materialout');
        Route::get('/add/materialout', 'Addmaterialout')->name('add.materialout')->middleware('can:add.materialout');
        Route::get('/add/materialoutsp', 'Addmaterialoutsp')->name('add.materialoutsp')->middleware('can:add.materialout');
        Route::post('/store/materialout', 'Storematerialout')->name('store.materialout');
        Route::post('/store/materialoutsp', 'Storematerialoutsp')->name('store.materialoutsp');
        Route::get('/edit/materialout/{id}', 'Editmaterialout')->name('edit.materialout')->middleware('can:edit.materialout');
        Route::post('/update/materialout/{id}', 'Updatematerialout')->name('update.materialout')->middleware('can:edit.materialout');
        Route::get('/delete/materialout/{id}', 'Deletematerialout')->name('delete.materialout')->middleware('can:delete.materialout');
        Route::get('/export/materialout', 'Exportmaterialout')->name('export.materialout')->middleware('can:all.materialout');;
        Route::get('/get/materialout', 'Getmaterialout')->name('get.materialout')->middleware('can:all.materialout');
        Route::get('/get/materialoutcount', 'Getmaterialoutcount')->name('get.materialoutcount')->middleware('can:all.materialout');
        Route::get('/get/materialoutdetail', 'Getmaterialoutdetail')->name('get.materialoutdetail')->middleware('can:all.materialout');
        Route::get('/get/materialoutid/{id}', 'Getmaterialoutid')->name('get.materialoutid')->middleware('can:all.materialout');
        Route::post('/check/materialout', 'Checkmaterialout')->name('check.materialout');
        Route::get('/print/materialout', 'Printmaterialout')->name('print.materialout')->middleware('can:export.materialout');
        Route::get('/pdf/materialout/{id}', 'exportPDF')->name('pdf.materialout')->middleware('can:export.materialout');
        Route::post('/import/materialout', 'Importmaterialout')->name('import.materialout')->middleware('can:import.materialout');
        Route::get('/import/materialouts', 'Importmaterialouts')->name('import.materialouts')->middleware('can:import.materialout');
    });


    Route::controller(MaterialReturnController::class)->group(function () {
        Route::get('/all/materialreturn', 'Allmaterialreturn')->name('all.materialreturn')->middleware('can:all.materialreturn');
        Route::get('/all/materialreturndetail', 'Allmaterialreturndetail')->name('all.materialreturndetail')->middleware('can:all.materialreturn');
        Route::get('/add/materialreturn', 'Addmaterialreturn')->name('add.materialreturn')->middleware('can:add.materialreturn');
        Route::get('/add/materialreturnsp', 'Addmaterialreturnsp')->name('add.materialreturnsp')->middleware('can:add.materialreturn');
        Route::post('/store/materialreturn', 'Storematerialreturn')->name('store.materialreturn');
        Route::post('/store/materialreturnsp', 'Storematerialreturnsp')->name('store.materialreturnsp');
        Route::get('/edit/materialreturn/{id}', 'Editmaterialreturn')->name('edit.materialreturn')->middleware('can:edit.materialreturn');
        Route::post('/update/materialreturn/{id}', 'Updatematerialreturn')->name('update.materialreturn')->middleware('can:edit.materialreturn');
        Route::get('/delete/materialreturn/{id}', 'Deletematerialreturn')->name('delete.materialreturn')->middleware('can:delete.materialreturn');
        Route::get('/export/materialreturn', 'Exportmaterialreturn')->name('export.materialreturn')->middleware('can:all.materialreturn');;
        Route::get('/get/materialreturn', 'Getmaterialreturn')->name('get.materialreturn')->middleware('can:all.materialreturn');
        Route::get('/get/materialreturndetail', 'Getmaterialreturndetail')->name('get.materialreturndetail')->middleware('can:all.materialreturn');

        Route::post('/check/materialreturn', 'Checkmaterialreturn')->name('check.materialreturn');
        Route::get('/print/materialreturn', 'Printmaterialreturn')->name('print.materialreturn')->middleware('can:export.materialreturn');
        Route::get('/pdf/materialreturn/{id}', 'exportPDF')->name('pdf.materialreturn')->middleware('can:export.materialreturn');
        Route::post('/import/materialreturn', 'Importmaterialreturn')->name('import.materialreturn')->middleware('can:import.materialreturn');
        Route::get('/import/materialreturns', 'Importmaterialreturns')->name('import.materialreturns')->middleware('can:import.materialreturn');
    });



    Route::controller(StockController::class)->group(function () {
        Route::get('/all/stock', 'Allstock')->name('all.stock')->middleware('can:all.stock');
        Route::get('/all/stockdetail', 'Allstockdetail')->name('all.stockdetail')->middleware('can:all.stock');
        Route::get('/all/stockmutation', 'Allstockmutation')->name('all.stockmutation')->middleware('can:all.stock');
        Route::get('/all/stockmutationori', 'Allstockmutationori')->name('all.stockmutationori')->middleware('can:all.stock');
        Route::get('/export/stock', 'Exportstock')->name('export.stock')->middleware('can:export.stock');;
        Route::get('/get/stock', 'Getstock')->name('get.stock')->middleware('can:all.stock');
        Route::get('/get/stockmutation', 'Getstockmutation')->name('get.stockmutation')->middleware('can:all.stock');
        Route::get('/get/stockmutationori', 'Getstockmutationori')->name('get.stockmutationori')->middleware('can:all.stock');
        Route::get('/get/stockdetail', 'Getstockdetail')->name('get.stockdetail')->middleware('can:all.stock');
        Route::post('/check/stock', 'Checkstock')->name('check.stock');
        Route::get('/print/stock', 'Printstock')->name('print.stock')->middleware('can:export.stock');
        Route::get('/get/stockglobal', 'Getstockglobal')->name('get.stockglobal')->middleware('can:all.stock');
    });


    Route::controller(StockRelaxController::class)->group(function () {
        Route::get('/all/stockrelax', 'Allstockrelax')->name('all.stockrelax')->middleware('can:all.stockrelax');
        Route::get('/all/stockrelaxdetail', 'Allstockrelaxdetail')->name('all.stockrelaxdetail')->middleware('can:all.stockrelax');
        Route::get('/all/stockrelaxmutation', 'Allstockrelaxmutation')->name('all.stockrelaxmutation')->middleware('can:all.stockrelax');
        Route::get('/all/stockrelaxmutationori', 'Allstockrelaxmutationori')->name('all.stockrelaxmutationori')->middleware('can:all.stockrelax');
        Route::get('/export/stockrelax', 'Exportstockrelax')->name('export.stockrelax')->middleware('can:export.stockrelax');;
        Route::get('/get/stockrelax', 'Getstockrelax')->name('get.stockrelax')->middleware('can:all.stockrelax');
        Route::get('/get/stockrelaxmutation', 'Getstockrelaxmutation')->name('get.stockrelaxmutation')->middleware('can:all.stockrelax');
        Route::get('/get/stockrelaxmutationori', 'Getstockrelaxmutationori')->name('get.stockrelaxmutationori')->middleware('can:all.stockrelax');
        Route::get('/get/stockrelaxdetail', 'Getstockrelaxdetail')->name('get.stockrelaxdetail')->middleware('can:all.stockrelax');
        Route::post('/check/stockrelax', 'Checkstockrelax')->name('check.stockrelax');
        Route::get('/print/stockrelax', 'Printstockrelax')->name('print.stockrelax')->middleware('can:export.stockrelax');
    });






    Route::controller(RelaxInController::class)->group(function () {
        Route::get('/all/relaxin', 'Allrelaxin')->name('all.relaxin')->middleware('can:all.relaxin');
        Route::get('/all/relaxindetail', 'Allrelaxindetail')->name('all.relaxindetail')->middleware('can:all.relaxin');
        Route::get('/add/relaxin', 'Addrelaxin')->name('add.relaxin')->middleware('can:add.relaxin');
        Route::get('/add/relaxinsp', 'Addrelaxinsp')->name('add.relaxinsp')->middleware('can:add.relaxin');
        Route::post('/store/relaxin', 'Storerelaxin')->name('store.relaxin');
        Route::post('/store/relaxinsp', 'Storerelaxinsp')->name('store.relaxinsp');
        Route::get('/edit/relaxin/{id}', 'Editrelaxin')->name('edit.relaxin')->middleware('can:edit.relaxin');
        Route::post('/update/relaxin/{id}', 'Updaterelaxin')->name('update.relaxin')->middleware('can:edit.relaxin');
        Route::get('/delete/relaxin/{id}', 'Deleterelaxin')->name('delete.relaxin')->middleware('can:delete.relaxin');
        Route::get('/export/relaxin', 'Exportrelaxin')->name('export.relaxin')->middleware('can:all.relaxin');;
        Route::get('/get/relaxin', 'Getrelaxin')->name('get.relaxin')->middleware('can:all.relaxin');
        Route::get('/get/relaxindetail', 'Getrelaxindetail')->name('get.relaxindetail')->middleware('can:all.relaxin');

        Route::post('/check/relaxin', 'Checkrelaxin')->name('check.relaxin');
        Route::get('/print/relaxin', 'Printrelaxin')->name('print.relaxin')->middleware('can:export.relaxin');
        Route::get('/pdf/relaxin/{id}', 'exportPDF')->name('pdf.relaxin')->middleware('can:export.relaxin');
        Route::post('/import/relaxin', 'Importrelaxin')->name('import.relaxin')->middleware('can:import.relaxin');
        Route::get('/import/relaxins', 'Importrelaxins')->name('import.relaxins')->middleware('can:import.relaxin');
        Route::get('/get/relaxinoriginal/{original_no}', 'Getrelaxinoriginal')->name('get.relaxinoriginal')->middleware('can:all.relaxin');
    });


    Route::controller(RelaxOutController::class)->group(function () {
        Route::get('/all/relaxout', 'Allrelaxout')->name('all.relaxout')->middleware('can:all.relaxout');
        Route::get('/all/relaxoutdetail', 'Allrelaxoutdetail')->name('all.relaxoutdetail')->middleware('can:all.relaxout');
        Route::get('/add/relaxout', 'Addrelaxout')->name('add.relaxout')->middleware('can:add.relaxout');
        Route::get('/add/relaxoutsp', 'Addrelaxoutsp')->name('add.relaxoutsp')->middleware('can:add.relaxout');
        Route::post('/store/relaxout', 'Storerelaxout')->name('store.relaxout');
        Route::post('/store/relaxoutsp', 'Storerelaxoutsp')->name('store.relaxoutsp');
        Route::get('/edit/relaxout/{id}', 'Editrelaxout')->name('edit.relaxout')->middleware('can:edit.relaxout');
        Route::post('/update/relaxout/{id}', 'Updaterelaxout')->name('update.relaxout')->middleware('can:edit.relaxout');
        Route::get('/delete/relaxout/{id}', 'Deleterelaxout')->name('delete.relaxout')->middleware('can:delete.relaxout');
        Route::get('/export/relaxout', 'Exportrelaxout')->name('export.relaxout')->middleware('can:all.relaxout');;
        Route::get('/get/relaxout', 'Getrelaxout')->name('get.relaxout')->middleware('can:all.relaxout');
        Route::get('/get/relaxoutdetail', 'Getrelaxoutdetail')->name('get.relaxoutdetail')->middleware('can:all.relaxout');

        Route::post('/check/relaxout', 'Checkrelaxout')->name('check.relaxout');
        Route::get('/print/relaxout', 'Printrelaxout')->name('print.relaxout')->middleware('can:export.relaxout');
        Route::get('/pdf/relaxout/{id}', 'exportPDF')->name('pdf.relaxout')->middleware('can:export.relaxout');
        Route::post('/import/relaxout', 'Importrelaxout')->name('import.relaxout')->middleware('can:import.relaxout');
        Route::get('/import/relaxouts', 'Importrelaxouts')->name('import.relaxouts')->middleware('can:import.relaxout');
    });


    Route::controller(RelaxReturnController::class)->group(function () {
        Route::get('/all/relaxreturn', 'Allrelaxreturn')->name('all.relaxreturn')->middleware('can:all.relaxreturn');
        Route::get('/all/relaxreturndetail', 'Allrelaxreturndetail')->name('all.relaxreturndetail')->middleware('can:all.relaxreturn');
        Route::get('/add/relaxreturn', 'Addrelaxreturn')->name('add.relaxreturn')->middleware('can:add.relaxreturn');
        Route::get('/add/relaxreturnsp', 'Addrelaxreturnsp')->name('add.relaxreturnsp')->middleware('can:add.relaxreturn');
        Route::post('/store/relaxreturn', 'Storerelaxreturn')->name('store.relaxreturn');
        Route::post('/store/relaxreturnsp', 'Storerelaxreturnsp')->name('store.relaxreturnsp');
        Route::get('/edit/relaxreturn/{id}', 'Editrelaxreturn')->name('edit.relaxreturn')->middleware('can:edit.relaxreturn');
        Route::post('/update/relaxreturn/{id}', 'Updaterelaxreturn')->name('update.relaxreturn')->middleware('can:edit.relaxreturn');
        Route::get('/delete/relaxreturn/{id}', 'Deleterelaxreturn')->name('delete.relaxreturn')->middleware('can:delete.relaxreturn');
        Route::get('/export/relaxreturn', 'Exportrelaxreturn')->name('export.relaxreturn')->middleware('can:all.relaxreturn');;
        Route::get('/get/relaxreturn', 'Getrelaxreturn')->name('get.relaxreturn')->middleware('can:all.relaxreturn');
        Route::get('/get/relaxreturndetail', 'Getrelaxreturndetail')->name('get.relaxreturndetail')->middleware('can:all.relaxreturn');

        Route::post('/check/relaxreturn', 'Checkrelaxreturn')->name('check.relaxreturn');
        Route::get('/print/relaxreturn', 'Printrelaxreturn')->name('print.relaxreturn')->middleware('can:export.relaxreturn');
        Route::get('/pdf/relaxreturn/{id}', 'exportPDF')->name('pdf.relaxreturn')->middleware('can:export.relaxreturn');
        Route::post('/import/relaxreturn', 'Importrelaxreturn')->name('import.relaxreturn')->middleware('can:import.relaxreturn');
        Route::get('/import/relaxreturns', 'Importrelaxreturns')->name('import.relaxreturns')->middleware('can:import.relaxreturn');
    });










    Route::controller(AccessoriesInController::class)->group(function () {
        Route::get('/all/accessoriesin', 'Allaccessoriesin')->name('all.accessoriesin')->middleware('can:all.accessoriesin');
        Route::get('/all/accessoriesindetail', 'Allaccessoriesindetail')->name('all.accessoriesindetail')->middleware('can:all.accessoriesin');
        Route::get('/add/accessoriesin', 'Addaccessoriesin')->name('add.accessoriesin')->middleware('can:add.accessoriesin');
        Route::get('/add/accessoriesinsp', 'Addaccessoriesinsp')->name('add.accessoriesinsp')->middleware('can:add.accessoriesin');
        Route::post('/store/accessoriesin', 'Storeaccessoriesin')->name('store.accessoriesin');
        Route::post('/store/accessoriesinsp', 'Storeaccessoriesinsp')->name('store.accessoriesinsp');
        Route::get('/edit/accessoriesin/{id}', 'Editaccessoriesin')->name('edit.accessoriesin')->middleware('can:edit.accessoriesin');
        Route::post('/update/accessoriesin/{id}', 'Updateaccessoriesin')->name('update.accessoriesin')->middleware('can:edit.accessoriesin');
        Route::get('/delete/accessoriesin/{id}', 'Deleteaccessoriesin')->name('delete.accessoriesin')->middleware('can:delete.accessoriesin');
        Route::get('/export/accessoriesin', 'Exportaccessoriesin')->name('export.accessoriesin')->middleware('can:all.accessoriesin');;
        Route::get('/get/accessoriesin', 'Getaccessoriesin')->name('get.accessoriesin')->middleware('can:all.accessoriesin');
        Route::get('/get/accessoriesindetail', 'Getaccessoriesindetail')->name('get.accessoriesindetail')->middleware('can:all.accessoriesin');

        Route::post('/check/accessoriesin', 'Checkaccessoriesin')->name('check.accessoriesin');
        Route::get('/print/accessoriesin', 'Printaccessoriesin')->name('print.accessoriesin')->middleware('can:export.accessoriesin');
        Route::get('/pdf/accessoriesin/{id}', 'exportPDF')->name('pdf.accessoriesin')->middleware('can:export.accessoriesin');
        Route::post('/import/accessoriesin', 'Importaccessoriesin')->name('import.accessoriesin')->middleware('can:import.accessoriesin');
        Route::get('/import/accessoriesins', 'Importaccessoriesins')->name('import.accessoriesins')->middleware('can:import.accessoriesin');
        Route::get('/get/accessoriesinoriginal/{original_no}', 'Getaccessoriesinoriginal')->name('get.accessoriesinoriginal')->middleware('can:all.accessoriesin');
    });


    Route::controller(AccessoriesOutController::class)->group(function () {
        Route::get('/all/accessoriesout', 'Allaccessoriesout')->name('all.accessoriesout')->middleware('can:all.accessoriesout');
        Route::get('/all/accessoriesoutdetail', 'Allaccessoriesoutdetail')->name('all.accessoriesoutdetail')->middleware('can:all.accessoriesout');
        Route::get('/add/accessoriesout', 'Addaccessoriesout')->name('add.accessoriesout')->middleware('can:add.accessoriesout');
        Route::get('/add/accessoriesoutsp', 'Addaccessoriesoutsp')->name('add.accessoriesoutsp')->middleware('can:add.accessoriesout');
        Route::post('/store/accessoriesout', 'Storeaccessoriesout')->name('store.accessoriesout');
        Route::post('/store/accessoriesoutsp', 'Storeaccessoriesoutsp')->name('store.accessoriesoutsp');
        Route::get('/edit/accessoriesout/{id}', 'Editaccessoriesout')->name('edit.accessoriesout')->middleware('can:edit.accessoriesout');
        Route::post('/update/accessoriesout/{id}', 'Updateaccessoriesout')->name('update.accessoriesout')->middleware('can:edit.accessoriesout');
        Route::get('/delete/accessoriesout/{id}', 'Deleteaccessoriesout')->name('delete.accessoriesout')->middleware('can:delete.accessoriesout');
        Route::get('/export/accessoriesout', 'Exportaccessoriesout')->name('export.accessoriesout')->middleware('can:all.accessoriesout');;
        Route::get('/get/accessoriesout', 'Getaccessoriesout')->name('get.accessoriesout')->middleware('can:all.accessoriesout');
        Route::get('/get/accessoriesoutdetail', 'Getaccessoriesoutdetail')->name('get.accessoriesoutdetail')->middleware('can:all.accessoriesout');
        Route::get('/get/accessoriesoutid/{id}', 'Getaccessoriesoutid')->name('get.accessoriesoutid')->middleware('can:all.accessoriesout');
        Route::post('/check/accessoriesout', 'Checkaccessoriesout')->name('check.accessoriesout');
        Route::get('/print/accessoriesout', 'Printaccessoriesout')->name('print.accessoriesout')->middleware('can:export.accessoriesout');
        Route::get('/pdf/accessoriesout/{id}', 'exportPDF')->name('pdf.accessoriesout')->middleware('can:export.accessoriesout');
        Route::post('/import/accessoriesout', 'Importaccessoriesout')->name('import.accessoriesout')->middleware('can:import.accessoriesout');
        Route::get('/import/accessoriesouts', 'Importaccessoriesouts')->name('import.accessoriesouts')->middleware('can:import.accessoriesout');
    });


    Route::controller(AccessoriesReturnController::class)->group(function () {
        Route::get('/all/accessoriesreturn', 'Allaccessoriesreturn')->name('all.accessoriesreturn')->middleware('can:all.accessoriesreturn');
        Route::get('/all/accessoriesreturndetail', 'Allaccessoriesreturndetail')->name('all.accessoriesreturndetail')->middleware('can:all.accessoriesreturn');
        Route::get('/add/accessoriesreturn', 'Addaccessoriesreturn')->name('add.accessoriesreturn')->middleware('can:add.accessoriesreturn');
        Route::get('/add/accessoriesreturnsp', 'Addaccessoriesreturnsp')->name('add.accessoriesreturnsp')->middleware('can:add.accessoriesreturn');
        Route::post('/store/accessoriesreturn', 'Storeaccessoriesreturn')->name('store.accessoriesreturn');
        Route::post('/store/accessoriesreturnsp', 'Storeaccessoriesreturnsp')->name('store.accessoriesreturnsp');
        Route::get('/edit/accessoriesreturn/{id}', 'Editaccessoriesreturn')->name('edit.accessoriesreturn')->middleware('can:edit.accessoriesreturn');
        Route::post('/update/accessoriesreturn/{id}', 'Updateaccessoriesreturn')->name('update.accessoriesreturn')->middleware('can:edit.accessoriesreturn');
        Route::get('/delete/accessoriesreturn/{id}', 'Deleteaccessoriesreturn')->name('delete.accessoriesreturn')->middleware('can:delete.accessoriesreturn');
        Route::get('/export/accessoriesreturn', 'Exportaccessoriesreturn')->name('export.accessoriesreturn')->middleware('can:all.accessoriesreturn');;
        Route::get('/get/accessoriesreturn', 'Getaccessoriesreturn')->name('get.accessoriesreturn')->middleware('can:all.accessoriesreturn');
        Route::get('/get/accessoriesreturndetail', 'Getaccessoriesreturndetail')->name('get.accessoriesreturndetail')->middleware('can:all.accessoriesreturn');

        Route::post('/check/accessoriesreturn', 'Checkaccessoriesreturn')->name('check.accessoriesreturn');
        Route::get('/print/accessoriesreturn', 'Printaccessoriesreturn')->name('print.accessoriesreturn')->middleware('can:export.accessoriesreturn');
        Route::get('/pdf/accessoriesreturn/{id}', 'exportPDF')->name('pdf.accessoriesreturn')->middleware('can:export.accessoriesreturn');
        Route::post('/import/accessoriesreturn', 'Importaccessoriesreturn')->name('import.accessoriesreturn')->middleware('can:import.accessoriesreturn');
        Route::get('/import/accessoriesreturns', 'Importaccessoriesreturns')->name('import.accessoriesreturns')->middleware('can:import.accessoriesreturn');
    });
}); 

//end admin middleware
