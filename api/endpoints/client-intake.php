<?php
/**
 * Client Intake API Endpoint
 * Handles CRUD operations for client intake forms
 */

require_once '../config.php';

setCorsHeaders();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();
    
    switch ($method) {
        case 'GET':
            // Get all client intakes or specific one by ID
            $id = $_GET['id'] ?? null;
            
            if ($id) {
                $stmt = $db->prepare("SELECT * FROM client_intakes WHERE id = ?");
                $stmt->execute([$id]);
                $intake = $stmt->fetch();
                
                if ($intake) {
                    successResponse($intake);
                } else {
                    errorResponse('Client intake not found', 404);
                }
            } else {
                // Get all with optional filters
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $db->prepare("SELECT * FROM client_intakes ORDER BY timestamp DESC LIMIT ? OFFSET ?");
                $stmt->execute([$limit, $offset]);
                $intakes = $stmt->fetchAll();
                
                $countStmt = $db->query("SELECT COUNT(*) as total FROM client_intakes");
                $total = $countStmt->fetch()['total'];
                
                successResponse([
                    'intakes' => $intakes,
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            }
            break;
            
        case 'POST':
            // Create new client intake
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            // Required fields
            $requiredFields = ['firstName', 'lastName'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    errorResponse("Missing required field: $field");
                }
            }
            
            $stmt = $db->prepare("
                INSERT INTO client_intakes (
                    first_name, last_name, dob, phone, email, address, city, province, 
                    postal_code, emergency_contact_name, emergency_contact_phone, 
                    emergency_contact_relationship, current_situation, housing_status, 
                    income_source, health_conditions, medications, mental_health_support, 
                    substance_use, legal_issues, service_needs, referral_source, 
                    consent_information_sharing, consent_photos
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['dob'] ?? null,
                $data['phone'] ?? null,
                $data['email'] ?? null,
                $data['address'] ?? null,
                $data['city'] ?? null,
                $data['province'] ?? null,
                $data['postalCode'] ?? null,
                $data['emergencyContactName'] ?? null,
                $data['emergencyContactPhone'] ?? null,
                $data['emergencyContactRelationship'] ?? null,
                $data['currentSituation'] ?? null,
                $data['housingStatus'] ?? null,
                $data['incomeSource'] ?? null,
                $data['healthConditions'] ?? null,
                $data['medications'] ?? null,
                $data['mentalHealthSupport'] ?? null,
                $data['substanceUse'] ?? null,
                $data['legalIssues'] ?? null,
                $data['serviceNeeds'] ?? null,
                $data['referralSource'] ?? null,
                $data['consentInformationSharing'] ?? null,
                $data['consentPhotos'] ?? null
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Client intake created successfully');
            } else {
                errorResponse('Failed to create client intake', 500);
            }
            break;
            
        case 'PUT':
            // Update existing client intake
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['id'])) {
                errorResponse('Missing ID for update');
            }
            
            $id = $data['id'];
            
            // Build update query dynamically
            $updateFields = [];
            $params = [];
            
            $allowedFields = [
                'firstName' => 'first_name',
                'lastName' => 'last_name',
                'dob' => 'dob',
                'phone' => 'phone',
                'email' => 'email',
                'address' => 'address',
                'city' => 'city',
                'province' => 'province',
                'postalCode' => 'postal_code',
                'emergencyContactName' => 'emergency_contact_name',
                'emergencyContactPhone' => 'emergency_contact_phone',
                'emergencyContactRelationship' => 'emergency_contact_relationship',
                'currentSituation' => 'current_situation',
                'housingStatus' => 'housing_status',
                'incomeSource' => 'income_source',
                'healthConditions' => 'health_conditions',
                'medications' => 'medications',
                'mentalHealthSupport' => 'mental_health_support',
                'substanceUse' => 'substance_use',
                'legalIssues' => 'legal_issues',
                'serviceNeeds' => 'service_needs',
                'referralSource' => 'referral_source',
                'consentInformationSharing' => 'consent_information_sharing',
                'consentPhotos' => 'consent_photos'
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
            $sql = "UPDATE client_intakes SET " . implode(', ', $updateFields) . " WHERE id = ?";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                successResponse([], 'Client intake updated successfully');
            } else {
                errorResponse('Failed to update client intake', 500);
            }
            break;
            
        case 'DELETE':
            // Delete client intake
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                errorResponse('Missing ID for deletion');
            }
            
            $stmt = $db->prepare("DELETE FROM client_intakes WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            if ($result) {
                successResponse([], 'Client intake deleted successfully');
            } else {
                errorResponse('Failed to delete client intake', 500);
            }
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Client Intake API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
