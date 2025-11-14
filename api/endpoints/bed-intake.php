<?php
/**
 * Bed Intake API Endpoint
 * Handles CRUD operations for bed intake forms
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
                $stmt = $db->prepare("SELECT * FROM bed_intakes WHERE id = ?");
                $stmt->execute([$id]);
                $intake = $stmt->fetch();
                
                if ($intake) {
                    successResponse($intake);
                } else {
                    errorResponse('Bed intake not found', 404);
                }
            } else {
                $status = $_GET['status'] ?? null;
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                if ($status) {
                    $stmt = $db->prepare("SELECT * FROM bed_intakes WHERE status = ? ORDER BY arrival_date DESC LIMIT ? OFFSET ?");
                    $stmt->execute([$status, $limit, $offset]);
                } else {
                    $stmt = $db->prepare("SELECT * FROM bed_intakes ORDER BY arrival_date DESC LIMIT ? OFFSET ?");
                    $stmt->execute([$limit, $offset]);
                }
                
                $intakes = $stmt->fetchAll();
                
                $countStmt = $db->query("SELECT COUNT(*) as total FROM bed_intakes");
                $total = $countStmt->fetch()['total'];
                
                // Get active beds count
                $activeStmt = $db->query("SELECT COUNT(*) as active FROM bed_intakes WHERE status = 'active'");
                $active = $activeStmt->fetch()['active'];
                
                successResponse([
                    'intakes' => $intakes,
                    'total' => $total,
                    'active' => $active,
                    'available' => max(0, 24 - $active),
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            $requiredFields = ['firstName', 'lastName', 'dob', 'phone', 'arrivalDate'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    errorResponse("Missing required field: $field");
                }
            }
            
            $stmt = $db->prepare("
                INSERT INTO bed_intakes (
                    first_name, last_name, dob, phone, arrival_date, estimated_stay,
                    emergency_contact, emergency_phone, medical_conditions, special_needs, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $data['dob'],
                $data['phone'],
                $data['arrivalDate'],
                $data['estimatedStay'] ?? null,
                $data['emergencyContact'] ?? null,
                $data['emergencyPhone'] ?? null,
                $data['medicalConditions'] ?? null,
                $data['specialNeeds'] ?? null,
                $data['status'] ?? 'active'
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Bed intake created successfully');
            } else {
                errorResponse('Failed to create bed intake', 500);
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['id'])) {
                errorResponse('Missing ID for update');
            }
            
            $id = $data['id'];
            $updateFields = [];
            $params = [];
            
            $allowedFields = [
                'firstName' => 'first_name',
                'lastName' => 'last_name',
                'dob' => 'dob',
                'phone' => 'phone',
                'arrivalDate' => 'arrival_date',
                'estimatedStay' => 'estimated_stay',
                'emergencyContact' => 'emergency_contact',
                'emergencyPhone' => 'emergency_phone',
                'medicalConditions' => 'medical_conditions',
                'specialNeeds' => 'special_needs',
                'status' => 'status',
                'checkOutTime' => 'check_out_time'
            ];
            
            foreach ($allowedFields as $jsonKey => $dbKey) {
                if (isset($data[$jsonKey])) {
                    $updateFields[] = "$dbKey = ?";
                    $params[] = $data[$jsonKey];
                }
            }
            
            if (empty($updateFields)) {
                errorResponse('No fields to update');
            }
            
            $params[] = $id;
            $sql = "UPDATE bed_intakes SET " . implode(', ', $updateFields) . " WHERE id = ?";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                successResponse([], 'Bed intake updated successfully');
            } else {
                errorResponse('Failed to update bed intake', 500);
            }
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                errorResponse('Missing ID for deletion');
            }
            
            $stmt = $db->prepare("DELETE FROM bed_intakes WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            if ($result) {
                successResponse([], 'Bed intake deleted successfully');
            } else {
                errorResponse('Failed to delete bed intake', 500);
            }
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Bed Intake API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
