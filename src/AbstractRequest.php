<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Override;
use Verdient\Http\Builder\BuilderInterface;
use Verdient\Http\Request;
use Verdient\Http\Serializer\Body\BodySerializerInterface;

/**
 * 抽象请求基类，实现 RequestInterface，封装底层 Request。
 *
 * 主要负责设置请求 URL、查询参数、请求体等内容，支持链式调用。
 *
 * @template TConfigure
 *
 * @author Verdient。
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * 底层请求对象
     *
     * @author Verdient。
     */
    protected Request $request;

    /**
     * 构造函数，初始化底层 Request 实例
     *
     * @param TConfigure $configure 配置对象
     *
     * @author Verdient。
     */
    public function __construct(protected Configure $configure)
    {
        $this->request = new Request();
    }

    /**
     * @return TConfigure
     * @author Verdient。
     */
    #[Override]
    public function getConfigure(): Configure
    {
        return $this->configure;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setUrl(string $url): static
    {
        $this->request->setUrl($url);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setMethod(string $method): static
    {
        $this->request->setMethod($method);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setQueries(array $queries): static
    {
        $this->request->setQueries($queries);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setBodies(array|BuilderInterface $bodies): static
    {
        $this->request->setBodies($bodies);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setContent(string $content): static
    {
        $this->request->setContent($content);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setBodySerializer(BodySerializerInterface $serializer): static
    {
        $this->request->setBodySerializer($serializer);
        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setHeaders(array $headers): static
    {
        $this->request->setHeaders($headers);
        return $this;
    }
}
