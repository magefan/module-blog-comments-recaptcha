<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\BlogCommentsReCaptcha\Model\Provider\Failure;

use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Json\EncoderInterface;
use MSP\ReCaptcha\Model\Config;

class AjaxResponseFailure extends \MSP\ReCaptcha\Model\Provider\Failure\AjaxResponseFailure
{
    /**
     * @var ActionFlag
     */
    private $actionFlag;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * @var Config
     */
    private $config;

    /**
     * AjaxResponseFailure constructor.
     * @param ActionFlag $actionFlag
     * @param EncoderInterface $encoder
     * @param Config $config
     */
    public function __construct(
        ActionFlag $actionFlag,
        EncoderInterface $encoder,
        Config $config
    ) {
        $this->actionFlag = $actionFlag;
        $this->encoder = $encoder;
        $this->config = $config;
    }

    /**
     * Handle reCaptcha failure
     * @param ResponseInterface $response
     * @return void
     */
    public function execute(ResponseInterface $response = null)
    {
        $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);

        $jsonPayload = $this->encoder->encode([
            'success' => false,
            'message' => $this->config->getErrorDescription(),
        ]);
        $response->representJson($jsonPayload);
    }
}
