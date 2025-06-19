<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;

class CustomLogoutResponse implements Responsable
{
    /**
     * {@inheritDoc}
     */
    public function toResponse($request)
    {
        return redirect()->route('index');
    }
}
