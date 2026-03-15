# Salon Management System

A comprehensive web-based salon management platform built with PHP that streamlines appointment booking, service management, product ordering, and admin operations for salon businesses.

## ✨ Features

### Customer Features
- **User Authentication**: Secure login and registration system
- **Appointment Management**: 
  - Book appointments with availability checking
  - View appointment history
  - Track upcoming appointments
- **Service Browsing**: Browse and view salon services
- **Product Shopping**:
  - Search products
  - Add items to cart and wishlist
  - Checkout and order placement
- **Order Tracking**: View current and past orders
- **Profile Management**: Update personal profile and preferences
- **Contact System**: Send inquiries and messages

### Admin Features
- **Admin Dashboard**: Manage salon operations
- **Appointment Management**: View and manage all appointments
- **Service Management**: Add and manage services offered
- **User Management**: Manage customer accounts
- **Order Management**: Track and process customer orders

## 📁 Project Structure

```
Salon_Management_System/
├── admin panel/              # Admin dashboard and management
├── components/               # Reusable UI components
├── css/                      # Stylesheets
├── js/                       # JavaScript files
├── image/                    # Image assets
├── uploaded_files/           # User-uploaded content
├── index.php                 # Homepage
├── login.php                 # User login page
├── register.php              # User registration
├── profile.php               # User profile management
├── update.php                # Update user information
├── about-us.php              # About page
├── contact.php               # Contact form
├── services.php              # Services listing
├── view_services.php         # Service details view
├── book_appointment.php       # Appointment booking
├── appointment_history.php    # Appointment history
├── view_appointments.php      # View appointments
├── cart.php                  # Shopping cart
├── checkout.php              # Order checkout
├── orders.php                # Order management
├── view_orders.php           # View order details
├── wishlist.php              # Wishlist management
├── search_product.php        # Product search
├── menu.php                  # Navigation menu
├── view_page.php             # Dynamic page viewer
└── README.md                 # Project documentation
```

## 🛠️ Prerequisites

Before running this project, ensure you have:

- **PHP**: Version 7.0 or higher
- **MySQL**: Version 5.7 or higher
- **Web Server**: Apache with mod_rewrite enabled
- **Browser**: Modern web browser (Chrome, Firefox, Safari, Edge)

## 📦 Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/Satyakam-Gupta/Salon_Management_System.git
cd Salon_Management_System
```

### Step 2: Set Up Database
1. Create a new MySQL database for the project:
   ```sql
   CREATE DATABASE salon_management;
   ```

2. Import the database schema (if provided):
   ```bash
   mysql -u root -p salon_management < database.sql
   ```

### Step 3: Configure Database Connection
1. Locate the database configuration file (typically in `components/` or root)
2. Update the connection parameters:
   ```php
   $host = 'localhost';
   $user = 'root';
   $password = 'your_password';
   $database = 'salon_management';
   ```

### Step 4: Deploy Files
1. Move the project files to your web server directory (htdocs for Apache)
2. Set appropriate permissions for uploaded_files directory:
   ```bash
   chmod 755 uploaded_files
   ```

### Step 5: Start Services
1. Start Apache and MySQL services
2. Access the application at `http://localhost/Salon_Management_System/`

## 🚀 Usage

### For Customers
1. **Register/Login**: Create an account or log in with existing credentials
2. **Browse Services**: View available salon services
3. **Book Appointment**: Select service, date, and time
4. **Shop Products**: Browse and purchase salon products
5. **Manage Orders**: Track order status and history
6. **Update Profile**: Manage personal information and preferences

### For Admins
1. **Login** with admin credentials
2. **Dashboard**: Access the admin panel
3. **Manage Appointments**: View and confirm bookings
4. **Manage Services**: Add, edit, or remove services
5. **Process Orders**: Handle customer orders and payments
6. **View Users**: Manage customer accounts

## 📚 Key Modules

| Module | Purpose |
|--------|---------|
| Authentication | User login/registration and session management |
| Appointments | Booking, viewing, and managing appointments |
| Services | Browse and manage salon services |
| Products | Product catalog, shopping cart, checkout |
| Orders | Order placement, tracking, and history |
| Admin Panel | Administrative operations and management |
| User Profile | Personal information and preferences |
| Search | Product and content search functionality |
| Contact | Customer inquiries and communication |

## 💻 Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.0+
- **Database**: MySQL
- **Server**: Apache Web Server
- **Architecture**: MVC-inspired structure

## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the MIT License.

## 📞 Support

For support and inquiries:
- Visit the Contact page in the application
- Create an issue in the GitHub repository
- Review the About Us page for more information

---

**Created by**: Satyakam-Gupta  
**Last Updated**: March 2026
