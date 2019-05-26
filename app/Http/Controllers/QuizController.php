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

        $data = json_decode($response->getBody()->getContents());
        $questions = $data->clues;
        
        $faker = \Faker\Factory::create();
        
        // hold questions after removing unwanted stuff
        $cleanedQuestions = [];
        
        foreach($questions as $question) {
            // stuff 3 choices for answer
            $question->choices = $faker->words(3);
            // also stick the answer among the choices and shuffle
            // we don't want any right answers to happen, after all
            $question->choices[] = $question->answer;
            shuffle($question->choices);

            $cleanedQuestions[] = [
                'question' => $question->question,
                'choices' => $question->choices,
            ];
        }

        return response()->json($cleanedQuestions);
    }
}
