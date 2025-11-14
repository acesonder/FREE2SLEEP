<?php
/**
 * Messaging API Endpoint
 */

require_once '../config.php';

setCorsHeaders();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();
    
    switch ($method) {
        case 'GET':
            $conversationId = $_GET['conversation_id'] ?? null;
            
            if ($conversationId) {
                // Get messages for specific conversation
                $limit = $_GET['limit'] ?? 50;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $db->prepare("
                    SELECT * FROM messages 
                    WHERE conversation_id = ? 
                    ORDER BY timestamp DESC 
                    LIMIT ? OFFSET ?
                ");
                $stmt->execute([$conversationId, $limit, $offset]);
                $messages = $stmt->fetchAll();
                
                // Mark messages as read
                $updateStmt = $db->prepare("
                    UPDATE messages 
                    SET is_read = TRUE 
                    WHERE conversation_id = ? AND is_read = FALSE
                ");
                $updateStmt->execute([$conversationId]);
                
                successResponse(['messages' => array_reverse($messages)]);
            } else {
                // Get all conversations with latest message
                $stmt = $db->query("
                    SELECT 
                        conversation_id,
                        MAX(timestamp) as last_message_time,
                        COUNT(CASE WHEN is_read = FALSE THEN 1 END) as unread_count
                    FROM messages
                    GROUP BY conversation_id
                    ORDER BY last_message_time DESC
                ");
                $conversations = $stmt->fetchAll();
                
                successResponse(['conversations' => $conversations]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['conversationId']) || empty($data['messageContent'])) {
                errorResponse('Missing required fields');
            }
            
            $stmt = $db->prepare("
                INSERT INTO messages (
                    conversation_id, sender_type, sender_name, message_content, is_read
                ) VALUES (?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $data['conversationId'],
                $data['senderType'] ?? 'client',
                $data['senderName'] ?? 'Anonymous',
                $data['messageContent'],
                false
            ]);
            
            if ($result) {
                successResponse(['id' => $db->lastInsertId()], 'Message sent successfully');
            } else {
                errorResponse('Failed to send message', 500);
            }
            break;
            
        case 'PUT':
            // Mark messages as read
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || empty($data['conversationId'])) {
                errorResponse('Missing conversation ID');
            }
            
            $stmt = $db->prepare("
                UPDATE messages 
                SET is_read = TRUE 
                WHERE conversation_id = ?
            ");
            $result = $stmt->execute([$data['conversationId']]);
            
            successResponse([], $result ? 'Messages marked as read' : 'Update failed');
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) errorResponse('Missing ID');
            
            $stmt = $db->prepare("DELETE FROM messages WHERE id = ?");
            successResponse([], $stmt->execute([$id]) ? 'Deleted successfully' : 'Delete failed');
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Messages API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
