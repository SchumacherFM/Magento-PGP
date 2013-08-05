Magento PGP
===========

Secure emails in Magento via PGP / GPG email encryption.

Customers and shop owners can upload their public key and each email sent to their address will be automatically encrypted.


This module uses:

- PHP based https://github.com/jasonhinkle/php-gpg, if your hosting provider has disabled exec()
- CLI based [http://pear.php.net/package/Crypt_GPG] [PEAR SVN](https://svn.php.net/repository/pear/packages/Crypt_GPG) via the native gpg installation

[https://prism-break.org/#email-encryption](https://prism-break.org/#email-encryption)

Restrictions
------------

Sending of pure HTML emails is not possible ... ok it is ... but there needs to be mayor refactorings
of the Zend_Mail classes. Due to the different Magento and Zend versions this could be quite a challange.

At the moment I have implemented a PHP class [https://github.com/mtibben/html2text] which converts HTML into plain text.
This plain text lacks only of nice output tables ... so I am still looking for a good PHP based HTML to text converter.

The PHP based gpg module cannot handle comments in a key. So please remove comments before submitting a key.
The CLI based gpg module has no restrictions.

Used Versions
-------------

- Crypt_GPG-1.4.0b4.tgz
- https://github.com/jasonhinkle/php-gpg/commit/985bcdbfc16fb839d833d33a8f4c6057e621fbfe

Todo
----

- translations
- sign
- sign and encrypt

Printscreens
------------

### Frontend customer account section

![image](https://raw.github.com/SchumacherFM/Magento-PGP/master/doc/fe_customer_key_edit.png)

### Backend System Configuration

![image](https://raw.github.com/SchumacherFM/Magento-PGP/master/doc/be_config.png)

### Backend PGP Key Management (List)

![image](https://raw.github.com/SchumacherFM/Magento-PGP/master/doc/be_key_list.png)

### Backend PGP Key Management (Edit)

![image](https://raw.github.com/SchumacherFM/Magento-PGP/master/doc/be_key_edit.png)



Author
------

[Cyrill Schumacher](https://github.com/SchumacherFM)

Made in Sydney, Australia :-)

License GPL
-----------
[http://www.gnu.org/licenses/gpl.html](http://www.gnu.org/licenses/gpl.html)
