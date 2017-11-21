<?php

/**
 * A flexible & powerful string manipulation helper for Laravel.
 *
 *  @author abdumu <hi@abdumu.com>
 *
 * @param string $value
 *
 * @return mixed|Illuminate\Support\Str
 */
function str($value = null)
{
    if ($value === null) {
        return function_exists('app')
                    ? app('Illuminate\Support\Str')
                    : new Illuminate\Support\Str();
    }

    return new class($value) {
        protected $currentString = '';
        protected $falseIfTriggered = false;
        protected $falseElseTriggered = false;

        public function __construct($value = '')
        {
            $this->currentString = $value;
        }

        public function __call($methodName, $arguments)
        {
            //nothing to do, false ondition was triggered
            if ($this->falseIfTriggered || $this->falseElseTriggered) {
                return $this;
            }

            // in case of if{method}()
            if (substr($methodName, 0, 2) === 'if') {
                $methodName = ltrim(substr($methodName, 2), '_');

                return $this->if(function ($v) use ($methodName, $arguments) {
                    return $this->$methodName(...$arguments);
                });
            }

            // Str methods
            if (method_exists('Illuminate\Support\Str', $methodName)) {
                if (in_array($methodName, ['replaceLast', 'replaceFirst', 'replaceArray', 'is'])) {
                    array_push($arguments, $this->currentString);
                } else {
                    array_unshift($arguments, $this->currentString);
                }

                $result = call_user_func_array('Illuminate\Support\Str::'.$methodName, $arguments);
            }

            // Regualr functions -> do(methodName, ...)
            elseif (function_exists(str($methodName)->snake()->get())) {
                return $this->do(str($methodName)->snake()->get(), ...$arguments);
            }

            // Couldn't find either?
            else {
                throw new \Exception('Method ('.$methodName.') is not a valid Illuminate\Support\Str method!');
            }

            //if not a string, return the result,  array is converted to collection
            if (gettype($result) !== 'string') {
                return is_array($result) ? collect($result) : $result;
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
            return $this->currentString;
        }

        /**
         * Tap! Tap!
         *
         * @param callable $callable
         *
         * @return self|Illuminate\Support\Str
         */
        public function tap($callback)
        {
            $callback($this->currentString);

            return $this;
        }

        /**
         * Execute a callback on the string.
         *
         * @param callable $callable anonymous function, or name of a function
         *
         * @return mixed|self|Illuminate\Support\Str
         */
        public function do($callable, ...$args)
        {
            //nothing to do, false ondition was triggered
            if ($this->falseIfTriggered || $this->falseElseTriggered) {
                return $this;
            }

            //anonymose
            if ($callable instanceof Closure) {
                $result = $callable($this->currentString);
            }
            //regular functions
            elseif (function_exists($callable)) {

                //If a regular function is called, then we get its information
                //and where is the position of the string value among the params
                $functionInfo = new ReflectionFunction($callable);

                if ($functionInfo->isDeprecated() || $functionInfo->isDisabled()) {
                    throw new \Exception('Method ('.$callable.') is disabled or deprecated!');
                }

                if ($functionInfo->getNumberOfParameters() > 1) {
                    $stringIndex = 0;

                    foreach ($functionInfo->getParameters() as $order=>$arg) {
                        if (in_array($arg->name, ['str', 'string', 'subject', 'haystack'])) {
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
                throw new \Exception('Method (do) can only receive anonymous functions/functions!');
            }

            if (gettype($result) !== 'string') {
                return is_array($result) ? collect($result) : $result;
            }

            $this->currentString = $result;

            return $this;
        }

        /**
         * If condition, to end the condition use endif().
         *
         * @param callable $callable anonymous function, or name of a function
         * @param mixed    $args
         *
         * @return self
         */
        public function if($callable, ...$args)
        {
            $lastString = $this->currentString;

            $result = $this->do($callable, ...$args);

            if ($result instanceof self && strcmp($lastString, $this->currentString) === 0) {
                $this->falseIfTriggered = true;
            } elseif ($result instanceof Traversable && count($result) == 0) {
                $this->falseIfTriggered = true;
            } elseif ($result === false) {
                $this->falseIfTriggered = true;
            }

            return $this;
        }

        /**
         * End the If condition.
         *
         * @return self
         */
        public function endif()
        {
            $this->falseIfTriggered = false;
            $this->falseElseTriggered = false;

            return $this;
        }

        /**
         * else case of an initiated condition.
         *
         * @return self
         */
        public function else()
        {
            if (!$this->falseIfTriggered) {
                $this->falseElseTriggered = true;
            }

            $this->falseIfTriggered = false;

            return $this;
        }

        /**
         * get the current string.
         *
         * @return string
         */
        public function __toString()
        {
            return $this->currentString;
        }
    };
}
