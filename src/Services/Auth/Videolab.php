<?php

namespace Codific\Vault\Services\Auth;

use Codific\Vault\OptionsResolver;

/**
 * This service class handle all Vault HTTP API endpoints starting in /auth/token
 *
 */
class Videolab extends AuthenticationAbstraction
{

    /**
     * login with existing user
     *
     * @param array  $body
     * @param string $authBackEnd
     * @return mixed
     */
    public function login($body, $authBackEnd = 'user')
    {
        $body = OptionsResolver::resolve($body, [
            'username', 'password'
        ]);
        $username = $body['username'];
        $password = $body['password'];
        $params = [
            'body' => json_encode(["password" => $password])
        ];
        return $this->client->post('/v1/auth/videolab/login/' . $authBackEnd . '/' . $username, $params);
    }
}
