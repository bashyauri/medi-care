<?php

namespace App\Services\User;

/**
 * Class UserAddressService.
 */
class UserAddressService
{

    public function store($data)
    {
        return  $this->user()->userAddresses()->create($data);
    }
    public function update($data, $id)
    {

        return  $this->user()->userAddresses()->where('id', $id)->update($data);
    }
    public function destroy($id)
    {
        $this->user()->userAddresses()->where('id', $id)->delete();
    }
    private function user()
    {
        return auth()->user();
    }
}
