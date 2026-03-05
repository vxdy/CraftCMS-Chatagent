<?php

namespace eventiva\craftchatagent\jobs;

use Craft;
use craft\elements\Entry;
use craft\queue\BaseJob;
use eventiva\craftchatagent\Chatagent;

class TrainingJob extends BaseJob
{
    public int $entryId;
    public string $sectionHandle = '';

    public function execute($queue): void
    {
        $entry = Entry::find()->id($this->entryId)->status(null)->one();

        if (!$entry) {
            Craft::warning("TrainingJob: Entry #{$this->entryId} not found – skipping job.", __METHOD__);
            return;
        }

        try {
            $count = Chatagent::getInstance()->getTrainingService()->trainEntry($entry);
            Craft::info("TrainingJob: Entry #{$this->entryId} ({$entry->title}) – {$count} chunks indexed.", __METHOD__);
        } catch (\Throwable $e) {
            Craft::error("TrainingJob: Entry #{$this->entryId} failed: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    protected function defaultDescription(): ?string
    {
        return 'Chatbot Training: Entry #' . $this->entryId
            . ($this->sectionHandle ? " ({$this->sectionHandle})" : '');
    }
}
