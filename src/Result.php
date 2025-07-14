<?php

declare(strict_types=1);

namespace Verdient\HttpAPI;

use Verdient\Http\Result as HttpResult;
use Verdient\HttpAPI\AbstractResult;

/**
 * 响应
 *
 * @author Verdient。
 */
class Result extends AbstractResult
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resolve(HttpResult $result): void
    {
        $statusCode = $result->getStatusCode();

        $bodies = $result->getBodies();

        if ($statusCode >= 200 && $statusCode < 300) {
            $this->isOK = true;
            $this->data = $bodies;
        } else {
            $this->isOK = false;

            $errorCode = null;

            $errorMessage = null;

            if (is_array($bodies)) {
                foreach (['code', 'status'] as $key) {
                    if (!isset($bodies[$key])) {
                        continue;
                    }
                    if (is_int($bodies[$key])) {
                        $errorCode = $bodies[$key];
                    } else if (is_scalar($bodies[$key])) {
                        if (!is_int($errorCode)) {
                            $errorCode = (string) $bodies[$key];
                        }
                    }
                }

                foreach (['message', 'msg', 'error', 'err'] as $key) {
                    if (!isset($bodies[$key])) {
                        continue;
                    }
                    if (is_string($bodies[$key])) {
                        $errorMessage = $bodies[$key];
                    } else if (is_scalar($bodies[$key])) {
                        if (!is_string($errorMessage)) {
                            $errorMessage = $bodies[$key];
                        }
                    }
                }
            }

            if ($errorCode === null) {
                $this->errorCode = $statusCode;
            }

            if ($errorMessage === null) {
                $this->errorMessage = $result->getResponse()->getRawContent();
            } else {
                $this->errorMessage = (string) $errorMessage;
            }
        }
    }
}
