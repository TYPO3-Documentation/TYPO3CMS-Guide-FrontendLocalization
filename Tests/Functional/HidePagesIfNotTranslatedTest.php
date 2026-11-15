<?php

declare(strict_types=1);

namespace T3docs\GuideTranslate\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;

/**
 * Requests an untranslated page with the global setting shown in the
 * manual, in config/system/additional.php.
 */
final class HidePagesIfNotTranslatedTest extends AbstractSiteTestCase
{
    protected function setUp(): void
    {
        $this->configurationToUseInTestInstance = self::readAdditionalConfiguration();
        parent::setUp();
    }

    #[Test]
    public function untranslatedPageIsHidden(): void
    {
        self::assertSame(404, $this->requestPage(4, 1)->getStatusCode());
    }

    #[Test]
    public function translatedPageIsShown(): void
    {
        self::assertSame(200, $this->requestPage(1, 1)->getStatusCode());
    }

    /**
     * @return array<string, mixed>
     */
    private static function readAdditionalConfiguration(): array
    {
        $backup = $GLOBALS['TYPO3_CONF_VARS'] ?? null;
        $GLOBALS['TYPO3_CONF_VARS'] = [];
        require self::SNIPPET_PATH . 'config/system/additional.php';
        $configuration = $GLOBALS['TYPO3_CONF_VARS'];
        $GLOBALS['TYPO3_CONF_VARS'] = $backup;
        return $configuration;
    }
}
