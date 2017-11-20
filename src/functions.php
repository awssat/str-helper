<?php

/**
 * A flexiable alias for Str class.
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

        public function __construct($value = '')
        {
            $this->currentString = $value;
        }

        public function __call($methodName, $arguments)
        {
            if (in_array($methodName, ['replaceLast', 'replaceFirst', 'replaceArray', 'is'])) {
                array_push($arguments, $this->currentString);
            } else {
                array_unshift($arguments, $this->currentString);
            }

            if (method_exists('Illuminate\Support\Str', $methodName)) {
                $result = call_user_func_array('Illuminate\Support\Str::'.$methodName, $arguments);
            } else {
                throw new \Exception('Method ('.$methodName.') is not a valid Illuminate\Support\Str method!');
            }

            if (gettype($result) !== 'string') {
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
        public function do($callable)
        {
            $result = $callable instanceof Closure || function_exists($callable)
                        ? $callable($this->currentString)
                        : $callable;

            if (gettype($result) !== 'string') {
                return $result;
            }

            $this->currentString = $result;

            return $this;
        }

        public function __toString()
        {
            return $this->currentString;
        }
    };
}
