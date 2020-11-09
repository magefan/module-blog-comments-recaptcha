<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\BlogCommentsReCaptcha\Model;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Process error during ajax login
 *
 * Set "no dispatch" flag and error message to Response
 */
class ErrorProcessor
{
    /**
     * @var ActionFlag
     */
    private $actionFlag;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ActionFlag          $actionFlag
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ActionFlag $actionFlag,
        SerializerInterface $serializer
    ) {
        $this->actionFlag = $actionFlag;
        $this->serializer = $serializer;
    }

    /**
     * Set "no dispatch" flag and error message to Response
     *
     * @param  ResponseInterface $response
     * @param  string            $message
     * @return void
     */
    public function processError(ResponseInterface $response, string $message): void
    {
        $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);

        $jsonPayload = $this->serializer->serialize(
            [
            'success' => false,
            'message' => $message,
            ]
        );
        $response->representJson($jsonPayload);
    }
}
