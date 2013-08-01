Magento PGP
===========

Secure emails in Magento via PGP / GPG email encryption.

Customers and shop owners can upload their public key and each email sent to their address will be automatically encrypted.

This module uses:

- PHP based https://github.com/jasonhinkle/php-gpg, if your hosting provider has disabled exec()
- CLI based [http://pear.php.net/package/Crypt_GPG] [PEAR SVN](https://svn.php.net/repository/pear/packages/Crypt_GPG) via the native gpg installation

[https://prism-break.org/#email-encryption](https://prism-break.org/#email-encryption)

Used Versions
-------------

- Crypt_GPG-1.4.0b4.tgz
- https://github.com/jasonhinkle/php-gpg/commit/985bcdbfc16fb839d833d33a8f4c6057e621fbfe

Author
------

[Cyrill Schumacher](https://github.com/SchumacherFM)

Made in Sydney, Australia :-)

License GPL
-----------
[http://www.gnu.org/licenses/gpl.html](http://www.gnu.org/licenses/gpl.html)
