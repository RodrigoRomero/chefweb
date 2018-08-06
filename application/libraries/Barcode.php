<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Rodrigo Romero
 * @version     1.0.0
 */



// Including all required classes
require_once(APPPATH.'libraries/barCode/class/BCGFontFile.php');
require_once(APPPATH.'libraries/barCode/class/BCGColor.php');
require_once(APPPATH.'libraries/barCode/class/BCGDrawing.php');



// Including the barcode technology

require_once(APPPATH.'libraries/barCode/class/BCGean13.barcode.php');


class barCode{


    function save($codigo_barras,$full_code){

        // Loading Font
        $font = new BCGFontFile(APPPATH.'libraries/barCode/class/font/Arial.ttf', 10);



        // The arguments are R, G, B for color.

        $color_black = new BCGColor(0, 0, 0);

        $color_white = new BCGColor(255, 255, 255);



        $drawException = null;

        try {

        	$code = new BCGean13();

        	$code->setScale(2); // Resolution

        	$code->setThickness(25); // Thickness

        	$code->setForegroundColor($color_black); // Color of bars

        	$code->setBackgroundColor($color_white); // Color of spaces

        	$code->setFont($font); // Font (or 0)

        	$code->parse($codigo_barras); // Text

        } catch(Exception $exception) {

        	$drawException = $exception;

        }



        /* Here is the list of the arguments

        1 - Filename (empty : display on screen)

        2 - Background color */

        $drawing = new BCGDrawing('uploads/barcodes/'.$full_code.'.png', $color_white);

        if($drawException) {

        	$drawing->drawException($drawException);

        } else {

        	$drawing->setBarcode($code);

        	$drawing->draw();

        }



        // Header that says it is an image (remove it if you save the barcode to a file)

        //header('Content-Type: image/png');



        // Draw (or save) the image into PNG format.

        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);



    }

}
