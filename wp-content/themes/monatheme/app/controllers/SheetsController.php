<?php 
class SheetsController {

    protected $sheet_url = '';

    public function __construct( $spreadsheet_url ) {
        $this->sheet_url = esc_url( $spreadsheet_url );
    }

    public function getSheets()
    {
        return $this->requestSheet( 'get' );
    }

    public function getFirstArgs()
    {
        $sheetsRows = $this->getSheets();
        if ( ! empty ( $sheetsRows ) && count( $sheetsRows ) >= 1 ) {
            return array_keys( $sheetsRows[0] );
        } else {
            return false;
        }
    }

    public function requestSheet( $method = 'get', $data = [] )
    {
        $objects = $firstArgs = [];
        $options = [
            'http' => [
                'header'  => 'Content-type: application/x-www-form-urlencoded\r\n',
                'method'  => strtoupper( $method ),
                'content' => http_build_query( [ 'data' => $data ] ),
                'enable_cache' => false,
                'read_cache_expiry_seconds' => 0,
                'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0, no-transform',
                'Pragma' => 'no-cache',
            ]
        ];

        $html            = @file_get_contents( $this->sheet_url, false, stream_context_create( $options ) );
        $cacheArgsSize   = wp_cache_get( 'mona_cache_sheet_args_size' );
        $objects         = wp_cache_get( 'mona_cache_sheet_args_values' );
        $beforeArgsSize  = $this->getArgsSize( $html );

        if ( !$objects || $beforeArgsSize != $cacheArgsSize ) {
           
            $dom  = new DOMDocument( '1.0', 'UTF-8' );
            $dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8') );
            
            $i = -1;
            $loopObjects = $dom->getElementsByTagName( 'tr' );
            if ( ! empty ( $loopObjects ) ) {
                foreach( $loopObjects as $row )  {
                    $j = 0;
                    foreach( $row->getElementsByTagName( 'td' ) as $tag ) {
                        $string = esc_attr( $tag->textContent );
                        if ( $i < 1 ) {
                            $firstArgs[$j] = sanitize_title( $string );
                        }
                        if ( ! empty ( $firstArgs ) ) {
                            if ( $i >= 1 ) {
                                // Tính năng bổ sung theo site 
                                if ( strpos( $string, ' | ' ) !== false ) {
                                    $objects[($i-1)][$firstArgs[$j]] = explode( ' | ', $string );
                                } else {
                                    $objects[($i-1)][$firstArgs[$j]] = $string;
                                }
                            }
                        }
                        $j++;
                    }
                    $i++;
                }
            }

            wp_cache_set( 'mona_cache_sheet_args_size', $beforeArgsSize, '', 3600 );
            wp_cache_set( 'mona_cache_sheet_args_values', $objects, '', 3600 );

        }
        
        return $this->filterArgsFirstValue( $objects );
    }

    public function filterArgsFirstValue( $currentArgs = [] )
    {
        if ( ! empty ( $currentArgs ) ) {
            foreach ( $currentArgs as $key => $filArgs ) {
                $firstKey   = array_key_first( $filArgs );
                $firstValue = $filArgs[$firstKey];
                if ( empty ( $firstValue ) ) {
                    unset( $currentArgs[$key] );
                }
            }
        }
        return $currentArgs;
    }

    protected function getArgsSize( $argsSize = [] )
    {   
        return mb_strlen( serialize( ( array)$argsSize ), '8bit' );
    }

}