# Twinkle-IT Licence Management Platform

> **Vitrine Website • Client Dashboard • Admin Dashboard • Secure API Integration**

A **full-stack licence management platform** designed to manage software licences in a **secure, structured, and automated** way.
Developed as a **Final Year Project (PFE)**, this project follows **professional software engineering practices**, real-world business workflows, and modern security standards.

---

## 📌 Project Overview

The **Twinkle-IT Licence Management Platform** covers the **entire licence lifecycle**, from public product presentation to licence generation, activation, and monitoring.

The platform combines:

*  **Public Vitrine Website**
*  **Client Space (User Dashboard)**
*  **Administrator Dashboard**
*  **Secure License Management API** (JWT & role-based access)

###  Key Focus Areas

* Clean & modular architecture
* Secure authentication & authorization
* API-driven design
* Real-world business workflows
* Scalability & maintainability

---

## 🌐 Public Vitrine Website

Accessible to all visitors, the vitrine website serves as the **presentation and onboarding layer**.

### Features

* Homepage presenting **Twinkle-IT** and its products
* Overview of licence-based services
* Description of licence benefits & use cases
* Call-to-action buttons (**Register / Login**)
* Contact and informational sections

**Objective**
Provide a professional first impression and guide visitors toward platform adoption.

---

##  Authentication & Authorization

A robust security system ensures controlled access to platform features.

### Features

* User registration & login
* Secure password hashing
* JWT-based authentication
* Role-Based Access Control (RBAC)

### User Roles

* **Client**
* **Administrator**

Access to dashboards, routes, and API endpoints is strictly restricted based on authenticated roles.

---

##  Client Space (User Dashboard)

Authenticated users gain access to a dedicated **client dashboard**.

### Client Functionalities

* Manage personal profile
* Submit licence requests
* Select product, licence type & duration
* Track licence request history
* Monitor request status:

  * Pending
  * Approved
  * Rejected
* View assigned licences
* Check activation & expiration dates
* Receive automated email notifications

**Objective**
Offer transparency, autonomy, and real-time visibility over licences.

---

##  Licence Request Workflow

1. Client submits a licence request
2. Request is stored with **Pending** status
3. Administrator is notified
4. Admin reviews the request

### Outcomes

* ✅ **Approved** → Licence generated & activated via API
* ❌ **Rejected** → Client notified by email

This workflow ensures **traceability, control, and accountability**.

---

## 🛠️ Administrator Dashboard

Restricted to administrators only.

### Admin Functionalities

* View system statistics (users, licences, requests)
* Manage client accounts
* Review all licence requests
* Approve or reject requests
* Generate licence keys
* Activate / deactivate licences
* Define licence duration & expiration
* Monitor licence states
* Receive administrative notifications

**Objective**
Centralize all licence and user management operations in a secure interface.

---

## 🔗 Licence Management (API-Driven)

Licence operations are handled by a **dedicated secure backend API**, developed as a separate service.

### Licence Features

* Unique licence key generation
* Licence association with client & product
* Activation & deactivation
* Expiration date management
* Licence status verification

### Licence States

* Active
* Inactive
* Expired

Licences can be verified by **external applications** through secured API endpoints.

🔗 **API Repository**
👉 [https://github.com/wejdanhaddad/Secure-License-API](https://github.com/wejdanhaddad/Secure-License-API)

---

## 🎨 UI / UX Design

Special attention was given to **UI/UX design** to ensure a professional and intuitive experience.

### UI Principles

* Clean & modern interface
* Consistent layout & visual hierarchy
* Responsive design
* Clear typography & spacing
* Visual feedback (success, error, loading states)

### UX Approach

* User-centered workflows
* Minimal steps for critical actions
* Clear navigation between sections
* Role-based interfaces
* Explicit status indicators

**Objective**
Deliver a UX comparable to real-world enterprise platforms.

---

## 📧 Email Notification System

Automated email notifications are sent after key actions.

### Notifications

* Account creation
* Licence request submission
* Licence approval
* Licence rejection
* Licence activation

**Objective**
Ensure clear and timely communication between clients and administrators.

---

##  Security Measures

* JWT-based authentication
* Role-Based Access Control (RBAC)
* Protected client & admin routes
* Secured API endpoints
* Input validation & sanitization
* Restricted access to sensitive operations

Security is enforced at **both frontend and backend levels**.

---

##  Technical Architecture

### Architecture Style

* Layered / MVC architecture
* REST API–oriented design
* Separation of concerns

### Technologies Used

#### Frontend

* HTML, CSS, JavaScript
* Bootstrap
* Twig
* PHP

#### Backend

* Symfony (vitrine & dashboards)
* ASP.NET Core / .NET XAF (License Management API)

#### Database

* SQL Server

#### Authentication

* JWT
* Session-based authentication

#### Mailing

* SMTP / Mailer Service

#### Admin Interface

* EasyAdmin

#### Version Control

* Git & GitHub

#### Development Tools

* Visual Studio
* Visual Studio Code

---

##  Project Purpose

This project demonstrates:

* Full-stack web development expertise
* Secure API integration
* Professional licence management workflows
* Clean, scalable & maintainable architecture
* Industry-aligned software engineering practices

---

## 📄 License

This project was developed **for academic purposes (PFE)**.

**All rights reserved.**
Commercial use is prohibited without explicit author permission.

---

✨ *Designed & developed as a professional-grade licence management platform.*
