<?php


namespace App\Repositories;


use App\Models\Loan;

class LoanRepository extends BaseRepository
{
    protected Loan $loan;

    public function __construct(Loan $loan)
    {
        parent::__construct($loan);
        $this->loan = $loan;
    }

    public function withUser(int $loanId): object|null
    {
        return $this->loan::with('user')->find($loanId);
    }

    public function withBook(int $loanId): object|null
    {
        return $this->loan::with('book')->find($loanId);
    }

    public function complete(int $loanId): object|null
    {
        return $this->loan::with(['user', 'book'])->find($loanId);
    }


}
