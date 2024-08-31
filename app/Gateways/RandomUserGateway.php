<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Http;

class RandomUserGateway
{
   
    protected $dataProviderUrl;

    /**
     * RandomUserGateway 
     * 
     */
    public function __construct()
    {
        $this->dataProviderUrl = 'https://randomuser.me/api/';
    }


    /**
     * Fetch all users to randomuser.me
     * 
     * @param integer $totalUsers
     * @param string $nationality
     * @throws \Exception
     * @return mixed
     */
    public function fetchUsers($totalUsers, $nationality)
    {
        $response = Http::get($this->dataProviderUrl, [
            'results' => $totalUsers,
            'nat' => $nationality
        ]);

        if ($response->successful()) {
            return $response->json()['results'];
        }

        throw new \Exception('Failed to fetch customers');
    }

}
