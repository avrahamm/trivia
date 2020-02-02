<?php


namespace App\Helpers;

use App\Question;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionHelper
 * @package App\Helpers
 *
 * To perform question operations.
 * A question is created, stored in database but put to cache
 * to minimize DB calls for efficiency.
 */
class QuestionHelper
{
    //@link:https://stackoverflow.com/questions/28290332/best-practices-for-custom-helpers-in-laravel-5
    public static $illegalWords = ['',"for", "the", "a", "an", "and","or","nor","but","so","is","are","of"];
    public static $illegalSuffixes = ["es","s","ed","ing"];

    public static function generateNewValidQuestion()
    {
       $question = static::createNewQuestion();
       static::cacheValidQuestion($question);
       Question::where('id','<',$question->id)->delete();
       return $question;
    }

    public static function createNewQuestion()
    {
        $question = static::getRandomQuestionSentence();
        $answerCollection = static::getQuestionsAnswer($question);
        $answer = implode(" ", $answerCollection->toArray());
        return Question::create(compact('question','answer'));
    }

    public static function cacheValidQuestion(Question $question)
    {
        //@link:https://stackoverflow.com/questions/41165843/laravel-and-xampp-cache
        Cache::forever('question',$question);
    }

    public static function hasValidQuestion()
    {
        if (Cache::has('question')) {
            return true;
        }
        return false;
    }

    public static function getValidQuestion()
    {
        if( static::hasValidQuestion()) {
            return Cache::get('question');
        }

        // If there is no cached question.
        $question = Question::latest()->first();
        static::cacheValidQuestion($question);
        return $question;
    }

    public static function getValidQuestionId()
    {
        $validQuestion = static::getValidQuestion();
        return $validQuestion->id;
    }

    public static function isSubmittedQuestionValid(int $submittedQuestionId)
    {
        $validQuestionId = static::getValidQuestionId();
        return $submittedQuestionId === $validQuestionId;
    }

    public static function isAnswerCorrect(string $answer)
    {
        $answerCollection = static::getQuestionsAnswer($answer);
        $validAnswer = static::getValidQuestion()->answer;
        $validAnswerCollection = collect( explode(' ',$validAnswer));
        $diff = $validAnswerCollection->diff($answerCollection);
        return $diff->isEmpty();
    }

    public static function getRandomQuestionSentence()
    {
        $client = new Client(['base_uri' => 'http://jservice.io/api/random']);
        $response = $client->get('');
        $questionData = $response->getBody();
        $decodedQuestionData = json_decode($questionData);
        return $decodedQuestionData[0]->question;
    }

    /**
     * processes question string according to task definition steps.
     * @param string $question
     * @return \Illuminate\Support\Collection
     */
    public static function getQuestionsAnswer(string $question)
    {
        // collection from string
        $terms = collect(explode(" ",$question));

        // filter all non alphabetical symbols and convert to lower case.
        $lowAlphaTerms = $terms->map(function($term) {
            $lowTerm = strtolower(trim($term));
            $alphaTerm = preg_replace("/[^a-z]+/", "", $lowTerm);
            return $alphaTerm;
        });

        // filter illegal words
        $illegalWords = static::$illegalWords;
        $legalTerms = $lowAlphaTerms->filter(function($term) use($illegalWords) {
            return strlen($term)>0 && !in_array($term, $illegalWords);
        });

        // remove illegal suffixes
        $illegalSuffixes = static::$illegalSuffixes;
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

        return $legalSuffixesTerms;
    }

}
