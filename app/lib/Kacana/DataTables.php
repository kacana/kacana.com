<?php namespace Kacana;

class DataTables {

    /**
     * Create the data output array for the DataTables rows
     *
     *  @param  array $columns Column information array
     *  @param  array $data    Data from the SQL get
     *  @return array          Formatted data in a row based format
     */

    static function data_output ( $columns, $data )
    {
        $out = array();
        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();

            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];

                //example: binumi_bins_new.name AS projectName
                //$fieldName = projectName

                $fieldName = explode(' AS ',$columns[$j]['db']);

                if(count($fieldName)>1){
                    $fieldName = $fieldName[1];
                }else{
                    //example: binumi_bins_new.name
                    //$fieldName = name
                    $fieldName = explode('.',$columns[$j]['db']);
                    $fieldName = (count($fieldName)>1)?$fieldName[1]:$columns[$j]['db'];
                }

                $row[ $column['dt'] ] = $data[$i]->{$fieldName};
            }

            $out[] = $row;
        }

        return $out;
    }


    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @return array limit & offset
     */
    static function limit ( $request, $columns )
    {
        $limit = array(
            'offset' => 0,
            'limit' => 10
        );

        if ( isset($request['start']) && $request['length'] != -1 ) {
            $limit['offset'] = intval($request['start']);
            $limit['limit'] = intval($request['length']);
        }else{

        }

        return $limit;
    }


    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @return string SQL order by clause
     */
    static function order ( $request, $columns )
    {
        $order = array();

        if ( isset($request['order']) && count($request['order']) ) {

            $dtColumns = self::pluck( $columns, 'dt' );

            for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];

                if ( $requestColumn['orderable'] == 'true' && $request['order'][$i]['dir']) {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    if(mb_stripos($column['db'],' as '))
                        $column['db'] = preg_split('/ as /i',$column['db'])[1];
                    $order['field'] = $column['db'];
                    $order['dir'] = $dir;
                }
            }
        }

        return $order;
    }


    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @param  array $exceptColumns Except some columns
     *  @return string SQL where clause
     */
    static function filter ( $request, $columns , $exceptColumns = array())
    {
        $globalSearch = array();
        $columnSearch = array();
        $columnSearchOR = array();
        $dtColumns = self::pluck( $columns, 'dt' );

        if ( isset($request['search']) && $request['search']['value'] != '' ) {
            $str = $request['search']['value'];

            for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                if(array_search($i, $exceptColumns) !== false){
                    continue;
                }

                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];

                if ( $requestColumn['searchable'] == 'true' ) {
                    $fieldName = explode(' AS ',$column['db']);
                    if(count($fieldName) == 2)
                        $column['db'] = $fieldName[0];
                    $globalSearch[] = KACANA_PREFIX_DATABASE.$column['db'].' LIKE '.('""%'.$str.'%"');
                }
            }
        }

        // Individual column filtering
        for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
            if(array_search($i, $exceptColumns) !== false){
                continue;
            }

            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];

            $str = $requestColumn['search']['value'];

            if ( $requestColumn['searchable'] == 'true' && $str != '' ) {

                if($requestColumn['search']['regex'] === 'false'){
                    $str = '"%'.$requestColumn['search']['value'].'%"';
                }

                if(isset($requestColumn['search']['orWhere']) && $requestColumn['search']['orWhere'] === 'true'){
                    $fieldName = explode(' AS ',$column['db']);
                    if(count($fieldName) == 2)
                        $column['db'] = $fieldName[0];
                    $columnSearchOR[] = KACANA_PREFIX_DATABASE.$column['db'].' LIKE '.($str);
                }else{
                    $fieldName = explode(' AS ',$column['db']);
                    if(count($fieldName) == 2)
                        $column['db'] = $fieldName[0];
                    $columnSearch[] = KACANA_PREFIX_DATABASE.$column['db'].' LIKE '.($str);
                }
            }
        }

        // Combine the filters into a single string
        $where = '';

        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }

        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where .' AND '. implode(' AND ', $columnSearch);
        }

        //using when search data with OR
        if ( count( $columnSearchOR ) ) {
            $where = $where === '' ?
                implode(' OR ', $columnSearchOR) :
                $where .' AND ('. implode(' OR ', $columnSearchOR).')';
        }

        return $where;
    }


    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an Binumi_DataTables request, or can be modified if needed before
     * sending back to the client.
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  string $table SQL table to query
     *  @param  array $columns Column information array
     *  @return array          Server-side processing response array
     */
    static function simple ( $request, $table, $columns )
    {
        $db= Zend_Registry::get('db');

        // Build the SQL query string from the request
        $limit = Binumi_DataTables::limit( $request, $columns );
        $order = Binumi_DataTables::order( $request, $columns );
        $where = Binumi_DataTables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = $db->select()
            ->from($table,Binumi_DataTables::pluck($columns, 'db'))
            ->order($order)
            ->limit($limit['limit'],$limit['offset']);

        // Data set length
        $selectLength = $db->select()
            ->from($table,'COUNT(*)');

        // Total data set length
        $recordsTotal = $db->fetchOne($selectLength);

        if($where){
            $selectData->where($where);
            $selectLength->where($where);
        }

        $data = $db->fetchAll($selectData);

        // Total data set length after filtering
        $recordsFiltered= $db->fetchOne($selectLength);

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data"            => $data
        );
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */

    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    // @codeCoverageIgnoreStart
    static function fatal ( $msg )
    {
        echo json_encode( array(
            "error" => $msg
        ) );

        exit(0);
    }
    // @codeCoverageIgnoreEnd

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $a    Array to get data from
     *  @param  string $prop Property to read
     *  @return array        Array of property values
     */
    static function pluck ( $a, $prop )
    {
        $out = array();

        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            array_push($out, $a[$i][$prop]);
        }

        return $out;
    }
}