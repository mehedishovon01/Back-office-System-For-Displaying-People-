<?php


namespace Module\Account\Services;


use Module\Account\Models\Account;
use Module\Account\Models\Transaction;


class AccountTransactionService
{
    public function storeTransaction($model, $invoice_no, $account, $amount, $date)
    {
        $model->transactions()->updateOrCreate([
                'invoice_no'    => $invoice_no,
                'account_id'    => $account->id,
                'balance_type'  => $account->balance_type,
            ], [
                'amount'        => $amount,
                'date'          => $date,
            ]);
    }

    public function storeSaleTransaction($model, $invoice_no, $amount)
    {
        $invoice_no = 'inv-abc-1025487';
        $date       = $model->date;
        $account1   = $this->getAccount('A/C Receivables Customers');
        $account2   = $this->getAccount('Sales');

        $this->storeTransaction($model, $invoice_no, $account1, $amount, $date);
        $this->storeTransaction($model, $invoice_no, $account2, $amount, $date);
    }

    public function storeCollectionTransaction($model, $invoice_no, $amount)
    {
        $invoice_no = 'inv-def-1025487';
        $date       = $model->date;
        $account1   = $this->getAccount('A/C Receivables Customers');
        $account2   = $this->getAccount('Petty Cash');

        $this->storeTransaction($model, $invoice_no, $account1, -$amount, $date);
        $this->storeTransaction($model, $invoice_no, $account2, $amount, $date);
    }

    public function storeSaleReturnTransaction($model, $invoice_no, $amount)
    {
        $invoice_no = 'inv-sale-rtn-1025487';
        $date       = $model->date;
        $account1   = $this->getAccount('A/C Receivables Customers');
        $account2   = $this->getAccount('Sale Return');

        $this->storeTransaction($model, $invoice_no, $account1, -$amount, $date);
        $this->storeTransaction($model, $invoice_no, $account2, $amount, $date);
    }

    public function storePurchaseTransaction($model, $amount, $transaction_no, $date)
    {
        $account1   = $this->getAccount('Accounts Payable Suppliers'); //35 Credit
        $account2   = $this->getAccount('Local Purchase'); //4 Debit

        $this->storeTransaction($model, $transaction_no, $account1, $amount, $date);
        $this->storeTransaction($model, $transaction_no, $account2, -$amount, $date);
    }

    public function storePaymentTransaction($model, $invoice_no, $amount)
    {
        $invoice_no = 'inv-pmnt-1025487';
        $date       = $model->date;
        $account1   = $this->getAccount('Accounts Payable Suppliers');
        $account2   = $this->getAccount('Petty Cash');

        $this->storeTransaction($model, $invoice_no, $account1, -$amount, $date);
        $this->storeTransaction($model, $invoice_no, $account2, -$amount, $date);
    }

    public function storePurchaseReturnTransaction($model, $invoice_no, $amount)
    {
        $invoice_no = 'inv-pur-rtn-1025487';
        $date       = $model->date;
        $account1   = $this->getAccount('Accounts Payable Suppliers');
        $account2   = $this->getAccount('Purchase Return');

        $this->storeTransaction($model, $invoice_no, $account1, -$amount, $date);
        $this->storeTransaction($model, $invoice_no, $account2, $amount, $date);
    }

    public function storeDebitVoucher($model, $amount, $account_id, $transaction_no, $date) // <-------------------------
    {
        $account1   = $this->getAccountById($account_id);
        // $account2   = $this->getAccount('Petty Cash');

        $this->storeTransaction($model, $transaction_no, $account1, $amount, $date);
        // $this->storeTransaction($model, $transaction_no, $account2, -$amount, $date);
    }

    public function storeCreditVoucher($model, $amount, $account_id, $transaction_no, $date)
    {
        $account1   = $this->getAccountById($account_id);
        // $account2   = $this->getAccount('Petty Cash');

        $this->storeTransaction($model, $transaction_no, $account1, -$amount, $date);
        // $this->storeTransaction($model, $transaction_no, $account2, $amount, $date);
    }

    public function storeFundTransfer($transfer)
    {
        $fromAccount    = $this->getAccountById($transfer->from_account_id);
        $toAccount      = $this->getAccountById($transfer->to_account_id);

        $this->storeTransaction($transfer, $transfer->invoice_no, $fromAccount, -$transfer->amount, $transfer->date);
        $this->storeTransaction($transfer, $transfer->invoice_no, $toAccount, $transfer->amount, $transfer->date);
    }

    public function deleteTransaction($invoice_no)
    {
        Transaction::where('invoice_no', $invoice_no)->delete();
    }

    public function getAccount($accountName)
    {
        return Account::where('name', $accountName)->first();
    }

    public function getAccountById($id)
    {
        return Account::find($id);
    }
}
