<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BankAccountInfo extends Component
{
    public $bankName;
    public $accountNumber;
    public $accountHolder;

    public function __construct()
    {
        $this->bankName = settings('bank_name');
        $this->accountNumber = settings('account_number');
        $this->accountHolder = settings('account_holder');
    }

    public function render()
    {
        return view('components.bank-account-info');
    }
}
