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
    public bool $enabled = true;
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

    // Rating & Suggestions
    public bool $enableRatings = true;
    public bool $suggestionsEnabled = true;
    public array $suggestions = [];

    public function rules(): array
    {
        return [
            [['companyName', 'logoText', 'primaryColor', 'logoBgColor', 'initialMessage', 'defaultTheme', 'systemPrompt', 'openaiApiKey', 'openaiModel', 'embeddingModel'], 'string'],
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
            'enableRatings'      => Craft::t('chatagent', 'Enable Ratings'),
            'suggestionsEnabled' => Craft::t('chatagent', 'Enable Suggestions'),
            'suggestions'        => Craft::t('chatagent', 'Suggestions'),
        ];
    }
}
