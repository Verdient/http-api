<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

/**
 * 客户端接口
 *
 * @template TConfigure of Configure
 * @author Verdient。
 */
interface ClientInterface
{
    /**
     * 创建实例
     *
     * @param ?TConfigure $configure 配置对象
     * @author Verdient。
     */
    public static function create(?Configure $configure = null): static;

    /**
     * 创建并返回一个已设置好完整 URL 的请求实例
     *
     * @param string|null $path 请求相对路径
     * @author Verdient。
     */
    public function request(?string $path = null): RequestInterface;
}
