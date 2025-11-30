# Yii2 Book Catalog Project

This is a web application for managing a book catalog, built with the Yii2 framework.

## Features

- **Book Catalog**: View a list of books with authors.
- **User Registration & Authentication**: Users can sign up and log in.
- **Profile Management**: Users can update their profile, including their phone number.
- **Reports**: View a report of the top 10 authors by book count.
- **SMS Notifications**: Subscribed users receive SMS notifications when a new book by their favorite author is added (simulated via `smspilot.ru`).
- **Subscriptions**: Users can subscribe to authors to receive updates.

## Technology Stack

- **Framework**: Yii2 (PHP 8.4)
- **Database**: MariaDB (MySQL)
- **Containerization**: Docker & Docker Compose
- **Orchestration**: Kubernetes

## Installation & Running

### Local Development (Docker Compose)

1.  **Clone the repository**.
2.  **Configure Environment Variables**:
    Create a `.env` file in the root directory (you can copy from `.env.example` if available, or create one based on the keys below):
    ```env
    COOKIE_VALIDATION_KEY=your_random_secret_string
    SMS_PILOT_API_KEY=your_sms_pilot_api_key
    ```
    The `docker-compose.yml` file reads these variables from the `.env` file.

3.  **Start the application**:
    ```bash
    docker-compose up -d
    ```

4.  **Install dependencies**:
    ```bash
    docker-compose run --rm php composer install
    ```

5.  **Run Migrations**:
    ```bash
    docker-compose run --rm php yii migrate
    ```

6.  **Access the application**:
    Open [http://localhost:8000](http://localhost:8000) in your browser.

### Kubernetes Deployment

The configuration files are located in the `k8s/` directory.

1.  **Secrets**:
    The `k8s/secret.yaml` file contains sensitive information. **IMPORTANT**: In a real production environment, do not commit secrets to version control. Use a secret manager or encrypt them (e.g., Sealed Secrets).
    
    Update `k8s/secret.yaml` with your actual secrets:
    - `MYSQL_ROOT_PASSWORD`
    - `MYSQL_USER`
    - `MYSQL_PASSWORD`
    - `SMS_PILOT_API_KEY`
    - `COOKIE_VALIDATION_KEY`

2.  **Apply Configuration**:
    ```bash
    kubectl apply -f k8s/namespace.yaml
    kubectl apply -f k8s/configmap.yaml
    kubectl apply -f k8s/secret.yaml
    kubectl apply -f k8s/mysql-deployment.yaml
    kubectl apply -f k8s/app-deployment.yaml
    kubectl apply -f k8s/cronjob.yaml
    ```

3.  **Access**:
    The application is exposed via Ingress at `http://infotek.new.cy`.
