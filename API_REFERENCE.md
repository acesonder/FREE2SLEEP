# FREE2SLEEP API Reference

## Overview

The FREE2SLEEP application uses RESTful PHP API endpoints to manage all data operations with MySQL database backend.

## Base URL

```
http://localhost/api/endpoints/
```

## Authentication

Admin endpoints require session-based authentication. Use the `/auth.php` endpoint to authenticate.

## API Endpoints

### Authentication

#### Login
```http
POST /api/endpoints/auth.php?action=login
Content-Type: application/json

{
  "passcode": "079777"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "authenticated": true,
    "username": "admin",
    "role": "admin"
  }
}
```

#### Check Authentication Status
```http
POST /api/endpoints/auth.php?action=check
```

#### Logout
```http
POST /api/endpoints/auth.php?action=logout
```

---

### Client Intake

#### Get All Client Intakes
```http
GET /api/endpoints/client-intake.php?limit=100&offset=0
```

#### Get Single Client Intake
```http
GET /api/endpoints/client-intake.php?id=1
```

#### Create Client Intake
```http
POST /api/endpoints/client-intake.php
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "dob": "1980-01-01",
  "phone": "555-0123",
  "email": "john@example.com",
  "address": "123 Main St",
  "city": "Cobourg",
  "province": "ON",
  "postalCode": "K9A 1A1",
  "emergencyContactName": "Jane Doe",
  "emergencyContactPhone": "555-0124",
  "emergencyContactRelationship": "Spouse",
  "currentSituation": "Seeking emergency shelter",
  "housingStatus": "Homeless",
  "incomeSource": "None",
  "healthConditions": "None reported",
  "medications": "None",
  "mentalHealthSupport": "No",
  "substanceUse": "No",
  "legalIssues": "None",
  "serviceNeeds": "Housing, Food",
  "referralSource": "Walk-in",
  "consentInformationSharing": "Yes",
  "consentPhotos": "Yes"
}
```

#### Update Client Intake
```http
PUT /api/endpoints/client-intake.php
Content-Type: application/json

{
  "id": 1,
  "phone": "555-9999",
  "email": "newemail@example.com"
}
```

#### Delete Client Intake
```http
DELETE /api/endpoints/client-intake.php?id=1
```

---

### Bed Intake

#### Get All Bed Intakes
```http
GET /api/endpoints/bed-intake.php?limit=100&offset=0&status=active
```

**Response includes:**
- `total`: Total number of bed intakes
- `active`: Number of active beds
- `available`: Number of available beds (out of 24)

#### Create Bed Intake
```http
POST /api/endpoints/bed-intake.php
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "dob": "1980-01-01",
  "phone": "555-0123",
  "arrivalDate": "2025-01-14",
  "estimatedStay": "1-week",
  "emergencyContact": "Jane Doe",
  "emergencyPhone": "555-0124",
  "medicalConditions": "None",
  "specialNeeds": "Ground floor preferred",
  "status": "active"
}
```

#### Update Bed Intake (Check-out)
```http
PUT /api/endpoints/bed-intake.php
Content-Type: application/json

{
  "id": 1,
  "status": "completed",
  "checkOutTime": "2025-01-20 10:00:00"
}
```

---

### Shower Program

#### Get Shower Signups
```http
GET /api/endpoints/shower-program.php?limit=100&offset=0
```

#### Create Shower Signup
```http
POST /api/endpoints/shower-program.php
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "phone": "555-0123",
  "email": "john@example.com",
  "preferredDate": "2025-01-15",
  "preferredTime": "morning",
  "genderPreference": "male",
  "accessibilityNeeds": "None",
  "additionalNotes": "",
  "status": "pending"
}
```

---

### Laundry Program

#### Get Laundry Registrations
```http
GET /api/endpoints/laundry-program.php?limit=100&offset=0
```

#### Create Laundry Registration
```http
POST /api/endpoints/laundry-program.php
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "phone": "555-0123",
  "email": "john@example.com",
  "preferredDay": "Monday",
  "preferredTime": "morning",
  "numberOfLoads": 2,
  "specialInstructions": "Heavy stains",
  "status": "pending"
}
```

---

### Service Referrals

#### Get Referrals
```http
GET /api/endpoints/referrals.php?limit=100&offset=0
```

#### Create Referral
```http
POST /api/endpoints/referrals.php
Content-Type: application/json

{
  "clientFirstName": "John",
  "clientLastName": "Doe",
  "clientPhone": "555-0123",
  "clientEmail": "john@example.com",
  "serviceType": "Mental Health",
  "serviceProvider": "Community Health Centre",
  "urgencyLevel": "High",
  "reasonForReferral": "Requires counseling services",
  "additionalInformation": "Client is willing to participate",
  "status": "pending",
  "referralDate": "2025-01-14"
}
```

---

### Messaging

#### Get Messages for Conversation
```http
GET /api/endpoints/messages.php?conversation_id=staff&limit=50&offset=0
```

#### Get All Conversations
```http
GET /api/endpoints/messages.php
```

#### Send Message
```http
POST /api/endpoints/messages.php
Content-Type: application/json

{
  "conversationId": "staff",
  "messageContent": "Hello, I need assistance",
  "senderType": "client",
  "senderName": "John Doe"
}
```

#### Mark Messages as Read
```http
PUT /api/endpoints/messages.php
Content-Type: application/json

{
  "conversationId": "staff"
}
```

---

### User Preferences

#### Get Preferences
```http
GET /api/endpoints/preferences.php?user_id=session123
```

#### Save Preferences
```http
POST /api/endpoints/preferences.php
Content-Type: application/json

{
  "userIdentifier": "session123",
  "preferredLanguage": "en",
  "otherPreferences": {
    "theme": "light",
    "notifications": true
  }
}
```

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Response data here
  }
}
```

### Error Response
```json
{
  "success": false,
  "error": "Error message description"
}
```

## HTTP Status Codes

- `200 OK` - Successful request
- `400 Bad Request` - Invalid request data
- `401 Unauthorized` - Authentication required
- `404 Not Found` - Resource not found
- `405 Method Not Allowed` - HTTP method not supported
- `500 Internal Server Error` - Server error

## JavaScript API Client

The application includes a JavaScript API client (`js/api-client.js`) that wraps all endpoints:

```javascript
// Example usage
const api = window.FREE2SLEEP_API;

// Create bed intake
const result = await api.createBedIntake({
  firstName: 'John',
  lastName: 'Doe',
  dob: '1980-01-01',
  phone: '555-0123',
  arrivalDate: '2025-01-14'
});

// Get all client intakes
const intakes = await api.getClientIntakes(100, 0);

// Send message
await api.sendMessage('staff', 'Hello, I need help');

// Login
await api.login('079777');
```

## CORS Configuration

The API supports CORS for cross-origin requests. Configure allowed origins in `api/config.php`:

```php
define('ALLOWED_ORIGINS', ['http://localhost', 'https://yourdomain.com']);
```

## Rate Limiting

Currently not implemented. Consider adding rate limiting for production deployment.

## Pagination

Most GET endpoints support pagination via `limit` and `offset` parameters:

```http
GET /api/endpoints/client-intake.php?limit=20&offset=40
```

This retrieves records 41-60.

## Security Notes

1. Always use HTTPS in production
2. Implement rate limiting for API endpoints
3. Add authentication middleware for sensitive endpoints
4. Regularly update passwords and security keys
5. Monitor API access logs
6. Use prepared statements (already implemented)
7. Validate and sanitize all inputs (already implemented)

---

*Last Updated: 2025-01-14*
