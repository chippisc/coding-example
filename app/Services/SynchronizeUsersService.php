<?php

namespace App\Services;

use App\Models\SchulcampusUser;
use Carbon\Exceptions\InvalidTypeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SynchronizeUsersService
{
    public function fromApi(): void
    {
        $token = $this->requestToken();
        $users = $this->fetchUsers($token);
        $this->validate($users);
        $this->synchronizeDatabase($users);
    }

    /**
     * @param  array<string[]>  $users
     */
    private function validate($users): void
    {
        // Use default laravel validation. For huge datasets a custom validator would need to be implemented for performance reasons
        Validator::make($users, [
            '*' => [
                'required',
                'array',
                'required_array_keys:username,givenName,familyName,role',
            ],
            '*.username' => ['string', 'max:255'],
            '*.givenName' => ['string', 'max:255'],
            '*.familyName' => ['string', 'max:255'],
            '*.role' => ['string', 'max:255', 'in:student,teacher'],
        ])->validate();
    }

    /**
     * @param  array<string[]>  $users
     */
    private function synchronizeDatabase(array $users): void
    {
        // Update or create users from api
        foreach ($users as $user) {
            $user = $user;
            SchulcampusUser::upsert([
                'username' => $user['username'] ?? '',
                'given_name' => $user['givenName'] ?? '',
                'family_name' => $user['familyName'] ?? '',
                'role' => $user['role'] ?? '',
            ], uniqueBy: 'username');
        }

        // Delete all users that were not returned from the api
        SchulcampusUser::query()
            ->whereNotIn('username', Arr::flatten($users))
            ->delete();
    }

    /**
     * @return array<string[]>
     */
    private function fetchUsers(string $token): array
    {
        $url = config('services.schulcampus_api.users_url');
        if (! is_string($url)) {
            throw new InvalidTypeException('Url must be a string');
        }

        $response = Http::get(
            $url,
            [
                'access_token' => $token,
            ]
        );

        $users = (array) $response->json();

        /** @var array<string[]> */
        return $users['users'];
    }

    private function requestToken(): string
    {
        $url = config('services.schulcampus_api.token_url');
        if (! is_string($url)) {
            throw new InvalidTypeException('Url must be a string');
        }

        $response = Http::post(
            $url,
            [
                'client_id' => config('services.schulcampus_api.client_id'),
                'client_secret' => config('services.schulcampus_api.client_secret'),
                'grant_type' => 'client_credentials',
            ]
        );
        $token = is_array($response->json()) && array_key_exists('access_token', $response->json()) ? $response->json()['access_token'] : throw new \Exception('Token could not be fetched from schulcampus api');

        return is_string($token) ? $token : throw new \Exception('Token could not be fetched from schulcampus api');
    }
}
