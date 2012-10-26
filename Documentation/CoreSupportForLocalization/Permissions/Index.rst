.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Permissions
^^^^^^^^^^^

For all backend users and groups you can define which backend
languages they can edit (exclusively). The permissions are enforced
over all tables with the [languageField] set.

|img-101|

Settings from groups and subgroups are all added together.

If a user has no “Limit to languages” checkboxes set at all he can
edit  *all languages* .

Regardless of “Limit to languages” all users can edit records with
“[All]” language.

Setting “Limit to languages” is not only good to protect translators
from editing other languages or default content - it is also helpful
to limit the confusion a user might have when faced with a Web>List
display that includes localizations from 10 other languages!

Make sure you use the Tools > User Admin module to check you users
permissions for language editing:

|img-102|

