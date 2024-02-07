<?php

namespace App\Enums;

enum UserStatusEnum{
    const REGISTERED = 'registered';
    const VERIFIED = 'verified';
    const APPROVED = 'approved';
    const DEACTIVATED = 'deactivated';
}
