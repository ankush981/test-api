<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class QuizController extends Controller
{
    // GuzzleHttp client
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('QUIZ_API_BASE_URL')
        ]);        
    }

    public function getCategories() {
        $response = $this->client->request('GET', 'categories', [
            'query' => [
                'count' => 10
            ]
        ]);
        
        return response()->json(json_decode($response->getBody()->getContents()));
    }

    public function getQuestionsByCategory(int $cat_id) {

        $response = $this->client->request('GET', 'category', [
            'query' => [
                'id' => $cat_id,
            ]
        ]);

        return response()->json(json_decode($response->getBody()->getContents()));
    }
}
