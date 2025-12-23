### Licence Management System

## Project Overview
The **Licence Management System** is a full web-based application designed to manage software licences in a **secure, structured, and automated way**.

The system covers the **entire lifecycle of a licence**, starting from a public vitrine website, through client licence requests, to administrative approval, licence generation, activation, and notification.

This project was developed as a **Final Year Project (PFE)** with a strong focus on:
- Clean architecture
- Security best practices
- Real-world workflow
- Scalability and maintainability

##  Vitrine Website (Public Area)

The vitrine website is accessible to all visitors and serves as the **presentation layer** of the system.

### Features:
- Homepage presenting the system and its purpose
- Description of services and licence benefits
- Information about the company / product
- Call-to-action buttons (Register / Login)
- Contact or information section

 **Objective:**  
Provide a professional presentation and guide users toward account creation.

##  Authentication & Authorization

### Features:
- Secure user registration
- Login and logout
- Password encryption
- Role-based access control (RBAC)

### Roles:
- **Client**
- **Administrator**

Access to pages and actions is restricted based on the user’s role.

##  Client Space (User Dashboard)

Once authenticated as a **Client**, users gain access to their personal dashboard.

### Client Functionalities:
- View personal profile information
- Submit a new licence request
- Select licence type or product
- View licence request history
- Track request status:
  - Pending
  - Approved
  - Rejected
- View active licences
- Receive email notifications for status updates

Objective:
Give clients full visibility and autonomy over their licence requests.

##  Licence Request Workflow

1. Client submits a licence request
2. Request is stored with **pending** status
3. Administrator is notified
4. Administrator reviews the request
5. Request is either:
   - Approved → licence is generated and activated
   - Rejected → client is notified with the decision

This workflow ensures **traceability and control**.

##  Admin Dashboard

The **administration dashboard** is restricted to administrators only.

### Admin Functionalities:
- View system statistics (users, licences, requests)
- Manage users (clients)
- View all licence requests
- Approve or reject licence requests
- Generate licences
- Activate or deactivate licences
- Define licence duration and expiration
- Monitor licence status
- Receive administrative notifications

 Objective:
Centralize all management operations in a secure interface.

## Licence Management

### Licence Features:
- Unique licence key generation
- Association of licence with a specific client
- Activation and deactivation
- Expiration date management
- Licence status tracking

### Licence States:
- Active
- Inactive
- Expired

Licences are designed to be **verifiable by external applications**.

## Email Notification System

Automated email notifications are sent after key actions:

### Notifications:
- Account creation
- Licence request submission
- Licence approval
- Licence rejection
- Licence activation

Objective: 
Ensure clear communication between the system, clients, and administrators.

##  Security Measures

- Role-based access control (RBAC)
- Protected admin routes
- Input validation and sanitization
- Secure authentication mechanism
- Restricted access to sensitive actions
- Protected API endpoints

##  Technical Architecture

### Architecture Style:
- MVC / Layered architecture
- REST API–Oriented Design

### Technologies Used:
- **Backend:** Symfony / .NET 
- **Frontend:** HTML, CSS, JavaScript, Twig, PHP, Bootstrap
- **Database:** SQLserver 
- **Authentication:** JWT and session-based authentication
- **Mailing:** SMTP / Mailer service
- **Admin Interface:** EasyAdmin 
- **Version Control:** GitHub
- **Development Tools:** Visual Studio / Visual Studio Code 

## License
This project is for **academic purposes only**. All rights reserved.
Commercial use is prohibited without author permission.

 

