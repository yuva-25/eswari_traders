  <?php 
    include("include_files.php");  
    if(isset($_REQUEST['get_party_state'])) {
        $party_id = filter_input(INPUT_GET,'get_party_state', FILTER_SANITIZE_SPECIAL_CHARS);
        $party_state = "";
        if(!empty($party_id)) {
            $party_state = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'state');
        }
        echo $party_state;
    }
    ?>
