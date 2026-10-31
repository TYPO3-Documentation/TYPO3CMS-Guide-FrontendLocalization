<?php

declare(strict_types=1);

namespace T3docs\GuideTranslate\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Renders a page with the example site package in
 * Documentation/CodeSnippets/my_sitepackage, so the TypoScript and the
 * Fluid template of the language menu shown in the manual are tested
 * with the current TYPO3 version.
 */
final class MySitepackageTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'myvendor/my-sitepackage',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/pages.csv');
        // English, Español with a fallback to English, and العربية without one,
        // as in the screenshots of the manual
        $this->get(SiteWriter::class)->write('main', [
            'rootPageId' => 1,
            'base' => 'https://example.org/',
            'dependencies' => ['myvendor/my-sitepackage'],
            'languages' => [
                ['languageId' => 0, 'title' => 'English', 'navigationTitle' => 'English', 'base' => '/', 'locale' => 'en_US.UTF-8'],
                ['languageId' => 1, 'title' => 'Español', 'navigationTitle' => 'Español', 'base' => '/es/', 'locale' => 'es_ES.UTF-8', 'fallbackType' => 'fallback', 'fallbacks' => '0'],
                ['languageId' => 2, 'title' => 'العربية', 'navigationTitle' => 'العربية', 'base' => '/ar/', 'locale' => 'ar_SA.UTF-8', 'fallbackType' => 'strict'],
            ],
        ]);
    }

    #[Test]
    public function languageMenuLinksTheTranslationsOfThePage(): void
    {
        $body = $this->renderPage(0);
        self::assertMatchesRegularExpression('#<li class="active ">\s*<a href="/" hreflang="en-US" title="English">\s*<span>English</span>#', $body);
        self::assertMatchesRegularExpression('#<li class=" ">\s*<a href="/es/" hreflang="es-ES" title="Español">\s*<span>Español</span>#', $body);
    }

    #[Test]
    public function languageMenuShowsALanguageWithoutTranslationAsText(): void
    {
        $body = $this->renderPage(0);
        self::assertMatchesRegularExpression('#<li class=" text-muted">\s*<span>العربية</span>#', $body);
    }

    #[Test]
    public function languageMenuMarksTheLanguageOfThePage(): void
    {
        $body = $this->renderPage(1);
        self::assertMatchesRegularExpression('#<li class="active ">\s*<a href="/es/" hreflang="es-ES" title="Español">#', $body);
    }

    private function renderPage(int $languageId): string
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.org/')->withPageId(1)->withLanguageId($languageId));
        return (string)$response->getBody();
    }
}
