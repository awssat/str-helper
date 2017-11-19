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

            $result = call_user_func_array('Illuminate\Support\Str::'.$methodName, $arguments);
            if (gettype($result) !== 'string') {
                return $result;
            }
            $this->currentString = $result;

            return $this;
        }

        public function get()
        {
            return $this->currentString;
        }

        public function __toString()
        {
            return $this->currentString;
        }
    };
}
