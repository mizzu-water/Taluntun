<?php
/**
 * Cluster 1: Business and Management (Degrees 1 to 8)
 * 50 questions per degree across Stages 1 to 4
 */

function getClusterBusinessFullQuestions() {
    $data = [];

    // Helper to generate balanced questions if needed
    require_once __DIR__ . '/cluster_business_data.php';
    return getClusterBusinessExport();
}
