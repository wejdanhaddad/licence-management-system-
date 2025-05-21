<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LicenseApiService
{
    private $client;
    private $apiUrl;

    public function __construct(HttpClientInterface $client)  
    { 
        $this->client = $client;
        $this->apiUrl = 'http://localhost:5000/api/licenses'; //  API .NET
    }

    public function checkLicense(string $licenseKey): array
    {
        $response = $this->client->request('GET', $this->apiUrl . '/check/' . $licenseKey);

        if ($response->getStatusCode() === 200) {
            return $response->toArray();
        }

        return ['error' => 'Licence introuvable ou erreur API'];
    }

    public function activateLicense(string $licenseKey): string
    {
        $response = $this->client->request('POST', $this->apiUrl . '/activate/' . $licenseKey);

        return $response->getContent(false);
    }

    public function generateLicense(array $data): array
    {
        $response = $this->client->request('POST', $this->apiUrl . '/generate', [
            'json' => $data,
        ]);

        return $response->toArray();
    }
}
