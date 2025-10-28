<?php

namespace App\Interfaces;

interface LoginRepositoryInterface
{
    public function attemptLogin($credentials,$remember = false);
    public function forgotPassword($email);
    public function resetPassword($request);
}
