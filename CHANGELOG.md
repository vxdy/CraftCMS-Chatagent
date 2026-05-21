# Release Notes for Chatagent

## 1.1.0 - 2026-05-21

### Added
- Company/Website settings tab with fields for company name, website URL, and company description. Values are automatically prepended as a context block to the system prompt.
- `default-prompt.md` in plugin root as a persistent fallback system prompt. Loaded when no prompt is configured in the backend. Can be edited and committed alongside the plugin.
- Log bulk delete: delete all sessions before a given date or delete all sessions at once. New UI panel in the logs overview.

### Changed
- Settings persistence: migrated from Craft cache (`chatbot_settings` key) to Craft's native plugin settings system (`craft_plugins` table, JSON). Settings now survive cache clears and deployments.
- Settings model: added missing fields (`logoAssetId`, `logoBgColor`, `enableRatings`, `suggestionsEnabled`, `suggestions`, `websiteUrl`, `companyDescription`). Removed hardcoded company-specific default values.
- Logo URL in chat widget now generated via image transform (height: 60, fit) instead of raw upload URL, fixing broken images on object storage setups.

### Fixed
- Suggestions textarea incorrectly used `join('\n')` (Twig single-quote = literal backslash-n). Fixed to `join("\n")` so suggestions are displayed and saved correctly.
- `extra.documentationUrl` in `composer.json` now points to the correct README URL.

---

## 1.0.0

- Initial release
