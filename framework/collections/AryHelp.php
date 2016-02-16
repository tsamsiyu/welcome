<?php namespace welcome\collections;

class AryHelp
{
    public static function raze(array &$data, $splitter = '.')
    {

    }

    public static function getBySegment(array $data, $segment, $splitter = '.', $failValue = null)
    {
        if (!is_array($segment)) {
            $segment = explode($splitter, $segment);
        }

        if (count($segment)) {
            foreach ($segment as $item) {
                if (isset($data[$item])) {
                    $data = &$data[$item];
                } else {
                    return $failValue;
                }
            }

            return $data;
        }

        return $failValue;
    }

}