<?php

class Evatix_Artists_Model_Resize extends Mage_Core_Model_Abstract {

    /**
     * Image Path
     * String <type>
     */
    protected $_imgPath;

    /**
     * Image Name
     * @var String
     */
    protected $_imageName;
    

    /**
     * AspectRatio
     * @var Bool
     */
    protected $_aspectRatio = TRUE;    

    /**
     * Set Image Path
     * @param string $imgPath
     */
    public function setImagePath($imgPath = '') {
        $this->_imgPath = $imgPath;
    }
    
    /**
     * Set AspectRatio
     * @param string $imgPath
     */
    public function keepAspectRatio($ratio = TRUE) {
        $this->_aspectRatio = $ratio;
    }

    /**
     * Set Image Name
     * @param string $imgName
     */
    public function setImageName($imgName = '') {
        $this->_imageName = $imgName;
    }
    /**
     * Returns the resized Image URL
     *
     * @param string $imgUrl - This is relative to the the media folder (custom/module/images/example.jpg)
     * @param int $x Width
     * @param int $y Height
     */
    public function getResizedUrl($x, $y=NULL){

        /**
         * Path with Directory Seperator
         */
        $this->_imgPath = str_replace("/", DS, $this->_imgPath);

        if($this->_imageName == ''){
            $thumbnailImage = Mage::getStoreConfig('catalog/placeholder/thumbnail_placeholder');
            //Mage::helper(‘core/url’)->getHomeUrl();
            if ($thumbnailImage) {
            $imageName = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product/placeholder/'.$thumbnailImage;
            } else {
            $imageName = Mage::getDesign()->getSkinUrl('images/catalog/product/placeholder/thumbnail.jpg');
            }
            
            return $imageName;
        }

        /**
         * Absolute full path of Image
         */
        $imgPathFull = Mage::getBaseDir("media").DS.$this->_imgPath.DS.$this->_imageName;

        /**
         * If Y is not set set it to as X
         */
        $widht = $x;
        $y?$height = $y:$height = $x;

        /**
         * Resize folder is widthXheight
         */
        $resizeFolder = $widht."X".$height;

        /**
         * Image resized path will then be
         */
        $imageResizedPath = Mage::getBaseDir("media").DS.$this->_imgPath.DS.$resizeFolder.DS.$this->_imageName;

        /**
         * First check in cache i.e image resized path
         * If not in cache then create image of the width=X and height = Y
         */
        if (!file_exists($imageResizedPath) && file_exists($imgPathFull)) {
            $imageObj = new Varien_Image($imgPathFull);
            $imageObj->constrainOnly(TRUE);
            $imageObj->keepAspectRatio($this->_aspectRatio);
            $imageObj->resize($widht,$height);
            $imageObj->save($imageResizedPath);
        }

        /**
         * Else image is in cache replace the Image Path with / for http path.
         */
        $imgUrl = str_replace(DS, "/", $this->_imgPath);

        /**
         * Return full http path of the image
         */
        return Mage::getBaseUrl("media").$imgUrl."/".$resizeFolder."/".$this->_imageName;
    }

}
