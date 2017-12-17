<?php

namespace Awssat\StrHelper;

use Countable;

class StrHelper implements Countable
{
    protected $currentString = '';
    protected $conditionDepth = 0;
    protected $falseIfTriggered = [];
    protected $falseElseTriggered = [];
    protected $isIf = [];
    protected $isElse = [];
    protected $insideIfCondition = false;

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
        if ($this->skipIfTriggered() && ! $this->insideIfCondition) {
            return $this;
        }


        $snake_method_name = preg_replace('/([a-z]{1})([A-Z]{1})/', '$1_$2', $methodName);

        if (
            class_exists('\\Illuminate\\Support\\Str') &&
            method_exists('Illuminate\Support\Str', $methodName)
            ) {
            // Str methods

            if (in_array($methodName, ['replaceLast', 'replaceFirst', 'replaceArray', 'is'])) {
                array_push($arguments, $this->currentString);
            } else {
                array_unshift($arguments, $this->currentString);
            }

            $result = call_user_func_array('Illuminate\Support\Str::'.$methodName, $arguments);
        } elseif (function_exists($snake_method_name)) {
            // Regular functions -> do(methodName, ...)
            return $this->do($snake_method_name, ...$arguments);
        } else {
            // Couldn't find either?
            throw new \BadMethodCallException('Method ('.$methodName.') is not a valid Illuminate\Support\Str method!');
        }

        //if not a string, return the result,  array is converted to collection
        if (
            gettype($result) !== 'string' && 
            ! (isset($this->isIf[$this->conditionDepth]) && $this->isIf[$this->conditionDepth]) &&
            ! (isset($this->isElse[$this->conditionDepth]) && $this->isElse[$this->conditionDepth])
        ) {

            if (is_array($result) && class_exists('\\Illuminate\\Support\\Collection')) {
                return new \Illuminate\Support\Collection($result);
            }

            return $result;
        }

        if($this->insideIfCondition){
            return $result;
        }

        $this->currentString = $result;

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
     * @return self|Illuminate\Support\Str
     */
    public function tap($callable)
    {
        $callable($this->currentString);

        return $this;
    }


    protected function skipIfTriggered($condition = null)
    {
        if($this->conditionDepth === 0){
            return false;
        }

        if($condition === null){
            $condition = $this->conditionDepth;
            if($condition > 1 && $this->skipIfTriggered($condition - 1)){
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
     * @return mixed|self|Illuminate\Support\Str
     */
    public function do($callable, ...$args)
    {
        if($this->skipIfTriggered() && ! $this->insideIfCondition){
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
                    if (in_array($arg->name, ['str', 'string', 'subject', 'haystack', 'body'])) {
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
            throw new \InvalidArgumentException('Method (do) can only receive anonymous functions or regular (built-in/global) functions!');
        }

        if (
            gettype($result) !== 'string' && 
            ! (isset($this->isIf[$this->conditionDepth]) && $this->isIf[$this->conditionDepth]) &&
            ! (isset($this->isElse[$this->conditionDepth]) && $this->isElse[$this->conditionDepth])
        ) {

            if (is_array($result) && class_exists('\\Illuminate\\Support\\Collection')) {
               return new \Illuminate\Support\Collection($result);
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

        if (! $this->falseIfTriggered[$this->conditionDepth]) {
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
        return $this->length();
    }
}
