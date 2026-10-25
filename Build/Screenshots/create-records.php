<?php

declare(strict_types=1);

/*
 * Prepares the demo site of the Camino theme for the screenshots. The pages
 * and content elements come from the theme. This file adds only what a
 * screenshot needs on top, such as the languages, and finds the records by
 * their title, as the uids can differ between TYPO3 versions.
 *
 * Runs after "typo3 setup" and "typo3 extension:setup".
 */

use TYPO3\CMS\Core\Authentication\CommandLineUserAuthentication;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$classLoader = require __DIR__ . '/../../.Build/vendor/autoload.php';
SystemEnvironmentBuilder::run(0, SystemEnvironmentBuilder::REQUESTTYPE_CLI);
$container = Bootstrap::init($classLoader);
Bootstrap::initializeBackendUser(CommandLineUserAuthentication::class);
$GLOBALS['BE_USER']->authenticate();
$GLOBALS['LANG'] = $container->get(LanguageServiceFactory::class)
    ->createFromUserPreferences($GLOBALS['BE_USER']);

$process = static function (array $data): DataHandler {
    $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    $dataHandler->start($data, []);
    $dataHandler->process_datamap();
    if ($dataHandler->errorLog !== []) {
        throw new RuntimeException(implode("\n", $dataHandler->errorLog));
    }
    return $dataHandler;
};

// The uid of a record of the theme, found by its title
$find = static function (string $table, string $field, string $value, ?int $pid = null): int {
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
    $queryBuilder->select('uid')->from($table)
        ->where($queryBuilder->expr()->eq($field, $queryBuilder->createNamedParameter($value)));
    if ($pid !== null) {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid)));
    }
    $uid = $queryBuilder->executeQuery()->fetchOne();
    if ($uid === false) {
        throw new RuntimeException(sprintf('No %s with %s "%s" in the Camino demo site', $table, $field, $value));
    }
    return (int)$uid;
};

$uids = [
    'root' => $find('pages', 'title', 'Camino', 0),
];

// The languages of the examples in the manual, besides the default
// language English: Danish, which falls back to English, and German. The
// titles are English, as the text names them, such as in the prefix
// "[Translate to German:]".
$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByRootPageId($uids['root']);
$configuration = $site->getConfiguration();
$configuration['languages'][] = [
    'title' => 'Danish',
    'enabled' => true,
    'languageId' => 1,
    'base' => '/da/',
    'locale' => 'da_DK',
    'hreflang' => 'da-DK',
    'navigationTitle' => 'Dansk',
    'websiteTitle' => '',
    'flag' => 'dk',
    'fallbackType' => 'fallback',
    'fallbacks' => '0',
];
$configuration['languages'][] = [
    'title' => 'German',
    'enabled' => true,
    'languageId' => 2,
    'base' => '/de/',
    'locale' => 'de_DE',
    'hreflang' => 'de-DE',
    'navigationTitle' => 'Deutsch',
    'websiteTitle' => '',
    'flag' => 'de',
    'fallbackType' => 'strict',
    'fallbacks' => '',
];
GeneralUtility::makeInstance(SiteWriter::class)->write($site->getIdentifier(), $configuration);
GeneralUtility::makeInstance(CacheManager::class)->flushCaches();

// A group of translators, who may edit German records only, for the
// screenshot of the language permissions
$dataHandler = $process(['be_groups' => ['NEWtranslators' => [
    'pid' => 0,
    'title' => 'German translators',
    'allowed_languages' => '2',
]]]);
$uids['germanTranslators'] = $dataHandler->substNEWwithIDs['NEWtranslators'];

// The uids differ between TYPO3 versions, so screenshots.mjs reads them here
GeneralUtility::mkdir_deep(Environment::getVarPath());
file_put_contents(Environment::getVarPath() . '/screenshot-records.json', json_encode($uids, JSON_PRETTY_PRINT) . "\n");
