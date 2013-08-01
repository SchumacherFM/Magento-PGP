<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */

$installer = $this;
/** @var SchumacherFM_Pgp_Model_Resource_Setup $installer */
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('pgp/keys'))
    ->addColumn('key_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'identity' => FALSE,
        'nullable' => FALSE,
        'primary'  => TRUE,
    ), 'Key ID')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'unsigned' => TRUE,
        'nullable' => FALSE,
        'default'  => '0',
    ), 'Email Address')
    ->addColumn('public_key', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable' => FALSE,
    ), 'PGP Public Key')
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Modification Time')
    ->addIndex(
        $installer->getIdxName('pgp/keys', array('email')),
        array('email'), array('type' => 'UNIQUE'))
    ->setComment('PGP Public Key Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();