// Takes the backend screenshots of the Frontend Localization Guide from a
// running TYPO3 instance with the demo site of the Camino theme.
//
// Usage: node screenshots.mjs [name ...]
// Without names, all screenshots are taken. A name is the path of the image
// below Documentation/Images/GeneratedScreenshots, without ".png". With DUMP
// set, the HTML of each screen is also written to var/, to look up selectors.
//
// The engine at the end is the one of the Editors Tutorial, so that a fix
// in one of them can be copied to the other.

import { existsSync, mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { dirname } from 'node:path';
import { chromium } from 'playwright';

const baseUrl = process.env.TYPO3_BASE_URL ?? 'http://localhost:8080';
const target = process.env.SCREENSHOT_TARGET ?? '../../Documentation/Images/GeneratedScreenshots';
// The administrator, unless a screenshot names another user
const defaultUser = 'j.doe';
const password = 'Screenshots-2026!';

const moduleUrl = (path, id) => `${baseUrl}/typo3/module/${path}?id=${id}`;
const editUrl = (table, uid) => `${baseUrl}/typo3/record/edit?edit[${table}][${uid}]=edit`;
// Space around an element, so its border does not touch the edge
const margin = 12;
// The width of the frontend screenshots, which the text shows side by side
const frontendWidth = 600;

// The uids of the records that create-records.php looked up
const { spanishTranslators, packingList, essentialItems, arabicItems, arabicToiletries, privacy, allLanguages, arabicRoutes } =
  JSON.parse(readFileSync('../../var/screenshot-records.json', 'utf8'));

// A field of a form, found by its label: the backend runs without debug
// mode, which would show the field names
const field = (name) => `.form-group:has([name$="[${name}]"]):not(:has(.form-group))`;
// An inline field of a form, which holds the forms of its items: the outer
// form group around the inline container
const inlineField = '.form-group:has(typo3-formengine-container-inline)';
// A palette of a form, found by its headline
const palette = (headline) => `.form-section:has(> .form-section-headline:text-is("${headline}"))`;

// Marks a button that the text names. A button in a group or a table cell
// is marked inside, as its neighbours would cut a frame around it.
const outline = (locator, inside = false) => locator.evaluate((element, inner) => {
  element.style.outline = '3px solid #ff8700';
  element.style.outlineOffset = inner ? '-3px' : '3px';
}, inside);

// A number in an orange circle at the lower right of an element, for a
// screenshot whose text explains the numbered parts
// Below the right corner, or below the left one where a neighbour follows
// closely on the right. 'before' puts it left of the element, centered on
// its height, so that the numbers of a screenshot line up.
const badge = (locator, number, side = 'right') => locator.evaluate((element, [text, side]) => {
  const box = element.getBoundingClientRect();
  const position = side === 'before'
    ? { left: box.left - 32, top: box.top + box.height / 2 - 13 }
    : { left: side === 'left' ? box.left - 14 : box.right - 12, top: box.bottom - 6 };
  const circle = element.ownerDocument.createElement('span');
  // The crop takes in every circle, see below
  circle.className = 'screenshot-badge';
  circle.textContent = text;
  Object.assign(circle.style, {
    position: 'fixed', left: `${position.left}px`, top: `${position.top}px`, width: '26px', height: '26px',
    borderRadius: '50%', background: '#ff8700', color: '#fff', font: 'bold 15px sans-serif', zIndex: '10000',
    display: 'flex', alignItems: 'center', justifyContent: 'center', boxShadow: '0 1px 3px rgba(0, 0, 0, 0.4)',
  });
  element.ownerDocument.body.appendChild(circle);
}, [String(number), side]);

// The language menu at the top of a module, its open list, and the
// translation wizard that it opens for a language in the Layout module
const languageMenu = (frame) => frame.locator('.module-docheader-navigation button.dropdown-toggle').last();
const languageList = '.module-docheader .dropdown-menu >> visible=true';
const openTranslation = (language) => async (frame) => {
  await languageMenu(frame).click();
  await frame.page().waitForTimeout(500);
  await frame.locator(languageList).getByText(language).first().click();
  await frame.page().locator('typo3-backend-modal dialog[open]').waitFor();
  await frame.page().waitForTimeout(1500);
};

const screenshots = {
  // The languages of the site, in the module where they are configured
  'SettingUpLanguages/SiteLanguages': {
    url: `${baseUrl}/typo3/module/site/configuration/edit?site=camino`,
    tab: 'Languages',
    menu: 'Sites',
    window: true,
    // The counter below the languages, so the last one is in the image
    until: 'typo3-backend-formengine-item-count',
  },
  // The Records module with the Arabic records: the translation of the
  // page, the buttons that translate a content element, and a translated
  // content element below its original. The backend keeps the languages of
  // a page, so Arabic is checked only if it is not checked yet.
  'SettingUpLanguages/RecordsTranslations': {
    url: moduleUrl('content/records', packingList),
    prepare: async (frame) => {
      if (!(await languageMenu(frame).innerText()).includes('(2)')) {
        await languageMenu(frame).click();
        await frame.page().waitForTimeout(500);
        await frame.locator(languageList).getByText('العربية').first().click();
        await frame.waitForLoadState('networkidle');
        await frame.page().waitForTimeout(1500);
      }
      // On the flags and the button, as the cells are much wider than their
      // content, and a circle on an Arabic title would cover its first word.
      // Left of the flags, as the language name follows on their right.
      await badge(frame.locator('#t3-table-pages_translated tbody tr td.col-localizationa .t3js-icon').first(), 1, 'left');
      await badge(frame.locator('#t3-table-tt_content tbody tr typo3-backend-localization-button').first(), 2);
      await badge(frame.locator(`#t3-table-tt_content tr[data-l10nparent="${essentialItems}"] td.col-localizationa .t3js-icon`).first(), 3, 'left');
    },
    from: '#t3-table-pages_translated',
    to: `#t3-table-tt_content tr[data-uid="${essentialItems}"] ~ tr >> nth=1`,
  },
  // The form of a translation, with the values of the default language
  // below the fields. The headlines only, as the text field of an instance
  // without the rich text editor shows the HTML.
  'CoreSupport/TranslationForm': {
    url: editUrl('tt_content', arabicItems),
    from: palette('Headlines'),
  },
  // A translation whose original changed since it was translated
  'CoreSupport/TranslationChanged': {
    url: editUrl('tt_content', arabicToiletries),
    from: field('header'),
  },
  // The step of the translation wizard that asks for the mode. The wizard
  // only opens, so the page stays without a Spanish translation.
  'LocalizedContent/TranslationMode': {
    url: moduleUrl('web/layout', packingList),
    prepare: async (frame) => {
      await openTranslation('Español')(frame);
      // The source language, then the content selection, then the mode
      const dialog = frame.page().locator('typo3-backend-modal dialog[open]');
      for (let step = 0; step < 2; step++) {
        await dialog.getByRole('button', { name: /^Next/ }).click();
        await frame.page().waitForTimeout(1500);
      }
      await frame.page().evaluate(() => document.activeElement?.blur());
    },
    modal: true,
  },
  // The imprint in English, in Arabic, which shows only what is
  // translated, and in Spanish, which falls back to the English text. The
  // text shows two of them side by side, so the window is as narrow as a
  // phone, and Camino shows its layout for small screens. From the header
  // of the website down to the end of the content.
  'LocalizedContent/FrontendEnglish': {
    loggedOut: true,
    url: `${baseUrl}/camino/imprint`,
    prepare: async (window) => window.setViewportSize({ width: frontendWidth, height: viewportHeight }),
    until: 'main p >> nth=1',
  },
  'LocalizedContent/FrontendStrict': {
    loggedOut: true,
    url: `${baseUrl}/camino/ar/imprint`,
    prepare: async (window) => window.setViewportSize({ width: frontendWidth, height: viewportHeight }),
    // The page title, as nothing follows it
    until: 'main >> xpath=preceding-sibling::*[1]',
  },
  'LocalizedContent/FrontendFallback': {
    loggedOut: true,
    url: `${baseUrl}/camino/es/imprint`,
    prepare: async (window) => window.setViewportSize({ width: frontendWidth, height: viewportHeight }),
    // The first lines of the English text are enough to show it
    until: 'main p >> nth=1',
  },
  // A content element for all languages, in its form
  'LocalizedContent/AllLanguagesField': {
    url: editUrl('tt_content', allLanguages),
    tab: 'Language',
    from: field('sys_language_uid'),
  },
  // The list items of a translated list: the button that translates the
  // items that are not translated yet, and such an item with its own button
  'LocalizedContent/InlineElements': {
    url: editUrl('tt_content', arabicRoutes),
    prepare: async (frame) => {
      const items = frame.locator(inlineField).first();
      await badge(items.getByRole('button', { name: 'Localize all records' }), 1);
      await badge(items.locator('.panel', { hasText: 'Camino Inglés' }).locator('button, a').last(), 2, 'left');
    },
    from: `${inlineField} >> nth=0`,
  },
  // The language menu in the header of the Camino website, open, on a page
  // with an Arabic translation, but without a Spanish one
  'LanguageMenu/CaminoLanguageMenu': {
    loggedOut: true,
    url: `${baseUrl}/camino/packing-list`,
    prepare: async (window) => {
      await window.locator('#header-language-button').click();
      await window.locator('#header-language-menu').waitFor();
      await window.waitForTimeout(500);
      await window.mouse.move(0, 0);
    },
    until: '#header-language-menu',
  },
  // The languages that a group of translators may edit. The tables above
  // fill more than the window, so the palette is scrolled into view.
  'Permissions/LimitToLanguages': {
    url: editUrl('be_groups', spanishTranslators),
    tab: 'Record Permissions',
    prepare: async (frame) => {
      await frame.locator(palette('Language Permissions')).scrollIntoViewIfNeeded();
    },
    from: palette('Language Permissions'),
  },
  // A content element for all languages in the Layout module, which
  // compares the languages of the page side by side. The backend keeps the
  // view for the next pages, so this screenshot comes last.
  'LocalizedContent/AllLanguagesLayout': {
    url: `${moduleUrl('web/layout', privacy)}&viewMode=2&languages[]=0&languages[]=1&languages[]=2`,
    prepare: async (frame) => {
      await outline(frame.locator(`#element-tt_content-${allLanguages} .t3-page-ce-element`));
    },
    window: true,
    // The content element, as the columns of the page go on below it
    until: `#element-tt_content-${allLanguages}`,
  },
};

// Hides the page tree, unless the screenshot needs it, and collapses the
// groups of the module menu, except the one of the module, which stays open:
// the screenshot shows where to find the module and stays narrow enough for
// the documentation page. The group is named, because not every view marks
// its module as active in time, such as the history.
const collapseNavigation = async (pageTree, menu) => {
  const hideTree = page.locator('typo3-backend-content-navigation-toggle[action="collapse"]');
  let clicked = false;
  if (!pageTree && await hideTree.isVisible()) {
    await hideTree.click();
    clicked = true;
  }
  const groups = page.locator('button[data-modulemenu-collapsible="true"]');
  for (let index = 0; index < await groups.count(); index++) {
    const group = groups.nth(index);
    // A narrow window hides the menu
    if (!await group.isVisible()) {
      continue;
    }
    const open = await group.getAttribute('aria-expanded') === 'true';
    const keep = (await group.innerText()).trim() === menu;
    if (open !== keep) {
      await group.click();
      clicked = true;
    }
  }
  // The clicked buttons would look selected. Without a click the focus
  // stays, as it can be part of the screenshot, such as the message of the
  // browser about an invalid field.
  if (clicked) {
    await page.evaluate(() => document.activeElement?.blur());
  }
};

// Tall, so that most pages fit without scrolling
const viewportHeight = 2000;

const browser = await chromium.launch();
// One logged in window per user, opened when a screenshot needs it
const windows = {};
const login = async (username) => {
  if (windows[username] === undefined) {
    const window = await browser.newPage({ viewport: { width: 1280, height: viewportHeight } });
    await window.goto(`${baseUrl}/typo3/`);
    await window.fill('#t3-username', username);
    await window.fill('#t3-password', password);
    await window.click('#t3-login-submit');
    await window.waitForURL(/\/typo3\/(main|module)/);
    windows[username] = window;
  }
  return windows[username];
};
let page;

// A new image differs from the old one in a few pixels even when nothing
// changed, such as at the edge of a rounded corner. Below this number of
// pixels, the old image stays, so a commit holds only real changes.
const unchangedPixels = 10;
let comparison;
const changedPixels = async (before, after) => {
  comparison ??= await browser.newPage();
  return comparison.evaluate(async ([before, after]) => {
    const load = (data) => new Promise((resolve) => {
      const image = new Image();
      image.onload = () => resolve(image);
      image.src = `data:image/png;base64,${data}`;
    });
    const images = [await load(before), await load(after)];
    const { width, height } = images[0];
    if (images[1].width !== width || images[1].height !== height) {
      return Infinity;
    }
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const context = canvas.getContext('2d');
    const [a, b] = images.map((image) => {
      context.drawImage(image, 0, 0);
      return context.getImageData(0, 0, width, height).data;
    });
    let count = 0;
    for (let i = 0; i < a.length; i += 4) {
      if (Math.abs(a[i] - b[i]) + Math.abs(a[i + 1] - b[i + 1]) + Math.abs(a[i + 2] - b[i + 2]) > 30) {
        count++;
      }
    }
    return count;
  }, [before.toString('base64'), after.toString('base64')]);
};
// Writes the image, unless it looks the same as the one already there
const save = async (name, image) => {
  const path = `${target}/${name}.png`;
  if (existsSync(path) && await changedPixels(readFileSync(path), image) < unchangedPixels) {
    console.log(`${name}.png (unchanged)`);
    return;
  }
  mkdirSync(dirname(path), { recursive: true });
  writeFileSync(path, image);
  console.log(`${name}.png`);
};

const names = process.argv.length > 2 ? process.argv.slice(2) : Object.keys(screenshots);
for (const name of names) {
  const screenshot = screenshots[name];
  if (screenshot === undefined) {
    throw new Error(`Unknown screenshot "${name}"`);
  }
  if (screenshot.loggedOut) {
    // A window of its own, without the session of the other screenshots
    const context = await browser.newContext({ viewport: { width: 1280, height: 900 }, extraHTTPHeaders: screenshot.headers });
    const window = await context.newPage();
    await window.goto(screenshot.url);
    await window.waitForLoadState('networkidle');
    await screenshot.prepare(window);
    await window.waitForTimeout(500);
    let clip;
    if (screenshot.until) {
      // The whole width of the window, down to the element named
      const until = await window.locator(screenshot.until).first().boundingBox();
      clip = { x: 0, y: 0, width: 1280, height: until.y + until.height + margin };
    } else {
      const box = await window.locator(screenshot.from).first().boundingBox();
      clip = { x: box.x - margin, y: box.y - margin, width: box.width + 2 * margin, height: box.height + 2 * margin };
    }
    const image = await window.screenshot({ clip });
    await context.close();
    await save(name, image);
    continue;
  }
  page = await login(screenshot.user ?? defaultUser);
  await page.setViewportSize({
    width: screenshot.width ?? 1280,
    height: screenshot.height ?? viewportHeight,
  });
  await page.goto(screenshot.url);
  await page.waitForLoadState('networkidle');
  const frame = page.frame({ name: 'list_frame' });
  await frame.waitForLoadState('networkidle');
  // The backend remembers the last tab of a form, so a form opens the tab
  // that the screenshot names, or the first one
  const tab = frame.getByRole('tab', { name: screenshot.tab ?? 'General', exact: true });
  if (await tab.count() > 0) {
    await tab.click();
  }
  // Also for a part of a module: the module frame is too narrow for the
  // columns of the Layout module next to the page tree
  await collapseNavigation(screenshot.pageTree, screenshot.menu ?? 'Content');
  // A hovered button would look selected, unless hovering is the point
  if (!screenshot.hover) {
    await page.mouse.move(0, 0);
  }
  if (screenshot.prepare) {
    await screenshot.prepare(frame);
    // A view opened by "prepare" can change the menu again. Clicks would
    // close a context menu, so only a changed menu is clicked. Behind a
    // dialog, the menu does not show and cannot be clicked.
    if (!screenshot.modal) {
      await collapseNavigation(screenshot.pageTree, screenshot.menu ?? 'Content');
    }
  }
  await page.waitForTimeout(500);
  if (process.env.DUMP) {
    writeFileSync(`../../var/${name.replaceAll('/', '_')}.html`, await frame.content());
    writeFileSync(`../../var/${name.replaceAll('/', '_')}-window.html`, await page.content());
  }
  if (screenshot.frontend) {
    // The page in the frontend, cut to the element named
    await page.goto(screenshot.frontend);
    await page.waitForLoadState('networkidle');
    const box = await page.locator(screenshot.frontendElement).first().boundingBox();
    await save(name, await page.screenshot({
      clip: { x: box.x - margin, y: box.y - margin, width: box.width + 2 * margin, height: box.height + 2 * margin },
    }));
    continue;
  }
  if (screenshot.modal) {
    // Only the dialog: the page behind it does not belong to the example
    await save(name, await page.locator('typo3-backend-modal dialog[open]').screenshot());
    continue;
  }
  if (screenshot.window) {
    // The whole backend. It ends below the element named in "until", so the
    // image takes no more room on the page than it needs.
    let clip = screenshot.clip && { x: 0, y: 0, ...screenshot.clip };
    if (screenshot.until) {
      const until = await frame.locator(screenshot.until).last().boundingBox();
      const viewport = page.viewportSize();
      clip = { x: 0, y: 0, width: viewport.width, height: Math.min(until.y + until.height + 4, viewport.height) };
    }
    await save(name, await page.screenshot({ clip }));
    continue;
  }
  // Bounding boxes are relative to the page, also for elements in the frame
  // The page tree and dialogs are outside of the module frame
  const scope = screenshot.outside ? page : frame;
  const boxes = [
    await scope.locator(screenshot.from).first().boundingBox(),
    screenshot.toOutside
      ? await page.locator(screenshot.toOutside).last().boundingBox()
      : await scope.locator(screenshot.to ?? screenshot.from).last().boundingBox(),
  ];
  // Numbered circles, which can stick out of the elements
  for (const circle of await scope.locator('.screenshot-badge').all()) {
    boxes.push(await circle.boundingBox());
  }
  // Other elements that stick out, such as the tooltip of a drag
  for (const selector of screenshot.include ?? []) {
    boxes.push(await page.locator(selector).first().boundingBox());
  }
  const space = screenshot.margin ?? margin;
  const left = Math.max(Math.min(...boxes.map((box) => box.x)) - space - (screenshot.left ?? 0), 0);
  const top = Math.max(Math.min(...boxes.map((box) => box.y)) - space, 0);
  await save(name, await page.screenshot({
    clip: {
      x: left,
      y: top,
      width: Math.max(...boxes.map((box) => box.x + box.width)) + space - left,
      height: Math.max(...boxes.map((box) => box.y + box.height)) + space - top,
    },
  }));
}
await browser.close();
