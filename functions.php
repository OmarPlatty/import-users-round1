<?php

function insert_multiple_rows($table, $request) {
    global $wpdb;
    $column_keys   = '';
    $column_values = '';
    $sql           = '';
    $last_key      = array_key_last($request);
    $first_key     = array_key_first($request);
    foreach ($request as $k => $value) {
        $keys = array_keys($value);

        foreach ( $keys as $v ) {
            $column_keys   .= $v . ',';
            $sanitize_value = addslashes($value[$v]);
            $column_values .=  "'$sanitize_value'" . ',';
        }
        // Trim trailing comma.
        $column_keys   = rtrim($column_keys, ',');
        $column_values = rtrim($column_values, ',');
        if ( $first_key === $k ) {
            $sql .= "INSERT INTO {$table} ($column_keys) VALUES ($column_values),";
        } elseif ( $last_key == $k ) {
            $sql .= "($column_values)";
        } else {
            $sql .= "($column_values),";
        }

        // Reset keys & values to avoid duplication.
        $column_keys   = '';
        $column_values = '';
    }
    return $wpdb->query( $sql );
}

function getUsers($limit) {
    global $wpdb;
    $query = "SELECT * FROM user_export WHERE user_export.imported='0' LIMIT {$limit};";
    return $wpdb->get_results($query);
}

function getUsersToEmail($limit) {
    global $wpdb;
    $query = "SELECT * FROM user_export WHERE user_export.imported=1 and user_export.emailed=0 LIMIT {$limit};";
    return $wpdb->get_results($query);
}

function getUserByEmail($email) {
    global $wpdb;
    $query = "SELECT * FROM wp_users WHERE user_email='{$email}';";
    return $wpdb->query($query);
}

function dump($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}