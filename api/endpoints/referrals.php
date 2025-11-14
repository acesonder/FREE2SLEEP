<?php
/**
 * Service Referrals API Endpoint
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
                $stmt = $db->prepare("SELECT * FROM service_referrals WHERE id = ?");
                $stmt->execute([$id]);
                successResponse($stmt->fetch() ?: null);
            } else {
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $db->prepare("SELECT * FROM service_referrals ORDER BY referral_date DESC LIMIT ? OFFSET ?");
                $stmt->execute([$limit, $offset]);
                $referrals = $stmt->fetchAll();
                
                $countStmt = $db->query("SELECT COUNT(*) as total FROM service_referrals");
                $total = $countStmt->fetch()['total'];
                
                successResponse(['referrals' => $referrals, 'total' => $total]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                errorResponse('Invalid JSON data');
            }
            
            $stmt = $db->prepare("
                INSERT INTO service_referrals (
                    client_first_name, client_last_name, client_phone, client_email,
                    service_type, service_provider, urgency_level, reason_for_referral,
                    additional_information, status, referral_date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['clientFirstName'] ?? '',
                $data['clientLastName'] ?? '',
                $data['clientPhone'] ?? null,
                $data['clientEmail'] ?? null,
                $data['serviceType'] ?? '',
                $data['serviceProvider'] ?? null,
                $data['urgencyLevel'] ?? null,
                $data['reasonForReferral'] ?? null,
                $data['additionalInformation'] ?? null,
                $data['status'] ?? 'pending',
                $data['referralDate'] ?? date('Y-m-d')
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Referral created successfully');
            } else {
                errorResponse('Failed to create referral', 500);
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['id'])) {
                errorResponse('Missing ID for update');
            }
            
            $stmt = $db->prepare("UPDATE service_referrals SET status = ? WHERE id = ?");
            $result = $stmt->execute([$data['status'] ?? 'pending', $data['id']]);
            
            successResponse([], $result ? 'Updated successfully' : 'Update failed');
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) errorResponse('Missing ID');
            
            $stmt = $db->prepare("DELETE FROM service_referrals WHERE id = ?");
            successResponse([], $stmt->execute([$id]) ? 'Deleted successfully' : 'Delete failed');
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Referrals API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
