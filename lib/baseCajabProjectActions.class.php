<?php


class baseCajabProjectActions extends sfActions
{	
  public function preExecute()
  {
  }

  /**
   * Envia una imagen al browser
   */
  public function sendImagen($path, $mime="image/jpeg")
  {
    $image = imagecreatefromjpeg($path);
    //$image_size = getimagesize($path); //now we have dimensions of original image...
    
    try
    {
        ob_start(); // start a new output buffer
        imagejpeg($image,NULL,100);
        $imageData = ob_get_contents();
        ob_end_clean(); // stop this output buffer
        header('Content-Type: '. $mime);
        echo $imageData;
        imagedestroy( $image );
        
    }catch (Exception $e)
    {
        $this->renderText('ERROR drawing image');
    }

    return sfView::NONE;
  }

 
    protected function downloadDocument($server_path, $filename, $mimeType = ""){

      try
      {
        
        if(!file_exists($server_path))
        {          
          return $this->renderText("El archivo ". $filename ." no existe en el servidor" );
        }
        
        $fsize = filesize($server_path); 
        
        ob_start(); // start a new output buffer
        //echo file_get_contents($server_path);

        $this->getResponse()->setHttpHeader('Content-Type', $mimeType);
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');
        $this->getResponse()->setHttpHeader('Content-length', $fsize);
        $this->getResponse()->setHttpHeader('Cache-control', 'private');
        
         if ($fd = fopen ($server_path, "r")) {
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
         }
        
        //$this->renderText(ob_end_flush());
        
      }catch (Exception $e)
      {
          $this->renderText('ERROR dowloading file');
      }

      return sfView::NONE;
    }
    
    /**
   
    * Exporta el Grid de datos a un archivo de Excel
   
    */
    protected function exportToExcel($template ="listaExcel", $filename = "reporte"){

        if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
        {
          ob_start("gz_handler");
        }
        
        $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-excel');
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename='.str_replace(" ", "_",$filename).'.xls');
        $this->getResponse()->setHttpHeader('Pragma', 'no-cache');
        $this->getResponse()->setHttpHeader('Cache-Control', 'public, must-revalidate');
    
        $this->setTemplate('excel/'.$template);
        $this->setLayout("excel_layout");
        
        return sfView::SUCCESS;
    }

    /**    
    * Muestra el contenido de un template para imprimir    
    */
    protected function FormatoImpresion($template){
        $this->setTemplate($template);
        $this->setLayout("print_layout");
        $this->getResponse()->addStylesheet('impresion','last', array("media"=>"print,screen"));
        return sfView::SUCCESS;
    }
 
  /*
   * Metodo para enviar datos al cliente (browser) en formato JSON
   */
  public function sendJSON($data)
  {
      $this->getResponse()->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
      $this->getResponse()->setHttpHeader('Last-Modified', gmdate( "D, d M Y H:i:s" ).'GMT');
      $this->getResponse()->setHttpHeader('Cache-Control', 'no-cache, must-revalidate');
      $this->getResponse()->setHttpHeader('Pragma', 'no-cache');
      $this->getResponse()->setHttpHeader('Content-Type', 'text/x-json; charset=iso-8859-1');

      return $this->renderText(JSON::json_encode($data));
  }
  
 
  
  /*
  * Envia notificaciones de correo electronico
  */
  public function sendEmailNotification($subject, $toEmail, $content)
  {
    $mailer = $this->getMailer();
    //se crea el mensaje sin el contenido
    $message = $mailer->compose(array("SAMQRO" => $fromEmail),$toEmail,$subject);
    $message->addPart($content, "text/html");
    
    return $mailer->send($message);
  }
  
  public function executeTextToImage(sfWebRequest $request)
  {
    
    $font = 2;
    $t = $request->getParameter("t", false);
    
    try
    {
                
        if($t){
          
          $t = base64_decode($t);
          
          //Se crea la imagen con el texto especificado
          $w = ImageFontWidth($font) * strlen($t);
          $h = ImageFontHeight($font);

          $img = @imagecreatetruecolor ($w, $h);

          //Make it transparent
          imagesavealpha($img, true);
          $trans_colour = imagecolorallocatealpha($img, 0, 0, 0, 127);
          imagefill($img, 0, 0, $trans_colour);

          $tc = imagecolorallocate ($img, 0, 102, 204);//black text

          header('Content-Type: image/png');
          imagestring ($img, $font, 0, 0,  $t, $tc);
          imagepng ($img);
          
          imagedestroy($img);
        }
        
    }catch (Exception $e)
    {
        $this->renderText('ERROR drawing image');
    }
    
    return sfView::NONE;
    
  }
  
}