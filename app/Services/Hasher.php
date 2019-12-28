<?php


namespace App\Services;



use Hashids\Hashids;

class Hasher
{

    public static function encode($data)
    {
        $hash = new Hashids(env('APP_KEY'), 10);
        return $hash->encode($data);
    }

    public static function decode($data)
    {

        $hash = new Hashids(env('APP_KEY'), 10);
        return $hash->decode($data)[0];
    }

    public static function decodeIDs($data = [])
    {
        $ids = collect();
        foreach ($data as $item)
        {
            $ids->push(self::decode($item));
        }
        return $ids;
    }
}
