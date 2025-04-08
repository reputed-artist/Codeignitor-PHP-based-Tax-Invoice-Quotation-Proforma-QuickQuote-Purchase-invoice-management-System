# CodeIgniter-PHP Tax Invoice, Quotation, Quick-Quotation, Purchase Invoice, and Account Management System

## 📌 Overview

This project is a comprehensive **Tax Invoice, Quotation, Proforma, Purchase Invoice, and Account Management System** built using **CodeIgniter (PHP)**. It streamlines business processes related to sales, purchases, invoices, client management, and account transactions while providing an insightful dashboard for turnover-based marketing analysis.

## 🚀 Features

### 🎯 Dashboard

- Marketing and sales turnover-based analytics
- Overview of key business metrics

### 👥 Client Management

- Add, update, and manage client details
- Categorize clients based on type

### 📦 Product Management

- Maintain product details and pricing
- Efficiently manage stock and product catalog

### 🏭 Supplier Management

- Store and manage supplier information
- Dual entity support (Client/Supplier)

### 📑 Invoice Management with Live HSN Code Change

- **Purchase Invoice Management**
  - Record and track supplier purchases
  - Manage Purchase Invoice
- **Sales Invoice Management**
  - Generate GST-compliant sales invoices
  - Maintain invoice history
- **Proforma Invoice Management**
  - Generate quotations and estimates

### 📦 Quotation Management

- **Client/Supplier Quotation Management**
  - Record and track quotations
  - Manage quotation data
  - Quick Quotation Also supported - POS Based Quick Quotation

### 📊 Reports & Analysis

- Generate various reports on sales, purchases, and client transactions
- Export data for further analysis

### ⚙️ Settings & Customization

- Update user profile
- Update company profile (name, details, bank information, etc.)
- Update bank details
- Change password for security
- Customize UI to match business branding

### 💰 Billing System

- **IGST**: Applied for out-of-state transactions
- **Loc (CGST & SGST)**: Applied for within-state transactions

### 🏷️ User Management

- **Client**: Can place orders and receive tax invoices
- **Supplier**: Provides goods/services and gives purchase invoices
- **Dual (Customer/Supplier)**: Acts as both client and supplier

### 🏦 Account Management

- Manage financial transactions efficiently
- Record and track ledger entries
- Maintain opening and closing balances
- View detailed credit and debit reports
- Export financial reports in multiple formats

## 🛠️ Installation

### Prerequisites

- PHP 7.4+
- MySQL 5.7+
- Composer
- Xampp v3.3.0 [7.4.30 specific]

### Steps

1. **Clone the repository**:
   ```sh
   git clone https://github.com/your-repository-url.git
   cd your-repository-folder
   ```
2. **Install dependencies**:
   ```sh
   composer install
   ```
3. **Configure database** in `.env` or `config/database.php`.
4. **Run migrations** (if applicable):
   ```sh
   php spark migrate
   ```
5. **Start the development server**:
   ```sh
   php spark serve
   ```
6. **Access the application**:
   - Login Page: [`localhost/C4/`](http://localhost/C4/)
   - Dashboard: [`localhost/C4/dashboard`](http://localhost/C4/dashboard)

### 🔑 Default Login Credentials
   ```plaintext
   Email: admin@gmail.com
   Password: admin@123
   ```

## 🏗️ Tech Stack

- **Backend**: CodeIgniter 4 (PHP)
- **Frontend**: HTML, CSS, JavaScript, jQuery, AJAX
- **Database**: MySQL
- **Libraries**: Select2, DataTables, intl-tel-input, daterangepicker, morris, apexcharts, ultimate-export, sweetalert

## 📜 License

This project is licensed under the [MIT License](LICENSE).

## 🤝 Contributing

Feel free to **fork** the repository and submit **pull requests** to enhance functionality or fix issues.

## 📞 Contact

For support or inquiries, reach out via **GitHub Issues** or email **[********[tejaschavda2020@gmail.com](mailto\:tejaschavda2020@gmail.com)********]**.

---

*Developed with ❤️ using CodeIgniter.*

