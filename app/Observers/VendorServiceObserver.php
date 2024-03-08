<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorService;
use App\Notifications\Admin\VendorServiceCreatedNotification;
use App\Notifications\Admin\VendorServiceUpdatedNotification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

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
        $vendor = Vendor::Find('id', $vendorService->vendor_id)->name;
        $admins = User::where('role', 'admin')->get();
        dd($vendor);
        foreach ($admins as $admin) {
            $admin->notify(new VendorServiceCreatedNotification($vendor));
        }
    }

    /**
     * Handle the VendorService "deleted" event.
     */
    public function deleted(VendorService $vendorService): void
    {
        $vendor = auth()->user()->vendor->name;

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new VendorServiceUpdatedNotification($vendor));
        }
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
