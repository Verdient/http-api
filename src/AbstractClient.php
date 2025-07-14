<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use ReflectionClass;
use RuntimeException;

/**
 * 抽象客户端基类，用于构造请求基础信息和生成请求实例。
 *
 * @template TConfigure of Configure
 * @author Verdient。
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * @var TConfigure 配置对象
     *
     * @author Verdient。
     */
    public readonly ?Configure $configure;

    /**
     * 基础 URI
     *
     *
     * @author Verdient。
     */
    protected ?string $baseUri = null;

    /**
     * 命名空间
     *
     * @author Verdient。
     */
    protected string|null|false $namespace = null;

    /**
     * 构造函数，初始化基本参数
     *
     * @param ?TConfigure $configure 配置对象
     * @author Verdient。
     */
    public function __construct(?Configure $configure = null)
    {
        $this->configure = $configure ?: $this->newDefaultConfigure();
    }

    /**
     * 创建实例
     *
     * @param ?TConfigure $configure 配置对象
     * @author Verdient。
     */
    public static function create(?Configure $configure = null): static
    {
        return new static($configure);
    }

    /**
     * 获取命名空间
     *
     * @author Verdient。
     */
    protected function getNamespace(): string|false
    {
        if ($this->namespace === null) {
            $reflectionClass = new ReflectionClass($this);

            if ($reflectionClass->inNamespace()) {
                $this->namespace = $reflectionClass->getNamespaceName();
            } else {
                $this->namespace = false;
            }
        }

        return $this->namespace;
    }

    /**
     * 创建新的默认配置
     *
     * @return TConfigure
     * @author Verdient。
     */
    protected function newDefaultConfigure(): Configure
    {
        if (!$namespace = $this->getNamespace()) {
            throw new RuntimeException(sprintf(
                'Client class "%s" is not in a namespace, cannot resolve Configure class.',
                get_class($this)
            ));
        }

        $configureClass = $namespace . '\\Configure';

        if (!class_exists($configureClass)) {
            throw new RuntimeException(sprintf(
                'Request class "%s" does not exist.',
                $configureClass
            ));
        }

        if (!is_subclass_of($configureClass, Configure::class)) {
            throw new RuntimeException(sprintf(
                'Request class "%s" must implement %s.',
                $configureClass,
                Configure::class
            ));
        }

        return new $configureClass();
    }

    /**
     * 构造并返回完整请求 URI
     *
     * @param string|null $path 请求路径，相对于路由前缀
     * @author Verdient。
     */
    public function resolveUri(?string $path = null): string
    {
        $configure = $this->configure;

        if ($this->baseUri === null) {
            $port = $configure->getPort();

            if (
                ($configure->getProtocol() === 'http' && $configure->getPort() === 80)
                || ($configure->getProtocol() === 'https' && $configure->getPort() === 443)
            ) {
                $port = null;
            }

            $this->baseUri = $configure->getProtocol() . '://' . $configure->getHost()
                . ($port !== null ? ':' . $port : '')
                . ($configure->getRoutePrefix() ? '/' . trim($configure->getRoutePrefix(), '/') : '');
        }

        if ($path === null || $path === '') {
            return $this->baseUri;
        }

        return rtrim($this->baseUri, '/') . '/' . ltrim($path, '/');
    }

    /**
     * 创建新的 Request 实例
     *
     * @throws RuntimeException 无法找到合适的请求类时抛出异常
     * @author Verdient。
     */
    public function newRequest(): RequestInterface
    {
        if (!$namespace = $this->getNamespace()) {
            throw new RuntimeException(sprintf(
                'Client class "%s" is not in a namespace, cannot resolve Request class.',
                get_class($this)
            ));
        }

        $requestClass = $namespace . '\\Request';

        if (class_exists($requestClass)) {
            if (!is_subclass_of($requestClass, RequestInterface::class)) {
                throw new RuntimeException(sprintf(
                    'Request class "%s" must implement %s.',
                    $requestClass,
                    RequestInterface::class
                ));
            }
        } else {
            $requestClass = Request::class;
        }

        return new $requestClass($this->configure);
    }

    /**
     * 创建并返回一个已设置好完整 URL 的请求实例
     *
     * @param string|null $path 请求相对路径
     * @author Verdient。
     */
    public function request(?string $path = null): RequestInterface
    {
        $request = $this->newRequest();
        $request->setUrl($this->resolveUri($path));
        return $request;
    }
}
