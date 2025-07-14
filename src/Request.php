<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\HttpAPI\AbstractRequest;
use Verdient\HttpAPI\ResultInterface;

/**
 * 请求
 *
 * @template TConfigure of Configure
 * @extends AbstractRequest<TConfigure>
 * @author Verdient。
 */
class Request extends AbstractRequest
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function send(): ResultInterface
    {
        return new Result($this->request->send());
    }
}
