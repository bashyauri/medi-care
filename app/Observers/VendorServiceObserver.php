<?php

namespace App\Observers;

use App\Models\User;
use App\Models\VendorService;
use App\Notifications\Admin\VendorServiceCreatedNotification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class VendorServiceObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the VendorService "created" event.
     */
    public function created(VendorService $vendorService): void
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new VendorServiceCreatedNotification());
        }
    }

    /**
     * Handle the VendorService "updated" event.
     */
    public function updated(VendorService $vendorService): void
    {
        //
    }

    /**
     * Handle the VendorService "deleted" event.
     */
    public function deleted(VendorService $vendorService): void
    {
        //
    }

    /**
     * Handle the VendorService "restored" event.
     */
    public function restored(VendorService $vendorService): void
    {
        //
    }

    /**
     * Handle the VendorService "force deleted" event.
     */
    public function forceDeleted(VendorService $vendorService): void
    {
        //
    }
}
