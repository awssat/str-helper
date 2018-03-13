<?php

namespace Awssat\StrHelper;

use Countable;

/**
 * @method \Awssat\StrHelper\StrHelper capitalize()
 * @method \Awssat\StrHelper\StrHelper ucwords([string $delimiters ])
 * @method \Awssat\StrHelper\StrHelper chop()
 * @method \Awssat\StrHelper\StrHelper trim([string $character_mask])
 * @method \Awssat\StrHelper\StrHelper ltrim([string $character_mask])
 * @method \Awssat\StrHelper\StrHelper rtrim([string $character_mask])
 * @method \Awssat\StrHelper\StrHelper lcfirst()
 * @method \Awssat\StrHelper\StrHelper lower()
 * @method \Awssat\StrHelper\StrHelper upper()
 * @method bool equal(string $str2)
 * @method bool contains(string $string)
 * @method \Awssat\StrHelper\StrHelper append(string $string)
 * @method \Awssat\StrHelper\StrHelper prepend(string $string)
 * @method array explode(string $delimiter)
 * @method \Awssat\StrHelper\StrHelper slice(int $start [,int $length])
 * @method \Awssat\StrHelper\StrHelper addcslashes(string $charlist)
 * @method \Awssat\StrHelper\StrHelper addslashes()
 * @method \Awssat\StrHelper\StrHelper nl2br([bool $is_xhtml])
 * @method \Awssat\StrHelper\StrHelper strip_tags([string $allowable_tags])
 * @method int index(string $needle [,int $offset])
 * @method \Awssat\StrHelper\StrHelper shuffle()
 * @method int length()
 * @method \Awssat\StrHelper\StrHelper chunk_split([int $chunklen [,string $end]])
 * @method \Awssat\StrHelper\StrHelper convert_uudecode()
 * @method \Awssat\StrHelper\StrHelper convert_uuencode()
 * @method \Awssat\StrHelper\StrHelper soundex()
 * @method int crc32()
 * @method int ord()
 * @method \Awssat\StrHelper\StrHelper bin2hex()
 * @method \Awssat\StrHelper\StrHelper hex2bin()
 * @method \Awssat\StrHelper\StrHelper crypt([string $salt])
 * @method \Awssat\StrHelper\StrHelper html_entity_decode([ int $flags [,string $encoding]])
 * @method \Awssat\StrHelper\StrHelper htmlentities([,int $flags [,string $encoding [,bool $double_encode]]])
 * @method \Awssat\StrHelper\StrHelper htmlspecialchars_decode([int $flags])
 * @method \Awssat\StrHelper\StrHelper htmlspecialchars([int $flags [,string $encoding [,bool $double_encode]]])
 * @method int levenshtein([string $str2 [,int $cost_ins [,int $cost_rep [,int $cost_del]]]])
 * @method \Awssat\StrHelper\StrHelper md5([bool $raw_output])
 * @method \Awssat\StrHelper\StrHelper sha1([bool $raw_output])
 * @method \Awssat\StrHelper\StrHelper metaphone([int $phonemes])
 * @method array parse()
 * @method \Awssat\StrHelper\StrHelper quoted_printable_decode()
 * @method \Awssat\StrHelper\StrHelper quoted_printable_encode()
 * @method int similar_text (string $second [,float &$percent ])
 * @method mixed|\Awssat\StrHelper\StrHelper sscanf(string $format [,mixed &$... ])
 * @method array getcsv([string $delimiter [,string $enclosure [,string $escape]]])
 * @method mixed|\Awssat\StrHelper\StrHelper ireplace(mixed $search , mixed $replace , [,int &$count ])
 * @method \Awssat\StrHelper\StrHelper pad(int $pad_length [,string $pad_string [,int $pad_type]])
 * @method \Awssat\StrHelper\StrHelper repeat(int $multiplier)
 * @method mixed|\Awssat\StrHelper\StrHelper replace(mixed $search, mixed $replace , [,int &$count])
 * @method \Awssat\StrHelper\StrHelper rot13()
 * @method array split([int $split_length])
 * @method mixed word_count([ int $format [,string $charlist]])
 * @method int strcasecmp(string $str2)
 * @method int strnatcasecmp(string $str2)
 * @method int strnatcmp(string $str2)
 * @method int strcmp(string $str2)
 * @method int strncmp(string $str2, int $len)
 * @method int strcoll(string $str2)
 * @method \Awssat\StrHelper\StrHelper strstr(mixed $needle [,bool $before_needle])
 * @method \Awssat\StrHelper\StrHelper stristr(mixed $needle [,bool $before_needle])
 * @method int strcspn(string $mask [,int $start [,int $length]])
 * @method \Awssat\StrHelper\StrHelper stripcslashes()
 * @method \Awssat\StrHelper\StrHelper stripslashes()
 * @method int stripos(string $needle [,int $offset])
 * @method int strpos(string $needle [,int $offset])
 * @method int strripos(string $needle [,int $offset])
 * @method int strrpos(string $needle [,int $offset])
 * @method int strlen()
 * @method \Awssat\StrHelper\StrHelper strpbrk(string $char_list)
 * @method \Awssat\StrHelper\StrHelper strrchr(mixed $needle)
 * @method \Awssat\StrHelper\StrHelper strrev()
 * @method int strspn(string $mask [,int $start [,int $length]])
 * @method \Awssat\StrHelper\StrHelper strtok(string $token)
 * @method \Awssat\StrHelper\StrHelper strtr(string $from , string $to)
 * @method \Awssat\StrHelper\StrHelper strtr(array $replace_pairs)
 * @method int substr_compare(string $str , int $offset [,int $length [,bool $case_insensitivity]])
 * @method int substr_count(string $needle [,int $offset [,int $length]])
 * @method mixed substr_replace(mixed $replacement , mixed $start [,mixed $length])
 * @method mixed|\Awssat\StrHelper\StrHelper substr_replace(mixed $replacement, mixed $start [,mixed $length])
 * @method \Awssat\StrHelper\StrHelper substr(int $start [,int $length])
 * @method \Awssat\StrHelper\StrHelper ucfirst()
 * @method \Awssat\StrHelper\StrHelper wordwrap([int $width [,string $break [,bool $cut]]])
 */
class StrHelper implements Countable
{
    protected $currentString = '';
    protected $conditionDepth = 0;
    protected $falseIfTriggered = [];
    protected $falseElseTriggered = [];
    protected $isIf = [];
    protected $isElse = [];
    protected $insideIfCondition = false;

    protected $aliasMethods = [
        'lower'      => 'strtolower',
        'upper'      => 'strtoupper',
        'parse'      => 'parse_str',
        'length'     => 'strlen',
        'capitalize' => 'ucfirst',
        'slice'      => 'substr',
        'index'      => 'strpos',
    ];

    /**
     * Initiate the class.
     *
     * @param string $value given string
     */
    public function __construct($value = '')
    {
        $this->currentString = (string) $value;
    }

    /**
     * The door to the magic.
     *
     * @param string $methodName name of called method
     * @param array  $arguments  arguments of called method
     *
     * @return void
     */
    public function __call($methodName, $arguments)
    {
        if (array_key_exists($methodName, $this->aliasMethods)) {
            $methodName = $this->aliasMethods[$methodName];
        }

        // in case of if{method}()
        if (substr($methodName, 0, 2) === 'if') {
            $methodName = ltrim(substr($methodName, 2), '_');

            return $this->if(
                function () use ($methodName, $arguments) {
                    return $this->$methodName(...$arguments);
                }
            );
        }

        //nothing to do, false condition was triggered
        if ($this->skipIfTriggered() && !$this->insideIfCondition) {
            return $this;
        }

        $snake_method_name = strtolower(preg_replace('/([a-z]{1})([A-Z]{1})/', '$1_$2', $methodName));

        if (in_array($snake_method_name, ['parse_str', 'strlen', 'equal', 'contains', 'append', 'prepend'])) {
            return $this->do(function () use ($snake_method_name, $arguments) {
                if ($snake_method_name === 'parse_str') {
                    $mb_parse_str = function_exists('mb_parse_str') ? 'mb_parse_str' : 'parse_str';

                    $mb_parse_str($this->currentString, $result);
                    return $result;
                } elseif ($snake_method_name === 'strlen') {
                    return $this->count();
                } elseif ($snake_method_name === 'equal' && sizeof($arguments)) {
                    foreach($arguments as $arg) {
                        if($this->currentString !== $arg) {
                            return false;
                        }
                    }

                    return true;
                } elseif ($snake_method_name === 'contains' && sizeof($arguments)) {
                    foreach ($arguments as $arg) {
                        $mb_strpos = function_exists('mb_strpos') ? 'mb_strpos' : 'strpos';

                        if ($mb_strpos($this->currentString, $arg) === false) {
                            return false;
                        }
                    }

                    return true;
                } elseif ($snake_method_name === 'append') {
                    return $this->currentString.implode('', $arguments);
                } elseif ($snake_method_name === 'prepend') {
                    return  implode('', $arguments).$this->currentString;
                }
            });
        } elseif (function_exists($snake_method_name)) {
            if(function_exists('mb_chr') && function_exists('mb_'.$snake_method_name)) {
                $snake_method_name = 'mb_'.$snake_method_name;
            }
            // Regular functions -> do(methodName, ...)
            return $this->do($snake_method_name, ...$arguments);
        } else {
            // Couldn't find either?
            throw new \BadMethodCallException('Method ('.$methodName.') does not exist!');
        }

        return $this;
    }

    /**
     * Get the processed string.
     *
     * @return string
     */
    public function get()
    {
        if ($this->skipIfTriggered()) {
            return $this;
        }

        return $this->currentString;
    }

    /**
     * set current string.
     *
     * @return string
     */
    public function set($value)
    {
        if ($this->skipIfTriggered()) {
            return $this;
        }

        $this->currentString = (string) $value;

        return $this;
    }

    /**
     * Tap! Tap!
     *
     * @param callable $callable Anonymous function
     *
     * @return self
     */
    public function tap($callable)
    {
        $callable($this->currentString);

        return $this;
    }

    protected function skipIfTriggered($condition = null)
    {
        if ($this->conditionDepth === 0) {
            return false;
        }

        if ($condition === null) {
            $condition = $this->conditionDepth;
            if ($condition > 1 && $this->skipIfTriggered($condition - 1)) {
                return true;
            }
        }

        $isIf = $this->isIf[$condition] && $this->falseIfTriggered[$condition];
        $isElse = $this->isElse[$condition] && $this->falseElseTriggered[$condition];

        return $isIf || $isElse;
    }

    /**
     * Execute a callable on the string.
     *
     * @param callable $callable
     * @param mixed    ...$args
     *
     * @return mixed
     */
    public function do($callable, ...$args)
    {
        if ($this->skipIfTriggered() && !$this->insideIfCondition) {
            return $this;
        }

        if ($callable instanceof \Closure) {

            //anonymous
            $callable = $callable->bindTo($this);
            $result = ($callable->bindTo($this))($this->currentString);

            if (\is_object($result) && is_a($result, __CLASS__)) {
                $result = $result->get();
            } elseif ($result === null) {
                return $this;
            }
        } elseif (function_exists($callable)) {
            //regular functions

            //If a regular function is called, then we get its information
            //and where is the position of the string value among the params
            $functionInfo = new \ReflectionFunction($callable);

            if ($functionInfo->getNumberOfParameters() > 1) {
                $stringIndex = 0;

                foreach ($functionInfo->getParameters() as $order => $arg) {
                    if (in_array($arg->name, ['main_str', 'str1', 'str', 'string', 'subject', 'haystack', 'body', 'first'])) {
                        $stringIndex = $order;
                        break;
                    }
                }

                //add the string param in the right order
                array_splice($args, $stringIndex, 0, [$this->currentString]);

                $result = $callable(...$args);
            } elseif ($functionInfo->getNumberOfParameters() == 1) {
                $result = $callable($this->currentString);
            } else {
                $result = $callable();
            }
        } else {
            if (function_exists('str_'.$callable)) {
                return $this->do($callable, ...$args);
            }

            throw new \InvalidArgumentException('Method (do) can only receive anonymous functions or regular (built-in/global) functions!');
        }

        if (
            gettype($result) !== 'string' &&
            !(isset($this->isIf[$this->conditionDepth]) && $this->isIf[$this->conditionDepth]) &&
            !(isset($this->isElse[$this->conditionDepth]) && $this->isElse[$this->conditionDepth])
        ) {
            if (is_array($result) && class_exists('\\Awssat\\ArrayHelper\\ArrayHelper')) {
                return new \Awssat\ArrayHelper\ArrayHelper($result);
            }

            return $result;
        }

        if ($this->insideIfCondition) {
            return $result;
        }

        $this->currentString = $result;

        return $this;
    }

    /**
     * If condition, to end the condition use endif().
     *
     * @param callable $callable
     * @param mixed    ...$args
     *
     * @return self
     */
    public function if($callable, ...$args)
    {
        $this->conditionDepth++;

        $this->falseIfTriggered[$this->conditionDepth] = false;
        $this->falseElseTriggered[$this->conditionDepth] = false;
        $this->isIf[$this->conditionDepth] = true;
        $this->isElse[$this->conditionDepth] = false;

        $lastString = $this->currentString;

        $this->insideIfCondition = true;

        $result = $this->do($callable, ...$args);

        if ($result instanceof self && strcmp($lastString, $this->currentString) === 0) {
            $this->falseIfTriggered[$this->conditionDepth] = true;
        } elseif (gettype($result) && strcmp($lastString, $result) === 0) {
            $this->falseIfTriggered[$this->conditionDepth] = true;
        } elseif ($result instanceof \Traversable && count($result) == 0) {
            $this->falseIfTriggered[$this->conditionDepth] = true;
        } elseif ($result === false) {
            $this->falseIfTriggered[$this->conditionDepth] = true;
        }

        $this->insideIfCondition = false;

        return $this;
    }

    /**
     * End the If condition.
     *
     * @return self
     */
    public function endif()
    {
        unset(
            $this->falseIfTriggered[$this->conditionDepth],
            $this->falseElseTriggered[$this->conditionDepth],
            $this->isIf[$this->conditionDepth],
            $this->isElse[$this->conditionDepth]
        );

        $this->conditionDepth--;

        return $this;
    }

    /**
     * Else case of an initiated condition.
     *
     * @return self
     */
    public function else()
    {
        $this->isIf[$this->conditionDepth] = false;
        $this->isElse[$this->conditionDepth] = true;

        if (!$this->falseIfTriggered[$this->conditionDepth]) {
            $this->falseElseTriggered[$this->conditionDepth] = true;
        }

        $this->falseIfTriggered[$this->conditionDepth] = false;

        return $this;
    }

    /**
     * Get the current string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->currentString;
    }

    /**
     * Return the length of the processed string.
     *
     * @return int
     */
    public function count()
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($this->currentString);
        }

        return strlen($this->currentString);
    }
}
