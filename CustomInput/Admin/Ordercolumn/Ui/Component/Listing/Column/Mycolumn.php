<?php
namespace CustomInput\Admin\Ordercolumn\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Sales\Api\OrderRepositoryInterface;

class Mycolumn extends Column
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * Mycolumn constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, // Corrected argument type
        array $components = [],
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $orderId = $item['entity_id'];
                $email = $this->getOrderEmail($orderId);

                // Create an input field HTML with the retrieved email
                $inputFieldHtml =  $email ;
                $item[$this->getData('name')] = $inputFieldHtml;
            }
        }
        return $dataSource;
    }

    protected function getOrderEmail($orderId)
    {
        try {
            $order = $this->orderRepository->get($orderId);
            return $order->getCustomerEmail();
        } catch (\Exception $e) {
            // Handle exception (e.g., order not found)
            return '';
        }
    }
}
