<?php
namespace common\component;

use Exception;
use Redis;
use common\utils\Utils;

class RedisComponent
{
    private $host;
    private $port;
    private $password;
    protected $redis = null;


    public function __construct($host = null, $port = 6379, $password = "")
    {
        Utils::checkNotEmptyStr($host, "host");
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->getRedis();
    }

    protected function getRedis()
    {
        if (!Utils::notEmptyStr($this->redis)) {
            $this->setRedis();
        }
        return $this->redis;
    }

    protected function setRedis()
    {
        if (!Utils::notEmptyStr($this->host) || !Utils::notEmptyStr($this->port) || !Utils::notEmptyStr($this->password)) {
            throw new Exception("invalid host or port or password or db");
        }
        $redis = new Redis();
        $redis->connect($this->host, $this->port);
        $redis->auth($this->password);
        $this->redis = $redis;
    }

    public function get($key)
    {
        $value = $this->redis->get($key);
        return is_null(json_decode($value)) ? $value : json_decode($value, true);
    }

    public function set($key, $value, $expire = 0)
    {
        $value = is_array($value) ? json_encode($value) : $value;
        return $expire > 0 ? $this->redis->setex($key, $expire, $value) : $this->redis->set($key, $value);
    }

    public function del($key) {
        return $this->redis->del($key);
    }

    public function delKeys($patten)
    {
        $keys = $this->redis->keys($patten);
        return $this->redis->del($keys);
    }
}
