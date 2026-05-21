<?php

namespace eventiva\craftchatagent\twigextensions;

use Craft;
use eventiva\craftchatagent\assetbundles\ChatbotAssetBundle;
use eventiva\craftchatagent\Chatagent;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ChatbotTwigExtension extends AbstractExtension
{
    private static bool $rendered = false;

    public function getFunctions(): array
    {
        return [
            new TwigFunction('chatbotWidget', [$this, 'renderWidget'], ['is_safe' => ['html']]),
        ];
    }

    public function renderWidget(): string
    {
        if (self::$rendered) {
            return '';
        }

        $settings = Chatagent::getInstance()->getChatService()->getSettings();

        if (!$settings['enabled']) {
            return '';
        }

        self::$rendered = true;

        $view = Craft::$app->getView();

        // Register asset bundle (JS + CSS)
        $view->registerAssetBundle(ChatbotAssetBundle::class);

        // Resolve logo asset URL via transform so object storage serves it correctly
        $logoUrl = '';
        if (!empty($settings['logoAssetId'])) {
            $asset = Craft::$app->getAssets()->getAssetById((int)$settings['logoAssetId']);
            if ($asset) {
                $logoUrl = $asset->getUrl(['height' => 60, 'mode' => 'fit']) ?? '';
            }
        }

        // Render the initialization script template
        return $view->renderTemplate('chatbot/_widget', [
            'settings' => $settings,
            'logoUrl' => $logoUrl,
            'csrfTokenName' => Craft::$app->getConfig()->getGeneral()->csrfTokenName,
            'csrfTokenValue' => Craft::$app->getRequest()->getCsrfToken(),
        ]);
    }
}
