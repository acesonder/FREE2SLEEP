<?php
/**
 * Shower Program API Endpoint
 */

require_once '../config.php';

setCorsHeaders();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();
    
    switch ($method) {
        case 'GET':
            $id = $_GET['id'] ?? null;
            
            if ($id) {
                $stmt = $db->prepare("SELECT * FROM shower_signups WHERE id = ?");
                $stmt->execute([$id]);
                successResponse($stmt->fetch() ?: null);
            } else {
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $db->prepare("SELECT * FROM shower_signups ORDER BY preferred_date DESC, preferred_time ASC LIMIT ? OFFSET ?");
                $stmt->execute([$limit, $offset]);
                $signups = $stmt->fetchAll();
                
                $countStmt = $db->query("SELECT COUNT(*) as total FROM shower_signups");
                $total = $countStmt->fetch()['total'];
                
                successResponse(['signups' => $signups, 'total' => $total]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            $stmt = $db->prepare("
                INSERT INTO shower_signups (
                    first_name, last_name, phone, email, preferred_date, preferred_time,
                    gender_preference, accessibility_needs, additional_notes, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['phone'] ?? null,
                $data['email'] ?? null,
                $data['preferredDate'] ?? null,
                $data['preferredTime'] ?? null,
                $data['genderPreference'] ?? null,
                $data['accessibilityNeeds'] ?? null,
                $data['additionalNotes'] ?? null,
                $data['status'] ?? 'pending'
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Shower signup created successfully');
            } else {
                errorResponse('Failed to create shower signup', 500);
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['id'])) {
                errorResponse('Missing ID for update');
            }
            
            $stmt = $db->prepare("
                UPDATE shower_signups SET 
                    status = ?, preferred_date = ?, preferred_time = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([
                $data['status'] ?? 'pending',
                $data['preferredDate'] ?? null,
                $data['preferredTime'] ?? null,
                $data['id']
            ]);
            
            successResponse([], $result ? 'Updated successfully' : 'Update failed');
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) errorResponse('Missing ID');
            
            $stmt = $db->prepare("DELETE FROM shower_signups WHERE id = ?");
            successResponse([], $stmt->execute([$id]) ? 'Deleted successfully' : 'Delete failed');
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Shower Program API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
