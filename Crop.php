<?php
    class Crop
    {
        //VARIABLES
        private $_directory;
        private $_x;
        private $_y;
        private $_height;
        private $_width;
        private $_endImg;

        //SIZE CONST
        const CROP_XS = '400/800';
        const CROP_SM = '300/200';
        const CROP_MD = '750/500';

        //LOCATION CONST
        const CROP_START = '0/0';
        const CROP_MIDDLE = '200/50';
        const CROP_END = '500/100';


        public function __construct($size, $location, $directory){
            $this->setSize($size);
            $this->setLocation($location);
            $this->_directory = $directory;
        }

        public function setSize($size) {
            if (in_array($size, [self::CROP_XS, self::CROP_SM, self::CROP_MD])) {
                $sizes = explode('/', $size);
                $this->_width = $sizes[0];
                $this->_height = $sizes[1];
            }
        }

        public function setLocation($location){
            if (in_array($location, [self::CROP_START, self::CROP_MIDDLE, self::CROP_END])) {
                $locations = explode('/', $location);
                $this->_x = $locations[0];
                $this->_y = $locations[1];
            }
        }

        public function cropImg($image){
            $extension = substr(strrchr($image,'.'),1);

            if($extension === 'png'){
                $im = imagecreatefrompng($image);
            }
            else {
                $im = imagecreatefromjpeg($image);
            }

            $endImg = $this->_directory.time().'42.png';
            $cropImg = imagecrop($im, ['x' => $this->_x, 'y' => $this->_y, 'width' => $this->_width, 'height' => $this->_height]);
            if ($endImg !== FALSE) {
                imagepng($cropImg, $endImg);
                imagedestroy($cropImg);
                $this->_endImg = $endImg;
            }
            imagedestroy($im);
        }
        public function getEndImg() {
            return $this->_endImg;
        }
    }
?>