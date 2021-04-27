<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use chorus\BaseObject;
use chorus\Configurable;
use chorus\ObjectHelper;
use Verdient\http\Request;

/**
 * 客户端
 * @author Verdient。
 */
abstract class AbstractClient extends BaseObject
{
    use Configurable;

    /**
     * @var string 协议方法
     * @author Verdient。
     */
    public $protocol = 'http';

    /**
     * @var string 主机域名
     * @author Verdient。
     */
    public $host = null;

    /**
     * @var string 端口
     * @author Verdient。
     */
    public $port = null;

    /**
     * @var string 路由前缀
     * @author Verdient。
     */
    public $routePrefix = null;

    /**
     * @var string 请求组件
     * @author Verdient。
     */
    public $request;

    /**
     * @var string 请求路径
     * @author Verdient。
     */
    protected $requestPath;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function __construct($config)
    {
        $this->configuration($config);
    }

    /**
     * 获取请求路径
     * @return string
     * @author Verdient。
     */
    public function getRequestPath(): string
    {
        if(!$this->requestPath){
            if(!$this->host){
                throw new \Exception('host must be set');
            }
            if($this->protocol == 'http' && $this->port == 80){
                $this->port = null;
            }
            if($this->protocol == 'https' && $this->port == 443){
                $this->port = null;
            }
            $this->requestPath = $this->protocol . '://' . $this->host . ($this->port ? (':' . $this->port) : '') . ($this->routePrefix ? '/' . $this->routePrefix : '');
        }
        return $this->requestPath;
    }

    /**
     * 请求
     * @param string $methodName 方法名称
     * @return Request
     * @author Verdient。
     */
    public function request($path): Request
    {
        $request = ObjectHelper::create($this->request ?: Request::class);
        $request->setUrl($this->getRequestPath() . '/' . $path);
        return $request;
    }
}