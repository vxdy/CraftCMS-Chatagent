<?php

namespace eventiva\craftchatagent\models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public string $companyName = '';
    public string $logoText = '';
    public int $logoAssetId = 0;
    public string $primaryColor = '#7C3AED';
    public string $logoBgColor = '#7C3AED';
    public string $initialMessage = 'Hi, how can I help you today?';
    public string $defaultTheme = 'light';
    public string $systemPrompt = '';
    public string $openaiApiKey = '';
    public bool $enabled = false;
    public bool $logConversations = true;
    public int $logRetentionDays = 90;

    // RAG / AI fields
    public string $openaiModel = 'gpt-4o-mini';
    public string $embeddingModel = 'text-embedding-3-small';
    public array $trainingSections = [];
    public bool $autoTrainOnSave = false;
    public int $maxContextChunks = 5;
    public float $minSimilarityScore = 0.4;

    // Company / Website context
    public string $websiteUrl = '';
    public string $companyDescription = '';

    // Widget UI labels
    public string $inputPlaceholder = 'Your message...';
    public string $sendButtonText = 'Send';

    // Widget icons (full CSS class string, e.g. "fas fa-comments" or "bi bi-chat")
    public string $iconChat = 'fas fa-comments';
    public string $iconThumbUp = 'fas fa-thumbs-up';
    public string $iconThumbDown = 'fas fa-thumbs-down';
    public string $iconClose = 'fas fa-times';
    public string $iconNewChat = 'fas fa-sync-alt';
    public string $iconThemeLight = 'fas fa-moon';
    public string $iconThemeDark = 'fas fa-sun';

    // Rating & Suggestions
    public bool $enableRatings = true;
    public bool $suggestionsEnabled = true;
    public array $suggestions = [];

    public function rules(): array
    {
        return [
            [['companyName', 'logoText', 'primaryColor', 'logoBgColor', 'initialMessage', 'defaultTheme', 'systemPrompt', 'openaiApiKey', 'openaiModel', 'embeddingModel', 'inputPlaceholder', 'sendButtonText', 'iconChat', 'iconThumbUp', 'iconThumbDown', 'iconClose', 'iconNewChat', 'iconThemeLight', 'iconThemeDark'], 'string'],
            [['enabled', 'logConversations', 'autoTrainOnSave', 'enableRatings', 'suggestionsEnabled'], 'boolean'],
            [['logRetentionDays', 'maxContextChunks', 'logoAssetId'], 'integer', 'min' => 0],
            [['minSimilarityScore'], 'number', 'min' => 0, 'max' => 1],
            [['websiteUrl', 'companyDescription'], 'string'],
            [['trainingSections', 'suggestions'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'companyName'        => Craft::t('chatagent', 'Company Name'),
            'logoText'           => Craft::t('chatagent', 'Logo Text'),
            'logoAssetId'        => Craft::t('chatagent', 'Logo Asset'),
            'primaryColor'       => Craft::t('chatagent', 'Primary Color'),
            'logoBgColor'        => Craft::t('chatagent', 'Logo Background Color'),
            'initialMessage'     => Craft::t('chatagent', 'Initial Message'),
            'defaultTheme'       => Craft::t('chatagent', 'Default Theme'),
            'enabled'            => Craft::t('chatagent', 'Chatbot Enabled'),
            'logConversations'   => Craft::t('chatagent', 'Log Conversations'),
            'logRetentionDays'   => Craft::t('chatagent', 'Log Retention (days, 0 = unlimited)'),
            'openaiModel'        => Craft::t('chatagent', 'Chat Model'),
            'embeddingModel'     => Craft::t('chatagent', 'Embedding Model'),
            'trainingSections'   => Craft::t('chatagent', 'Training Sections'),
            'autoTrainOnSave'    => Craft::t('chatagent', 'Auto-Train on Entry Save'),
            'maxContextChunks'   => Craft::t('chatagent', 'Max. Context Chunks'),
            'minSimilarityScore' => Craft::t('chatagent', 'Min. Similarity Score'),
            'websiteUrl'         => Craft::t('chatagent', 'Website URL'),
            'companyDescription' => Craft::t('chatagent', 'About the Company / Website'),
            'inputPlaceholder'   => Craft::t('chatagent', 'Input Placeholder'),
            'sendButtonText'     => Craft::t('chatagent', 'Send Button Text'),
            'iconChat'           => Craft::t('chatagent', 'Chat Button Icon'),
            'iconThumbUp'        => Craft::t('chatagent', 'Thumb Up Icon'),
            'iconThumbDown'      => Craft::t('chatagent', 'Thumb Down Icon'),
            'iconClose'          => Craft::t('chatagent', 'Close Button Icon'),
            'iconNewChat'        => Craft::t('chatagent', 'New Chat Button Icon'),
            'iconThemeLight'     => Craft::t('chatagent', 'Theme Toggle Icon (Light Mode)'),
            'iconThemeDark'      => Craft::t('chatagent', 'Theme Toggle Icon (Dark Mode)'),
            'enableRatings'      => Craft::t('chatagent', 'Enable Ratings'),
            'suggestionsEnabled' => Craft::t('chatagent', 'Enable Suggestions'),
            'suggestions'        => Craft::t('chatagent', 'Suggestions'),
        ];
    }
}
