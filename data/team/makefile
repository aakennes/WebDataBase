NODE_VERSION_MIN := v22.12.0
NPM_VERSION_MIN := 10.7.0
MYSQL_VERSION_MIN := 5.7
PHP_VERSION_MIN := 8.1
COMPOSER_VERSION_MIN := 2.2.6
DB_NAME := Web_Database
SQL_FILE := ../install.sql

.PHONY: all install start refresh-db

all: install start

install:
	@echo "Checking and installing environment dependencies..."
	@if ! command -v node >/dev/null || [ "$(shell node -v)" \< "$(NODE_VERSION_MIN)" ]; then \
		echo "Installing Node.js..."; \
		# Add your installation command here; \
	else \
		echo "Node.js is already installed."; \
	fi
	@if ! command -v npm >/dev/null || [ "$(shell npm -v)" \< "$(NPM_VERSION_MIN)" ]; then \
		echo "Installing npm..."; \
		# Add your installation command here; \
	else \
		echo "npm is already installed."; \
	fi
	@if ! command -v mysql >/dev/null || [ "$(shell mysql --version | grep -o '[0-9.]*')" \< "$(MYSQL_VERSION_MIN)" ]; then \
		echo "Installing MySQL..."; \
		# Add your installation command here; \
	else \
		echo "MySQL is already installed."; \
	fi
	@if ! command -v php >/dev/null || [ "$(shell php -v | head -n1 | grep -o '[0-9.]*')" \< "$(PHP_VERSION_MIN)" ]; then \
		echo "Installing PHP..."; \
		# Add your installation command here; \
	else \
		echo "PHP is already installed."; \
	fi
	@if ! command -v composer >/dev/null || [ "$(shell composer -V | grep -o '[0-9.]*')" \< "$(COMPOSER_VERSION_MIN)" ]; then \
		echo "Installing Composer..."; \
		# Add your installation command here; \
	else \
		echo "Composer is already installed."; \
	fi

	@echo "Initializing project dependencies..."
	cd login && rm package-lock.json && npm install
	cd frontend && rm package-lock.json && npm install
	cd frontend/frontendBack && rm package-lock.json && npm install && npm install -g @vue/cli
	cd backend && composer install
	sudo chmod 1733 /var/lib/php/sessions
	@echo "Environment setup complete."

refresh-db:
	@echo "Refreshing MySQL database..."
	@if [ -f "$(SQL_FILE)" ]; then \
		mysql -u root -p $(DB_NAME) < $(SQL_FILE) && \
		echo "Database refreshed successfully."; \
	else \
		echo "SQL file $(SQL_FILE) not found. Skipping database refresh."; \
	fi

start:
	@echo "Starting the project..."
	cd login && npm start
