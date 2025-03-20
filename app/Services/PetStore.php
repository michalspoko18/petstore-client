<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class PetStore {

    protected string $apiBaseUrl;

    public function __construct() {
        $this->apiBaseUrl = config('services.petstore.apiBaseUrl');

        if (empty($this->apiBaseUrl)) {
            throw new InvalidArgumentException('PetStore API URL is not configured');
        }
    }

    protected function request(string $method, string $endpoint, array $params = []) {
        if (empty($endpoint)) {
            throw new InvalidArgumentException('Endpoint cannot be empty');
        }

        $response = Http::$method("{$this->apiBaseUrl}{$endpoint}", $params);

        if ($response->failed()) {
            throw new \Exception("API PetStore error: {$response->status()} - " . $response->body());
        }

        return $response->json();
    } 

    public function findByStatus(string $status = 'available'): array {
        return $this->request('get', '/pet/findByStatus', [
            'status' => $status
        ]);
    }
}