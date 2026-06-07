# Employee Leave Management System

A web-based Employee Leave Management System built using **Core PHP**, **MySQL**, **Bootstrap**, **JavaScript**, **jQuery**, and **AJAX**.

---

## Features

### Authentication & Authorization

- Login using Email and Password
- Password hashing using `password_hash()`
- Session-based authentication
- Role-based access control
- Secure logout functionality

---

## User Roles

### Administrator

- Dashboard with employee and leave statistics
- Create employees and user accounts
- Edit employee/user details
- Enable / Disable users
- Search users by:
  - Employee Name
  - Employee ID
  - Department
- Manage Leave Types
- Configure Leave Allocations
- View Leave Reports
- AJAX-based report filtering

### Manager

- Dashboard with leave request statistics
- View pending leave requests
- Approve leave requests (AJAX)
- Reject leave requests (AJAX)
- Add manager remarks for rejected requests

### Employee

- Dashboard with leave statistics
- Apply for leave (AJAX)
- View leave balance
- View leave history

---

## Leave Application Rules

The system validates:

- Start Date cannot be earlier than current date
- End Date cannot be earlier than Start Date
- Leave duration is calculated automatically
- Leave cannot exceed available balance
- Overlapping leave requests are not allowed
- Approved leave requests cannot be modified

---

## AJAX Features

The following operations are implemented using AJAX:

- Leave Application Submission
- Leave Approval
- Leave Rejection
- User Search
- Report Filtering

---

## Technology Stack

| Layer | Technology |
|---------|------------|
| Backend | PHP 8.x |
| Database | MySQL |
| Frontend | HTML5, CSS3, Bootstrap 5 |
| Scripting | JavaScript, jQuery |
| AJAX | jQuery AJAX |

---

## Project Structure

```text
employee-leave-management-system/
│
├── admin/
├── employee/
├── manager/
├── ajax/
├── assets/
├── config/
├── includes/
├── sql/
├── screenshots/
│
├── login.php
├── logout.php
└── README.md
```

---

## Database Setup

### Step 1

Create a database:

```sql
CREATE DATABASE employee_leave_management;
```

### Step 2

Import:

```text
sql/database.sql
```

### Step 3

Configure database credentials:

```php
config/database.php
```

Example:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "employee_leave_management";
```

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
```

Move the project into your web server directory:

### XAMPP

```text
htdocs/
```

### MAMP

```text
htdocs/
```

Start:

- Apache
- MySQL

Open:

```text
http://localhost/employee-leave-management-system/login.php
```

---

## Test Credentials

### Administrator

```text
Email: admin@company.com
Password: ********
```

### Manager

```text
Email: manager@company.com
Password: ********
```

### Employee

```text
Email: employee@company.com
Password: ********
```

---

## Assumptions

- Leave balances are generated automatically during employee creation.
- Leave balances are deducted only after manager approval.
- Rejected leave requests do not affect leave balance.
- Users are never physically deleted.
- User status is managed using Active / Inactive flags.

---

## Screenshots

Application screenshots are available in the:

```text
screenshots/
```

directory.

---

## Developer

**Prasad Datir**

PHP Full Stack Developer