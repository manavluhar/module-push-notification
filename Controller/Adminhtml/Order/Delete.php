<?php

namespace Codilar\PushNotification\Controller\Adminhtml\Order;

use Codilar\PushNotification\Api\OrderTemplateManagementInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Message\ManagerInterface;

/**
 * class Delete
 *
 * @description Delete Template
 * @author   Codilar Team Player <ankith@codilar.com>
 * @license  Open Source
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 * Controller for Delete Template
 */

class Delete extends Action
{
    const ADMIN_RESOURCE = "Codilar_PushNotification::pushnotify_order_template";
    /**
     * @var OrderTemplateManagementInterface
     */
    private $templateManagement;
    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param OrderTemplateManagementInterface $templateManagement
     * @param ManagerInterface $manager
     */
    public function __construct(
        Action\Context $context,
        OrderTemplateManagementInterface $templateManagement,
        ManagerInterface $manager
    ) {
        parent::__construct($context);
        $this->templateManagement = $templateManagement;
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('template_id');
        if ($this->templateManagement->load($id)->getId()) {
            if ($this->templateManagement->deleteById($id)) {
                $this->manager->addSuccessMessage('Template with Id ' . $id . ' has been successfully deleted');
            } else {
                $this->manager->addErrorMessage('Something went wrong');
            }
        } else {
            $this->manager->addErrorMessage('Template does not exists');
        }
        return $this->resultRedirectFactory->create()->setPath('pushnotify/order/view');
    }
}
