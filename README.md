Magento PGP
===========

Module Idea.

Secure emails in Magento via PGP / GPG email encryption.

Customers and shop owners can upload their public key and each email sent to their address will be automatically encrypted.

This module uses:

- PHP based https://github.com/jasonhinkle/php-gpg, if your hosting provider has disabled exec()
- CLI based http://pear.php.net/package/Crypt_GPG via the native gpg installation

[https://prism-break.org/#email-encryption](https://prism-break.org/#email-encryption)

