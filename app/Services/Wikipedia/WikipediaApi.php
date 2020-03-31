<?php


namespace App\Services\Wikipedia;


use GuzzleHttp\Client;
use Illuminate\Support\Str;

class WikipediaApi implements WikipediaApiInterface
{
    private Client $httpClient;

    private string $url = 'https://en.wikipedia.org/w/api.php';

    public function __construct()
    {
        $this->httpClient = new Client();
    }


    /**
     * @param string $page
     * @param int|null $section
     * @return string
     */
    public function getPageSection(string $page, ?int $section = 0): string
    {
        $params = [
            'query' => [
                'action' => 'parse',
                'page' => $page,
                'format' => 'json',
                'prop' => 'text',
                'section' => $section
            ]
        ];
        $response = $this->httpClient->get($this->url, $params);

        if ($response->getStatusCode() === 200) {
            $pageContents = json_decode($response->getBody()->getContents(), false);
            return $pageContents->parse->text->{'*'};
        }

        return '';
    }
}
