<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

/**
 * 配置类，用于存储 HTTP API 客户端相关配置。
 *
 * @author Verdient。
 */
class Configure
{
    /**
     * 主机名或 IP 地址
     *
     * @author Verdient。
     */
    protected string $host = '127.0.0.1';

    /**
     * 端口号，可选，默认为 null 表示使用默认端口
     *
     * @var int|null
     */
    protected ?int $port = null;

    /**
     * 协议，默认 https
     *
     * @author Verdient。
     */
    protected string $protocol = 'https';

    /**
     * 路由前缀，可选，用于接口前缀路径
     *
     * @author Verdient。
     */
    protected ?string $routePrefix = null;

    /**
     * @param array $options 配置选项
     * @author Verdient。
     */
    public function __construct(array $options = [])
    {
        $options = array_merge($this->configure(), $options);

        foreach ($options as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
    }

    /**
     * 配置
     *
     * @author Verdient。
     */
    protected function configure(): array
    {
        return [];
    }

    /**
     * 创建配置实例
     *
     * @param array $options 配置选项
     * @author Verdient。
     */
    public static function create(array $options = []): static
    {
        return new static($options);
    }

    /**
     * 获取主机名或 IP
     *
     * @author Verdient。
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * 获取端口号
     *
     * @author Verdient。
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * 获取协议
     *
     * @author Verdient。
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * 获取路由前缀
     *
     * @author Verdient。
     */
    public function getRoutePrefix(): ?string
    {
        return $this->routePrefix;
    }
}
