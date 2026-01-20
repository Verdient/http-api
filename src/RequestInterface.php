<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\Http\Builder\BuilderInterface;
use Verdient\Http\Request;
use Verdient\Http\Serializer\Body\BodySerializerInterface;

/**
 * 请求接口，定义请求相关的设置方法及发送请求的方法。
 * 实现该接口的类负责构造请求并执行，最终返回响应。
 *
 * @author Verdient。
 */
interface RequestInterface
{
    /**
     * 获取配置对象
     *
     * @author Verdient。
     */
    public function getConfigure(): Configure;

    /**
     * 获取底层请求对象
     *
     * @author Verdient。
     */
    public function getRequest(): Request;

    /**
     * 设置请求 URL
     *
     * @param string $url 完整请求地址
     *
     * @author Verdient。
     */
    public function setUrl(string $url): static;

    /**
     * 设置请求方法
     *
     * @param string $method 请求方法
     *
     * @author Verdient。
     */
    public function setMethod(string $method): static;

    /**
     * 设置查询参数（Query String）
     *
     * @param array $queries 查询参数键值对数组
     *
     * @author Verdient。
     */
    public function setQueries(array $queries): static;

    /**
     * 设置请求体参数（如表单、JSON 的键值对）
     *
     * @param array|BuilderInterface $bodies 请求体参数数组或构造器
     *
     * @author Verdient。
     */
    public function setBodies(array|BuilderInterface $bodies): static;

    /**
     * 设置原始请求内容（字符串）
     *
     * @param string $content 原始请求体字符串
     *
     * @author Verdient。
     */
    public function setContent(string $content): static;

    /**
     * 设置请求体序列化器类型
     *
     * @param BodySerializerInterface $serializer 序列化器
     *
     * @author Verdient。
     */
    public function setBodySerializer(BodySerializerInterface $serializer): static;

    /**
     * 设置头部
     *
     * @param array $headers
     *
     * @author Verdient。
     */
    public function setHeaders(array $headers): static;

    /**
     * 发送请求并返回结果
     *
     * @author Verdient。
     */
    public function send(): ResultInterface;
}
