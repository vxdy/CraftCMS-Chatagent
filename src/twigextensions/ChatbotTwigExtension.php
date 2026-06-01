<?php

namespace eventiva\craftchatagent\twigextensions;

use Craft;
use craft\helpers\UrlHelper;
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

        // Publish web assets and register files with mtime-based cache busting
        [$basePath, $baseUrl] = Craft::$app->assetManager->publish(__DIR__ . '/../web');
        $jsMtime  = @filemtime(__DIR__ . '/../web/js/chatbot-widget.js') ?: 0;
        $cssMtime = @filemtime(__DIR__ . '/../web/css/chatbot-widget.css') ?: 0;
        $view->registerCssFile($baseUrl . '/css/chatbot-widget.css?v=' . $cssMtime);
        $view->registerJsFile($baseUrl . '/js/chatbot-widget.js?v=' . $jsMtime);

        // Resolve logo asset URL via transform so object storage serves it correctly
        $logoUrl = '';
        if (!empty($settings['logoAssetId'])) {
            $asset = Craft::$app->getAssets()->getAssetById((int)$settings['logoAssetId']);
            if ($asset) {
                $logoUrl = $asset->getUrl(['height' => 60, 'mode' => 'fit']) ?? '';
            }
        }

        // Build ChatbotConfig directly in PHP - no Twig template cache between settings and widget
        $config = json_encode([
            'apiUrl'          => UrlHelper::siteUrl('chatbot/message'),
            'rateUrl'         => UrlHelper::siteUrl('chatbot/rate'),
            'csrfTokenName'   => Craft::$app->getConfig()->getGeneral()->csrfTokenName,
            'csrfTokenValue'  => Craft::$app->getRequest()->getCsrfToken(),
            'companyName'     => $settings['companyName'] ?? '',
            'logoText'        => $settings['logoText'] ?? '',
            'logoUrl'         => $logoUrl,
            'primaryColor'    => $settings['primaryColor'] ?? '#7C3AED',
            'initialMessage'  => $settings['initialMessage'] ?? '',
            'defaultTheme'    => $settings['defaultTheme'] ?? 'light',
            'inputPlaceholder'=> $settings['inputPlaceholder'] ?: 'Your message...',
            'sendButtonText'  => $settings['sendButtonText'] ?: 'Send',
            'enableRatings'   => (bool)($settings['enableRatings'] ?? true),
            'suggestionsEnabled' => (bool)($settings['suggestionsEnabled'] ?? true),
            'suggestions'     => $settings['suggestions'] ?? [],
            'iconChat'        => $settings['iconChat'] ?: 'fas fa-comments',
            'iconThumbUp'     => $settings['iconThumbUp'] ?: 'fas fa-thumbs-up',
            'iconThumbDown'   => $settings['iconThumbDown'] ?: 'fas fa-thumbs-down',
            'iconClose'       => $settings['iconClose'] ?: 'fas fa-times',
            'iconNewChat'     => $settings['iconNewChat'] ?: 'fas fa-sync-alt',
            'iconThemeLight'  => $settings['iconThemeLight'] ?: 'fas fa-moon',
            'iconThemeDark'   => $settings['iconThemeDark'] ?: 'fas fa-sun',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG);

        $primaryColor = htmlspecialchars($settings['primaryColor'] ?? '#7C3AED', ENT_QUOTES);
        $logoBgColor  = htmlspecialchars($settings['logoBgColor'] ?? $primaryColor, ENT_QUOTES);

        return <<<HTML
<style>
.chatbot-button,.chatbot-container{--chatbot-primary:{$primaryColor};--chatbot-user-msg:{$primaryColor};--chatbot-logo-bg:{$logoBgColor};}
</style>
<script>var ChatbotConfig = {$config};</script>
HTML;
    }
}
