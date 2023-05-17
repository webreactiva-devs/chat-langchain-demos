<?php
/**
* @description		  Object for Download of files [Object for Download of files]
* @author			  Olavo Alexandrino - oalexandrino@yahoo.com.br
* @since			  May/2004
* @otherInformation	  Other properties can be added header.  It makes!
*/
class EasyDownload
{
	var $ContentType;				
	var $ContentLength;
	var $ContentDisposition;
	var $ContentTransferEncoding;
	var $Path;
	var $FileName;
	var $FileNameDown;	
	
	/**
	* Constructor
	* @access		public	
	*/	
	function EasyDownload()
	{
		$this->ContentType 				= "application/save";
		$this->ContentLength			= "";	
		$this->ContentDisposition		= "";
		$this->ContentTransferEncoding	= "";
		$this->Path						= "";
		$this->FileName					= "";
		$this->FileNameDown		= "";		
	}
	
	/**
	* It configures value Header 'ContentType'
	*
	* @access		public
	*/		
	function setContentType($strValue)
	{
		$this->ContentType = $strValue;
	}
	
	/**
	* It configures value Header 'ContentLength' with the size of the informed file
	* @return		void
	* @access		private
	*/	
	function _setContentLength()
	{
		$this->ContentLength = filesize($this->Path . "/" . $this->FileName);
	}
	
	/**
	* It configures value Header 'ContentDisposition' 
	* @access		public
	*/	
	function setContentDisposition($strValue)
	{
		$this->ContentDisposition = $strValue;
	}
	
	/**
	* It configures value Header 'ContentTransferEncoding' 
	* @access		public
	*/	
	function setContentTransferEncoding($strValue)
	{
		$this->ContentTransferEncoding = $strValue;
	}
	
	/**
	* It configures the physical place where the file if finds in the server
	* @access		public
	*/	
	function setPath($strValue)
	{
		$this->Path = $strValue;
	}
	
	/**
	* It configures the real name of the archive in the server
	* @access		public
	*/	
	function setFileName($strValue)
	{
		$this->FileName = $strValue;
	}		
	
	/**
	* It configures the personalized name of the file 
	* (therefore it can be different of the located real name in the server)
	* @access		public
	*/	
	function setFileNameDown($strValue)
	{
		$this->FileNameDown = $strValue;
	}			
	
	/**
	* Init Download
	* @access		public
	*/	
	function send()
	{
		$this->_setContentLength();
		header("Content-Type: " .  $this->ContentType); 	
		header("Content-Length: " .  $this->ContentLength);

		if ($this->FileNameDown == "")
			header("Content-Disposition: attachment; filename=" . $this->FileName); 
		else
			header("Content-Disposition: attachment; filename=" . $this->FileNameDown); 		
			
		header("Content-Transfer-Encoding: binary");
		$fp = fopen($this->Path . "/" . $this->FileName, "r"); 
		fpassthru($fp); 
		fclose($fp);		
	}		
}
?>