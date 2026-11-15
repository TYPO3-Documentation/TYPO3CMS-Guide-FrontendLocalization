<?php

declare(strict_types=1);

namespace T3docs\GuideTranslate\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;

/**
 * Renders a page with the site configuration of the free mode shown in
 * the manual.
 */
final class FreeModeTest extends AbstractSiteTestCase
{
    protected const SITE_CONFIGURATION = 'config/sites/my_site_free/config.yaml';

    #[Test]
    public function freeModeShowsOnlyTheRecordsOfTheLanguage(): void
    {
        $body = $this->renderPage(1, 1);
        self::assertStringContainsString('<h2>Bienvenidos</h2>', $body);
        self::assertStringNotContainsString('<h2>Welcome</h2>', $body);
        // The original of this translation is hidden, which free mode ignores
        self::assertStringContainsString('<h2>Oculto</h2>', $body);
    }
}
