<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\Http\Request;
use Verdient\Http\Response;

/**
 * 结果接口，定义获取响应状态、错误信息、数据及原始响应对象的方法。
 *
 * @author Verdient。
 */
interface ResultInterface
{
    /**
     * 获取请求是否成功
     *
     * @author Verdient。
     */
    public function getIsOK(): bool;

    /**
     * 获取错误码
     *
     * @author Verdient。
     */
    public function getErrorCode(): int|string|null;

    /**
     * 获取错误信息
     *
     * @author Verdient。
     */
    public function getErrorMessage(): ?string;

    /**
     * 获取返回的业务数据
     *
     *
     * @author Verdient。
     */
    public function getData(): mixed;

    /**
     * 获取底层原始请求对象
     *
     * @author Verdient。
     */
    public function getRequest(): ?Request;

    /**
     * 获取底层原始响应对象
     *
     * @author Verdient。
     */
    public function getResponse(): ?Response;
}
