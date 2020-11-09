<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\BlogCommentsReCaptcha\Model;

use Magento\Framework\App\PlainTextRequestInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\ReCaptchaUi\Model\CaptchaResponseResolverInterface;

/**
 * @inheritdoc
 */
class CaptchaResponseResolver implements CaptchaResponseResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     *
     * @param  RequestInterface|PlainTextRequestInterface $request
     * @return string
     * @throws InputException
     */
    public function resolve(RequestInterface $request): string
    {
        $content = $request->getContent();

        if (empty($content)) {
            throw new InputException(__('Can not resolve reCAPTCHA response.'));
        }

        try {
            //$params = $this->serializer->unserialize($content);
            $params = [];
            parse_str($content, $params);
        } catch (\InvalidArgumentException $e) {
            throw new InputException(__('Can not resolve reCAPTCHA response.'), $e);
        }

        if (empty($params[self::PARAM_RECAPTCHA])) {
            throw new InputException(__('Can not resolve reCAPTCHA response.'));
        }

        return $params[self::PARAM_RECAPTCHA];
    }
}
