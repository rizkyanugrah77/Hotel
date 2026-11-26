<?php

namespace App\Services;

use App\Enums\BookingStatus;
use Illuminate\Validation\ValidationException;

class BookingStateMachine
{
    /**
     * Administrative transitions only. Financial statuses are owned by the
     * payment reconciliation flow, never by an admin edit form.
     */
    public function assertAdminTransitionAllowed(string $from, string $to): void
    {
        if ($from === $to) {
            return;
        }

        $allowed = array_keys(BookingStatus::adminTransitionsFor($from));

        if (! in_array($to, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => "Status booking tidak dapat diubah dari {$from} menjadi {$to}.",
            ]);
        }
    }
}
