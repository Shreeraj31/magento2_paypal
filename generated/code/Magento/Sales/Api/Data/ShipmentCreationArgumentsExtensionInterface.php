<?php
namespace Magento\Sales\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface
 */
interface ShipmentCreationArgumentsExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getSourceCode();

    /**
     * @param string $sourceCode
     * @return $this
     */
    public function setSourceCode($sourceCode);

    /**
     * @return string|null
     */
    public function getShippingLabel();

    /**
     * @param string $shippingLabel
     * @return $this
     */
    public function setShippingLabel($shippingLabel);

    /**
     * @return string|null
     */
    public function getExtShipmentId();

    /**
     * @param string $extShipmentId
     * @return $this
     */
    public function setExtShipmentId($extShipmentId);

    /**
     * @return string|null
     */
    public function getExtReturnShipmentId();

    /**
     * @param string $extReturnShipmentId
     * @return $this
     */
    public function setExtReturnShipmentId($extReturnShipmentId);

    /**
     * @return string|null
     */
    public function getExtLocationId();

    /**
     * @param string $extLocationId
     * @return $this
     */
    public function setExtLocationId($extLocationId);

    /**
     * @return string|null
     */
    public function getExtTrackingUrl();

    /**
     * @param string $extTrackingUrl
     * @return $this
     */
    public function setExtTrackingUrl($extTrackingUrl);

    /**
     * @return string|null
     */
    public function getExtTrackingReference();

    /**
     * @param string $extTrackingReference
     * @return $this
     */
    public function setExtTrackingReference($extTrackingReference);
}
