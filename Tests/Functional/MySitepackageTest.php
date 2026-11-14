<?php

declare(strict_types=1);

namespace T3docs\GuideTranslate\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Renders pages with the site configuration and the site package shown in
 * the manual: English, Español with a fallback to English, and العربية
 * without one, as in the screenshots.
 */
final class MySitepackageTest extends AbstractSiteTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Where a language pack puts the Spanish labels of the Camino theme,
        // before the first request caches the labels
        $directory = Environment::getLabelsPath() . '/es/theme_camino/Resources/Private/Language';
        GeneralUtility::mkdir_deep($directory);
        file_put_contents($directory . '/es.messages.xlf', <<<'XLIFF'
            <?xml version="1.0" encoding="UTF-8"?>
            <xliff version="1.2" xmlns="urn:oasis:names:tc:xliff:document:1.2">
              <file source-language="en" target-language="es" datatype="plaintext" original="EXT:theme_camino/Resources/Private/Language/messages.xlf">
                <body>
                  <trans-unit id="menu.label">
                    <source>Menu</source>
                    <target>Menú</target>
                  </trans-unit>
                </body>
              </file>
            </xliff>
            XLIFF);
    }

    #[Test]
    public function languageMenuLinksTheTranslationsOfThePage(): void
    {
        $body = $this->renderPage(1, 0);
        self::assertMatchesRegularExpression('#<li class="active ">\s*<a href="/" hreflang="en-US" title="English">\s*<span>English</span>#', $body);
        self::assertMatchesRegularExpression('#<li class=" ">\s*<a href="/es/" hreflang="es-ES" title="Español">\s*<span>Español</span>#', $body);
        self::assertMatchesRegularExpression('#<li class=" ">\s*<a href="/ar/" hreflang="ar-SA" title="العربية">#', $body);
    }

    #[Test]
    public function languageMenuShowsALanguageWithoutTranslationAsText(): void
    {
        $body = $this->renderPage(4, 0);
        self::assertMatchesRegularExpression('#<li class=" text-muted">\s*<span>Español</span>#', $body);
        self::assertMatchesRegularExpression('#<li class=" text-muted">\s*<span>العربية</span>#', $body);
    }

    #[Test]
    public function languageMenuMarksTheLanguageOfThePage(): void
    {
        $body = $this->renderPage(1, 1);
        self::assertMatchesRegularExpression('#<li class="active ">\s*<a href="/es/" hreflang="es-ES" title="Español">#', $body);
    }

    #[Test]
    public function labelIsTranslatedFromTheLabelsPath(): void
    {
        self::assertStringContainsString('Menú', $this->renderPage(1, 1));
        // Without a translation, the output is the English label
        self::assertMatchesRegularExpression('#^Menu$#m', $this->renderPage(1, 2));
    }

    #[Test]
    public function fallbackShowsTheContentOfTheDefaultLanguage(): void
    {
        $body = $this->renderPage(1, 1);
        self::assertStringContainsString('<h2>Welcome</h2>', $body);
        // The original of this translation is hidden, so the translation is hidden too
        self::assertStringNotContainsString('<h2>Oculto</h2>', $body);
    }

    #[Test]
    public function strictShowsOnlyTranslatedContent(): void
    {
        self::assertStringNotContainsString('<h2>Welcome</h2>', $this->renderPage(1, 2));
    }

    #[Test]
    public function fallbackShowsAnUntranslatedPage(): void
    {
        self::assertStringContainsString('<title>FAQ', $this->renderPage(4, 1));
    }
}
