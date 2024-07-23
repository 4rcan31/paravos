<?php

class AuthMiddleware {

    private const SESSION_COOKIE = 'session';

    public function sessionAsAdmin(): bool {
        return $this->sessionHasRole('staff', 'admin');
    }

    public function sessionAsUser(): bool {
        return $this->sessionHasRole('users', 'user');
    }

    private function sessionHasRole(string $table, string $role): bool {
        return $this->session($table) && $this->getPayload('rol') === $role;
    }

    private function session(string $table): bool {
        return $this->middlewareAuthServerAndClient($table);
    }

    private function middlewareAuthServerAndClient(string $table): bool {
        $session = Request::$cookies[self::SESSION_COOKIE] ?? null;

        if (!$session) {
            return false;
        }

        $idUserClient = $this->getPayload('id');

        if (!$idUserClient) {
            return false;
        }

        return Sauth::middlewareAuthServerAndClient(
            $session,
            $_ENV['APP_KEY'],
            $table,
            'remember_token',
            (int) $idUserClient
        );
    }

    private function getPayload(string $key): ?string {
        $session = Request::$cookies[self::SESSION_COOKIE] ?? null;

        if (!$session) {
            return null;
        }

        return Sauth::getPayLoadTokenClient($session, $_ENV['APP_KEY'], $key);
    }
}
