<?php

namespace Vargate\WechatSDK\OfficialAccount\Server;

class Reply implements \ArrayAccess
{
    /**
     * 消息内容
     *
     * @var array
     */
    protected $values = [];

    /**
     * __construct
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * 所有
     *
     * @return array
     */
    public function all()
    {
        return $this->values;
    }

    /**
     * 合并
     *
     * @param  array  $values
     * @return static
     */
    public function merge(array $values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }

    /**
     * 检查是否存在
     *
     * @param  mixed $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return array_key_exists($name, $this->values);
    }

    /**
     * 获取
     *
     * @param  mixed $name
     * @return mixed
     */
    public function offsetGet($name)
    {
        return $this->values[$name];
    }

    /**
     * 设置
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($name, $value)
    {
        if (null === $name) {
            $this->values[] = $value;
        } else {
            $this->values[$name] = $value;
        }
    }

    /**
     * 删除
     *
     * @param  mixed $name
     * @return void
     */
    public function offsetUnset($name)
    {
        unset($this->values[$name]);
    }

    /**
     * __set
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->offsetExists($name)
                ? $this->offsetGet($name)
                : null;
    }
}
