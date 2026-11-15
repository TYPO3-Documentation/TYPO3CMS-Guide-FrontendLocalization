<?php

declare(strict_types=1);

namespace T3docs\GuideTranslate\Tests\Functional;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Sets up a site from a site configuration in
 * Documentation/CodeSnippets/config/sites/, with the example site package
 * in Documentation/CodeSnippets/my_sitepackage, so the examples shown in
 * the manual are tested with the current TYPO3 version.
 */
abstract class AbstractSiteTestCase extends FunctionalTestCase
{
    protected const SNIPPET_PATH = __DIR__ . '/../../Documentation/CodeSnippets/';

    protected const SITE_CONFIGURATION = 'config/sites/my_site/config.yaml';

    protected array $testExtensionsToLoad = [
        'typo3/theme-camino',
        'myvendor/my-sitepackage',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/pages.csv');
        $siteDirectory = Environment::getConfigPath() . '/sites/my_site';
        GeneralUtility::mkdir_deep($siteDirectory);
        copy(self::SNIPPET_PATH . static::SITE_CONFIGURATION, $siteDirectory . '/config.yaml');
    }

    protected function requestPage(int $pageId, int $languageId): ResponseInterface
    {
        return $this->executeFrontendSubRequest(new InternalRequest('https://example.org/')->withPageId($pageId)->withLanguageId($languageId));
    }

    protected function renderPage(int $pageId, int $languageId): string
    {
        $response = $this->requestPage($pageId, $languageId);
        self::assertSame(200, $response->getStatusCode());
        return (string)$response->getBody();
    }
}
