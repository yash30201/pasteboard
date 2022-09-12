<?php

/**
 * Creates a new paste(text)
 * 
 * @param String $title Title of the paste
 * @param String $text The text to be pasted
 * @param String $userId The user who pasted it
 * @return String ID of the last text
 */ 
function create_text_paste($title, $text, $userId) {
    global $db;
    $type = "text";
    $sql = "INSERT INTO paste ";
    $sql .= "(type, title, link, user_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . $type . "',";
    $sql .= "'" . $title . "',";
    $sql .= "'" . $text . "',";
    $sql .= "'" . $userId . "'";
    $sql .= ")";


    try {
        $db->exec($sql);
        $last_id = $db->lastInsertId();
        return $last_id;
    } catch (PDOException $err) {
        echo_pdo_error($err);
        db_disconnect();
        confirm_result_set($sql, $err);
    }
}

/**
 * Get a paste by its ID
 * 
 * @param String $id
 * @return array
 */
function get_paste_by_id($id) {
    global $db;

    $sql = "SELECT title, link FROM paste ";
    $sql .= "WHERE id='" . $id . "'";
    try {
        $paste_set = $db->query($sql);
        return $paste_set->fetch();
    } catch (PDOException $err) {
        echo_pdo_error($err);
        db_disconnect();
        confirm_result_set($sql, $err);
    }
}


/**
 * Get a paste by its userId
 * 
 * @param String $id
 * @return array
 */
function get_pastes_by_userId($userId) {
    global $db;

    $sql = "SELECT id, title, link FROM paste ";
    $sql .= "WHERE user_id='" . $userId . "'";
    try {
        $paste_set = $db->query($sql);
        $paste_set->setFetchMode(PDO::FETCH_ASSOC);
        return $paste_set;
    } catch (PDOException $err) {
        echo_pdo_error($err);
        db_disconnect();
        confirm_result_set($sql, $err);
    }
}


/**
 * Get all the pastes
 * The purpose of this function is to mimic large number of pastes.
 * 
 * @return array
 */
function get_all_pastes() {
    global $db;

    $sql = "SELECT id, title, link FROM paste";
    try {
        $paste_set = $db->query($sql);
        $paste_set->setFetchMode(PDO::FETCH_ASSOC);
        return $paste_set;
    } catch (PDOException $err) {
        echo_pdo_error($err);
        db_disconnect();
        confirm_result_set($sql, $err);
    }
}