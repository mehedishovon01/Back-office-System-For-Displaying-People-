<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'production'], function () {
    Route::resource('factories', 'FactoryController');
    Route::resource('materials-assign', 'RawMaterialsController');
    Route::resource('manufactured', 'ManufacturedProductController');
    Route::resource('production', 'ProductionController');
    Route::resource('sales', 'ProductionSalesController');
    Route::get('production/approve/{id}', 'ProductionController@production_approve')->name('production.approve');
    Route::get('sales-order', 'ProductionSalesController@salesOrderIndex')->name('sales.order.index');
    Route::get('sales-order/create', 'ProductionSalesController@salesOrderCreate')->name('sales.order.create');
    Route::post('sales-order/store', 'ProductionSalesController@salesOrderStore')->name('sales.order.store');
    Route::get('sales-order/is/confirm/{id}', 'ProductionSalesController@isConfirm')->name('is.confirmed');

    // For Requsition
    Route::group(['prefix' => 'requsition'], function () {
        Route::resource('unit-item', 'RequsitionUnitItemController');
        Route::resource('item', 'RequsitionItemController');
        Route::resource('purchase', 'RequsitionPurchaseController');
        Route::get('grn/purchase', 'RequsitionPurchaseController@grnIndex')->name('purchase.grnIndex');
        Route::get('grn/purchase/approve/{id}/show', 'RequsitionPurchaseController@purchaseApproveShow')->name('purchase.approve.show');
        Route::put('grn/purchase/approve/{id}', 'RequsitionPurchaseController@purchaseApprove')->name('purchase.approve');
        Route::get('grn/purchase/approve/receive{id}', 'RequsitionPurchaseController@purchaseApproveReceive')->name('purchase.approve.receives.create');
    });


    Route::group(['prefix' => 'report'], function () {
        Route::resource('leger-report', 'ProductReportController');
        Route::get('product-ledger', 'ProductReportController@product_ledger')->name('product-ledger.index');
    });
    
});

// Ajax Call
Route::get('factories-data', 'RawMaterialsController@getFactoryData')->name('ajax.factories');
Route::get('is-approved/{id}', 'RawMaterialsController@is_approved')->name('is.approved');

Route::get('test', 'FactoryController@test');