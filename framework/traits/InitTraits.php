<?php namespace welcome\traits;

trait InitTraits
{
    use ReflectionTrait;

    public function initTraits()
    {
        $obj = $this->getReflectionClass();
        do {
            $traitNames = $obj->getTraitNames();
            foreach ($traitNames as $namespace) {
                $name = substr($namespace, strrpos($namespace, '\\') + 1);
                if (method_exists($this, 'init' . $name)) {
                    call_user_func_array([$this, 'init' . $name], func_get_args());
                }
            }
        } while ($obj = $obj->getParentClass());
    }
}