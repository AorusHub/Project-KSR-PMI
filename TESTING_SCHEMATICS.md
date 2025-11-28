# Project-KSR-PMI Software Testing Schematics

## 📋 System Overview
**Blood Donation Management System for KSR PMI UNHAS**
- **Framework**: Laravel 12.0 with PHP 8.2
- **Testing Framework**: PHPUnit 11.5.3
- **Database**: MySQL/SQLite (testing)
- **Frontend**: Blade Templates with Tailwind CSS

## 🎯 Testing Strategy

### 1. Test Pyramid Structure
```
           ┌─────────────────┐
           │   E2E Tests     │ (10%)
           │   (Browser)     │
           └─────────────────┘
         ┌─────────────────────┐
         │  Integration Tests  │ (20%)
         │   (Feature Tests)   │
         └─────────────────────┘
       ┌───────────────────────────┐
       │      Unit Tests           │ (70%)
       │   (Models, Services)      │
       └───────────────────────────┘
```

## 🧪 Testing Categories

### A. Unit Tests (70% - Core Business Logic)

#### 1. Model Tests
**Location**: `tests/Unit/Models/`

##### User Model Tests
```php
tests/Unit/Models/UserTest.php
- testUserCreation()
- testPasswordHashing()
- testOTPGeneration()
- testUserRoles() (admin, staf, pendonor)
- testUserVerification()
- testRelationshipToPendonor()
```

##### Pendonor Model Tests
```php
tests/Unit/Models/PendonorTest.php
- testPendonorCreation()
- testBloodTypeValidation()
- testAgeValidation()
- testRelationshipToUser()
- testRelationshipToDonasiDarah()
- testEligibilityCheck()
```

##### KegiatanDonor Model Tests
```php
tests/Unit/Models/KegiatanDonorTest.php
- testKegiatanCreation()
- testDateValidation()
- testStatusTransitions()
- testTargetDonorValidation()
- testRelationshipToDonasiDarah()
- testRelationshipToCreator()
```

##### DonasiDarah Model Tests
```php
tests/Unit/Models/DonasiDarahTest.php
- testDonasiCreation()
- testVolumeValidation()
- testStatusValidation()
- testRelationshipToPendonor()
- testRelationshipToKegiatan()
```

##### PermintaanDonor Model Tests
```php
tests/Unit/Models/PermintaanDonorTest.php
- testPermintaanCreation()
- testBloodTypeValidation()
- testUrgencyLevelValidation()
- testTrackingNumberGeneration()
- testStatusTransitions()
```

#### 2. Service/Helper Tests
**Location**: `tests/Unit/Services/`

```php
tests/Unit/Services/OTPServiceTest.php
tests/Unit/Services/BloodDonationEligibilityTest.php
tests/Unit/Services/NotificationServiceTest.php
tests/Unit/Services/ReportGeneratorTest.php
```

### B. Integration Tests (20% - Feature Tests)

#### 1. Authentication & Authorization Tests
**Location**: `tests/Feature/Auth/`

```php
tests/Feature/Auth/RegistrationTest.php
- testUserRegistration()
- testOTPVerification()
- testEmailVerification()
- testDuplicateEmailPrevention()

tests/Feature/Auth/LoginTest.php
- testValidLogin()
- testInvalidCredentials()
- testUnverifiedUserLogin()
- testRoleBasedRedirection()

tests/Feature/Auth/PasswordResetTest.php
- testPasswordResetRequest()
- testPasswordResetWithValidToken()
- testPasswordResetWithInvalidToken()
```

#### 2. Dashboard Tests
**Location**: `tests/Feature/Dashboard/`

```php
tests/Feature/Dashboard/AdminDashboardTest.php
- testAdminDashboardAccess()
- testStatisticsDisplay()
- testUserManagementAccess()
- testReportGeneration()

tests/Feature/Dashboard/StafDashboardTest.php
- testStafDashboardAccess()
- testKegiatanManagement()
- testPermintaanDonorManagement()
- testVerificationTasks()

tests/Feature/Dashboard/PendonorDashboardTest.php
- testPendonorDashboardAccess()
- testDonationHistory()
- testEligibilityCheck()
- testPermintaanDonorCreation()
```

#### 3. Blood Donation Activity Tests
**Location**: `tests/Feature/Kegiatan/`

```php
tests/Feature/Kegiatan/KegiatanManagementTest.php
- testKegiatanCreation()
- testKegiatanUpdate()
- testKegiatanDeletion()
- testKegiatanRegistration()
- testKegiatanCancellation()
- testParticipantManagement()

tests/Feature/Kegiatan/RegistrationTest.php
- testSuccessfulRegistration()
- testDuplicateRegistrationPrevention()
- testEligibilityValidation()
- testRegistrationLimits()
```

#### 4. Blood Request Tests
**Location**: `tests/Feature/Permintaan/`

```php
tests/Feature/Permintaan/PermintaanDonorTest.php
- testPermintaanCreation()
- testTrackingNumberGeneration()
- testPermintaanApproval()
- testPermintaanRejection()
- testUrgentRequestPriority()
```

#### 5. API Tests (if applicable)
**Location**: `tests/Feature/Api/`

```php
tests/Feature/Api/AuthenticationTest.php
tests/Feature/Api/KegiatanApiTest.php
tests/Feature/Api/PermintaanApiTest.php
```

### C. End-to-End Tests (10% - Browser Tests)

#### 1. User Journey Tests
**Location**: `tests/Browser/`

```php
tests/Browser/UserRegistrationJourneyTest.php
- testCompleteRegistrationFlow()
- testOTPVerificationFlow()
- testProfileCompletion()

tests/Browser/BloodDonationJourneyTest.php
- testKegiatanDiscovery()
- testRegistrationProcess()
- testAttendanceConfirmation()
- testPostDonationFeedback()

tests/Browser/PermintaanDonorJourneyTest.php
- testPermintaanCreationFlow()
- testTrackingSystemUsage()
- testStatusUpdates()

tests/Browser/AdminWorkflowTest.php
- testUserManagementWorkflow()
- testKegiatanApprovalWorkflow()
- testReportGenerationWorkflow()
```

## 🗂️ Test Database Schema

### Test Environment Setup
```php
config/database.php - testing environment:
- Connection: SQLite in-memory
- Migrations: Fresh migration for each test
- Seeders: Minimal test data
```

### Test Data Factory Structure
```php
database/factories/UserFactory.php
database/factories/PendonorFactory.php
database/factories/KegiatanDonorFactory.php
database/factories/DonasiDarahFactory.php
database/factories/PermintaanDonorFactory.php
```

## 🔧 Testing Tools & Configuration

### 1. PHPUnit Configuration
```xml
phpunit.xml:
- Test suites: Unit, Feature, Browser
- Database: SQLite in-memory
- Environment variables for testing
- Code coverage configuration
```

### 2. Testing Libraries
```json
composer.json (require-dev):
- phpunit/phpunit: ^11.5.3
- mockery/mockery: ^1.6
- laravel/dusk (for browser tests)
- fakerphp/faker: ^1.23
```

### 3. Code Coverage Target
- **Overall**: 85%
- **Models**: 95%
- **Controllers**: 80%
- **Services**: 90%

## 📊 Test Execution Matrix

### Test Categories by User Role

| Test Category | Admin | Staff | Pendonor | Guest |
|---------------|-------|-------|----------|-------|
| Authentication | ✅ | ✅ | ✅ | ✅ |
| Dashboard Access | ✅ | ✅ | ✅ | ❌ |
| User Management | ✅ | ❌ | ❌ | ❌ |
| Kegiatan Management | ✅ | ✅ | View Only | View Only |
| Permintaan Donor | ✅ | ✅ | ✅ | ❌ |
| Donation History | ✅ | ✅ | Own Only | ❌ |
| Reports | ✅ | Limited | Own Only | ❌ |

### Critical Test Scenarios

#### 1. Security Tests
```php
- SQL Injection Prevention
- XSS Protection
- CSRF Token Validation
- Authorization Bypass Attempts
- Input Validation
- File Upload Security
```

#### 2. Performance Tests
```php
- Database Query Optimization
- Page Load Times
- Concurrent User Handling
- Large Dataset Processing
- Memory Usage Monitoring
```

#### 3. Data Integrity Tests
```php
- Foreign Key Constraints
- Data Validation Rules
- Transaction Rollbacks
- Duplicate Prevention
- Audit Trail Accuracy
```

## 🚀 Test Implementation Plan

### Phase 1: Foundation (Week 1-2)
1. Set up testing environment
2. Create base test classes
3. Implement model unit tests
4. Set up factories and seeders

### Phase 2: Core Features (Week 3-4)
1. Authentication & authorization tests
2. Dashboard functionality tests
3. Basic CRUD operation tests
4. Role-based access control tests

### Phase 3: Business Logic (Week 5-6)
1. Blood donation workflow tests
2. Request management tests
3. Notification system tests
4. Reporting functionality tests

### Phase 4: Integration & E2E (Week 7-8)
1. Feature integration tests
2. Browser automation tests
3. Performance testing
4. Security testing

## 📈 Continuous Integration

### GitHub Actions Workflow
```yaml
.github/workflows/tests.yml:
- Run on: push, pull_request
- PHP versions: 8.2, 8.3
- Database: MySQL, SQLite
- Steps: composer install, migrate, test, coverage
```

### Quality Gates
```yaml
- Unit test coverage: > 85%
- Feature test coverage: > 80%
- PHPStan level: 8
- PHP CS Fixer compliance
- No security vulnerabilities
```

## 📝 Test Documentation

### Test Case Documentation
```markdown
Each test should include:
- Test description and purpose
- Prerequisites and setup
- Test steps and data
- Expected results
- Edge cases and error scenarios
```

### Bug Tracking Integration
```markdown
- Link test failures to bug reports
- Track test coverage improvements
- Monitor test execution trends
- Performance regression tracking
```

## 🔍 Specific Test Cases for KSR-PMI Features

### Blood Donation Eligibility Tests
```php
- Age requirement (17-60 years)
- Weight requirement (>= 45kg)
- Health status validation
- Previous donation interval (56 days)
- Medical history screening
```

### OTP Verification Tests
```php
- OTP generation and expiration
- Email delivery confirmation
- Invalid OTP handling
- Resend OTP functionality
- Rate limiting protection
```

### Blood Type Matching Tests
```php
- Compatible blood type requests
- Emergency blood type protocols
- Inventory management accuracy
- Cross-matching validations
```

### Activity Management Tests
```php
- Event creation and scheduling
- Participant registration limits
- Location and resource management
- Staff assignment workflows
- Post-event reporting
```

This comprehensive testing schematic ensures thorough coverage of your blood donation management system while maintaining focus on critical business logic and user safety.