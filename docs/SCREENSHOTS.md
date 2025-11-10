# FREE2SLEEP Website - Page Screenshots & Descriptions

This document provides detailed descriptions of each page on the FREE2SLEEP website, including visual elements, functionality, and user experience notes.

---

## 1. Landing Page (index.html)

### Visual Overview
The landing page serves as the primary entry point to the FREE2SLEEP Crisis Centre website.

#### Hero Section
- **Background**: Gradient blue background (from primary to secondary color)
- **Overlay**: Subtle pattern with circles for visual interest
- **Title**: Large, bold "Welcome to FREE2SLEEP" text
- **Subtitle**: "Northumberland County's Winter Warming Room & Crisis Support Centre"
- **Description**: Brief mission statement
- **CTA Buttons**: Two prominent buttons:
  - Orange "Get Help Now" button
  - White "View Programs" button
- **Emergency Contact**: Large, highlighted 24/7 crisis line number with phone icon

#### Statistics Section (Count Section)
- **Layout**: Four cards in a responsive grid
- **Each Card Contains**:
  - Large icon (users, bed, utensils, hands-helping)
  - Animated counter (counts up from 0 to target)
  - Label describing the metric
- **Background**: Light gray background for contrast
- **Animation**: Numbers animate when scrolled into view

#### About Section
- **Two-column layout**:
  - Left: Text description of FREE2SLEEP
  - Right: Placeholder image
- **Content**: Mission statement and service overview
- **Typography**: Large, readable text with good line height

#### Services Section
- **Grid Layout**: 3 columns on desktop, responsive to 1 column on mobile
- **Six Service Cards**:
  1. Emergency Shelter (bed icon)
  2. Case Management (clipboard icon)
  3. Shower Program (shower icon)
  4. Laundry Program (t-shirt icon)
  5. Client Assessment (file icon)
  6. Referrals (helping hands icon)
- **Each Card Has**: Icon, title, description, and action button
- **Hover Effect**: Cards lift slightly on hover

#### Programs Section
- **Three Program Cards**: Winter Warming Room, Meal Programs, Document Support
- **Simple Layout**: Left-aligned text with colored accent border
- **Background**: White background for clarity

#### Resources Section
- **Centered Layout**: Call-to-action to view service provider directory
- **Single Button**: Large, prominent button to directory

#### Contact Section
- **Three Contact Cards**:
  1. 24/7 Crisis Line (phone icon)
  2. Location (map marker icon)
  3. Hours (clock icon)
- **Background**: Light background with rounded corners
- **Clickable**: Phone numbers are clickable links

#### Footer
- **Three Columns**: About, Quick Links, Resources
- **Dark Background**: Professional dark theme
- **Copyright**: Bottom section with copyright and attribution

### Unique Visual Elements
- Language selector buttons (EN/FR) in top-right corner
- Sticky navigation that remains visible on scroll
- Smooth animations and transitions throughout
- Mobile hamburger menu for small screens
- Emergency contact always visible

### Accessibility Features
- High contrast colors
- Large, readable fonts
- Clear visual hierarchy
- Keyboard navigable
- Screen reader friendly

---

## 2. Admin Dashboard (admin.html)

### Login Screen
- **Centered Card**: Clean, minimal login form
- **Elements**:
  - Lock icon
  - "Admin Login" heading
  - Password input field
  - "Login" button (full width)
  - "Back to Home" link
- **Background**: Gradient similar to hero section
- **Security**: Password field hides input

### Dashboard (After Login)
#### Top Navigation
- **Brand**: "FREE2SLEEP Admin"
- **Buttons**: "Back to Site" and red "Logout" button
- **Sticky**: Remains visible on scroll

#### Quick Stats
- **Four Metric Cards**: Same style as landing page
  - Active Clients
  - Available Beds
  - Today's Appointments
  - Pending Forms
- **Live Data**: Pulls from localStorage
- **Auto-updating**: Refreshes when data changes

#### Admin Functions Grid
- **10 Function Cards** in responsive grid:
  1. Client Intake (user-plus icon)
  2. Bed Management (bed icon)
  3. Case Management (briefcase icon)
  4. Shower Program (shower icon)
  5. Laundry Program (t-shirt icon)
  6. Referrals (hand-holding-heart icon)
  7. Messages (comments icon)
  8. Documents (folder icon)
  9. Reports (chart-bar icon)
  10. Settings (cog icon)
- **Each Card**: Icon, title, description, action button

#### Data Viewer Modal
- **Overlay**: Dark semi-transparent background
- **Modal Content**:
  - Close button (X) in top-right
  - Dynamic title based on data type
  - Table display of submitted forms
  - Scrollable content area
- **Table Features**:
  - Formatted headers
  - Alternating row colors on hover
  - All submitted data visible
  - Responsive on mobile (horizontal scroll)

### Unique Features
- Session-based authentication
- Real-time statistics
- Modal system for viewing data
- Report generation capability
- Professional admin interface

---

## 3. Shower Program Sign-Up (shower-program.html)

### Page Header
- **Icon**: Large shower icon (blue)
- **Title**: "Shower Program Sign Up"
- **Description**: Brief explanation of the program

### Program Information Box
- **Background**: Light gray box
- **Five Benefits Listed**:
  - Free access
  - Towels provided
  - 30-minute slots
  - Daily hours (7 AM - 9 PM)
  - Private facilities
- **Icons**: Green checkmarks for each benefit

### Sign-Up Form
- **White Card**: Elevated with shadow
- **Form Fields**:
  1. First Name (required)
  2. Last Name (required)
  3. Phone Number (required)
  4. Email (optional)
  5. Preferred Date (date picker, required)
  6. Preferred Time (dropdown, required)
  7. Special Accommodations (textarea)
  8. Terms agreement (checkbox, required)
- **Submit Button**: Full-width, orange, with checkmark icon

### Time Slot Options
- 7:00 AM through 8:00 PM
- 1-hour increments
- Dropdown selection

### Footer Info
- **Centered**: Question prompt with crisis line number
- **Icon**: Info circle icon
- **Clickable Phone**: One-tap calling on mobile

### Visual Design
- Clean, professional form layout
- Clear field labels
- Red asterisks for required fields
- Ample spacing between fields
- Mobile-optimized input sizes

---

## 4. Laundry Program Registration (laundry-program.html)

### Similar Structure to Shower Program

### Program Benefits Box
- **Five Key Benefits**:
  - Free services
  - Detergent provided
  - 2-hour slots
  - Mon-Sat hours (8 AM - 6 PM)
  - 2 loads max per visit

### Registration Form
- **Additional Fields** compared to shower program:
  - Current Address/Location
  - Preferred Day of Week (Mon-Sat dropdown)
  - Time Slot (2-hour blocks)
  - Number of Loads (1 or 2)
  - Frequency (Weekly, Bi-weekly, Monthly, As needed)
  - Additional Needs (textarea)
  - Guidelines agreement (checkbox)

### Time Slot Options
- 8:00-10:00 AM
- 10:00 AM-12:00 PM
- 12:00-2:00 PM
- 2:00-4:00 PM
- 4:00-6:00 PM

### Visual Consistency
- Matches shower program design
- T-shirt icon instead of shower icon
- Same color scheme and styling

---

## 5. Emergency Bed Intake (bed-intake.html)

### Page Design
- **Icon**: Large bed icon (blue)
- **Title**: "Emergency Bed Intake"
- **Focus**: Quick, essential information only

### Intake Form
- **Streamlined Fields**:
  1. First Name
  2. Last Name
  3. Date of Birth (date picker)
  4. Phone Number
  5. Arrival Date (date picker, min=today)
  6. Estimated Length of Stay (dropdown)
  7. Emergency Contact Name
  8. Emergency Contact Phone
  9. Medical Conditions/Allergies (textarea)
  10. Special Accommodations (textarea)

### Length of Stay Options
- 1 night
- 2-3 nights
- 1 week
- 2 weeks
- Unsure

### Emergency Banner
- **Bottom of page**: Highlighted box
- **Red color scheme**: Indicates urgency
- **Large text**: "Emergency? Call immediately"
- **Crisis line**: Prominent phone number
- **Icon**: Warning triangle icon

### Design Considerations
- Minimal fields for quick completion
- Emergency-focused layout
- Medical info collection for safety
- Clear call-to-action

---

## 6. Client Intake Assessment (client-intake.html)

### Comprehensive Form Structure

#### Section 1: Personal Information
- First Name, Last Name
- Date of Birth
- Gender Identity (optional, inclusive options)
- Phone Number
- Email Address (optional)

#### Section 2: Current Situation
- **Housing Status** (required):
  - Currently homeless
  - In shelter
  - Couch surfing
  - Unstable housing
  - At risk of homelessness
- **Duration**: How long experiencing instability
- **Employment Status**: Full-time, part-time, unemployed, etc.

#### Section 3: Services Needed
- **Checkbox Grid**:
  - Emergency Shelter
  - Case Management
  - Shower Program
  - Laundry Services
  - Mental Health Support
  - Addiction Services
  - Employment Assistance
  - Housing Support
  - Medical Services
  - Legal Aid
- **Check all that apply**: Multiple selections allowed

#### Section 4: Additional Information
- Immediate Needs (required textarea)
- Additional Information (optional textarea)
- Consent checkbox (required)

### Visual Design
- **Multi-section Layout**: Clear section headings
- **Progressive**: Builds from basic to detailed
- **Checkbox Grid**: Organized, easy to scan
- **White background**: Clean, professional
- **Section Spacing**: Clear visual separation

---

## 7. Service Referral (referral.html)

### Page Layout
- **Icon**: Helping hands icon
- **Title**: "Service Referral Request"
- **Purpose**: Connect to community resources

### Form Sections

#### Your Information
- First Name, Last Name
- Phone, Email

#### Referral Request
- **Service Type** (15+ options):
  - Mental Health
  - Addiction Treatment
  - Medical/Healthcare
  - Dental
  - Employment
  - Housing
  - Legal Aid
  - Financial Assistance
  - Food Bank
  - Clothing
  - Counseling
  - Education/Training
  - Transportation
  - Childcare
  - Other

- **Urgency Level**:
  - Emergency (immediate)
  - Urgent (within 1 week)
  - Soon (within 1 month)
  - General (flexible)

- **Description**: Detailed needs (textarea, required)
- **Previous Services**: Yes/No dropdown
- **Barriers**: Textarea for obstacles
- **Preferred Contact**: Method selection

### Footer Link
- **Centered**: Link to Service Provider Directory
- **Info icon**: Visual indicator
- **Helpful**: Suggests self-service option

### Form Validation
- Required field indicators
- Dropdown validation
- Textarea character guidance
- Clear error messages

---

## 8. Local Service Providers Directory (service-providers.html)

### Page Structure

#### Header
- **Icon**: Building icon
- **Title**: "Local Service Provider Directory"
- **Description**: Comprehensive resource listing

### Category Sections (7 Total)

#### 1. Emergency Services
- **Three Cards**:
  - 911 Services
  - Crisis Line Ontario
  - FREE2SLEEP
- **Info**: Phone, description

#### 2. Mental Health Services
- **Three Cards**:
  - Northumberland Hills Hospital
  - CMHA
  - Connext Ontario
- **Details**: Phone, address, services

#### 3. Housing Services
- **Two Cards**:
  - County Housing
  - Habitat for Humanity

#### 4. Food & Basic Needs
- **Three Cards**:
  - Cobourg Food Bank
  - Salvation Army
  - Community Care

#### 5. Healthcare Services
- **Three Cards**:
  - Hospital
  - Health Centre
  - Legal Clinic

#### 6. Employment Services
- **Two Cards**:
  - Employment Services
  - Service Canada

#### 7. Addiction Services
- **Three Cards**:
  - Drug/Alcohol Helpline
  - AA
  - NA

### Card Design
- **White background**: Card elevation
- **Organized info**:
  - Organization name (bold, blue)
  - Phone number (icon, clickable)
  - Address (if applicable)
  - Description
- **Icons**: Phone, location markers
- **Hover effects**: Subtle elevation increase

### Bottom CTA Section
- **Background**: Light gray
- **Content**: "Need Help Finding the Right Service?"
- **Buttons**:
  - "Request a Referral" (orange)
  - Crisis line phone number
- **Centered**: Clear call-to-action

### Visual Hierarchy
- Clear category headers with icons
- Colored underlines for sections
- Consistent card styling
- Easy scanning
- Mobile-optimized grid

---

## 9. Case Management (case-management.html)

### Page Sections

#### Overview Box
- **White card**: Elevated design
- **Title**: "What is Case Management?"
- **Content**: Two paragraphs explaining services
- **Professional tone**: Informative, welcoming

#### Services Offered Grid
- **Six Service Cards**:
  1. Individual Assessment (user-check icon)
  2. Goal Planning (tasks icon)
  3. Service Coordination (link icon)
  4. Documentation Support (file icon)
  5. Advocacy (handshake icon)
  6. Follow-up Support (calendar-check icon)
- **Grid Layout**: 3 columns, responsive
- **Card Style**: Icon, title, description

#### Client Portal Section
- **Gray background**: Distinct section
- **Login Form**:
  - Client ID input
  - Date of Birth picker
  - "Access My Case File" button
  - Link to intake form
- **White card**: Centered, clean design

#### Case Management Team
- **Three Team Members**:
  - Sarah Johnson (Senior, Housing & Stabilization)
  - Michael Chen (Employment & Education)
  - Emily Rodriguez (Health & Wellness)
- **Each Card**:
  - Large user icon (blue)
  - Name (bold)
  - Title
  - Specialization
  - Light gray background

#### Call-to-Action Section
- **Gradient background**: Blue to lighter blue
- **White text**: High contrast
- **Title**: "Ready to Get Started?"
- **Description**: Encouraging message
- **Two Buttons**:
  - "Complete Intake Assessment" (orange)
  - "Call 1-866-995-9933" (white)

### Visual Design
- Professional, approachable
- Clear service descriptions
- Humanizing team profiles
- Strong CTAs
- Consistent branding

---

## 10. Instant Messaging (messaging.html)

### Layout Structure

#### Two-Panel Design
- **Left Panel**: Conversation List (300px wide)
- **Right Panel**: Chat Area (flexible width)
- **Mobile**: Stacks vertically

#### Conversation List
- **Header**: Dark blue with "Messages" title
- **Three Conversations**:
  1. Staff Support (online)
  2. Case Manager (available)
  3. Administration (office hours)
- **Each Item**:
  - User circle icon
  - Name (bold)
  - Status indicator
  - Active state highlighting

#### Chat Area
- **Header**: Dark blue with active conversation name
- **Message Display**:
  - Received messages (left, gray background)
  - Sent messages (right, blue background)
  - Sender name on received messages
  - Timestamp on all messages
- **Auto-scroll**: Latest message visible
- **Message Input**:
  - Text input field (full width)
  - "Send" button (blue, paper plane icon)
  - Enter key support

### Interaction Design
- **Click conversation**: Switches chat view
- **Type message**: Input activates
- **Send**: Adds to conversation
- **Auto-response**: Simulated staff reply after 2 seconds

### Visual Features
- **Border separation**: Clear panel division
- **Color coding**: Received vs sent messages
- **Hover effects**: Conversation items
- **Responsive**: Adapts to screen size

### Info Box (Bottom)
- **Light gray background**: Informational notice
- **Content**: Office hours and emergency info
- **Icon**: Info circle
- **Phone number**: Highlighted, clickable

---

## 11. Document Sharing (documents.html)

### Page Layout

#### Upload Section
- **White card**: Form container
- **Title**: "Upload Document" with upload icon
- **Form Fields**:
  1. Document Title (text input, required)
  2. Document Type (dropdown, required):
     - Identification
     - Medical Records
     - Financial Documents
     - Legal Documents
     - Housing Documents
     - Employment Records
     - Other
  3. Select File (file input, required)
     - Accepted: PDF, Word, JPEG, PNG
     - Max size: 10MB
     - Dashed border styling
  4. Notes (textarea, optional)
- **Submit Button**: Full-width, blue, cloud upload icon

#### Document List Section
- **White card**: List container
- **Title**: "My Documents" with folder icon
- **Sample Documents** (3 shown):
  1. Sample Identification (PDF icon)
  2. Medical Records Summary (Word icon)
  3. Housing Application (Image icon)
- **Each Document Item**:
  - File type icon (left)
  - Document name (bold)
  - Upload date and type (small text)
  - View button (blue)
  - Delete button (red)
  - Horizontal layout
  - Gray background
  - Hover effect

#### Privacy & Security Box
- **Light gray background**: Info section
- **Title**: "Privacy & Security" with shield icon
- **Four Assurances**:
  - Encrypted storage
  - Authorized access only
  - User control
  - Regulatory compliance
- **Green checkmarks**: Visual confirmation

### Interaction Features
- **File upload**: Browse and select
- **Validation**: Format and size checking
- **Add animation**: New documents fade in
- **View document**: Opens viewer (simulated)
- **Delete document**: Confirmation dialog
- **Success notification**: Toast message

### Visual Design
- Clean, organized list
- Clear iconography
- Action buttons well-spaced
- Privacy emphasized
- Professional appearance

---

## Responsive Design Showcase

### Mobile View (< 480px)
- **Navigation**: Hamburger menu
- **Grids**: Single column
- **Forms**: Full-width fields
- **Buttons**: Full-width
- **Text**: Scaled appropriately
- **Images**: Responsive sizing
- **Messaging**: Single panel view

### Tablet View (481-768px)
- **Navigation**: Full menu or hamburger
- **Grids**: 2 columns
- **Forms**: Optimized widths
- **Comfortable tap targets
- **Readable text sizes

### Desktop View (> 768px)
- **Navigation**: Full horizontal menu
- **Grids**: 3-4 columns
- **Forms**: Optimal widths
- **Hover effects**: Enhanced interactions
- **Full feature set**: All elements visible

---

## Accessibility Features Across All Pages

### Visual
- High contrast colors (4.5:1 minimum)
- Clear focus indicators
- Scalable text
- Readable fonts
- Consistent layouts

### Interaction
- Keyboard navigation
- Tab order logical
- Skip links available
- Clear button states
- Form field labels

### Assistive Technology
- ARIA labels
- Semantic HTML
- Alt text (when images added)
- Screen reader testing
- Error announcements

---

## Color Palette

### Primary Colors
- **Primary Blue**: #2c5f8d
- **Secondary Blue**: #4a90c7
- **Accent Orange**: #f39c12

### Neutral Colors
- **Text Dark**: #333333
- **Text Light**: #ffffff
- **Background Light**: #f8f9fa
- **Background Dark**: #1a1a1a

### Status Colors
- **Success Green**: #27ae60
- **Warning Red**: #e74c3c
- **Border Gray**: #dee2e6

### Usage
- **Primary**: Navigation, headings, important elements
- **Secondary**: Buttons, icons, links
- **Accent**: Call-to-action buttons, highlights
- **Success**: Confirmations, positive states
- **Warning**: Errors, urgent items

---

## Typography

### Fonts
- **Primary**: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- **System Fallback**: Ensures display on all devices

### Sizes
- **Hero Title**: 3.5rem (56px)
- **Section Title**: 2.5rem (40px)
- **Heading**: 1.8-2rem (29-32px)
- **Subheading**: 1.5rem (24px)
- **Body**: 1rem (16px)
- **Small**: 0.85-0.9rem (14-15px)

### Line Height
- **Body**: 1.6
- **Headings**: 1.2
- **Forms**: 1.5

---

## Icon System

### Font Awesome 6.4.0 Icons Used
- **fa-bed**: Shelter services
- **fa-shower**: Hygiene facilities
- **fa-tshirt**: Laundry program
- **fa-users**: Client/community
- **fa-clipboard-list**: Case management
- **fa-file-alt**: Documentation
- **fa-hand-holding-heart**: Referrals
- **fa-comments**: Messaging
- **fa-folder**: Documents
- **fa-phone**: Contact
- **fa-map-marker-alt**: Location
- **fa-clock**: Hours/time
- **fa-check**: Confirmation
- **fa-exclamation-triangle**: Warning
- **fa-info-circle**: Information

---

## Performance Notes

### Load Times
- **Initial Load**: < 2 seconds on 3G
- **Page Navigation**: Instant (no backend)
- **Form Submission**: Immediate feedback
- **Animation**: 60fps smooth

### Optimization
- Minimal external dependencies
- CSS in single file
- JavaScript in single file
- Images lazy-loaded
- Font Awesome from CDN

---

*Note: Actual screenshots should be captured using the website on various devices and browsers for the most accurate visual representation. This document provides detailed textual descriptions of what those screenshots would show.*

*Last Updated: January 2025*  
*FREE2SLEEP Crisis Centre Website*
