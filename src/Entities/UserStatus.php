<?php

namespace Project\Entities;

enum UserStatus
{
    case ADMIN;
    case AUTHOR;
    case DISABLED;
    case PENDING_CONFIRMATION;

    public function value(): string
    {
        return match ($this) {
            UserStatus::ADMIN => 'ADMIN',
            UserStatus::AUTHOR => 'AUTHOR',
            UserStatus::DISABLED => 'DISABLED',
            UserStatus::PENDING_CONFIRMATION => 'PENDING_CONFIRMATION',
        };
    }
}