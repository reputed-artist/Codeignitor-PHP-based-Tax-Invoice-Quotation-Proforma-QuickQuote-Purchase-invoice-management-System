# CodeIgniter-PHP Tax Invoice, Quotation, Quick-Quotation, Purchase Invoice, and Account Management System

## 📌 Overview

This project is a comprehensive **Tax Invoice, Quotation, Proforma, Purchase Invoice, and Account Management System** built using **CodeIgniter (PHP)**. It streamlines business processes related to sales, purchases, invoices, client management, and account transactions while providing an insightful dashboard for turnover-based marketing analysis.

## 🚀 Features

### 🎯 Dashboard

- Marketing and sales turnover-based analytics
- Overview of key business metrics
- Faster dashboard loading with optimized database indexes
- Additional **More Info** pages for detailed dashboard information
- Improved dashboard data loading and performance

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
- Updated quotation format for improved presentation and usability

### 📊 Reports & Analysis

- Generate various reports on sales, purchases, and client transactions
- Export data for further analysis
- Export filenames are automatically updated according to the current page/report

### ⚙️ Settings & Customization

- Update user profile
- Update company profile (name, details, bank information, etc.)
- Update bank details
- Change password for security
- Customize UI to match business branding

### 💰 Billing System

- **IGST**: Applied for out-of-state transactions
- **Loc (CGST & SGST)**: Applied for within-state transactions
- Improved GST calculation and GST data insertion/update logic

### 🏷️ User Management

- **Client**: Can place orders and receive tax invoices
- **Supplier**: Provides goods/services and gives purchase invoices
- **Dual (Customer/Supplier)**: Acts as both client and supplier

### 🏦 Account Management

- Manage financial transactions efficiently
- Record and track ledger entries
- Maintain opening and closing balances
- **Closing balance is now displayed directly on the Manage Accounts page**
- View detailed credit and debit reports
- Export financial reports in multiple formats

---

# 🆕 Recent Updates

The latest version includes several improvements to installation, performance, accounting, GST processing, address management, quotations, exports, and error handling.

### 🧙 Installation Wizard

A new **Installation Wizard** has been added to simplify the initial setup of the application.

The wizard is available at:

```text
http://localhost/C4/install
```

The installation process can be used to configure the application during the initial setup, including required project and database configuration.

This makes it easier to deploy the project on a new system without manually configuring every setting before the first launch.

### 🚫 Improved 404 Error Handling

A dedicated and improved **404 Error Page** has been added.

The application now provides a proper error page when a requested route or page does not exist instead of displaying an unhandled or generic error.

This improves:

- User experience
- Application navigation
- Error visibility
- Handling of invalid URLs
- Overall application presentation

### 📍 Improved Address Logic

Address handling logic has been improved throughout the application.

The updated logic provides better handling of address-related information and improves consistency when inserting and updating address data.

### 🧾 Improved GST Logic

GST insertion and update logic has been improved.

The updated GST handling provides more reliable processing when:

- Adding GST-related data
- Updating GST information
- Processing invoice-related GST values
- Handling CGST/SGST and IGST logic

This helps maintain better consistency between invoice calculations and stored GST information.

### 🏦 Improved Account Management

The **Manage Accounts** section has been enhanced.

The front-facing Manage Accounts page now displays the **closing balance**, making it easier to understand the current financial position without opening additional account details.

### 📄 Updated Quotation Format

The quotation format has been redesigned/updated for improved presentation.

The updated quotation layout provides a cleaner and more organized format for displaying quotation information.

### ⚡ Faster Dashboard Loading

Dashboard performance has been improved by adding **database indexes through migrations**.

This optimization reduces the time required to retrieve frequently accessed dashboard data and improves the overall dashboard loading experience.

The optimization particularly benefits dashboards containing:

- Turnover data
- Sales information
- Purchase information
- Account information
- Date-based statistics
- Graphs and analytical information

### 📊 New Dashboard More Info Pages

Additional **More Info** pages have been added to the dashboard.

These pages allow users to move from high-level dashboard information to more detailed views of the underlying business data.

### 📥 Improved Export Filenames

Export functionality has been improved.

Generated export files now use filenames based on the **current page/report**, making exported files easier to identify and organize.

For example, instead of generic filenames, exports can now use page-specific names such as:

```text
Manage_Accounts.xlsx
Sales_Report.xlsx
Purchase_Report.xlsx
Quotation_Report.xlsx
```

---

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

   - Installation Wizard: [`http://localhost/C4/install`](http://localhost/C4/install)
   - Login Page: [`http://localhost/C4/`](http://localhost/C4/)
   - Dashboard: [`http://localhost/C4/dashboard`](http://localhost/C4/dashboard)

> **Note:** For a fresh installation, use the Installation Wizard to complete the initial application setup.

### 🔑 Default Login Credentials

```plaintext
Email: admin@gmail.com
Password: admin@123
```

> **Security Recommendation:** Change the default administrator password immediately after the first login.

---

## 🏗️ Tech Stack

- **Backend**: CodeIgniter 4 (PHP)
- **Frontend**: HTML, CSS, JavaScript, jQuery, AJAX
- **Database**: MySQL
- **Libraries**: Select2, DataTables, intl-tel-input, daterangepicker, morris, apexcharts, ultimate-export, sweetalert

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

## 🤝 Contributing

Feel free to **fork** the repository and submit **pull requests** to enhance functionality or fix issues.

## 📞 Contact

For support or inquiries, reach out via **GitHub Issues** or email **[********[tejaschavda2020@gmail.com](mailto\:tejaschavda2020@gmail.com)********]**.

---

*Developed with ❤️ using CodeIgniter.*