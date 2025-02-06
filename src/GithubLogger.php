<?php

namespace Geekgarden\GithubLogger;

use GuzzleHttp\Client;

class GithubLogger
{
    protected $client;
    protected $repo;
    protected $owner;
    protected $token;

    public function __construct(string $repo, string $token)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'Authorization' => "token {$token}",
                'Accept'        => 'application/vnd.github.v3+json',
            ]
        ]);
        $this->repo = $repo;
        $this->token = $token;
    }

    public function report(string $message, string $stackTrace, string $logLevel = 'BUG', array $extraData = [])
    {
        $formattedBody = "**Log Level:** `$logLevel`\n\n" .
            "**Message:**\n" .
            "> $message\n\n" .
            "**Stack Trace:**\n" .
            "```php\n$stackTrace\n```\n\n" .
            "**Extra Data:**\n" .
            "```json\n" . $this->formatJson($extraData) . "\n```";
        $response = $this->client->post("repos/{$this->repo}/issues", [
            'json' => [
                'title' => $message,
                'body'  => $formattedBody,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function formatJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
