<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 기존에 있는 다른 예외들을 유지하면서,
        '/check-reservation', // 이 라인을 추가하여 CSRF 검증에서 해당 라우트를 제외합니다.
    ];
}
