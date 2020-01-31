<?php


namespace App\Helpers;


use App\Question;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class QuestionHelper
{

    public const VALID_QUESTION = true;
    public const NOT_VALID_QUESTION = false;

    public static function getQuestionsAnswer(string $question)
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

    //TODO! move Question functionality to QuestionHelper
    public static function isSubmittedQuestionValid(Request $request, Question $curQuestion)
    {
        return static::VALID_QUESTION;
//        $curQuestionId = $curQuestion->id;
//        $questionId = (int)$request->input('questionId');
//        return ($curQuestionId !== $questionId) : static::OUTDATED_QUESTION ? static::VALID_QUESTION;
    }

    public static function isAnswerCorrect(Request $request,Question $curQuestion)
    {
//        return true; // TEMP
        return false; // TEMP
        /**
        $submittedAnswer = $request->input('answer');
        //TODO! simple validations via QuestionHelper
        $correctAnswer = $curQuestion->answer;

        $submittedAnswerArray = array_filter( explode(" ",$submittedAnswer));
        $correctAnswerArray = explode(" ",$correctAnswer);

        if( sizeof($submittedAnswerArray) !== sizeof($correctAnswerArray)) {
        return false;
        }


        $submittedAnswerCollection = collect($submittedAnswerArray);
        $correctAnswerCollection = collect($correctAnswerArray);
         */
    }

    public static function getRandomQuestionSentence()
    {
        $client = new Client(['base_uri' => 'http://jservice.io/api/random']);
        $response = $client->get('');
        $questionData = $response->getBody();
        $decodedQuestionData = json_decode($questionData);
        $question = $decodedQuestionData[0]->question;
        return $question;
    }

    public static function getValidQuestion()
    {

    }

}
