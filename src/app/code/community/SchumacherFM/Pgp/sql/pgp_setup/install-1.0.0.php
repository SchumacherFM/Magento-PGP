<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */

$installer = $this;
/** @var SchumacherFM_Pgp_Model_Resource_Setup $installer */
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('pgp/pgp_public_keys'))
    ->addColumn('key_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
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
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Updated Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Created Time')
    ->addIndex(
        $installer->getIdxName('pgp/pgp_public_keys', array('key_id')),
        array('key_id'), array('type' => 'UNIQUE'))
    ->addIndex(
        $installer->getIdxName('pgp/pgp_public_keys', array('email')),
        array('email'), array('type' => 'UNIQUE'))
    ->setComment('PGP Public Key Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();