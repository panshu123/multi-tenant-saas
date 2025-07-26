### Laravel Multi-Tenant SaaS Backend

A minimal Laravel backend for a multi-tenant SaaS app allowing users to create, manage, and switch between multiple companies. All data and actions are scoped to the currently active company.

### Setup Instructions

1. **Clone repository**
   -git clone https://github.com/yourusername/your-repo-name.git
   -cd multi-tenant-saas 

2. **Install dependenciesy**
    -composer install

3. **Configure environment**
    -Set your database credentials

4. **Run migrations**
    -php artisan migrate

5. **Authentication**
    -Register and login via API (Laravel Breeze API stack used).
    -Use returned API tokens to authenticate requests (via Authorization: Bearer {token} header).



### API Endpoints    
All routes are prefixed with /public/api and protected by Sanctum authentication unless noted.

1. **Authentication**
    -register   |POST
    -login      |POST
    -logout     |POST

2. **Companies**
    -companies      | GET (List all companies of authenticated user)
    -companies      | POST (Create a new company)
    -companies{id}  | GET (Show a specific company)
    -companies/{id} | PUT (Update a company)
    -companies/{id} | DELETE (Soft delete a company)

3. **Active Company**
    -companies/switch/{company_id} | POST (Set the active company for the user)

4. **Invoices**
    -invoices | POST (Create invoice under active company)	



### Example Requests (Using Postman)
    Register User
    -POST /api/register
    {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
    }

    Login User
    -POST /api/login
    {
    "email": "john@example.com",
    "password": "password"
    }

    Create Company
    -POST /api/companies
    -Authorization: Bearer {token}
    {
    "name": "Acme Inc",
    "address": "123 Market St",
    "industry": "Technology"
    }

    Switch Active Company
    -POST /api/companies/switch/1
    -Authorization: Bearer {token}

    Create Invoice
    -POST /api/invoices
    -Authorization: Bearer {token}
    {
    "title": "Website Development",
    "amount": 1200
    }



### Multi-Tenant Logic and Data Scoping
-Users can own multiple companies.
-Each user has an active company stored either in the user_active_companies pivot table or a foreign key on users table.
-All company-related data (e.g., invoices, projects) are linked to a company.
-Global Eloquent Scopes enforce that queries on tenant-specific models automatically filter by the user's active company.
-This prevents cross-company data leakage and enforces tenant isolation.
-Switching active company updates the stored active company for the user and changes the data context for all subsequent API requests.
-Authorization checks ensure users can only manage companies they own.
