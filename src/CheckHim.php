<?php
namespace CheckHim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CheckHim
{
    private string $apiKey;
    private Client $client;
    private string $baseUrl = 'https://api.checkhim.tech/api/v1/verify';

    public function __construct(string $apiKey)
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key is required.');
        }
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'timeout' => 10,
        ]);
    }

    /**
     * Checks if the phone number is active.
     * @param string $number
     * @return array
     * @throws \Exception
     */
    public function verify(string $number): array
    {
        if (empty($number)) {
            throw new \InvalidArgumentException('Number is required.');
        }
        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'number' => $number,
                    'type'   => 'frontend', // inserted internally
                ],
                'http_errors' => false,
            ]);
            $status = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(), true);
            if ($status === 200 && isset($data['carrier'], $data['valid'])) {
                return [
                    'carrier' => $data['carrier'],
                    'valid'   => (bool)$data['valid'],
                ];
            }
            // Standardized error handling
            if (isset($data['error'], $data['code'])) {
                return [
                    'error' => $data['error'],
                    'code'  => $data['code'],
                    'http_status' => $status,
                ];
            }
            throw new \Exception('Invalid response from API.');
        } catch (GuzzleException $e) {
            throw new \Exception('HTTP request failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
