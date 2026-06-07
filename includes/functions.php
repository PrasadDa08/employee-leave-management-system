<?php

function addAuditLog($conn, $user_id, $activity)
{
    $stmt = $conn->prepare("INSERT INTO audit_logs(user_id, activity) VALUES (?, ?)");

    $stmt->bind_param("is", $user_id, $activity);

    $stmt->execute();
}
