<?php
/**
 * Laundry Program API Endpoint
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
                $stmt = $db->prepare("SELECT * FROM laundry_registrations WHERE id = ?");
                $stmt->execute([$id]);
                successResponse($stmt->fetch() ?: null);
            } else {
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $db->prepare("SELECT * FROM laundry_registrations ORDER BY preferred_day, preferred_time LIMIT ? OFFSET ?");
                $stmt->execute([$limit, $offset]);
                $registrations = $stmt->fetchAll();
                
                $countStmt = $db->query("SELECT COUNT(*) as total FROM laundry_registrations");
                $total = $countStmt->fetch()['total'];
                
                successResponse(['registrations' => $registrations, 'total' => $total]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            $stmt = $db->prepare("
                INSERT INTO laundry_registrations (
                    first_name, last_name, phone, email, preferred_day, preferred_time,
                    number_of_loads, special_instructions, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['phone'] ?? null,
                $data['email'] ?? null,
                $data['preferredDay'] ?? null,
                $data['preferredTime'] ?? null,
                $data['numberOfLoads'] ?? 1,
                $data['specialInstructions'] ?? null,
                $data['status'] ?? 'pending'
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Laundry registration created successfully');
            } else {
                errorResponse('Failed to create registration', 500);
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['id'])) {
                errorResponse('Missing ID for update');
            }
            
            $stmt = $db->prepare("
                UPDATE laundry_registrations SET 
                    status = ?, preferred_day = ?, preferred_time = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([
                $data['status'] ?? 'pending',
                $data['preferredDay'] ?? null,
                $data['preferredTime'] ?? null,
                $data['id']
            ]);
            
            successResponse([], $result ? 'Updated successfully' : 'Update failed');
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) errorResponse('Missing ID');
            
            $stmt = $db->prepare("DELETE FROM laundry_registrations WHERE id = ?");
            successResponse([], $stmt->execute([$id]) ? 'Deleted successfully' : 'Delete failed');
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Laundry Program API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
