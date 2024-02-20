<?php

namespace Middleware;

use Helpers\Authenticate;
use Response\HTTPRenderer;
use Response\Render\RedirectRenderer;

class GuestMiddleware implements Middleware
{
    public function handle(callable $next): HTTPRenderer
    {
        error_log('Running authentication check...');
        // ユーザーがログインしている場合は、メッセージなしでページにリダイレクトします
        if(Authenticate::isLoggedIn()){
            if(Authenticate::isVerificationEmail()){
                return new RedirectRenderer('random/part');
            }
            else{
                return new RedirectRenderer('verify/resend');
            }
        }

        return $next();
    }
}