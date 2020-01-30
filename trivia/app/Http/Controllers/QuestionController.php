<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client(['base_uri' => 'http://jservice.io/api/random']);
        $response = $client->get('');
        $questionData = $response->getBody();
        $decodedQuestionData = json_decode($questionData);
        $question = $decodedQuestionData[0]->question;
        $answer = $this->getQuestionsAnswer($question);
        $questionModel = Question::create(compact('question','answer'));
        return $questionModel;
    }

    public function getQuestionsAnswer(string $question)
    {
//        $question = "II   faked shots smoking 45r& for an apples or nor but so";
        $terms = collect(explode(" ",$question));
        $lowAlphaTerms = $terms->map(function($term) {
            $lowTerm = strtolower(trim($term));
            $alphaTerm = preg_replace("/[^a-z]+/", "", $lowTerm);
            return $alphaTerm;
        });

        $illegalWords = ['',"for", "the", "a", "an", "and","or","nor","but","so","is","are","of"];
        $legalTerms = $lowAlphaTerms->filter(function($term) use($illegalWords) {
            return strlen($term)>0 && !in_array($term, $illegalWords);
        });

        $illegalSuffixes = ["es","s","ed","ing"];
        $legalSuffixesTerms = $legalTerms->map(function($term) use($illegalSuffixes) {
            $originalLength = strlen($term);
            foreach ($illegalSuffixes as $suffix) {
                $result = preg_replace( "/$suffix$/", '', $term);
                if (strlen($result) < $originalLength ) {
                    return $result;
                }
            }
            // nothing replaced
            return $term;
        });

        $resultTerms = implode(" ", $legalSuffixesTerms->toArray());
        return $resultTerms;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
