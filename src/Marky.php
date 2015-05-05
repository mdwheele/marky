<?php

namespace Marky;

class Marky 
{
    const LOOKAHEAD = 4;

    /**
     * @var array
     */
    private $table = [];


    private function __construct($text)
    {
        $this->text = $text;
    }

    public static function fromFile($filename)
    {
        $contents = file_get_contents($filename);
        $contents = preg_replace('/\n/', '', $contents);

        return static::fromString($contents);
    }

    public static function fromString($text)
    {
        $instance = new static($text);

        return $instance;
    }

    public function generate($length)
    {
        $this->buildMarkovTableFromText(self::LOOKAHEAD);

        // get first character
        $char = array_rand($this->table);
        $o = $char;

        for ($i = 0; $i < ($length / self::LOOKAHEAD); $i++) {
            $newchar = $this->getWeightedCharacter($this->table[$char]);

            if ($newchar) {
                $char = $newchar;
                $o .= $newchar;
            } else {
                $char = array_rand($this->table);
            }
        }

        return $o;
    }

    private function buildMarkovTableFromText($lookAhead)
    {
        // now walk through the text and make the index table
        for ($i = 0; $i < strlen($this->text); $i++) {
            $char = substr($this->text, $i, $lookAhead);
            if (!isset($this->table[$char])) $this->table[$char] = [];
        }

        // walk the array again and count the numbers
        for ($i = 0; $i < (strlen($this->text) - $lookAhead); $i++) {
            $index = substr($this->text, $i, $lookAhead);
            $count = substr($this->text, $i + $lookAhead, $lookAhead);

            if (isset($table[$index][$count])) {
                $this->table[$index][$count]++;
            } else {
                $this->table[$index][$count] = 1;
            }
        }
    }

    private function getWeightedCharacter($array)
    {
        if (!$array) return false;
        $total = array_sum($array);
        $rand = mt_rand(1, $total);
        foreach ($array as $item => $weight) {
            if ($rand <= $weight) return $item;
            $rand -= $weight;
        }
    }

}
