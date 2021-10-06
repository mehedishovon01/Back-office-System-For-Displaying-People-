<?php

use \Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'setup'], function () {
    Route::get('account-setups', 'AccountSetupController@index')->name('account-setups.index');
    Route::get('account-groups', 'AccountGroupController@index')->name('account-groups.index');
    Route::resource('account-controls', 'AccountControlController');
    Route::resource('account-subsidiaries', 'AccountSubsidiaryController');
    Route::resource('accounts', 'AccountController');


    // AJAX
    Route::get('account-control-data', 'AccountAjaxController@getAccountControlsByAccountGroup')->name('ajax.account-controls');
    Route::get('account-subsidiary-data', 'AccountAjaxController@getAccountSubsidiariesByAccountControl')->name('ajax.account-subsidiaries');
    Route::get('account-data', 'AccountAjaxController@getAccountsByAccountControlAndAccountSubsidiary')->name('ajax.accounts-by-control-and-subsidiary');
    Route::get('account-subsidiary-and-account-data', 'AccountAjaxController@getAccountSubsidiariesAndAccountsByAccountControl')->name('ajax.subsidiaries-and-accounts-by-control');
});

Route::group(['prefix' => 'payment'], function () {
    Route::resource('vouchers', 'VoucherController');
    Route::get('vouchers/{voucher}/approve', 'VoucherController@showApprove')->name('payment.approve.show');
    Route::post('vouchers/{voucher}/approve', 'VoucherController@approveVoucher')->name('payment.approve.update');
    Route::get('vouchers/download/{id}', 'VoucherController@download')->name('payment.invoice.download');
});

Route::group(['prefix' => 'receive'], function () {
    Route::get('vouchers', 'VoucherController@receiveIndex')->name('receive.index');
    Route::get('vouchers/create', 'VoucherController@receiveCreate')->name('receive.create');
    Route::post('vouchers/store', 'VoucherController@receiveStore')->name('receive.store');
    Route::get('vouchers/{id}/edit', 'VoucherController@receiveEdit')->name('receive.edit');
    Route::get('vouchers/{id}/show', 'VoucherController@receiveShow')->name('receive.show');
    Route::get('vouchers/{voucher}/approve', 'VoucherController@showreceiveApprove')->name('receive.approve.show');
    Route::post('vouchers/{voucher}/approve', 'VoucherController@approvereceiveVoucher')->name('receive.approve.update');
});
Route::group(['prefix' => 'journal'], function () {
    Route::get('vouchers', 'VoucherController@journalIndex')->name('journal.index');
    Route::get('vouchers/create', 'VoucherController@journalCreate')->name('journal.create');
    Route::post('vouchers/store', 'VoucherController@journalStore')->name('journal.store');
    Route::get('vouchers/{id}/edit', 'VoucherController@journalEdit')->name('journal.edit');
    Route::get('vouchers/{id}/show', 'VoucherController@journalShow')->name('journal.show');
    Route::get('vouchers/{voucher}/approve', 'VoucherController@showjournalApprove')->name('journal.approve.show');
    Route::post('vouchers/{voucher}/approve', 'VoucherController@approvejournalVoucher')->name('journal.approve.update');

});
Route::group(['prefix' => 'contra'], function () {
    Route::get('vouchers', 'VoucherController@contraIndex')->name('contra.index');
    Route::get('vouchers/create', 'VoucherController@contraCreate')->name('contra.create');
    Route::post('vouchers/store', 'VoucherController@contraStore')->name('contra.store');
    Route::get('vouchers/{id}/edit', 'VoucherController@contraEdit')->name('contra.edit');
    Route::get('vouchers/{id}/show', 'VoucherController@contraShow')->name('contra.show');
    Route::get('vouchers/{voucher}/approve', 'VoucherController@showcontraApprove')->name('contra.approve.show');
    Route::post('vouchers/{voucher}/approve', 'VoucherController@approvecontraVoucher')->name('contra.approve.update');

});

Route::resource('fund-transfers', 'FundTransferController');
Route::post('fund-transfers/{fundTransfer}/approve', 'FundTransferController@approveFundTransfer')->name('fund-transfers.approve.update');



Route::group(['prefix' => 'reports'], function () {

    Route::get('chart-of-account', 'AccountReportController@chartOfAccountReport')->name('report.chart-of-account');
    Route::get('ledger-journal', 'AccountReportController@ledgerJournalReport')->name('report.ledger-journal');
    Route::get('transaction-ledger', 'AccountReportController@transactionLedgerReport')->name('report.transaction-ledger');
    Route::get('account-ledger', 'AccountReportController@accountLedgerReport')->name('report.account-ledger');
    Route::get('subsidiary-wise-ledger', 'AccountReportController@subsidiaryWiseLedgerReport')->name('report.subsidiary-wise-ledger');
    Route::get('nominal-account-ledger', 'AccountReportController@nominalAccountLedgerReport')->name('report.nominal-account-ledger');


    Route::get('revenue-analysis', 'AccountReportController@revenueAnalysisReport')->name('report.revenue-analysis');
    Route::get('expense-analysis', 'AccountReportController@expenseAnalysisReport')->name('report.expense-analysis');
    Route::get('ratio-analysis', 'AccountReportController@ratioAnalysisReport')->name('report.ratio-analysis');
    Route::get('received-payment-statement', 'AccountReportController@receivedPaymentStatementReport')->name('report.received-payment-statement');

    Route::group(['prefix' => 'financial-statements'], function() {
        Route::get('trial-balance', 'AccountReportController@trialBalanceReport')->name('report.trial-balance');
        Route::get('balance-sheet', 'AccountReportController@balanceSheetReport')->name('report.balance-sheet');
        Route::get('profit-and-loss', 'AccountReportController@profitAndLossReport')->name('report.profit-and-loss');
    });
});


// Product
Route::group(['prefix' => 'product'], function() {
   Route::resource('units', 'UnitController');
   Route::resource('categories', 'CategoryController');
   Route::resource('products', 'ProductController');
});

// Purchase
Route::group(['prefix' => 'purchase'], function() {
   Route::resource('acc_payments', 'PaymentController');
   Route::resource('acc_purchases', 'PurchaseController');
   Route::resource('acc_suppliers', 'SupplierController');
});

// Sale
Route::group(['prefix' => 'sale'], function() {
   Route::resource('acc_collections', 'CollectionController');
   Route::resource('acc_sales', 'SaleController');
    Route::resource('acc_customers', 'CustomerController');
});
