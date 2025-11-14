/**
 * API Client for FREE2SLEEP
 * Replaces localStorage with MySQL database calls via PHP API
 */

// API Configuration
const API_BASE_URL = window.location.origin + '/api/endpoints';

// API Client Class
class ApiClient {
    constructor(baseUrl = API_BASE_URL) {
        this.baseUrl = baseUrl;
    }

    /**
     * Generic request method
     */
    async request(endpoint, method = 'GET', data = null, params = {}) {
        try {
            const url = new URL(`${this.baseUrl}/${endpoint}`);
            
            // Add query parameters for GET requests
            if (params && Object.keys(params).length > 0) {
                Object.keys(params).forEach(key => {
                    url.searchParams.append(key, params[key]);
                });
            }

            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'include' // Include cookies for session management
            };

            if (data && method !== 'GET') {
                options.body = JSON.stringify(data);
            }

            const response = await fetch(url.toString(), options);
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'API request failed');
            }

            return result;
        } catch (error) {
            console.error(`API Error (${endpoint}):`, error);
            throw error;
        }
    }

    // Client Intake API
    async createClientIntake(data) {
        return this.request('client-intake.php', 'POST', data);
    }

    async getClientIntakes(limit = 100, offset = 0) {
        return this.request('client-intake.php', 'GET', null, { limit, offset });
    }

    async getClientIntake(id) {
        return this.request('client-intake.php', 'GET', null, { id });
    }

    async updateClientIntake(id, data) {
        return this.request('client-intake.php', 'PUT', { ...data, id });
    }

    async deleteClientIntake(id) {
        return this.request('client-intake.php', 'DELETE', null, { id });
    }

    // Bed Intake API
    async createBedIntake(data) {
        return this.request('bed-intake.php', 'POST', data);
    }

    async getBedIntakes(limit = 100, offset = 0, status = null) {
        const params = { limit, offset };
        if (status) params.status = status;
        return this.request('bed-intake.php', 'GET', null, params);
    }

    async getBedIntake(id) {
        return this.request('bed-intake.php', 'GET', null, { id });
    }

    async updateBedIntake(id, data) {
        return this.request('bed-intake.php', 'PUT', { ...data, id });
    }

    async deleteBedIntake(id) {
        return this.request('bed-intake.php', 'DELETE', null, { id });
    }

    // Shower Program API
    async createShowerSignup(data) {
        return this.request('shower-program.php', 'POST', data);
    }

    async getShowerSignups(limit = 100, offset = 0) {
        return this.request('shower-program.php', 'GET', null, { limit, offset });
    }

    async updateShowerSignup(id, data) {
        return this.request('shower-program.php', 'PUT', { ...data, id });
    }

    async deleteShowerSignup(id) {
        return this.request('shower-program.php', 'DELETE', null, { id });
    }

    // Laundry Program API
    async createLaundryRegistration(data) {
        return this.request('laundry-program.php', 'POST', data);
    }

    async getLaundryRegistrations(limit = 100, offset = 0) {
        return this.request('laundry-program.php', 'GET', null, { limit, offset });
    }

    async updateLaundryRegistration(id, data) {
        return this.request('laundry-program.php', 'PUT', { ...data, id });
    }

    async deleteLaundryRegistration(id) {
        return this.request('laundry-program.php', 'DELETE', null, { id });
    }

    // Service Referrals API
    async createReferral(data) {
        return this.request('referrals.php', 'POST', data);
    }

    async getReferrals(limit = 100, offset = 0) {
        return this.request('referrals.php', 'GET', null, { limit, offset });
    }

    async updateReferral(id, data) {
        return this.request('referrals.php', 'PUT', { ...data, id });
    }

    async deleteReferral(id) {
        return this.request('referrals.php', 'DELETE', null, { id });
    }

    // Messaging API
    async sendMessage(conversationId, messageContent, senderType = 'client', senderName = 'User') {
        return this.request('messages.php', 'POST', {
            conversationId,
            messageContent,
            senderType,
            senderName
        });
    }

    async getMessages(conversationId, limit = 50, offset = 0) {
        return this.request('messages.php', 'GET', null, { conversation_id: conversationId, limit, offset });
    }

    async getConversations() {
        return this.request('messages.php', 'GET');
    }

    async markMessagesRead(conversationId) {
        return this.request('messages.php', 'PUT', { conversationId });
    }

    // Authentication API
    async login(passcode) {
        return this.request('auth.php?action=login', 'POST', { passcode });
    }

    async logout() {
        return this.request('auth.php?action=logout', 'POST');
    }

    async checkAuth() {
        return this.request('auth.php?action=check', 'POST');
    }

    // Preferences API
    async getPreferences(userId = null) {
        const params = userId ? { user_id: userId } : {};
        return this.request('preferences.php', 'GET', null, params);
    }

    async savePreferences(language, otherPrefs = {}) {
        return this.request('preferences.php', 'POST', {
            preferredLanguage: language,
            otherPreferences: otherPrefs
        });
    }
}

// Create global API client instance
const apiClient = new ApiClient();

// Export for use in other scripts
window.FREE2SLEEP_API = apiClient;

// Helper function to map form data to API format
function mapFormDataToApi(formType, formData) {
    // Convert FormData or object to camelCase for API
    const data = {};
    
    if (formData instanceof FormData) {
        for (let [key, value] of formData.entries()) {
            // Convert kebab-case or snake_case to camelCase
            const camelKey = key.replace(/[-_](.)/g, (_, char) => char.toUpperCase());
            data[camelKey] = value;
        }
    } else {
        Object.keys(formData).forEach(key => {
            const camelKey = key.replace(/[-_](.)/g, (_, char) => char.toUpperCase());
            data[camelKey] = formData[key];
        });
    }
    
    return data;
}

// Export helper
window.FREE2SLEEP_API.mapFormData = mapFormDataToApi;
