<?php
/**
 * User Preferences API Endpoint
 */

require_once '../config.php';

setCorsHeaders();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();
    
    switch ($method) {
        case 'GET':
            $userIdentifier = $_GET['user_id'] ?? session_id();
            
            $stmt = $db->prepare("SELECT * FROM user_preferences WHERE user_identifier = ?");
            $stmt->execute([$userIdentifier]);
            $prefs = $stmt->fetch();
            
            if ($prefs) {
                // Decode JSON preferences if exists
                if ($prefs['other_preferences']) {
                    $prefs['other_preferences'] = json_decode($prefs['other_preferences'], true);
                }
                successResponse($prefs);
            } else {
                successResponse([
                    'preferred_language' => 'en',
                    'other_preferences' => []
                ]);
            }
            break;
            
        case 'POST':
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            $userIdentifier = $data['userIdentifier'] ?? session_id();
            $language = $data['preferredLanguage'] ?? 'en';
            $otherPrefs = $data['otherPreferences'] ?? [];
            
            // Check if preferences exist
            $stmt = $db->prepare("SELECT id FROM user_preferences WHERE user_identifier = ?");
            $stmt->execute([$userIdentifier]);
            $exists = $stmt->fetch();
            
            if ($exists) {
                // Update
                $stmt = $db->prepare("
                    UPDATE user_preferences 
                    SET preferred_language = ?, other_preferences = ?
                    WHERE user_identifier = ?
                ");
                $result = $stmt->execute([
                    $language,
                    json_encode($otherPrefs),
                    $userIdentifier
                ]);
            } else {
                // Insert
                $stmt = $db->prepare("
                    INSERT INTO user_preferences (user_identifier, preferred_language, other_preferences)
                    VALUES (?, ?, ?)
                ");
                $result = $stmt->execute([
                    $userIdentifier,
                    $language,
                    json_encode($otherPrefs)
                ]);
            }
            
            if ($result) {
                successResponse([], 'Preferences saved successfully');
            } else {
                errorResponse('Failed to save preferences', 500);
            }
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Preferences API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
