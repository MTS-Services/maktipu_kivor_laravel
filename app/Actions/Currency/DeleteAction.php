<?php

namespace App\Actions\Currency;

use App\Events\Currency\CurrencyDeleted;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $currencyInterface
    ) {}

    public function execute(int $currencyId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($currencyId, $forceDelete) {
            $currency = $this->currencyInterface->find($currencyId);

            if (!$currency) {
                throw new \Exception('Currency not found');
            }

            // Dispatch event before deletion
            event(new CurrencyDeleted($currency));

            if ($forceDelete) {
                return $this->currencyInterface->forceDelete($currencyId);
            }

            return $this->currencyInterface->delete($currencyId);
        });
    }

    public function restore(int $currencyId): bool
    {
        return $this->currencyInterface->restore($currencyId);
    }
}
