<?php namespace welcome\collections;

use welcome\collections\enum\FilterEnum;

class AryFilter
{
    public static function pull(array &$data, $key, array $options = [])
    {
        $options = array_merge([
            'failValue' => null,
            'filter' => null
        ], $options);

        if (isset($data[$key])) {
            $v = $data[$key];

            if (!static::filter($data, $key, $options['filter'], true)) {
                return false;
            }

            unset($data[$key]);
            return $v;
        }

        return $options['failValue'];
    }

    public static function filter(array &$data, $key, $filter, $missingFilterVal = null)
    {
        $v = $data[$key];
        if (is_array($filter)) {
            $filterId = array_shift($filter);
            $filterParams = $filter;
            array_unshift($filterParams, $v);
        } elseif (is_string($filter)) {
            $filterId = $filter;
            $filterParams = [$v];
        } else {
            return $missingFilterVal;
        }

        if (FilterEnum::has($filterId)) {
            return FilterEnum::filter($filterParams, $filterId);
        } else {
            return $missingFilterVal;
        }
    }

    public static function rmEmpty(array &$data)
    {
        $removed = [];
        foreach ($data as $i => $v) {
            if (empty($v)) {
                unset($data[$i]);
                $removed[$i] = $v;
            }
        }
        return $removed;
    }

    public static function trim(array &$data, $charlist = " \t\n\r\0\x0B")
    {
        foreach ($data as $k => $v) {
            $data[$k] = trim($v, $charlist);
        }
        return $data;
    }

    public static function pullOrFail(array &$data, $key, array $options = [])
    {
        $options = array_merge([
            'filter' => null
        ], $options);

        $options['failValue'] = '!^*~###@-NULL-@###~*^!';

        $pulled = static::pull($data, $key, $options);
        if ($pulled === '!^*~###@-NULL-@###~*^!') {
            throw new \Exception("Key `$key` must be set or set correctly");
        }

        return $pulled;
    }

}