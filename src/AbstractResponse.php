<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\http\Response;

/**
 * 抽象响应
 * @author Verdient。
 */
abstract class AbstractResponse
{
    /**
     * @var bool 请求是否成功
     * @author Verdient。
     */
    protected $isOK = false;

    /**
     * @var int 错误码
     * @author Verdient。
     */
    protected $errorCode = null;

    /**
     * @var string 错误信息
     * @author Verdient。
     */
    protected $errorMessage = null;

    /**
     * @var Response 响应对象
     * @author Verdient。
     */
    protected $response = null;

    /**
     * @var array 数据
     * @author Verdient。
     */
    protected $data = null;

    /**
     * @var Response 响应对象
     * @author Verdient。
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $result = $this->normailze($response);
        $this->isOK = $result->isOK;
        if ($this->isOK) {
            $this->data = $result->data;
        } else {
            $this->errorCode = $result->errorCode ?: $response->getStatusCode();
            $this->errorMessage = $result->errorMessage ?: $response->getRawContent();
        }
    }

    /**
     * 获取响应对象
     * @return Response
     * @author Verdient。
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 获取是否成功
     * @return bool
     * @author Verdient。
     */
    public function getIsOK()
    {
        return $this->isOK;
    }

    /**
     * 获取错误码
     * @return int
     * @author Verdient。
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * 获取错误信息
     * @return string
     * @author Verdient。
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * 获取返回的数据
     * @return array
     * @author Verdient。
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     * @return mixed
     * @author Verdient。
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * 格式化
     * @param Response 响应
     * @return Result
     * @author Verdient。
     */
    abstract protected function normailze(Response $response): Result;
}
