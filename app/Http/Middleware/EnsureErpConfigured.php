<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class EnsureErpConfigured
{
    public function handle(Request $request, Closure $next)
    {
        $stores = Store::active()->get();

        if ($stores->isEmpty()) {

            return redirect()
                ->route('admin.stores')
                ->with('error', 'Δεν υπάρχουν καταστήματα. Παρακαλώ δημιουργήστε ένα.');
        }


        $hasValid = $stores->contains(fn($store) => $store->hasPylon());

        if (!$hasValid) {

            return redirect()
                ->route('admin.stores')
                ->with('error', 'Δεν υπάρχουν ρυθμισμένα ERP στοιχεία. Παρακαλώ ολοκληρώστε τη ρύθμιση.');
        }

        return $next($request);
    }
}
