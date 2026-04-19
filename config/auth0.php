<?php

declare(strict_types=1);

use Auth0\Laravel\Configuration;
use Auth0\SDK\Configuration\SdkConfiguration;

$auth0Enabled = filled(env('AUTH0_DOMAIN'))
    && filled(env('AUTH0_CLIENT_ID'))
    && filled(env('AUTH0_CLIENT_SECRET'));

$appUrl = rtrim((string) env('APP_URL', ''), '/');
$appUrlPath = trim((string) parse_url($appUrl, PHP_URL_PATH), '/');
$appSubfolder = rtrim((string) env('APP_SUBFOLDER', ''), '/');
$routePrefix = $appSubfolder !== '' && $appUrlPath === trim($appSubfolder, '/')
    ? ''
    : ($appSubfolder !== '' ? $appSubfolder : '');

$normalizeAuth0Route = static function (string $route) use ($appSubfolder, $appUrlPath): string {
    if ($route === '') {
        return $route;
    }

    if ($appSubfolder === '' || $appUrlPath !== trim($appSubfolder, '/')) {
        return $route;
    }

    $subfolder = trim($appSubfolder, '/');
    $normalized = '/' . ltrim($route, '/');

    if ($subfolder !== '' && str_starts_with($normalized, '/' . $subfolder . '/')) {
        return substr($normalized, strlen('/' . $subfolder)) ?: '/';
    }

    if ($subfolder !== '' && $normalized === '/' . $subfolder) {
        return '/';
    }

    return $normalized;
};
$defaultIndexRoute = $routePrefix . '/';
$defaultCallbackRoute = $routePrefix . '/callback';
$defaultLoginRoute = $routePrefix . '/login';
$defaultAfterLoginRoute = $routePrefix . '/community';
$defaultLogoutRoute = $routePrefix . '/logout';
$defaultAfterLogoutRoute = $routePrefix . '/';

$routeIndex = $normalizeAuth0Route((string) env('AUTH0_INDEX', Configuration::get(Configuration::CONFIG_ROUTE_INDEX, $defaultIndexRoute)));
$routeCallback = $normalizeAuth0Route((string) env('AUTH0_CALLBACK', env('AUTH0_ROUTE_CALLBACK', Configuration::get(Configuration::CONFIG_ROUTE_CALLBACK, $defaultCallbackRoute))));
$routeLogin = $normalizeAuth0Route((string) env('AUTH0_LOGIN', env('AUTH0_ROUTE_LOGIN', Configuration::get(Configuration::CONFIG_ROUTE_LOGIN, $defaultLoginRoute))));
$routeAfterLogin = $normalizeAuth0Route((string) env('AUTH0_AFTER_LOGIN', env('AUTH0_ROUTE_AFTER_LOGIN', Configuration::get(Configuration::CONFIG_ROUTE_AFTER_LOGIN, $defaultAfterLoginRoute))));
$routeLogout = $normalizeAuth0Route((string) env('AUTH0_LOGOUT', env('AUTH0_ROUTE_LOGOUT', Configuration::get(Configuration::CONFIG_ROUTE_LOGOUT, $defaultLogoutRoute))));
$routeAfterLogout = $normalizeAuth0Route((string) env('AUTH0_AFTER_LOGOUT', env('AUTH0_ROUTE_AFTER_LOGOUT', Configuration::get(Configuration::CONFIG_ROUTE_AFTER_LOGOUT, $defaultAfterLogoutRoute))));

return Configuration::VERSION_2 + [
    'registerGuards' => $auth0Enabled,
    'registerMiddleware' => $auth0Enabled,
    'registerAuthenticationRoutes' => false,
    'configurationPath' => null,

    'guards' => [
        'default' => [
            Configuration::CONFIG_STRATEGY => Configuration::get(Configuration::CONFIG_STRATEGY, SdkConfiguration::STRATEGY_NONE),
            Configuration::CONFIG_DOMAIN => Configuration::get(Configuration::CONFIG_DOMAIN),
            Configuration::CONFIG_CUSTOM_DOMAIN => Configuration::get(Configuration::CONFIG_CUSTOM_DOMAIN),
            Configuration::CONFIG_CLIENT_ID => Configuration::get(Configuration::CONFIG_CLIENT_ID),
            Configuration::CONFIG_CLIENT_SECRET => Configuration::get(Configuration::CONFIG_CLIENT_SECRET),
            Configuration::CONFIG_AUDIENCE => Configuration::get(Configuration::CONFIG_AUDIENCE),
            Configuration::CONFIG_ORGANIZATION => Configuration::get(Configuration::CONFIG_ORGANIZATION),
            Configuration::CONFIG_USE_PKCE => Configuration::get(Configuration::CONFIG_USE_PKCE),
            Configuration::CONFIG_SCOPE => Configuration::get(Configuration::CONFIG_SCOPE),
            Configuration::CONFIG_RESPONSE_MODE => Configuration::get(Configuration::CONFIG_RESPONSE_MODE),
            Configuration::CONFIG_RESPONSE_TYPE => Configuration::get(Configuration::CONFIG_RESPONSE_TYPE),
            Configuration::CONFIG_TOKEN_ALGORITHM => Configuration::get(Configuration::CONFIG_TOKEN_ALGORITHM),
            Configuration::CONFIG_TOKEN_JWKS_URI => Configuration::get(Configuration::CONFIG_TOKEN_JWKS_URI),
            Configuration::CONFIG_TOKEN_MAX_AGE => Configuration::get(Configuration::CONFIG_TOKEN_MAX_AGE),
            Configuration::CONFIG_TOKEN_LEEWAY => Configuration::get(Configuration::CONFIG_TOKEN_LEEWAY),
            Configuration::CONFIG_TOKEN_CACHE => Configuration::get(Configuration::CONFIG_TOKEN_CACHE),
            Configuration::CONFIG_TOKEN_CACHE_TTL => Configuration::get(Configuration::CONFIG_TOKEN_CACHE_TTL),
            Configuration::CONFIG_HTTP_MAX_RETRIES => Configuration::get(Configuration::CONFIG_HTTP_MAX_RETRIES),
            Configuration::CONFIG_HTTP_TELEMETRY => Configuration::get(Configuration::CONFIG_HTTP_TELEMETRY),
            Configuration::CONFIG_MANAGEMENT_TOKEN => Configuration::get(Configuration::CONFIG_MANAGEMENT_TOKEN),
            Configuration::CONFIG_MANAGEMENT_TOKEN_CACHE => Configuration::get(Configuration::CONFIG_MANAGEMENT_TOKEN_CACHE),
            Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_KEY => Configuration::get(Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_KEY),
            Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_ALGORITHM => Configuration::get(Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_ALGORITHM),
            Configuration::CONFIG_PUSHED_AUTHORIZATION_REQUEST => Configuration::get(Configuration::CONFIG_PUSHED_AUTHORIZATION_REQUEST),
            Configuration::CONFIG_BACKCHANNEL_LOGOUT_CACHE => Configuration::get(Configuration::CONFIG_BACKCHANNEL_LOGOUT_CACHE),
            Configuration::CONFIG_BACKCHANNEL_LOGOUT_EXPIRES => Configuration::get(Configuration::CONFIG_BACKCHANNEL_LOGOUT_EXPIRES),
        ],

        'api' => [
            Configuration::CONFIG_STRATEGY => SdkConfiguration::STRATEGY_API,
        ],

        'web' => [
            Configuration::CONFIG_STRATEGY => SdkConfiguration::STRATEGY_REGULAR,
            Configuration::CONFIG_COOKIE_SECRET => Configuration::get(Configuration::CONFIG_COOKIE_SECRET, env('APP_KEY')),
            Configuration::CONFIG_REDIRECT_URI => Configuration::get(Configuration::CONFIG_REDIRECT_URI, env('APP_URL') . '/callback'),
            Configuration::CONFIG_SESSION_STORAGE => Configuration::get(Configuration::CONFIG_SESSION_STORAGE),
            Configuration::CONFIG_SESSION_STORAGE_ID => Configuration::get(Configuration::CONFIG_SESSION_STORAGE_ID),
            Configuration::CONFIG_TRANSIENT_STORAGE => Configuration::get(Configuration::CONFIG_TRANSIENT_STORAGE),
            Configuration::CONFIG_TRANSIENT_STORAGE_ID => Configuration::get(Configuration::CONFIG_TRANSIENT_STORAGE_ID),
            'persistAccessToken' => filter_var(env('AUTH0_PERSIST_ACCESS_TOKEN', false), FILTER_VALIDATE_BOOL),
            'queryUserInfo' => filter_var(env('AUTH0_QUERY_USER_INFO', true), FILTER_VALIDATE_BOOL),
        ],
    ],

    'routes' => [
        Configuration::CONFIG_ROUTE_INDEX => $routeIndex,
        Configuration::CONFIG_ROUTE_CALLBACK => $routeCallback,
        Configuration::CONFIG_ROUTE_LOGIN => $routeLogin,
        Configuration::CONFIG_ROUTE_AFTER_LOGIN => $routeAfterLogin,
        Configuration::CONFIG_ROUTE_LOGOUT => $routeLogout,
        Configuration::CONFIG_ROUTE_AFTER_LOGOUT => $routeAfterLogout,
    ],
];
