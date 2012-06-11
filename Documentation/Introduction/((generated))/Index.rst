

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


((generated))
^^^^^^^^^^^^^

“Free” and “Bound” paradigms of localization with TemplaVoilà
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

During the work with this document I realized that it should have been
around many years ago; it turned out that many people are already
localizing websites but in a less efficient way than it could have
been done. It lead to a lot of debate and eventually we realized that
there exists different paradigms of how localization should be done.
Since many existing websites are using a paradigm that is not
recommended we decided to integrate configurable support for this in
order to stay backwards compatible.


“Localization” and “Translation”
""""""""""""""""""""""""""""""""

The two terms are often used to express the same. Also in this
document. But more precisely this is how I understand the difference:

- “ **Translation”** means that a specific composition of words are
  translated to another language. In other words: If there is a header
  and an image in the default language, so there will be in the
  translation. No more, no less.

- “ **Localization”** means more broadly that a page is represented in
  another language. This of course means information in that language
  (“translation”) but could also include alternative templates,
  additional composition of content directed to another audience etc. In
  other words: There might be another number of headers and images than
  in the default language.

TYPO3 handles both types of approaches, but this flexibility has the
price that you need to read this document to find out which approach
to choose for your project!


Dedication
""""""""""

I want to dedicate this document to every native English speaker who
has over the years learned to live with my gazillions of documents
full of weird syntactical compositions and understood that it was a
privilege that a non-native like me after all chose to communicate in
a foreign language to the best of my abilities.

\- kasper

