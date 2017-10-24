<?php
/**
	This class is used to parse all data using by website.
	The data is accessible using the getter functions.
**/

class	ContentManager
{
	function __construct() {

	}

  public function Parse( $filePath ) {
    if ( ! file_exists( $filePath ) )
      throw new Exception( "Error file not found $filePath", 504 ); 
  	$fileContent = file_get_contents( $filePath );
    $lines = explode( "\n", $fileContent );
  	foreach ( $lines as $line ) {
      $args = explode( "@", $line );
      
      if ( count( $args ) < 5 )
        continue;
      $this->m_cathegories[ $args[ 0 ] ][ $args[ 1 ] ][ $args[ 2 ] ][ "Image" ] = $args[ 3 ];
      $this->m_cathegories[ $args[ 0 ] ][ $args[ 1 ] ][ $args[ 2 ] ][ "Sound" ] = $args[ 4 ];
    }
  }

 	public function GetCathegories() {
    $returnArray = array();

    foreach ($this->m_cathegories as $cathegorie => $value) {
      array_push( $returnArray, $cathegorie );
    }
 	  return ( $returnArray );
  }

  public function GetLevels( $cathegorie ) {
    $returnArray = array();

    foreach ($this->m_cathegories[ $cathegorie ] as $level => $value) {
      array_push( $returnArray, $level );
    }
  	return ( $returnArray );
  }

  public function GetWords( $cathegorie, $level ) {
    $returnArray = array();

    foreach ($this->m_cathegories[ $cathegorie ][ $level ] as $word => $value) {
      array_push( $returnArray, $word );
    }
    return ( $returnArray );
  }

  public function GetImage( $cathegorie, $level, $word ) {
    return ( $this->m_cathegories[ $cathegorie ][ $level ][ $word ][ "Image" ] );
  }

  public function GetSound( $cathegorie, $level, $word ) {
  	return ( $this->m_cathegories[ $cathegorie ][ $level ][ $word ][ "Sound" ] );
  }

  private $m_cathegories = array();
}
?>
