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

// The languages of the Editors Tutorial, besides the default language
// English: Spanish, and Arabic, which was spoken in Spain for centuries,
// and which is written from right to left. Their titles are the names of the
// languages in themselves, as the language menus of the backend show them.
$site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByRootPageId($uids['root']);
$configuration = $site->getConfiguration();
$configuration['languages'][] = [
    'title' => 'Español',
    'enabled' => true,
    'languageId' => 1,
    'base' => '/es/',
    'locale' => 'es-ES',
    'hreflang' => 'es-ES',
    'navigationTitle' => 'Español',
    'websiteTitle' => '',
    'flag' => 'es',
    'fallbackType' => 'strict',
    'fallbacks' => '',
];
$configuration['languages'][] = [
    'title' => 'العربية',
    'enabled' => true,
    'languageId' => 2,
    'base' => '/ar/',
    'locale' => 'ar',
    'hreflang' => 'ar',
    'navigationTitle' => 'العربية',
    'websiteTitle' => '',
    'flag' => 'ma',
    'fallbackType' => 'strict',
    'fallbacks' => '',
];
GeneralUtility::makeInstance(SiteWriter::class)->write($site->getIdentifier(), $configuration);
GeneralUtility::makeInstance(CacheManager::class)->flushCaches();

$localize = static function (string $table, int $uid, int $language): int {
    $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    $dataHandler->start([], [$table => [$uid => ['localize' => $language]]]);
    $dataHandler->process_cmdmap();
    if ($dataHandler->errorLog !== []) {
        throw new RuntimeException(implode("\n", $dataHandler->errorLog));
    }
    return (int)$dataHandler->copyMappingArray_merged[$table][$uid];
};

// The packing list in Arabic, as in the Editors Tutorial, so that the
// Records module shows the translation of the page
$uids['packingList'] = $find('pages', 'title', 'Packing List', $uids['root']);
$arabicPage = $localize('pages', $uids['packingList'], 2);
$process(['pages' => [$arabicPage => ['title' => 'قائمة الأمتعة', 'hidden' => 0]]]);

// A content element of the packing list in Arabic, whose form shows the
// English values below the fields, and which the Records module shows
// below the English one
$uids['essentialItems'] = $find('tt_content', 'header', 'Essential Items', $uids['packingList']);
$uids['arabicItems'] = $localize('tt_content', $uids['essentialItems'], 2);
$process(['tt_content' => [$uids['arabicItems'] => ['header' => 'الأغراض الأساسية', 'hidden' => 0]]]);
// The toiletries in Arabic, whose English header changes afterwards, so
// that the form of the translation shows the change
$toiletries = $find('tt_content', 'header', 'Toiletries', $uids['packingList']);
$uids['arabicToiletries'] = $localize('tt_content', $toiletries, 2);
$process(['tt_content' => [$uids['arabicToiletries'] => ['header' => 'أدوات النظافة', 'hidden' => 0]]]);
$process(['tt_content' => [$toiletries => ['header' => 'Toiletries and medicine']]]);

// A group of translators, who may edit Spanish records only, for the
// screenshot of the language permissions
$dataHandler = $process(['be_groups' => ['NEWtranslators' => [
    'pid' => 0,
    'title' => 'Spanish translators',
    'allowed_languages' => '1',
]]]);
$uids['spanishTranslators'] = $dataHandler->substNEWwithIDs['NEWtranslators'];

// The uids differ between TYPO3 versions, so screenshots.mjs reads them here
GeneralUtility::mkdir_deep(Environment::getVarPath());
file_put_contents(Environment::getVarPath() . '/screenshot-records.json', json_encode($uids, JSON_PRETTY_PRINT) . "\n");
