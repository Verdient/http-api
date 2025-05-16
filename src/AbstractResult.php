<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\Http\Request;
use Verdient\Http\Response;
use Verdient\Http\Result as HttpResult;

/**
 * 抽象结果类，封装响应解析后的状态及数据
 *
 * @author Verdient。
 */
abstract class AbstractResult implements ResultInterface
{
    /**
     * 是否成功
     *
     * @author Verdient。
     */
    protected bool $isOK;

    /**
     * 响应数据
     *
     * @author Verdient。
     */
    protected mixed $data = null;

    /**
     * 错误码
     *
     * @author Verdient。
     */
    protected int|string|null $errorCode = null;

    /**
     * 错误信息
     *
     * @author Verdient。
     */
    protected ?string $errorMessage = null;

    /**
     * 响应对象
     *
     * @author Verdient。
     */
    protected ?Response $response = null;

    /**
     * 构造函数
     *
     * @param HttpResult $result Http响应结果
     * @author Verdient。
     */
    public function __construct(HttpResult $result)
    {
        $this->response = $result->getResponse();

        if ($result->getIsOK()) {
            $this->resolve($result);
        } else {
            $this->isOK = false;
            $this->errorCode = $result->getErrorCode();
            $this->errorMessage  = $result->getErrorMessage();
        }
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getIsOK(): bool
    {
        return $this->isOK;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getErrorCode(): int|string|null
    {
        return $this->errorCode;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getRequest(): ?Request
    {
        return $this->response ? $this->response->getRequest() : null;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * 解析响应，完成结果
     *
     * @author Verdient。
     */
    abstract protected function resolve(HttpResult $result): void;
}
