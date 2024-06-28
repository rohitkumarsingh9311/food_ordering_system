<?php
    function pr($arr) {
        echo '<pre>';
        print_r($arr);
    }
    function prx($arr) {
        echo '<pre>';
        print_r($arr);
        die();
    }

    function get_safe_value($value){
        global $con;
        $value=mysqli_real_escape_string($con,$value);
        return $value;
    }

    function redirect($link) {
        ?>
        <script>
            window.location.href='<?php echo $link ?>';
        </script>
        <?php
        die;
    }
?>