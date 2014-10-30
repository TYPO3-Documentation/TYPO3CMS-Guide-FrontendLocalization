.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
------------


.. _about:

About this document
^^^^^^^^^^^^^^^^^^^

Creating a website in multiple languages with TYPO3 can be done in a
variety of ways - as usual. Unfortunately all the options are hard to
understand unless described in a context where used. In addition, even
if you understand the context you might like to get some suggestions
for what others have found to be best-practices.

This document tries to document everything there is to know about
localization of websites with TYPO3. It should ideally mention every
feature and what it is good for. You must however make sure to use
reference documents like TSref, TYPO3 Core API etc. to look up the
exact syntaxes for the features mentioned.

Both the classic column-based web designs and the modern TemplaVoilà
approaches are covered by the document.

Since the main goal of this document is to include all knowledge areas
of localization it might suffer from bad composition where advanced
content is mixed in here and there. A later revision could maybe make
up for this by prioritizing content better. For now that has not been
a priority. On the other hand you will come out as an expert in the
other end.


.. _about-paradigms:

Free and Bound paradigms of localization with TemplaVoilà
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""

During the work with this document I realized that it should have been
around many years ago; it turned out that many people are already
localizing websites but in a less efficient way than it could have
been done. It lead to a lot of debate and eventually we realized that
there exists different paradigms of how localization should be done.
Since many existing websites are using a paradigm that is not
recommended we decided to integrate configurable support for this in
order to stay backwards compatible.



.. _about-terms:

Localization and Translation
""""""""""""""""""""""""""""

The two terms are often used to express the same. Also in this
document. But more precisely this is how I understand the difference:

- "**Translation"** means that a specific composition of words are
  translated to another language. In other words: If there is a header
  and an image in the default language, so there will be in the
  translation. No more, no less.

- "**Localization"** means more broadly that a page is represented in
  another language. This of course means information in that language
  ("translation") but could also include alternative templates,
  additional composition of content directed to another audience etc. In
  other words: There might be another number of headers and images than
  in the default language.

TYPO3 handles both types of approaches, but this flexibility has the
price that you need to read this document to find out which approach
to choose for your project!


.. _credits:

Credits
^^^^^^^

This document was originally written by Kasper Skårhøj. It is currently
not maintained.


.. _credits-dedication:

Dedication
""""""""""

I want to dedicate this document to every native English speaker who
has over the years learned to live with my gazillions of documents
full of weird syntactical compositions and understood that it was a
privilege that a non-native like me after all chose to communicate in
a foreign language to the best of my abilities.

\- kasper



.. _feedback:

Feedback
^^^^^^^^

For general questions about the documentation get in touch by writing
to `documentation@typo3.org <mailto:documentation@typo3.org>`_ .

If you find a bug in this manual, please be so kind as to check the
online version on http://docs.typo3.org/typo3cms/FrontendLocalizationGuide/.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just file an issue
using the bug tracker: https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-FrontendLocalization/issues.


Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.
If you want to support us, please join the documentation
mailing list/forum (http://forum.typo3.org/index.php/f/44/).
