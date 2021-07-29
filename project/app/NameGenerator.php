<?php

declare(strict_types=1);

namespace App;

class NameGenerator
{
    private $adjectives = ["Small","Brave","Grumpy","Lazy","Silly","Honest","Lucky","Wise","Selfish","Serious","Massive","Clever"];
    private $nouns = ["Boy","Duck","Heart","Salmon","Fist","Eyes","Mammal","Bird","Elephant","Toad"];
    
    /*
     * Find middle name based on the number of characters in the user's first and last name
     * 
     * @param   String  $firstName  The first name
     * @param   String  $surname    The surname
     * 
     * @return  String  Generated middle name
     */
    public function generateMiddleName(string $firstName, string $surname) 
    {
        $adjectivePosition = (count($this->adjectives) >= strlen($firstName)) ? (strlen($firstName)-1) : (count($this->adjectives)-1);
        $nounPosition = (count($this->adjectives) >= strlen($surname)) ? (strlen($surname)-1) : (count($this->adjectives)-1);
                
        return $this->adjectives[$adjectivePosition] ." ". $this->nouns[$nounPosition];
    }
    
    /*
     * Randomly generate middle name
     *
     * @return  String  Generated middle name
     */
    public function generateMiddleNameRandom() 
    {
        return $this->adjectives[rand(0, (count($this->adjectives)-1))] ." ". $this->nouns[rand(0, (count($this->nouns)-1))];
    }
}
