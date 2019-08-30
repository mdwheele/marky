<?php

namespace Marky;

class Marky 
{
    const LOOKAHEAD = 4;

    /**
     * @var array
     */
    private $table = [];

    /**
     * @var string
     */
    private $text = '';

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
        if (empty($this->table)) {
            $this->buildMarkovTableFromText(static::LOOKAHEAD);
        }

        $output = '';

        // get first character
        $char = array_rand($this->table);
        $output .= $char;

        $iterations = ($length / static::LOOKAHEAD);
        for ($i = 0; $i < $iterations; $i++) {
            $newchar = $this->getWeightedCharacter($this->table[$char]);

            if (isset($newchar)) {
                $char = $newchar;
                $output .= $newchar;
            } else {
                $char = array_rand($this->table);
            }
        }

        return $output;
    }

    private function buildMarkovTableFromText($lookAhead)
    {
        $length = strlen($this->text);

        // now walk through the text and make the index table
        for ($i = 0; $i < $length; $i++) {
            $index = substr($this->text, $i, $lookAhead);
            if (!isset($this->table[$index])) {
                $this->table[$index] = [];
            }

            // count the numbers
            if ($i < ($length - $lookAhead)) {
                $count = substr($this->text, $i + $lookAhead, $lookAhead);

                if (isset($table[$index][$count])) {
                    $this->table[$index][$count]++;
                } else {
                    $this->table[$index][$count] = 1;
                }
            }
        }
    }

    private function getWeightedCharacter($array)
    {
        if (empty($array)) {
            return null;
        }
        $total = array_sum($array);
        $rand = mt_rand(1, $total);
        foreach ($array as $item => $weight) {
            if ($rand <= $weight) {
                return $item;
            }
            $rand -= $weight;
        }
        return null;
    }
}
