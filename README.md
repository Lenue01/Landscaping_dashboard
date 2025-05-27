# Lee's Landscaping Dashboard
[![Ask DeepWiki](https://devin.ai/assets/askdeepwiki.png)](https://deepwiki.com/Lenue01/Landscaping_dashboard)

Lee's Landscaping Dashboard is a web-based application designed to help manage customer information, service records, billing, and payments for a landscaping business. It provides a central dashboard to view key metrics, add new customers and services, track payments, and simulate email reminders for outstanding balances.

## Features

*   **Dashboard Overview**: Displays total revenue, total customers, active projects, and a revenue overview chart.
*   **Customer Management**:
    *   Add new customers with details like name, title, phone, email, and address.
    *   View a list of all registered customers.
*   **Service Management**:
    *   Add new service entries, including customer ID, last name, bill amount, service date, and amount paid.
    *   View all service records.
    *   Update payment status for services.
    *   Delete service records.
*   **Billing & Payments**:
    *   Track bill amounts and amounts paid for each service.
    *   Add payments to existing service records.
*   **Email Notifications**: Simulates sending email reminders to customers with outstanding balances.
*   **Responsive Design**: Styled with Tailwind CSS for a modern and responsive user interface.

## Technologies Used

*   **Backend**: PHP
*   **Database**: MySQL (Database name: `Lee_lawn_care`)
*   **Frontend**: HTML, Tailwind CSS, JavaScript
*   **Charting**: Chart.js

## File Structure and Description

The `landscaping/` directory contains all the core files for the application:

*   `dashboard.php`: The main landing page displaying key business metrics and navigation.
*   `customers.php`: Handles the addition of new customer records to the database.
*   `view.php`: Displays a tabular list of all customers from the database.
*   `services.php`: Allows users to add new service entries for customers.
*   `view_services.php`: Displays all service records, with options to add payments or delete services.
*   `add_payment.php`: Provides a form to update the `amount_paid` for a specific service.
*   `delete_service.php`: Handles the deletion of a service record from the database.
*   `email.php`: Simulates the process of sending email reminders for unpaid invoices.
*   `styles.css`: Contains custom CSS rules for the application, complementing Tailwind CSS.

## Setup and Running the Application

1.  **Prerequisites**:
    *   A web server environment like XAMPP, WAMP, or MAMP.
    *   MySQL database server.

2.  **Database Setup**:
    *   Create a MySQL database named `Lee_lawn_care`.
    *   You will need to create two tables: `customers` and `services`.
        *   **`customers` table schema (example)**:
            ```sql
            CREATE TABLE customers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_F_Name VARCHAR(255) NOT NULL,
                customer_L_Name VARCHAR(255) NOT NULL,
                customer_Title VARCHAR(50),
                customer_Phone VARCHAR(20),
                customer_Email VARCHAR(255),
                street_Address VARCHAR(255),
                city VARCHAR(100),
                state VARCHAR(100),
                zip VARCHAR(20)
            );
            ```
        *   **`services` table schema (example)**:
            ```sql
            CREATE TABLE services (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT,
                customer_L_Name VARCHAR(255), -- Consider normalizing this or ensuring consistency
                bill_amount DECIMAL(10, 2),
                service_date DATE,
                amount_paid DECIMAL(10, 2) DEFAULT 0.00,
                FOREIGN KEY (customer_id) REFERENCES customers(id) -- Optional, but good practice
            );
            ```
    *   Update database connection credentials in each PHP file if they differ from the defaults:
        ```php
        $servername = "localhost";
        $username = "root"; // Your MySQL username
        $password = "";     // Your MySQL password
        $dbname = "Lee_lawn_care";
        ```

3.  **Deploy Files**:
    *   Clone or download the repository.
    *   Place the `landscaping` folder into your web server's document root (e.g., `htdocs` for XAMPP).

4.  **Access the Application**:
    *   Start your Apache and MySQL services.
    *   Open your web browser and navigate to `http://localhost/landscaping/dashboard.php`.

## Usage

*   **Dashboard**: Provides an overview of business metrics. Use the navigation bar or sidebar to access different modules.
*   **Add Customers**: Navigate to "Add Customers" to input and save new customer details.
*   **View Customers**: Navigate to "View Customers" to see a list of all customers.
*   **Add Services**: Navigate to "Add Services" to record a new service provided to a customer. You will need the `customer_id`.
*   **View All Services**: Navigate to "View All Services" to see a list of all recorded services. From here, you can:
    *   Click "Add Payment" to update the amount paid for a service.
    *   Click "Delete" to remove a service record.
*   **Email Invoices**: Navigate to "Email Invoices" to see a simulation of email reminders being sent for outstanding balances. (Note: Actual email sending functionality is not implemented, it only displays the simulated email content).
