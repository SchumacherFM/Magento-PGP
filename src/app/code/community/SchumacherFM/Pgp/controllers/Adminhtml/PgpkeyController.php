<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Adminhtml_PgpkeyController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Banners list
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('PGP Keys'));

        $this->loadLayout();
        $this->_setActiveMenu('system/pgp');
        $this->renderLayout();
    }

    /**
     * Create new banner
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit action
     *
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var SchumacherFM_Pgp_Model_Pubkeys $model */
        $model = $this->_initBanner();
        if (!$model->getId() && $id) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pgp')->__('This pgp key no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New PGP Key'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->loadLayout();
        $this->_setActiveMenu('system/pgp');
        $this->_addBreadcrumb($id ? Mage::helper('pgp')->__('Edit PGP Key') : Mage::helper('pgp')->__('New PGP Key'),
            $id ? Mage::helper('pgp')->__('Edit PGP Key') : Mage::helper('pgp')->__('New PGP Key'))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', FALSE);
        if ($data = $this->getRequest()->getPost()) {

            /** @var SchumacherFM_Pgp_Model_Pubkeys $model */
            $model = $this->_initBanner();

            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pgp')->__('This banner no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            /**
             * extract key id and email address from pub key ...
             */

            // save model
            try {
                if (!empty($data)) {
                    $model->addData($data);
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                }
                $model->save();
                Mage::getSingleton('adminhtml/session')->setFormData(FALSE);
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pgp')->__('The PGP Key has been saved.'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = TRUE;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('Unable to save the PGP Key.'));
                $redirectBack = TRUE;
                Mage::logException($e);
            }
            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     *
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('pgp/pubkeys');
                $model->load($id);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pgp')->__('The PGP Key has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('An error occurred while deleting PGP Key data. Please review log and try again.'));
                Mage::logException($e);
                // save data in session
                // redirect to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pgp')->__('Unable to find a PGP Key to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Delete specified banners using grid massaction
     *
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('banner');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select banner(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('pgp/banner')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('An error occurred while mass deleting banners. Please review log and try again.'));
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Load from request
     *
     * @param string $idFieldName
     *
     * @return SchumacherFM_Pgp_Model_Pubkeys $model
     */
    protected function _initBanner($idFieldName = 'id')
    {
        $this->_title($this->__('System'))->_title($this->__('PGP Keys'));

        $id    = $this->getRequest()->getParam($idFieldName);
        $model = Mage::getModel('pgp/pubkeys');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('current_pubkeys')) {
            Mage::register('current_pubkeys', $model);
        }
        return $model;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/pgp');
    }

    /**
     * Render Banner grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}
