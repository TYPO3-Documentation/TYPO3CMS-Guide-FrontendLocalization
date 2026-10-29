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
    // Unlike in the Editors Tutorial, Spanish falls back to English, for
    // the example of a fallback in the frontend
    'fallbackType' => 'fallback',
    'fallbacks' => '0',
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
// Records module shows the translation of the page, and the language menu
// of the page shows a language with a translation next to Spanish, which
// has none
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

// The imprint in both languages, with its hero translated, but not its
// text: Arabic shows only what is translated, Spanish falls back to the
// English text
$uids['imprint'] = $find('pages', 'title', 'Imprint');
$imprintHero = $find('tt_content', 'CType', 'camino_hero_text_only', $uids['imprint']);
foreach ([1 => 'Aviso legal', 2 => 'بيانات النشر'] as $language => $title) {
    $page = $localize('pages', $uids['imprint'], $language);
    $process(['pages' => [$page => ['title' => $title, 'hidden' => 0]]]);
    $hero = $localize('tt_content', $imprintHero, $language);
    $process(['tt_content' => [$hero => ['header' => $title, 'hidden' => 0]]]);
}

// A content element for all languages on the privacy page. The page is
// translated, so that the Layout module compares its languages.
$uids['privacy'] = $find('pages', 'title', 'Privacy');
foreach ([1 => 'Privacidad', 2 => 'الخصوصية'] as $language => $title) {
    $page = $localize('pages', $uids['privacy'], $language);
    $process(['pages' => [$page => ['title' => $title, 'hidden' => 0]]]);
}
$dataHandler = $process(['tt_content' => ['NEWall' => [
    'pid' => $uids['privacy'],
    'colPos' => 0,
    'CType' => 'text',
    'sys_language_uid' => -1,
    'header' => 'Buen Camino!',
    'bodytext' => '<p>The greeting of the pilgrims, in every language of the website.</p>',
]]]);
$uids['allLanguages'] = $dataHandler->substNEWwithIDs['NEWall'];

// A page that hides its default language and exists in Arabic only, for
// the example of a page that is relevant in one language only. It is in
// the folder of the footer navigation, so that the header menus of the
// other screenshots do not change.
$dataHandler = $process(['pages' => ['NEWarabicOnly' => [
    'pid' => $find('pages', 'title', 'Footer navigation', $uids['root']),
    'title' => 'Arabic pilgrims',
    'slug' => '/arabic-pilgrims',
    'hidden' => 0,
    'l18n_cfg' => 1,
]]]);
$uids['arabicOnly'] = $dataHandler->substNEWwithIDs['NEWarabicOnly'];
$arabicOnlyPage = $localize('pages', $uids['arabicOnly'], 2);
$process(['pages' => [$arabicOnlyPage => ['title' => 'الحجاج العرب', 'hidden' => 0]]]);
$uids['faqs'] = $find('pages', 'title', 'FAQs', $uids['root']);

// The list of the Camino routes in Arabic. Its items are inline elements,
// which the translation translates together with the list. An item that
// the English list gets afterwards is not translated yet, so the form of
// the translation offers to translate it.
$routes = $find('tt_content', 'header', 'Camino Routes', $uids['root']);
$uids['arabicRoutes'] = $localize('tt_content', $routes, 2);
$process(['tt_content' => [$uids['arabicRoutes'] => ['header' => 'طرق كامينو', 'hidden' => 0]]]);
$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_themecamino_list_item');
$items = $queryBuilder->select('uid')->from('tx_themecamino_list_item')
    ->where(
        $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($routes)),
        $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter(0)),
    )
    ->orderBy('sorting_foreign')->executeQuery()->fetchFirstColumn();
$process([
    'tt_content' => [$routes => ['tx_themecamino_list_elements' => implode(',', [...$items, 'NEWroute'])]],
    'tx_themecamino_list_item' => ['NEWroute' => ['pid' => $uids['root'], 'header' => 'Camino Inglés']],
]);

// The prefix "[Translate to Español:]" in the title of a translation of the
// route comparison. Camino switches the prefix off with
// TCEMAIN.default.disablePrependAtCopy, so this page switches it on again.
// Camino hides the TSconfig field from the form, which the DataHandler
// respects, so the field is written directly. The screenshot of the page
// properties translates the page, so that the Localization Overview shows
// it without a Spanish translation.
$uids['routeComparison'] = $find('pages', 'title', 'Camino Route Comparison', $uids['root']);
GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages')->update(
    'pages',
    ['TSconfig' => 'TCEMAIN.default.disablePrependAtCopy = 0'],
    ['uid' => $uids['routeComparison']],
);

// A group of translators, who may edit Spanish records only, for the
// screenshot of the language permissions
$dataHandler = $process(['be_groups' => ['NEWtranslators' => [
    'pid' => 0,
    'title' => 'Spanish translators',
    'allowed_languages' => '1',
]]]);
$uids['spanishTranslators'] = $dataHandler->substNEWwithIDs['NEWtranslators'];

// The labels of the Camino theme in Spanish and Arabic, where an installed
// language pack would put them. The language packs on the translation
// server have no translations of these labels yet.
$labels = [
    'es' => ['menu.label' => 'Menú', 'menu.main.label' => 'Menú principal', 'menu.language.label' => 'Menú de idiomas'],
    'ar' => ['menu.label' => 'القائمة', 'menu.main.label' => 'القائمة الرئيسية', 'menu.language.label' => 'قائمة اللغات'],
];
foreach ($labels as $language => $translations) {
    $units = '';
    foreach ($translations as $id => $target) {
        $units .= sprintf("      <trans-unit id=\"%s\">\n        <target>%s</target>\n      </trans-unit>\n", $id, $target);
    }
    $directory = Environment::getLabelsPath() . '/' . $language . '/theme_camino/Resources/Private/Language';
    GeneralUtility::mkdir_deep($directory);
    file_put_contents($directory . '/' . $language . '.messages.xlf', sprintf(
        "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<xliff xmlns=\"urn:oasis:names:tc:xliff:document:1.2\" version=\"1.2\">\n"
        . "  <file source-language=\"en\" target-language=\"%s\" datatype=\"plaintext\" original=\"EXT:theme_camino/Resources/Private/Language/messages.xlf\">\n"
        . "    <body>\n%s    </body>\n  </file>\n</xliff>\n",
        $language,
        $units,
    ));
}

// The uids differ between TYPO3 versions, so screenshots.mjs reads them here
GeneralUtility::mkdir_deep(Environment::getVarPath());
file_put_contents(Environment::getVarPath() . '/screenshot-records.json', json_encode($uids, JSON_PRETTY_PRINT) . "\n");
