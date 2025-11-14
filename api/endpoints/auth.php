<?php
/**
 * Authentication API Endpoint
 */

require_once '../config.php';

setCorsHeaders();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();
    
    switch ($method) {
        case 'POST':
            $action = $_GET['action'] ?? '';
            
            if ($action === 'login') {
                // Admin login
                $data = json_decode(file_get_contents('php://input'), true);
                
                if (!$data || empty($data['passcode'])) {
                    errorResponse('Missing passcode');
                }
                
                $passcode = $data['passcode'];
                
                // Simple passcode check for demo (079777)
                if ($passcode === '079777') {
                    session_start();
                    $_SESSION['admin_authenticated'] = true;
                    $_SESSION['last_activity'] = time();
                    $_SESSION['user_id'] = 1;
                    $_SESSION['username'] = 'admin';
                    
                    successResponse([
                        'authenticated' => true,
                        'username' => 'admin',
                        'role' => 'admin'
                    ], 'Login successful');
                } else {
                    errorResponse('Invalid passcode', 401);
                }
                
            } elseif ($action === 'logout') {
                // Logout
                session_start();
                session_unset();
                session_destroy();
                
                successResponse([], 'Logged out successfully');
                
            } elseif ($action === 'check') {
                // Check authentication status
                session_start();
                
                if (isset($_SESSION['admin_authenticated']) && $_SESSION['admin_authenticated'] === true) {
                    // Check session timeout
                    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
                        session_unset();
                        session_destroy();
                        successResponse(['authenticated' => false], 'Session expired');
                    } else {
                        $_SESSION['last_activity'] = time();
                        successResponse([
                            'authenticated' => true,
                            'username' => $_SESSION['username'] ?? 'admin'
                        ]);
                    }
                } else {
                    successResponse(['authenticated' => false]);
                }
                
            } else {
                errorResponse('Invalid action');
            }
            break;
            
        default:
            errorResponse('Method not allowed', 405);
    }
    
} catch (Exception $e) {
    error_log("Auth API Error: " . $e->getMessage());
    errorResponse('Internal server error', 500);
}
?>
