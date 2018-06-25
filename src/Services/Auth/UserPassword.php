<?php
namespace Codific\Vault\Services\Auth;

use Codific\Vault\Client;
use Codific\Vault\OptionsResolver;

/**
 * This service class handle all Vault HTTP API endpoints starting in /auth/token
 *
 */
class UserPassword extends AuthenticationAbstraction
{

    /**
     * Creates a new user with credentials.
     *
     * @see    https://www.vaultproject.io/api/auth/userpass/index.html#create-update-user
     * @param array  $body options := { username | password | policies | ttl | max_ttl | bound_cidrs }
     * @param string $authBackEnd
     * @return mixed
     */
    public function create(array $body = [], $authBackEnd = 'userpass')
    {
        $body = OptionsResolver::resolve($body, [
            'username', 'password', 'policies', 'ttl', 'max_ttl', 'bound_cidrs'
        ]);
        $username = $body['username'];
        $params = [
            'body' => json_encode($body)
        ];

        return $this->client->post('/v1/auth/' . $authBackEnd . '/users/' . $username, $params);
    }

    /**
     * Update the password for an existing user
     *
     * @see   https://www.vaultproject.io/api/auth/userpass/index.html#create-update-user
     * @param array  $body
     * @param string $authBackEnd
     * @return mixed
     */
    public function update($body, $authBackEnd = 'userpass')
    {
        $body = OptionsResolver::resolve($body, [
            'username', 'password'
        ]);
        $username = $body['username'];
        $params = [
            'body' => json_encode($body)
        ];

        return $this->client->post('/v1/auth/' . $authBackEnd . '/users/' . $username, $params);
    }

    /**
     * Reads the properties of an existing username.
     * @see   https://www.vaultproject.io/api/auth/userpass/index.html#read-user
     * @param string $username
     * @param string $authBackEnd
     * @return mixed
     */
    public function readUser($username, $authBackEnd = 'userpass')
    {
        return $this->client->get('/v1/auth/' . $authBackEnd . '/users/' . $username);
    }

    /**
     * Deletes single user from vault based on username
     *
     * @see   https://www.vaultproject.io/api/auth/userpass/index.html#delete-user
     * @param string $username
     * @param string $authBackEnd
     * @return mixed
     */
    public function deleteUser($username, $authBackEnd = 'userpass')
    {
        return $this->client->delete('/v1/auth/' . $authBackEnd . '/users/' . $username);
    }

    /**
     * List available users for specific auth backend
     *
     * @see   https://www.vaultproject.io/api/auth/userpass/index.html#list-users
     * @param string $authBackEnd
     * @return mixed
     */
    public function listUser($authBackEnd = 'userpass')
    {
        return $this->client->listRequest('/v1/auth/' . $authBackEnd . '/users');
    }

    /**
     * login with existing user
     *
     * @see   https://www.vaultproject.io/api/auth/userpass/index.html#login
     * @param array  $body
     * @param string $authBackEnd
     * @return mixed
     */
    public function login($body, $authBackEnd = 'userpass')
    {
        $body = OptionsResolver::resolve($body, [
            'username', 'password'
        ]);
        $username = $body['username'];
        $password = $body['password'];
        $params = [
            'body' => json_encode(["password" => $password])
        ];
        return $this->client->post('/v1/auth/' . $authBackEnd . '/login/' . $username, $params);
    }
}
