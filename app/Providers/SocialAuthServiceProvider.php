<?php

namespace App\Providers;
use App\Http\Grant\SocialGrant;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use League\OAuth2\Server\AuthorizationServer;

class SocialAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $grant = $this->makeGrant();
            $server->enableGrantType($grant, Passport::tokensExpireIn());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function makeGrant()
    {
        $grant = new SocialGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());
        return $grant;
    }
}
