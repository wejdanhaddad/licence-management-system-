Twinkle-IT Licence Management Platform

Vitrine Website • Client Dashboard • Admin Dashboard • Secure API Integration

Project Overview :

The Twinkle-IT Licence Management Platform is a full-stack web application designed to manage software licences in a secure, structured, and automated way.

The platform combines:

A public vitrine website

A client space 

An administrator dashboard

Integration with a secure License Management API (JWT & role-based access)

It covers the entire licence lifecycle, from public presentation and client licence requests to administrative validation, licence generation, activation, and notification.

This project was developed as a Final Year Project (PFE) with a strong focus on:

Clean and modular architecture

Security best practices

API-driven design

Real-world business workflows

Scalability and maintainability

Public Vitrine Website :

The vitrine website is accessible to all visitors and serves as the presentation and onboarding layer.
 
Features :

Homepage presenting Twinkle-IT and its products

Overview of licence-based services

Description of licence benefits and use cases

Call-to-action buttons (Register / Login)

Contact and informational sections

Objective:
Provide a professional first impression and guide visitors toward account creation and platform usage.

Authentication & Authorization

The platform implements a secure authentication and authorization system.

Features

User registration and login

Secure password hashing

JWT-based authentication

Role-based access control (RBAC)

User Roles :

Client

Administrator

Access to pages, dashboards, and API endpoints is strictly restricted based on the authenticated user’s role.

Client Space (User Dashboard)

Authenticated clients gain access to a dedicated client dashboard.

Client Functionalities

View and manage personal profile

Submit licence requests

Select product, licence type, and duration

Track licence request history

Monitor request status:

Pending

Approved

Rejected

View assigned licences

Check licence activation and expiration

Receive automated email notifications

Objective:
Provide clients with transparency, autonomy, and real-time visibility over their licences.

Licence Request Workflow

Client submits a licence request

Request is stored with Pending status

Administrator is notified

Administrator reviews the request

Outcome:

Approved → licence is generated and activated via the API

Rejected → client is notified

This workflow ensures traceability, control, and accountability.

Administrator Dashboard

The administration dashboard is restricted to administrators only.

Admin Functionalities :

View system statistics (users, licences, requests)

Manage client accounts

Review all licence requests

Approve or reject requests

Generate licence keys

Activate or deactivate licences

Define licence duration and expiration

Monitor licence status

Receive administrative notifications

Objective:
Centralize all licence and user management operations in a secure and controlled interface.

Licence Management (API-Driven)

Licence operations are handled through a dedicated secure License Management API, developed as a separate backend service.

Licence Features :

Unique licence key generation

Licence association with client and product

Activation and deactivation

Expiration date management

Licence status verification

Licence States

Active

Inactive

Expired

Licences are designed to be verifiable by external applications through secured API endpoints.

UI / UX Design :

Special attention was given to UI/UX design to ensure the platform is intuitive, professional, and easy to use for both clients and administrators.

UI Principles :

Clean and modern interface

Consistent layout and visual hierarchy

Responsive design

Clear typography and spacing

Visual feedback for user actions (success, error, loading)

UX Approach :

User-centered design based on real business workflows

Minimal steps for critical actions (request, approval, activation)

Clear navigation between sections

Role-based interfaces:

Clients see only relevant features

Administrators access advanced management tools

Explicit status indicators (Pending, Approved, Active, Expired)

Objective:
Deliver a professional user experience comparable to real-world enterprise platforms.

Email Notification System

Automated emails are sent after key actions.

Notifications

Account creation

Licence request submission

Licence approval

Licence rejection

Licence activation

Objective:
Ensure clear and timely communication between clients and administrators.

Security Measures :

JWT-based authentication

Role-based access control (RBAC)

Protected admin and client routes

Secured API endpoints

Input validation and sanitization

Restricted access to sensitive operations

Security is enforced both at the frontend and API levels.

Technical Architecture :
Architecture Style :

Layered / MVC architecture

REST API–oriented design

Separation of concerns

Technologies Used :

Frontend :

HTML, CSS, JavaScript

Bootstrap

Twig / PHP

Backend :

Symfony (vitrine & dashboards)

ASP.NET Core / .NET XAF (License Management API)

Database :

SQL Server

Authentication :

JWT

Session-based authentication

Mailing :

SMTP / Mailer service

Admin Interface

EasyAdmin

Version Control :

GitHub

Development Tools :

Visual Studio

Visual Studio Code

Related Project :

This repository works in conjunction with a Secure License Management API, responsible for:

Licence generation

Licence activation/deactivation

Licence verification

Secure access using JWT and roles

Project Purpose :

This project demonstrates:

Full-stack web development skills

Secure API integration

Real-world licence management workflows

Clean, maintainable, and scalable architecture

Professional software engineering practices

License :

This project was developed for academic purposes (PFE).
All rights reserved.
Commercial use is prohibited without explicit author permission.
