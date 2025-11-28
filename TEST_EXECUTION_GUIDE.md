# Test Execution Guide for Project-KSR-PMI

## 🚀 Quick Start

### Prerequisites
```bash
# Ensure you have PHP 8.2+, Composer, and Node.js installed
php --version
composer --version
node --version
```

### Environment Setup
```bash
# Copy environment file
cp .env.example .env.testing

# Install dependencies
composer install
npm install

# Generate application key
php artisan key:generate --env=testing

# Configure testing database in .env.testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## 🧪 Running Tests

### Run All Tests
```bash
# Run all test suites
php artisan test

# Or using PHPUnit directly
./vendor/bin/phpunit
```

### Run Specific Test Categories

#### Unit Tests Only
```bash
php artisan test --testsuite=Unit
```

#### Feature Tests Only
```bash
php artisan test --testsuite=Feature
```

#### Specific Test Files
```bash
# Test specific model
php artisan test tests/Unit/Models/UserTest.php

# Test specific feature
php artisan test tests/Feature/Auth/LoginTest.php

# Test specific method
php artisan test --filter testUserCanLogin
```

### Browser Tests (Laravel Dusk)
```bash
# Install Laravel Dusk
composer require --dev laravel/dusk
php artisan dusk:install

# Run browser tests
php artisan dusk

# Run specific browser test
php artisan dusk tests/Browser/BloodDonationJourneyTest.php
```

## 📊 Code Coverage

### Generate Coverage Report
```bash
# Generate HTML coverage report
php artisan test --coverage-html coverage

# Generate text coverage report
php artisan test --coverage-text

# Generate coverage for specific directory
php artisan test --coverage-html coverage --coverage-filter app/Models
```

### Coverage Requirements
- **Overall Coverage**: Minimum 85%
- **Models**: Minimum 95%
- **Controllers**: Minimum 80%
- **Services**: Minimum 90%

## 🔍 Test Database Management

### Fresh Migration for Each Test
Tests use SQLite in-memory database which is automatically refreshed.

### Seed Test Data
```bash
# Run specific seeder for testing
php artisan db:seed --class=TestDataSeeder --env=testing

# Reset and seed database
php artisan migrate:fresh --seed --env=testing
```

## 📋 Test Checklist

### Before Running Tests
- [ ] Environment variables configured
- [ ] Dependencies installed
- [ ] Database permissions set
- [ ] Test data prepared

### Critical Test Scenarios

#### Authentication Tests ✅
- [ ] User registration with OTP
- [ ] Email verification
- [ ] Password reset functionality
- [ ] Role-based access control
- [ ] Session management

#### Blood Donation Workflow Tests ✅
- [ ] Event creation and management
- [ ] Donor registration process
- [ ] Eligibility verification
- [ ] Donation recording
- [ ] Certificate generation

#### Permission Tests ✅
- [ ] Admin access controls
- [ ] Staff permissions
- [ ] Donor limitations
- [ ] Guest restrictions

#### Data Integrity Tests ✅
- [ ] Foreign key constraints
- [ ] Validation rules
- [ ] Duplicate prevention
- [ ] Audit trails

## 🚨 Debugging Failed Tests

### Common Issues and Solutions

#### Database Connection Errors
```bash
# Check SQLite extension
php -m | grep sqlite

# Verify database configuration
php artisan config:show database.connections.sqlite
```

#### Permission Errors
```bash
# Check storage permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Clear cache
php artisan cache:clear
php artisan config:clear
```

#### Memory Limit Issues
```bash
# Increase PHP memory limit
php -d memory_limit=512M artisan test
```

### Test Output Analysis
```bash
# Verbose test output
php artisan test --verbose

# Stop on first failure
php artisan test --stop-on-failure

# Show test progress
php artisan test --testdox
```

## 📈 Continuous Integration

### GitHub Actions Workflow
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  tests:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ALLOW_EMPTY_PASSWORD: yes
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.2
        extensions: mbstring, dom, fileinfo, mysql, sqlite
        coverage: xdebug
    
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
    
    - name: Copy environment file
      run: cp .env.example .env.testing
    
    - name: Generate key
      run: php artisan key:generate --env=testing
    
    - name: Run migrations
      run: php artisan migrate --env=testing
    
    - name: Run tests
      run: php artisan test --coverage-clover coverage.xml
    
    - name: Upload coverage to Codecov
      uses: codecov/codecov-action@v3
      with:
        file: ./coverage.xml
```

## 📊 Performance Testing

### Load Testing with Laravel Tinker
```bash
php artisan tinker

# Test user creation performance
$start = microtime(true);
User::factory(1000)->create();
$end = microtime(true);
echo "Created 1000 users in " . ($end - $start) . " seconds\n";

# Test kegiatan creation
$start = microtime(true);
KegiatanDonor::factory(100)->create();
$end = microtime(true);
echo "Created 100 kegiatan in " . ($end - $start) . " seconds\n";
```

### Memory Usage Testing
```bash
# Monitor memory usage during tests
php -d memory_limit=128M artisan test --verbose | grep -E "(PASS|FAIL|Memory usage)"
```

## 🔐 Security Testing

### SQL Injection Tests
```php
// Test SQL injection prevention
$maliciousInput = "'; DROP TABLE users; --";
$response = $this->post('/login', [
    'email' => $maliciousInput,
    'password' => 'password'
]);

$this->assertDatabaseHas('users', []); // Ensure users table still exists
```

### XSS Protection Tests
```php
// Test XSS prevention
$xssPayload = "<script>alert('xss')</script>";
$response = $this->post('/kegiatan', [
    'nama_kegiatan' => $xssPayload
]);

$response->assertDontSee($xssPayload, false); // Ensure script tags are escaped
```

## 📝 Test Reporting

### Generate Test Reports
```bash
# Generate JUnit XML report
php artisan test --log-junit reports/junit.xml

# Generate HTML test report
php artisan test --testdox-html reports/testdox.html

# Generate coverage badge
php artisan test --coverage-text | grep "Lines:" | awk '{print $2}' > coverage.txt
```

### Custom Test Assertions
```php
// Create custom assertion for blood type validation
public function assertValidBloodType($bloodType)
{
    $validTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    $this->assertContains($bloodType, $validTypes, "Invalid blood type: {$bloodType}");
}

// Use in tests
$this->assertValidBloodType($pendonor->golongan_darah);
```

## 🚀 Test Optimization

### Parallel Testing
```bash
# Install parallel testing package
composer require --dev brianium/paratest

# Run tests in parallel
./vendor/bin/paratest
```

### Database Transaction Optimization
```php
// Use database transactions for faster tests
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FastUserTest extends TestCase
{
    use DatabaseTransactions;
    
    // Tests will be wrapped in transactions and rolled back
}
```

This guide provides comprehensive instructions for executing and managing tests in your Project-KSR-PMI blood donation management system.