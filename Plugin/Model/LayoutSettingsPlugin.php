<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\BlogCommentsReCaptcha\Plugin\Model;

use MSP\ReCaptcha\Model\LayoutSettings;
use Magento\Framework\App\Config\ScopeConfigInterface;

class LayoutSettingsPlugin
{
    const XML_PATH_BLOG_POST_COMMENTS_RECAPTCHA = 'mfblog/post_view/comments/type';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * LayoutSettingsPlugin constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param LayoutSettings $subject
     * @param $result
     * @return mixed
     */
    public function afterGetCaptchaSettings(LayoutSettings $subject, $result)
    {
        $result['enabled']['mfblog_comments'] = (bool) $this->scopeConfig->getValue(
            'msp_securitysuite_recaptcha/frontend/enabled_mfblog_comments',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return $result;
    }
}