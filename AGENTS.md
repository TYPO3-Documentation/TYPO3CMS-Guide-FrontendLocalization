# AGENTS.md — Frontend Localization Guide

## Repo structure

```
Documentation/                   # the actual manual (reST source, published to docs.typo3.org)
Build/Screenshots/               # takes the generated screenshots, see below
Build/Scripts/runTests.sh        # runs the containers that make install, make screenshots, and make test-extension need
Documentation/CodeSnippets/      # the example extension, whose files the manual includes
Tests/Functional/                # tests that the example extension installs
CONTRIBUTING.md                  # how to contribute
```

## Commands

- `make docs` — render the manual locally with Docker
- `make test-docs` — render in minimal-test mode (the same validation CI runs); use this to validate any change before committing
- `make install` — install the TYPO3 Core packages into `.Build/` that
  `make screenshots` needs; run it once in a new worktree
- `make screenshots` — take the screenshots listed in
  `Build/Screenshots/screenshots.mjs` from a throwaway TYPO3 instance;
  `Build/Scripts/runTests.sh -s screenshots Permissions/LimitToLanguages`
  takes only the named ones
- `make test-extension` — install the example extension in
  `Documentation/CodeSnippets/my_extension/` in a functional test, and
  check that its TCA needs no migration and that its labels exist; CI runs
  it on every push
- `pre-commit run --all-files` — apply the whitespace hooks
  (`trailing-whitespace`, `end-of-file-fixer`) configured in
  `.pre-commit-config.yaml`; `pre-commit install` wires them into `git commit`

## Scope

This manual covers making a TYPO3 *website* multilingual: site languages,
page and content translation, language menus, localized labels and character
sets. Its audience is integrators building a translated frontend.

Do not confuse it with the
[Localization Team Guidelines](https://github.com/TYPO3-Documentation/localization-team-guidelines),
which is about the process of translating TYPO3 itself on Crowdin.

Language handling changed substantially across TYPO3 versions, so verify
site configuration keys, TypoScript properties and fallback behaviour
against the Core source of the version being documented rather than from
memory.

## Generated screenshots

The screenshots in `Documentation/Images/GeneratedScreenshots/` come from a
TYPO3 instance with the demo site of the Camino theme, which the Core ships
from TYPO3 v14 on. The branch `13.4` keeps its screenshots in
`Documentation/Images/ManualScreenshots/`. `create-records.php` adds the
languages of the Editors Tutorial to the site, so that the screenshots of
both manuals show the same website: English as the default language,
Español (1), and العربية (2), which is written from right to left. Unlike
in the Editors Tutorial, Español falls back to English, for the example of
a fallback in the frontend. `create-records.php` also writes Spanish and
Arabic labels of the Camino theme into the labels path, where a language
pack would put them, as the language packs on the translation server have
no translations of these labels yet.
The backend runs without debug mode, so it looks as an editor sees it.
Screenshots are taken as the administrator `j.doe`.

The setup and the engine at the end of `screenshots.mjs` come from the
[Editors Tutorial](https://github.com/TYPO3-Documentation/TYPO3CMS-Tutorial-Editors).
Its `AGENTS.md` explains the options of a screenshot entry, such as
`from`/`to`, `window`, `modal`, `prepare`, and `tab`. Keep the engine the
same in both repositories, so that a fix in one can be copied to the other.

To add a screenshot:

1.  If a screenshot needs a record of its own, such as a translation, add it
    to `Build/Screenshots/create-records.php`. Find the records of the theme
    by their title, because their uids can differ between TYPO3 versions,
    and export the ones a screenshot needs in the list at the end.
2.  Add an entry to `Build/Screenshots/screenshots.mjs`. Mark what the text
    names with an orange frame, and number the parts that the text lists
    with an orange circle with a number. Draw no arrows. Copy the helpers
    for this, `outline()` and `badge()`, from the Editors Tutorial when a
    screenshot first needs them.
3.  Take only that screenshot, then all of them once. A run keeps an image
    that differs from the old one in fewer than 10 pixels, because a new
    image is never exactly the same, even when nothing changed. Review the
    changed images with the skill `typo3-docs-screenshot-review`, and
    commit only the ones that really changed. List an image that changes
    on every run in `Build/Screenshots/flaky-screenshots.txt`.
4.  Screenshots that a script cannot take stay in
    `Documentation/Images/ManualScreenshots/`.

## Documentation writing rules

Follow the official TYPO3 documentation writing conventions (see
https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-HowToDocument):

1. **reST, not Markdown** — everything under `Documentation/` is reStructuredText.
2. **Sentence case headlines** — first word and proper nouns only:
   https://docs.typo3.org/permalink/h2document:content-styleguide-title-capitalization
3. **4-space indentation** for directive bodies, 2 spaces after `..` markers:
   https://docs.typo3.org/permalink/h2document:cgl-indenting
4. **Single backticks over double**, unless the content needs a literal
   backtick: https://docs.typo3.org/permalink/h2document:inline-code
5. **Every headline needs a `..  _anchor:` target** directly above it
   (https://docs.typo3.org/permalink/h2document:link-anchor), and anchors are
   never removed once published
   (https://docs.typo3.org/permalink/h2document:anchor-persistence).
6. **Link TYPO3 documentation with permalinks**, also inside this manual,
   and give every link its own link text:
   https://docs.typo3.org/permalink/h2document:permalinks. Do not suggest
   replacing a permalink with `:ref:`.
7. **Validate before committing** — run `make test-docs`, and run the
   pre-commit hooks (see Commands).
8. **Never commit or push without being asked.**

## Commit message format

Follow https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/Howto/EditLocal.html:

- Prefix the subject line with `[TASK]`, `[BUGFIX]`, or `[FEATURE]`,
  followed by a short, imperative summary.
- Explain *why* the change is needed in the body — the diff already shows
  what changed.
- End with a `Signed-off-by: Your Name <email>` trailer.
- If AI assistance went beyond basic spelling/grammar checks, add an
  `Assisted-by: <tool/model name> <contact>` trailer, e.g.
  `Assisted-by: Claude Sonnet 5 <noreply@anthropic.com>`.
- If the change should be backported, add a `Releases: main, 14.3, 13.4`
  trailer listing every branch it applies to. This repo maintains multiple
  LTS branches, so `Releases:` applies here — including for changes to
  these agent instruction files themselves, since agents may be working
  on an older branch where a change is still relevant.

## Pull requests

- When a commit is the only commit in the PR, the PR title and body must
  match the commit's subject and body exactly.
- When the commit message has a `Releases:` trailer naming branches beyond
  `main`, attach the matching `backport <version>` label (e.g.
  `backport 14.3`, `backport 13.4`) to the PR for each of those branches
  when opening it — don't wait to be asked.
- Adding labels requires triage/write access, which an external
  contributor's account (e.g. a fork-based PR) usually doesn't have. If
  attaching a label fails for that reason, don't treat it as an error and
  don't note the failure in the PR — just skip it silently.

## For maintainers

- A PR opened by an agent may be missing its `backport <version>` labels
  if the agent's account lacked permission to add them. Check for and add
  any missing backport labels yourself before/when merging such a PR.

## References

- [TYPO3CMS-Guide-HowToDocument](https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-HowToDocument) — official writing style guide and reST reference
- https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/Howto/EditLocal.html — commit/PR conventions
