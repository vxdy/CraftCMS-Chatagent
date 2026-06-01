# Release Notes for Chatagent

## 1.3.0 - 2026-06-01

### Added
- **Icon Customization** – All 7 widget icons are now configurable per-install under Settings → Icons: chat button, close, new chat/reset, theme toggle (light/dark mode), thumb up and thumb down ratings.
- Icons accept any full CSS class string, making the system icon-library-agnostic - e.g. `fas fa-comments` (Font Awesome), `bi bi-chat-dots` (Bootstrap Icons), or any other library loaded on the frontend. A live preview is shown in the CP as you type.
- Rating buttons now use the configurable icon classes instead of hardcoded inline SVG.

### Fixed
- `ChatbotConfig` was generated via a Twig template which could be served from Craft's compiled template cache after updates. Config is now built directly in PHP via `json_encode()`, ensuring settings are always read fresh from the database.
- Widget JS and CSS are now served with a file-modification-time `?v=` cache-busting parameter, preventing browsers from running outdated widget code after plugin updates.

---

## 1.2.0 - 2026-05-21

### Added
- **Widget Label Customization** – Input placeholder and send button text are now configurable per-install under Settings → General → Widget Labels. Defaults are `"Your message..."` and `"Send"`.

### Changed
- All hardcoded German stri"uri": "produkt/kategorie/bild-und-videotechnik-mieten/himmelstadt"ngs removed from the chat widget JS (button tooltips, error messages). The widget is now fully English by default with user-configurable labels for input and send button.

### Fixed
- Company name title color rules now use `!important` to reliably prevent site-level heading styles from bleeding into the widget.

---

## 1.1.2 - 2026-05-21

### Fixed
- Default theme not applied on page load. Theme class is now set directly from config when the widget HTML is created instead of being corrected after the fact.
- Company name displayed in white in light mode due to site-level `h3` styles bleeding into the widget. Explicit theme-aware colors applied.

---

## 1.1.1 - 2026-05-21

### Added
- Chat widget is now automatically injected before `</body>` on all frontend pages when enabled - no template changes required.
- Double-render guard: if `{{ chatbotWidget() }}` is already called in a template, the auto-injection is skipped automatically.

### Changed
- Widget is now **disabled by default** on fresh installations. Enable it explicitly under Chatbot → Settings → General.

---

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
