<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDeliveryController;
use App\Http\Controllers\MainBranchController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubBranchCotroller;
use App\Http\Controllers\SubCategoryController;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



/**
 * Eng Nour Othman
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



//0000 todo   validation role mangment //0000





//client/delivery auth
Route::post('generateOTP', [OTPController::class, 'generateOTP']);
Route::post('clientDeliveryLogin', [ClientDeliveryController::class, 'clientDeliveryLogin']);



// wasity_manager/ sub_branch_owner auth
Route::post('managerLogin', [ManagerController::class, 'managerLogin']);
Route::post('addSubBranchOwner', [ManagerController::class, 'addSubBranchOwner']);
Route::post('addWasityManager', [ManagerController::class, 'addWasityManager']);



//main category
Route::post('addMainCategory', [MainCategoryController::class, 'addMainCategory']);
Route::get('getMainCatgories', [MainCategoryController::class, 'getMainCatgories']);
Route::post('updateMainCatgory', [MainCategoryController::class, 'updateMainCatgory']);
Route::post('deleteMainCatgory', [MainCategoryController::class, 'deleteMainCatgory']);


//sub category
Route::post('addSubCategory', [SubCategoryController::class, 'addSubCategory']);
Route::get('getSubCategoriesByMainCategoryId/{id}', [SubCategoryController::class, 'getSubCategoriesByMainCategoryId']);
Route::post('updateSubCategory', [SubCategoryController::class, 'updateSubCategory']);
Route::post('deleteSubCategory', [SubCategoryController::class, 'deleteSubCategory']);



// client 
Route::get('clientHome', [ClientDeliveryController::class, 'clientHome']);


//branches 

//main branch
Route::get('getMainBranches', [MainBranchController::class, 'getMainBranches']);
Route::post('addMainBranch', [MainBranchController::class, 'addMainBranch']);
Route::post('updateMainBranch', [MainBranchController::class, 'updateMainBranch']);




//sub branch
Route::post('addSubBranch', [SubBranchCotroller::class, 'addSubBranch']);
Route::post('updateSubBranch', [SubBranchCotroller::class, 'updateSubBranch']);


//brand
Route::post('addBrand', [BrandController::class, 'addBrand']);
Route::get('getBrands', [BrandController::class, 'getBrands']);
Route::post('updateBrand', [BrandController::class, 'updateBrand']);
Route::post('deleteBrand', [BrandController::class, 'deleteBrand']);




//product
Route::get('getProductsBySubCategoryId/{id}', [ProductController::class, 'getProductsBySubCategoryId']);
Route::post('addProduct', [ProductController::class, 'addProduct']);
Route::get('getProductsBySubBranchId/{id}', [ProductController::class, 'getProductsBySubBranchId']);
Route::post('updateProduct', [ProductController::class, 'updateProduct']);
Route::post('deleteProduct', [ProductController::class, 'deleteProduct']);
